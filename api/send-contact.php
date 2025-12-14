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
$required_fields = ['name', 'kana', 'email', 'message'];
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

// プライバシーポリシーの同意チェック
if (empty($data['privacy']) || $data['privacy'] !== 'on') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'プライバシーポリシーへの同意が必要です。']);
    exit;
}

// 送信先メールアドレス
$to = 'info@hamanavi-s.jp';
$customer_email = $data['email'];

// メール件名
$subject = '【YOKOHAMA Concierge】お問い合わせ - ' . $data['name'] . '様';
$customer_subject = '【YOKOHAMA Concierge】お問い合わせを承りました';

// メール本文を生成
$message = generateContactEmailBody($data);
$customer_message = generateCustomerContactEmailBody($data);

// メールヘッダー
$headers = "From: YOKOHAMA Concierge <info@hamanavi-s.jp>\r\n";
$headers .= "Reply-To: " . $customer_email . "\r\n";
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
        'message' => 'お問い合わせを承りました。確認メールをお送りしましたのでご確認ください。'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'メール送信に失敗しました。お手数ですが、直接お問い合わせください。'
    ]);
}

// 管理者向けメール本文生成
function generateContactEmailBody($data) {
    $body = "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "YOKOHAMA Concierge お問い合わせ\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $body .= "【基本情報】\n";
    $body .= "お名前: " . $data['name'] . "\n";
    $body .= "ふりがな: " . $data['kana'] . "\n";
    $body .= "メールアドレス: " . $data['email'] . "\n";
    $body .= "電話番号: " . ($data['tel'] ?? '未入力') . "\n\n";
    
    $body .= "【お問い合わせ種別】\n";
    $inquiry_types = [];
    if (!empty($data['type_service'])) $inquiry_types[] = 'サービスについて';
    if (!empty($data['type_reservation'])) $inquiry_types[] = '予約について';
    if (!empty($data['type_tour'])) $inquiry_types[] = '観光案内について';
    if (!empty($data['type_other'])) $inquiry_types[] = 'その他';
    
    $body .= implode('、', $inquiry_types) . "\n\n";
    
    $body .= "【お問い合わせ内容】\n";
    $body .= $data['message'] . "\n\n";
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "送信日時: " . date('Y年m月d日 H:i:s') . "\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    return $body;
}

// お客様向け自動返信メール本文生成
function generateCustomerContactEmailBody($data) {
    $body = $data['name'] . " 様\n\n";
    $body .= "この度はYOKOHAMA Conciergeにお問い合わせいただき、誠にありがとうございます。\n\n";
    $body .= "お問い合わせ内容を確認し、担当者より2営業日以内にご連絡させていただきます。\n\n";
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $body .= "お問い合わせ内容\n";
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $body .= "お名前: " . $data['name'] . "\n";
    $body .= "メールアドレス: " . $data['email'] . "\n\n";
    
    $body .= "お問い合わせ内容:\n";
    $body .= $data['message'] . "\n\n";
    
    $body .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
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
?>

