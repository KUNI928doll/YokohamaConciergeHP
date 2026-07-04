<?php
// WordPressを読み込む（このファイルは theme/api/ 配下のため4階層上がサイトルート）
require_once dirname(__DIR__, 4) . '/wp-load.php';

header('Content-Type: application/json; charset=utf-8');

// POSTリクエストのみ受け付ける
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
    exit;
}

// nonceチェック（CSRF対策）
if (!isset($_POST['reservation_nonce']) || !wp_verify_nonce($_POST['reservation_nonce'], 'reservation_form')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => '不正なリクエストです。']);
    exit;
}

// フォームデータを取得
$data = $_POST;

// 必須項目のチェック
$required_fields = ['name', 'phone', 'email'];
foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => '必須項目が入力されていません。']);
        exit;
    }
}

// メールアドレスの検証
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => '有効なメールアドレスを入力してください。']);
    exit;
}

// 送信先メールアドレス
$to = 'info@hamanavi-s.jp';
$customer_email = $data['email'];

// 言語コードを取得（ホワイトリスト検証）
$allowed_langs = ['ja', 'en', 'zh', 'ko'];
$lang = in_array($_POST['lang'] ?? '', $allowed_langs) ? $_POST['lang'] : 'ja';

// メール件名
$subject = '【YOKOHAMA Concierge】新規予約申し込み - ' . $data['name'] . '様';
$customer_subjects = [
    'ja' => '【YOKOHAMA Concierge】ご予約受付完了／現在手配中のお知らせ',
    'en' => '[YOKOHAMA Concierge] Reservation Request Received / Currently Processing',
    'zh' => '【YOKOHAMA Concierge】预约申请已受理／正在安排中',
    'ko' => '【YOKOHAMA Concierge】예약 신청 접수 완료／현재 수배 중',
];
$customer_subject = $customer_subjects[$lang];

// メール本文を生成
$message = generateEmailBody($data);
$customer_message = generateCustomerEmailBody($data, $lang);

// メールヘッダー
$headers = "From: YOKOHAMA Concierge <info@hamanavi-s.jp>\r\n";
$headers .= "Reply-To: info@hamanavi-s.jp\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// 管理者へメール送信
$admin_sent = mb_send_mail($to, $subject, $message, $headers);

// お客様へ自動返信メール送信
$customer_headers = "From: YOKOHAMA Concierge <info@hamanavi-s.jp>\r\n";
$customer_headers .= "Reply-To: info@hamanavi-s.jp\r\n";
$customer_headers .= "Bcc: info@hamanavi-s.jp, yukichikun0202@gmail.com\r\n";
$customer_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$customer_headers .= "X-Mailer: PHP/" . phpversion();

$customer_sent = mb_send_mail($customer_email, $customer_subject, $customer_message, $customer_headers);

// 結果を返す
if ($admin_sent && $customer_sent) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'ご予約を承りました。確認メールをお送りしましたのでご確認ください。'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'メール送信に失敗しました。お手数ですが、直接お問い合わせください。'
    ]);
}

