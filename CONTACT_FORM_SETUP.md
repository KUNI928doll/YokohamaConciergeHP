# Contact Form 7 セットアップガイド

## 1. プラグインのインストール

1. WordPressの管理画面にログイン
2. 「プラグイン」→「新規追加」
3. 「Contact Form 7」を検索してインストール・有効化

## 2. フォームの作成

「お問い合わせ」→「新規追加」で以下のコードを設定：

### フォームタブ

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
            [checkbox inquiry-type use_label_element "予約について" "サービス内容について" "見積もり依頼" "不明点・その他"]
        </div>
        <p class="inquiry-form__note">複数選択可能です</p>
    </div>
    
    <div class="inquiry-form__field inquiry-form__field--full">
        <label for="contact-message" class="inquiry-form__label">お問い合わせ内容<span class="inquiry-form__required">必須</span></label>
        [textarea* your-message id:contact-message class:inquiry-form__textarea rows:6 placeholder "ご希望サービスや具体的な内容をご入力ください"]
    </div>
</div>

<div class="inquiry-form__section inquiry-form__section--privacy">
    <p class="inquiry-form__privacy-text">個人情報のお取り扱いについては「<a href="<?php echo esc_url(home_url('/privacy/')); ?>" class="inquiry-form__privacy-link" target="_blank">プライバシーポリシー</a>」をご確認ください。</p>
    
    [acceptance acceptance-privacy class:inquiry-form__privacy-checkbox]
    プライバシーポリシーに同意する<span class="inquiry-form__required">必須</span>
    [/acceptance]
</div>

<div class="inquiry-form__actions">
    [submit class:btn class:btn--blue class:btn--lg "入力内容の確認 →"]
</div>
```

### メールタブ

**管理者宛メール:**
- 送信先: `info@hamanavi-s.jp`
- 送信元: `[your-email]`
- 題名: `【YOKOHAMA Concierge】お問い合わせ - [your-name]様`
- メッセージ本文:
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
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

**自動返信メール:**
- 送信先: `[your-email]`
- 送信元: `info@hamanavi-s.jp`
- 題名: `【YOKOHAMA Concierge】お問い合わせを承りました`
- メッセージ本文:
```
[your-name] 様

この度はYOKOHAMA Conciergeにお問い合わせいただき、誠にありがとうございます。

お問い合わせ内容を確認し、担当者より2営業日以内にご連絡させていただきます。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━
お問い合わせ内容
━━━━━━━━━━━━━━━━━━━━━━━━━━━━

お名前: [your-name]
メールアドレス: [your-email]

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

### メッセージタブ

送信完了メッセージ:
```
お問い合わせを受け付けました。
ご入力いただいたメールアドレス宛に受付確認メールをお送りしました。

担当者が内容を確認し、2営業日以内にご連絡いたします。
今しばらくお待ちください。

※メールが届かない場合は、迷惑メールフォルダをご確認いただくか、お電話にてお問い合わせください。
```

## 3. page-contact.php の更新

フォーム部分を Contact Form 7 のショートコードに置き換えます。

## 4. スパム対策（オプション）

reCAPTCHA v3 を追加する場合：
1. Google reCAPTCHA でサイトキーを取得
2. Contact Form 7 の設定で統合

## メリット

✅ セキュリティ対策が万全
✅ スパム対策が簡単
✅ メール送信の信頼性が高い
✅ データベースに履歴を保存（別プラグインと組み合わせ）
✅ 既存のデザインを維持可能

