# 予約フォーム メール送信機能

## 概要
予約フォームから送信された内容を`info@hamanavi-s.jp`に自動転送し、お客様にも確認メールを送信します。

## 実装内容

### 1. フロントエンド（JavaScript）
- **ファイル**: `js/reservation.js`
- **機能**:
  - 入力内容の確認画面表示
  - フォームデータの送信
  - 送信完了モーダル表示

### 2. バックエンド（PHP）
- **ファイル**: `api/send-reservation.php`
- **機能**:
  - フォームデータの受信とバリデーション
  - 管理者（info@hamanavi-s.jp）へのメール送信
  - お客様への自動返信メール送信
  - クレジットカード情報のマスク処理

## メール送信先

### 管理者宛メール
- **宛先**: info@hamanavi-s.jp
- **件名**: 【YOKOHAMA Concierge】新規予約申し込み - [お客様名]様
- **内容**: 全ての入力内容（カード番号はマスク済み）

### お客様宛自動返信メール
- **宛先**: お客様が入力したメールアドレス
- **件名**: 【YOKOHAMA Concierge】ご予約を承りました
- **内容**: 予約受付確認と連絡先情報

## サーバー要件

### 必須要件
1. **PHP 7.0以上**
2. **mb_send_mail関数が有効**
3. **メール送信機能（SMTP設定）**

### php.iniの設定例
```ini
[mail function]
SMTP = localhost
smtp_port = 25
sendmail_from = info@hamanavi-s.jp
```

## セットアップ手順

### 1. ファイルのアップロード
```
/api/send-reservation.php
/api/.htaccess
/js/reservation.js
```

### 2. パーミッション設定
```bash
chmod 755 api/
chmod 644 api/send-reservation.php
chmod 644 api/.htaccess
```

### 3. メール送信テスト
ブラウザで予約フォームにアクセスし、テストデータを入力して送信してください。

### 4. 確認項目
- [ ] 管理者にメールが届く
- [ ] お客様に自動返信メールが届く
- [ ] クレジットカード番号がマスクされている
- [ ] 送信完了モーダルが表示される

## トラブルシューティング

### メールが届かない場合

#### 1. PHPのメール設定を確認
```bash
php -i | grep mail
```

#### 2. エラーログを確認
```bash
tail -f /var/log/php-errors.log
```

#### 3. SMTPサーバーの確認
- サーバーのSMTP設定が正しいか確認
- ファイアウォールでSMTPポート（25, 587, 465）がブロックされていないか確認

### 送信エラーが表示される場合

#### 1. ブラウザのコンソールを確認
```javascript
// F12キーでデベロッパーツールを開く
// Consoleタブでエラーメッセージを確認
```

#### 2. PHPファイルへのアクセス権限を確認
```bash
ls -la api/send-reservation.php
```

#### 3. CORSエラーの場合
`send-reservation.php`のヘッダー設定を確認してください。

## セキュリティ対策

### 実装済み
1. ✅ POSTリクエストのみ受付
2. ✅ 必須項目のバリデーション
3. ✅ メールアドレスの形式チェック
4. ✅ クレジットカード番号のマスク処理
5. ✅ XSSヘッダーの設定

### 推奨される追加対策
1. **reCAPTCHA導入** - Bot対策
2. **レート制限** - 連続送信の防止
3. **SSL/TLS** - HTTPS通信の必須化
4. **CSRFトークン** - クロスサイトリクエストフォージェリ対策

## カスタマイズ

### メール送信先の変更
`api/send-reservation.php`の9行目を編集:
```php
$to = 'info@hamanavi-s.jp'; // ← ここを変更
```

### メール件名の変更
`api/send-reservation.php`の15-16行目を編集:
```php
$subject = '【YOKOHAMA Concierge】新規予約申し込み - ' . $data['name'] . '様';
$customer_subject = '【YOKOHAMA Concierge】ご予約を承りました';
```

### メール本文のカスタマイズ
`generateEmailBody()`関数と`generateCustomerEmailBody()`関数を編集してください。

## 注意事項

1. **本番環境での使用前に必ずテストを実施してください**
2. **個人情報の取り扱いには十分注意してください**
3. **定期的にログを確認し、異常な送信がないか監視してください**
4. **メールサーバーの送信制限に注意してください**

## サポート

問題が解決しない場合は、サーバー管理者またはホスティング会社にお問い合わせください。

---

最終更新日: 2025年12月10日