// 管理者向けメール本文生成
function generateEmailBody($data) {
    $body = "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "YOKOHAMA Concierge 予約申し込み\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $body .= "【基本情報】\n";
    $body .= "お名前: " . ($data['name'] ?? '') . "\n";
    $body .= "性別: " . ($data['gender'] ?? '') . "\n";
    $body .= "国籍: " . ($data['nationality'] ?? '') . "\n";
    $body .= "住所: " . ($data['address'] ?? '') . "\n";
    $body .= "パスポート番号: " . ($data['passport'] ?? '') . "\n";
    $body .= "滞在先: " . ($data['stay'] ?? '') . "\n";
    $body .= "電話番号: " . ($data['phone'] ?? '') . "\n";
    $body .= "メールアドレス: " . ($data['email'] ?? '') . "\n";
    $body .= "クレジットカード番号: " . (isset($data['card']) ? maskCardNumber($data['card']) : '') . "\n";
    $body .= "カード会社: " . ($data['cardType'] ?? '') . "\n";
    $body .= "同伴者情報: " . ($data['companion'] ?? '') . "\n\n";
    
    if (!empty($data['guideCourse']) || !empty($data['guideArea'])) {
        $body .= "【観光ガイドサービス】\n";
        $body .= "ご希望コース: " . ($data['guideCourse'] ?? '') . "\n";
        $body .= "ご希望エリア: " . ($data['guideArea'] ?? '') . "\n";
        $body .= "ご希望スポット: " . ($data['guideSpots'] ?? '') . "\n";
        $body .= "その他ご要望: " . ($data['guideNotes'] ?? '') . "\n\n";
    }
    
    if (!empty($data['hotelDate']) || !empty($data['hotelArea'])) {
        $body .= "【ホテル予約代行サービス】\n";
        $body .= "予約日: " . ($data['hotelDate'] ?? '') . "\n";
        $body .= "エリア: " . ($data['hotelArea'] ?? '') . "\n";
        $body .= "ご希望金額: " . ($data['hotelBudget'] ?? '') . "\n";
        $body .= "大人: " . ($data['hotelAdults'] ?? '0') . "名\n";
        $body .= "子供: " . ($data['hotelChildren'] ?? '0') . "名\n";
        $body .= "その他ご希望: " . ($data['hotelRequest'] ?? '') . "\n\n";
    }
    
    if (!empty($data['diningDate'])) {
        $body .= "【飲食店舗予約代行サービス】\n";
        $body .= "予約日: " . ($data['diningDate'] ?? '') . "\n";
        $body .= "大人: " . ($data['diningAdults'] ?? '0') . "名\n";
        $body .= "子供: " . ($data['diningChildren'] ?? '0') . "名\n";
        $body .= "ご予算: " . ($data['diningBudget'] ?? '') . "\n";
        $cuisine = $data['cuisine'] ?? ($data['diningGenre'] ?? ($data['diningCuisine'] ?? ''));
        $body .= "ジャンル: " . $cuisine . "\n";
        $body .= "その他ご希望: " . ($data['diningRequest'] ?? '') . "\n\n";
    }
    
    if (!empty($data['activityDatetime'])) {
        $body .= "【体験アクティビティ代行サービス】\n";
        $body .= "予約希望日時: " . ($data['activityDatetime'] ?? '') . "\n";
        $body .= "大人: " . ($data['activityAdults'] ?? '0') . "名\n";
        $body .= "子供: " . ($data['activityChildren'] ?? '0') . "名\n";
        $body .= "体験アクティビティ: " . ($data['activityType'] ?? '') . "\n";
        $body .= "その他ご希望: " . ($data['activityRequest'] ?? '') . "\n\n";
    }
    
    if (!empty($data['luggageDate'])) {
        $body .= "【トランクお預かりサービス】\n";
        $body .= "予約日: " . ($data['luggageDate'] ?? '') . "\n";
        $body .= "予約個数: " . ($data['luggageCount'] ?? '') . "個\n";
        $body .= "その他ご希望: " . ($data['luggageNotes'] ?? '') . "\n\n";
    }
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "送信日時: " . date('Y年m月d日 H:i:s') . "\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    return $body;
}

