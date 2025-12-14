<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// POSTリクエストのみ受け付ける
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
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

// メール件名
$subject = '【YOKOHAMA Concierge】新規予約申し込み - ' . $data['name'] . '様';
$customer_subject = '【YOKOHAMA Concierge】ご予約を承りました';

// メール本文を生成
$message = generateEmailBody($data);
$customer_message = generateCustomerEmailBody($data);

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
        $body .= "【飲食店予約代行サービス】\n";
        $body .= "予約日: " . ($data['diningDate'] ?? '') . "\n";
        $body .= "大人: " . ($data['diningAdults'] ?? '0') . "名\n";
        $body .= "子供: " . ($data['diningChildren'] ?? '0') . "名\n";
        $body .= "ご予算: " . ($data['diningBudget'] ?? '') . "\n";
        $body .= "ジャンル: " . ($data['diningGenre'] ?? '') . "\n";
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
        $body .= "【トランク預かりサービス】\n";
        $body .= "予約日: " . ($data['luggageDate'] ?? '') . "\n";
        $body .= "予約個数: " . ($data['luggageCount'] ?? '') . "個\n";
        $body .= "その他ご希望: " . ($data['luggageNotes'] ?? '') . "\n\n";
    }
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "送信日時: " . date('Y年m月d日 H:i:s') . "\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    return $body;
}

// お客様向け自動返信メール本文生成
function generateCustomerEmailBody($data) {
    $body = $data['name'] . " 様\n\n";
    $body .= "この度はYOKOHAMA Conciergeをご利用いただき、誠にありがとうございます。\n\n";
    $body .= "ご予約のお申し込みを承りました。\n";
    $body .= "ご入力いただいた内容を確認後、すぐに担当者からご連絡させていただきます。\n\n";
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "お申し込み内容\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $body .= "お名前: " . ($data['name'] ?? '') . "\n";
    $body .= "電話番号: " . ($data['phone'] ?? '') . "\n";
    $body .= "メールアドレス: " . ($data['email'] ?? '') . "\n\n";
    
    if (!empty($data['guideCourse'])) {
        $body .= "観光ガイドサービス: " . $data['guideCourse'] . "\n";
    }
    if (!empty($data['hotelArea'])) {
        $body .= "ホテル予約代行: " . $data['hotelArea'] . "\n";
    }
    if (!empty($data['diningDate'])) {
        $body .= "飲食店予約代行: " . $data['diningDate'] . "\n";
    }
    if (!empty($data['activityType'])) {
        $body .= "体験アクティビティ: " . $data['activityType'] . "\n";
    }
    if (!empty($data['luggageCount'])) {
        $body .= "トランク預かり: " . $data['luggageCount'] . "個\n";
    }
    
    $body .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $body .= "【お問い合わせ先】\n";
    $body .= "YOKOHAMA Concierge\n";
    $body .= "〒231-0023 神奈川県横浜市中区山下町76-4-1301\n";
    $body .= "Email: info@hamanavi-s.jp\n";
    $body .= "Instagram: @yokohama_concierge\n\n";
    
    $body .= "※このメールは自動送信されています。\n";
    $body .= "※ご不明な点がございましたら、上記連絡先までお問い合わせください。\n\n";
    
    $body .= "YOKOHAMA Concierge\n";
    
    return $body;
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

