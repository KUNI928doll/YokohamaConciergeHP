# Contact Form 7 セットアップ完了手順 ✅

## 完了した作業

✅ `page-contact.php` を Contact Form 7 対応に更新  
✅ Contact Form 7 用のカスタムCSSを作成  
✅ `functions.php` にスタイルシートの読み込みを追加  
✅ セットアップ手順書を作成

## 次にやること（管理画面での作業）

### ステップ1: Contact Form 7 をインストール

1. WordPressの管理画面にログイン
2. 左メニュー「プラグイン」→「新規プラグインを追加」
3. 検索ボックスに「**Contact Form 7**」と入力
4. 「今すぐインストール」→「有効化」をクリック

### ステップ2: フォームを作成

1. 左メニューに「**お問い合わせ**」が追加されるのでクリック
2. 「**新規追加**」をクリック
3. タイトルに「**お問い合わせフォーム**」と入力

### ステップ3: フォームタブの設定

「フォーム」タブに以下のコードを**すべて削除してから**貼り付けてください：

```html
<div class="inquiry-form__section">
    <h3 class="inquiry-form__legend">基本情報</h3>
    <p class="inquiry-form__description">お名前とご連絡先をご入力ください。ご入力内容をもとに、担当者がお電話またはメールでご連絡いたします。</p>
    <div class="inquiry-form__grid">
        <div class="inquiry-form__field">
            <label for="contact-name" class="inquiry-form__label">お名前<span class="inquiry-form__required">必須</span></label>
            [text* your-name id:contact-name class:inquiry-form__input placeholder "例）横浜 太郎"]
        </div>
        <div class="inquiry-form__field">
            <label for="contact-kana" class="inquiry-form__label">ふりがな<span class="inquiry-form__required">必須</span></label>
            [text* your-kana id:contact-kana class:inquiry-form__input placeholder "例）よこはま たろう"]
        </div>
        <div class="inquiry-form__field">
            <label for="contact-email" class="inquiry-form__label">メールアドレス<span class="inquiry-form__required">必須</span></label>
            [email* your-email id:contact-email class:inquiry-form__input placeholder "info@example.com"]
        </div>
        <div class="inquiry-form__field">
            <label for="contact-tel" class="inquiry-form__label">電話番号</label>
            [tel your-tel id:contact-tel class:inquiry-form__input placeholder "090-1234-5678"]
            <p class="inquiry-form__note">お急ぎの場合や予約希望の際はご入力ください</p>
        </div>
    </div>
</div>

<div class="inquiry-form__section">
    <h3 class="inquiry-form__legend">お問い合わせ内容</h3>
    <p class="inquiry-form__description">お問い合わせの種別と具体的な内容をご入力ください。</p>
    
    <div class="inquiry-form__field inquiry-form__field--full">
        <p class="inquiry-form__label">お問い合わせ種別<span class="inquiry-form__required">必須</span></p>
        <div class="inquiry-form__checkboxes">
            [checkbox* inquiry-type use_label_element class:inquiry-form__checkbox "予約について" "サービス内容について" "見積もり依頼" "不明点・その他"]
        </div>
        <p class="inquiry-form__note">複数選択可能です</p>
    </div>

    <div class="inquiry-form__field inquiry-form__field--full">
        <label for="contact-message" class="inquiry-form__label">お問い合わせ内容<span class="inquiry-form__required">必須</span></label>
        [textarea* your-message id:contact-message class:inquiry-form__textarea rows:6 placeholder "ご希望サービスや具体的な内容をご入力ください"]
    </div>
</div>

<div class="inquiry-form__section inquiry-form__section--privacy">
    <p class="inquiry-form__privacy-text">個人情報のお取り扱いについては「<a href="/privacy/" class="inquiry-form__privacy-link" target="_blank">プライバシーポリシー</a>」をご確認ください。</p>
    
    <label class="inquiry-form__privacy-checkbox">
        [acceptance acceptance-privacy]プライバシーポリシーに同意する<span class="inquiry-form__required">必須</span>[/acceptance]
    </label>
</div>

<div class="inquiry-form__actions">
    [submit class:btn class:btn--blue class:btn--lg "送信する"]
</div>
```