// お客様向け自動返信メール本文生成（多言語対応）
function generateCustomerEmailBody($data, $lang = 'ja') {
    $reservation_id = date('YmdHis');
    $t = getEmailTranslations($lang);
    $name = $data['name'] ?? '';

    // 冒頭の呼びかけ（言語により語順が異なる）
    if ($lang === 'en') {
        $body = "Dear " . $name . ",\n";
    } elseif ($lang === 'zh') {
        $body = $name . " 您好，\n";
    } elseif ($lang === 'ko') {
        $body = $name . " " . $t['honorific'] . ",\n";
    } else {
        $body = $name . " " . $t['honorific'] . "\n";
    }

    $body .= $t['greeting'] . "\n";
    $body .= $t['confirmed'] . "\n";
    $body .= $t['processing'] . "\n";
    $body .= $t['wait'] . "\n";
    $body .= $t['alternative'] . "\n";
    $body .= "\n" . $t['receipt_title'] . "\n";
    $body .= $t['reservation_id'] . "：#" . $reservation_id . "\n";
    $body .= $t['lbl_name'] . "：" . $name . "\n";
    $body .= $t['lbl_phone'] . "：" . ($data['phone'] ?? '') . "\n";
    $body .= $t['lbl_email'] . "：" . ($data['email'] ?? '') . "\n";
    if (!empty($data['estimated_amount']) && intval($data['estimated_amount']) > 0) {
        $body .= $t['lbl_amount'] . "：¥" . number_format(intval($data['estimated_amount'])) . "\n";
    }

    if (!empty($data['guideCourse'])) {
        $body .= "\n" . $t['svc_guide'] . "\n";
        $body .= $t['lbl_course'] . "：" . $data['guideCourse'] . "\n";
        if (!empty($data['guideDate'])) $body .= $t['lbl_date'] . "：" . $data['guideDate'] . "\n";
        if (!empty($data['guideArea'])) $body .= $t['lbl_area'] . "：" . $data['guideArea'] . "\n";
    }
    if (!empty($data['hotelDate']) || !empty($data['hotelArea'])) {
        $body .= "\n" . $t['svc_hotel'] . "\n";
        if (!empty($data['hotelDate']))      $body .= $t['lbl_date'] . "：" . $data['hotelDate'] . "\n";
        if (!empty($data['hotelArea']))      $body .= $t['lbl_area'] . "：" . $data['hotelArea'] . "\n";
        if (!empty($data['hotelProposal1'])) $body .= $t['lbl_proposal'] . "：" . $data['hotelProposal1'] . "\n";
    }
    if (!empty($data['diningDate'])) {
        $body .= "\n" . $t['svc_dining'] . "\n";
        $body .= $t['lbl_date'] . "：" . $data['diningDate'] . "\n";
        if (!empty($data['diningTime']))      $body .= $t['lbl_time'] . "：" . $data['diningTime'] . "\n";
        if (!empty($data['diningProposal1'])) $body .= $t['lbl_proposal'] . "：" . $data['diningProposal1'] . "\n";
    }
    if (!empty($data['activityDatetime'])) {
        $body .= "\n" . $t['svc_activity'] . "\n";
        $body .= $t['lbl_datetime'] . "：" . $data['activityDatetime'] . "\n";
        if (!empty($data['activityType'])) $body .= $t['lbl_activity'] . "：" . $data['activityType'] . "\n";
    }
    if (!empty($data['luggageDate'])) {
        $body .= "\n" . $t['svc_luggage'] . "\n";
        $body .= $t['lbl_date'] . "：" . $data['luggageDate'] . "\n";
        if (!empty($data['luggageCount'])) $body .= $t['lbl_count'] . "：" . $data['luggageCount'] . "\n";
    }

    $body .= "\n\n" . $t['contact_title'] . "\n";
    $body .= $t['contact_name'] . "\n";
    $body .= "Email：info@hamanavi-s.jp\n";
    $body .= "TEL：070-1526-3845\n";
    $body .= $t['note_auto'] . "\n";
    $body .= $t['note_confirm'] . "\n";

    return $body;
}

