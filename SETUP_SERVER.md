# サーバーセットアップガイド

## 現在の状況

現在、ローカル環境（ファイルとして直接開いている状態）でHTMLを表示しているため、PHPスクリプトが動作せず、メール送信ができません。

**デモモード**として動作しており、送信ボタンを押すと完了画面は表示されますが、実際のメール送信は行われていません。

## 本番環境で動作させるための手順

### 方法1: ローカルサーバーを起動（開発・テスト用）

#### PHPの組み込みサーバーを使用

```bash
# プロジェクトのルートディレクトリに移動
cd /Users/kunisakiayaka/YokohamaConciergeHP-11

# PHPサーバーを起動
php -S localhost:8000
```

その後、ブラウザで以下にアクセス:
```
http://localhost:8000/reservation.html
```

#### MAMPを使用（Mac）

1. MAMPをインストール: https://www.mamp.info/
2. MAMPを起動
3. プロジェクトフォルダをMAMPの`htdocs`に配置
4. ブラウザで `http://localhost:8888/YokohamaConciergeHP-11/reservation.html` にアクセス

### 方法2: 本番サーバーにアップロード

#### 必要なファイル
```
/api/send-reservation.php
/api/.htaccess
/js/reservation.js
/reservation.html
```

#### アップロード手順

1. **FTPクライアントを使用**（FileZilla、Cyberduckなど）
2. サーバーにログイン
3. 上記ファイルをアップロード
4. パーミッション設定:
   ```
   api/ → 755
   api/send-reservation.php → 644
   ```

#### サーバー要件の確認

サーバーで以下のコマンドを実行して確認:
```bash
php -v  # PHP 7.0以上
php -m | grep mbstring  # mbstringが有効か確認
```

### 方法3: テスト用の簡易サーバー（Python）

PHPがない場合、まずは静的ファイルの確認用:
```bash
cd /Users/kunisakiayaka/YokohamaConciergeHP-11
python3 -m http.server 8000
```

ブラウザで `http://localhost:8000/reservation.html` にアクセス

**注意**: Pythonサーバーでは.phpファイルは実行されません。

## 現在のエラーについて

### エラーメッセージ
```
送信に失敗しました。ネットワーク接続を確認して、もう一度お試しください。
```

### 原因
1. **ローカルファイルとして開いている**
   - `file:///Users/...` のURLで開いている
   - JavaScriptのfetch APIが制限される

2. **PHPサーバーが動作していない**
   - `.php`ファイルが実行されない
   - HTTPサーバーが必要

### 解決方法

#### 今すぐ動作確認したい場合
→ **上記「方法1」のPHPサーバーを起動**してください

#### 本番環境で使用する場合
→ **上記「方法2」でサーバーにアップロード**してください

## デモモードについて

現在のコードは、PHPサーバーがない環境でも**デモモード**として動作します:

- ✅ フォーム入力
- ✅ 確認画面表示
- ✅ 完了画面表示
- ❌ 実際のメール送信（PHPサーバーが必要）

ブラウザのコンソール（F12キー）を開くと、以下のメッセージが表示されます:
```
【デモモード】実際のメール送信は行われていません。
本番環境ではPHPサーバーで ./api/send-reservation.php が動作します。
```

## メール送信のテスト

### 1. ローカルでテスト（PHPサーバー起動後）

```bash
# PHPサーバーを起動
php -S localhost:8000

# 別のターミナルでテスト送信
curl -X POST http://localhost:8000/api/send-reservation.php \
  -F "name=テスト太郎" \
  -F "phone=090-1234-5678" \
  -F "email=test@example.com"
```

### 2. 本番サーバーでテスト

1. ブラウザで予約フォームにアクセス
2. テストデータを入力
3. 送信
4. `info@hamanavi-s.jp` にメールが届くか確認

## トラブルシューティング

### Q: 「送信に失敗しました」と表示される
**A**: PHPサーバーが動作していません。上記の方法でサーバーを起動してください。

### Q: メールが届かない
**A**: 
1. サーバーのSMTP設定を確認
2. `php.ini`のメール設定を確認
3. スパムフォルダを確認

### Q: 「Access-Control-Allow-Origin」エラー
**A**: CORSの問題です。`send-reservation.php`のヘッダー設定を確認してください。

## 推奨環境

### 開発環境
- MAMP/XAMPP（Mac/Windows）
- PHP 7.4以上
- ローカルSMTPサーバー（MailHog等）

### 本番環境
- 共有サーバー or VPS
- PHP 7.4以上
- SMTP設定済み
- SSL/TLS（HTTPS）

## サポート

問題が解決しない場合:
1. ブラウザのコンソール（F12）でエラーを確認
2. サーバーのエラーログを確認
3. ホスティング会社のサポートに問い合わせ

---

**重要**: 本番環境では必ずHTTPSを使用し、個人情報を保護してください。