### ステップ4: メールタブの設定

#### 管理者宛メール（デフォルトのメール）

- **送信先**: `info@hamanavi-s.jp`
- **送信元**: `[your-email]`
- **題名**: `【YOKOHAMA Concierge】お問い合わせ - [your-name]様`
- **追加ヘッダー**: 
```
Reply-To: [your-email]
```
- **メッセージ本文**:
```
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
YOKOHAMA Concierge お問い合わせ
━━━━━━━━━━━━━━━━━━━━━━━━━━━━

【基本情報】
お名前: [your-name]
ふりがな: [your-kana]
メールアドレス: [your-email]
電話番号: [your-tel]

【お問い合わせ種別】
[inquiry-type]

【お問い合わせ内容】
[your-message]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━
送信日時: [_date] [_time]
送信元IP: [_remote_ip]
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

#### 自動返信メール（メール (2)）

「**メール (2) を使用**」にチェックを入れて：

- **送信先**: `[your-email]`
- **送信元**: `YOKOHAMA Concierge <info@hamanavi-s.jp>`
- **題名**: `【YOKOHAMA Concierge】お問い合わせを承りました`
- **追加ヘッダー**: 
```
Reply-To: info@hamanavi-s.jp
```
- **メッセージ本文**:
```
[your-name] 様

この度はYOKOHAMA Conciergeにお問い合わせいただき、誠にありがとうございます。

お問い合わせ内容を確認し、担当者より2営業日以内にご連絡させていただきます。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━
お問い合わせ内容
━━━━━━━━━━━━━━━━━━━━━━━━━━━━

お名前: [your-name]
メールアドレス: [your-email]

お問い合わせ種別:
[inquiry-type]

お問い合わせ内容:
[your-message]

━━━━━━━━━━━━━━━━━━━━━━━━━━━━

【お問い合わせ先】
YOKOHAMA Concierge
〒231-0023 神奈川県横浜市中区山下町76-4-1301
Email: info@hamanavi-s.jp
Instagram: @yokohama_concierge

※このメールは自動送信されています。
※ご不明な点がございましたら、上記連絡先までお問い合わせください。

YOKOHAMA Concierge
```

### ステップ5: メッセージタブの設定

以下のメッセージを設定：

- **送信完了**: 
```
お問い合わせを受け付けました。ご入力いただいたメールアドレス宛に受付確認メールをお送りしました。
```

- **送信エラー**: 
```
送信中にエラーが発生しました。お手数ですが、もう一度お試しいただくか、お電話にてお問い合わせください。
```

- **検証エラー**: 
```
入力内容に誤りがあります。ご確認ください。
```

- **承認が必要**: 
```
プライバシーポリシーへの同意が必要です。
```

### ステップ6: 保存

「**保存**」ボタンをクリック

### ステップ7: 確認

1. お問い合わせページ（`/contact/`）にアクセス
2. フォームが表示されていることを確認
3. テスト送信してメールが届くか確認

## 完了！🎉

これでContact Form 7の設定が完了しました。

## トラブルシューティング

### フォームが表示されない場合

1. Contact Form 7 が有効化されているか確認
2. フォームが作成されているか確認（「お問い合わせ」メニューで確認）
3. ブラウザのキャッシュをクリア

### メールが届かない場合

1. 送信先メールアドレスが正しいか確認
2. サーバーのメール送信機能が有効か確認
3. WP Mail SMTP などのプラグインを検討

### デザインが崩れる場合

1. ブラウザのキャッシュをクリア
2. `/css/contact-form-7-custom.css` が読み込まれているか確認
3. 必要に応じてCSSを調整

## 参考ファイル

- 詳細な設定手順: `CONTACT_FORM_7_SETUP.md`
- カスタムCSS: `/css/contact-form-7-custom.css`
- テンプレートファイル: `page-contact.php`