// 言語別翻訳テーブル
function getEmailTranslations($lang) {
    $t = [
        'ja' => [
            'honorific'    => '様',
            'greeting'     => 'この度はYOKOHAMA Concierge（ハマナビサービス）をご利用いただき、誠にありがとうございます。',
            'confirmed'    => 'ご予約のお申し込みおよび決済を確認いたしました。',
            'processing'   => '現在、ご希望内容に基づき提携店舗・提携事業者へ予約手配を進めております。',
            'wait'         => 'ご希望の日時・内容にて手配が完了次第、担当者より正式な「予約確定メール」を改めてお送りいたしますので、今しばらくお待ちください。',
            'alternative'  => 'なお、満席・満室・予約不可等によりご希望内容での手配が難しい場合は、同等条件の代替候補をご提案させていただく場合がございます。その際はメールにてご相談申し上げます。',
            'receipt_title'=> '受付内容',
            'reservation_id'=> '予約ID',
            'lbl_name'     => 'お名前',
            'lbl_phone'    => '電話番号',
            'lbl_email'    => 'メールアドレス',
            'lbl_amount'   => 'お支払い金額',
            'svc_guide'    => '【観光ガイドサービス】',
            'svc_hotel'    => '【ホテル予約代行サービス】',
            'svc_dining'   => '【飲食店舗予約代行サービス】',
            'svc_activity' => '【体験アクティビティ代行サービス】',
            'svc_luggage'  => '【トランクお預かりサービス】',
            'lbl_course'   => 'コース',
            'lbl_date'     => '予約日',
            'lbl_area'     => 'エリア',
            'lbl_proposal' => 'ご提案内容',
            'lbl_time'     => '予約時間',
            'lbl_datetime' => '予約希望日時',
            'lbl_activity' => 'アクティビティ',
            'lbl_count'    => '個数',
            'contact_title'=> '【お問い合わせ先】',
            'contact_name' => 'YOKOHAMA Concierge（ハマナビサービス）',
            'note_auto'    => '※このメールは自動送信されています。',
            'note_confirm' => '※正式な予約確定は、担当者からの別途ご連絡をもって完了となります。',
        ],
        'en' => [
            'honorific'    => '',
            'greeting'     => 'Thank you for using YOKOHAMA Concierge (Hamanavi Services).',
            'confirmed'    => 'We have confirmed your reservation request and payment.',
            'processing'   => 'We are currently making arrangements with our partner venues and service providers based on your request.',
            'wait'         => 'Once the arrangement is complete, our staff will send you a formal "Reservation Confirmed" email. Please wait a moment.',
            'alternative'  => 'Please note that if your requested time or content is unavailable due to full capacity or other reasons, we may suggest alternative options of similar conditions. We will contact you by email in that case.',
            'receipt_title'=> 'Booking Details',
            'reservation_id'=> 'Reservation ID',
            'lbl_name'     => 'Name',
            'lbl_phone'    => 'Phone',
            'lbl_email'    => 'Email',
            'lbl_amount'   => 'Payment Amount',
            'svc_guide'    => '[Sightseeing Guide Service]',
            'svc_hotel'    => '[Hotel Booking Service]',
            'svc_dining'   => '[Restaurant Booking Service]',
            'svc_activity' => '[Activity Booking Service]',
            'svc_luggage'  => '[Luggage Storage Service]',
            'lbl_course'   => 'Course',
            'lbl_date'     => 'Date',
            'lbl_area'     => 'Area',
            'lbl_proposal' => 'Proposed Option',
            'lbl_time'     => 'Time',
            'lbl_datetime' => 'Requested Date & Time',
            'lbl_activity' => 'Activity',
            'lbl_count'    => 'Count',
            'contact_title'=> '[Contact Us]',
            'contact_name' => 'YOKOHAMA Concierge (Hamanavi Services)',
            'note_auto'    => '※ This email was sent automatically.',
            'note_confirm' => '※ Your reservation will be officially confirmed upon separate notification from our staff.',
        ],
        'zh' => [
            'honorific'    => '',
            'greeting'     => '感谢您使用YOKOHAMA Concierge（滨航服务）。',
            'confirmed'    => '我们已确认您的预约申请及付款。',
            'processing'   => '我们目前正根据您的需求与合作商家及服务提供商进行预约安排。',
            'wait'         => '安排完成后，我们的工作人员将向您发送正式的「预约确认邮件」，请稍候。',
            'alternative'  => '如因满席、满房或无法预约等原因，难以按您要求进行安排，我们可能会推荐同等条件的替代方案，届时将通过邮件与您联系。',
            'receipt_title'=> '受理内容',
            'reservation_id'=> '预约编号',
            'lbl_name'     => '姓名',
            'lbl_phone'    => '电话',
            'lbl_email'    => '电子邮件',
            'lbl_amount'   => '付款金额',
            'svc_guide'    => '【观光导游服务】',
            'svc_hotel'    => '【酒店预订代理服务】',
            'svc_dining'   => '【餐厅预订代理服务】',
            'svc_activity' => '【体验活动代理服务】',
            'svc_luggage'  => '【行李寄存服务】',
            'lbl_course'   => '课程',
            'lbl_date'     => '预约日期',
            'lbl_area'     => '地区',
            'lbl_proposal' => '提案内容',
            'lbl_time'     => '预约时间',
            'lbl_datetime' => '希望预约日时',
            'lbl_activity' => '活动',
            'lbl_count'    => '数量',
            'contact_title'=> '【联系我们】',
            'contact_name' => 'YOKOHAMA Concierge（滨航服务）',
            'note_auto'    => '※ 此邮件为自动发送。',
            'note_confirm' => '※ 正式预约确认以工作人员的单独通知为准。',
        ],
        'ko' => [
            'honorific'    => '고객님',
            'greeting'     => 'YOKOHAMA Concierge（하마나비 서비스）를 이용해 주셔서 진심으로 감사드립니다.',
            'confirmed'    => '예약 신청 및 결제가 확인되었습니다.',
            'processing'   => '현재 고객님의 요청 사항에 따라 제휴 업체에 예약 수배를 진행 중입니다.',
            'wait'         => '희망하시는 일정 및 내용으로 수배가 완료되는 대로 담당자로부터 정식 「예약 확정 메일」을 별도로 보내드리오니 잠시만 기다려 주세요.',
            'alternative'  => '다만, 만석·만실·예약 불가 등의 사유로 원하시는 내용으로 수배가 어려울 경우, 동등한 조건의 대안을 제안해 드릴 수 있습니다. 이 경우 이메일로 안내해 드리겠습니다.',
            'receipt_title'=> '접수 내용',
            'reservation_id'=> '예약 ID',
            'lbl_name'     => '성함',
            'lbl_phone'    => '전화번호',
            'lbl_email'    => '이메일',
            'lbl_amount'   => '결제 금액',
            'svc_guide'    => '【관광 가이드 서비스】',
            'svc_hotel'    => '【호텔 예약 대행 서비스】',
            'svc_dining'   => '【식당 예약 대행 서비스】',
            'svc_activity' => '【체험 액티비티 대행 서비스】',
            'svc_luggage'  => '【수하물 보관 서비스】',
            'lbl_course'   => '코스',
            'lbl_date'     => '예약일',
            'lbl_area'     => '지역',
            'lbl_proposal' => '제안 내용',
            'lbl_time'     => '예약 시간',
            'lbl_datetime' => '희망 예약 일시',
            'lbl_activity' => '액티비티',
            'lbl_count'    => '개수',
            'contact_title'=> '【문의처】',
            'contact_name' => 'YOKOHAMA Concierge（하마나비 서비스）',
            'note_auto'    => '※ 이 메일은 자동 발송되었습니다.',
            'note_confirm' => '※ 정식 예약 확정은 담당자로부터의 별도 연락으로 완료됩니다.',
        ],
    ];

    return $t[$lang] ?? $t['ja'];
}

// クレジットカード番号をマスク
function maskCardNumber($cardNumber) {
    if (empty($cardNumber)) return '';
    $cardNumber = preg_replace('/\s+/', '', $cardNumber);
    if (strlen($cardNumber) > 4) {
        return str_repeat('*', strlen($cardNumber) - 4) . substr($cardNumber, -4);
    }
    return $cardNumber;
}
?>

