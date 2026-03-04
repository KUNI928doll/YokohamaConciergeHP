# 検索エンジンインデックス問題の調査と対応まとめ

## 📋 問題の概要

WordPressサイトが検索エンジンにインデックスされない問題が発生。Google Search Consoleで`noindex`が検出されている可能性がある。

---

## 🔍 想定されるnoindexの要因

### 1. ⚠️ 遅延読み込み（Lazy Loading）による影響 【重要】

**問題点：**
- プラグインが画像を`data-src`属性に変換している
- 検索エンジンクローラーが画像を正しく読み込めない可能性
- コンテンツが不完全と判断され、インデックスされない可能性

**確認箇所：**
- フッターのHTMLコードに`data-src`と`lazyload`クラスが存在
- プラグイン（WP Rocket、Autoptimize、Smush等）が遅延読み込みを実装している可能性

**対応方法：**
- 検索エンジンクローラーに対して遅延読み込みを無効化
- `data-src`を`src`に自動変換する機能を実装

---

### 2. WordPress管理画面の設定

**確認場所：**
- 「設定」→「表示設定」

**チェック項目：**
- ✅ 「検索エンジンがサイトをインデックスしないようにする」が**無効**になっているか

**対応方法：**
- チェックが入っている場合は外す

---

### 3. SEOプラグインの設定

**対象プラグイン：**
- Yoast SEO
- All in One SEO
- Rank Math
- その他のSEOプラグイン

**確認項目：**
- 個別ページ/投稿で`noindex`が設定されていないか
- プラグインのグローバル設定で`noindex`が有効になっていないか
- カテゴリーやタグページで`noindex`が設定されていないか

**確認方法：**
- 各SEOプラグインの設定画面を確認
- ページ編集画面のSEO設定を確認

---

### 4. robots.txt の設定

**確認場所：**
- サイトルートの`robots.txt`ファイル
- URL: `https://your-site.com/robots.txt`

**チェック項目：**
- `Disallow: /` などでインデックスがブロックされていないか
- 特定のディレクトリがブロックされていないか

**対応方法：**
- 必要に応じて`robots.txt`を修正

---

### 5. HTTPステータスコードの問題

**確認場所：**
- Google Search Consoleの「カバレッジレポート」

**チェック項目：**
- **401 Unauthorized**: 認証が必要なページ
- **404 Not Found**: ページが存在しない
- **500 Internal Server Error**: サーバーエラー

**対応方法：**
- エラーの原因を特定して修正

---

### 6. キャッシュプラグインの影響

**問題点：**
- キャッシュされた`noindex`タグが残っている可能性

**対応方法：**
- キャッシュプラグインのキャッシュをクリア
- ブラウザキャッシュもクリア

---

### 7. メタタグの直接記述

**確認場所：**
- `header.php`
- `functions.php`
- その他のテンプレートファイル

**調査結果：**
- ✅ テーマファイル内に`noindex`タグは見つかりませんでした

---

## ✅ 実装した対応内容

### 実装場所
`functions.php`に2つの関数を追加（1557行目〜1676行目）

---

### 1. 検索エンジンクローラー向けの遅延読み込み無効化（JavaScript）

**関数名：** `yokohama_concierge_disable_lazy_load_for_crawlers()`

**機能：**
- 主要な検索エンジンのボットを検出
  - Googlebot、Bingbot、Yahoo、DuckDuckBot、Baiduspider、Yandexbot等
- 検出時、`data-src`を`src`に自動変換
- `lazyload`クラスを削除
- 背景画像（`data-bg`）も処理

**実装コード：**
```php
// 検索エンジンクローラーに対して遅延読み込みを無効化
function yokohama_concierge_disable_lazy_load_for_crawlers() {
    // 検索エンジンのボットを検出
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    $is_crawler = false;
    
    // 主要な検索エンジンのボットをチェック
    $crawler_patterns = array(
        'googlebot',
        'bingbot',
        'slurp', // Yahoo
        'duckduckbot',
        'baiduspider',
        'yandexbot',
        'sogou',
        'exabot',
        'facebot',
        'ia_archiver',
        'msnbot',
        'ahrefsbot',
        'semrushbot',
        'dotbot',
        'mj12bot',
    );
    
    foreach ($crawler_patterns as $pattern) {
        if (strpos($user_agent, $pattern) !== false) {
            $is_crawler = true;
            break;
        }
    }
    
    // 検索エンジンクローラーの場合、data-srcをsrcに変換するスクリプトを追加
    if ($is_crawler) {
        ?>
        <script>
        (function() {
            // ページ読み込み時にdata-srcをsrcに変換
            function convertLazyImages() {
                var lazyImages = document.querySelectorAll('img[data-src]');
                lazyImages.forEach(function(img) {
                    if (img.getAttribute('data-src')) {
                        img.setAttribute('src', img.getAttribute('data-src'));
                        img.removeAttribute('data-src');
                        img.classList.remove('lazyload');
                    }
                });
                
                // 背景画像のdata-srcも処理
                var lazyBackgrounds = document.querySelectorAll('[data-bg]');
                lazyBackgrounds.forEach(function(el) {
                    if (el.getAttribute('data-bg')) {
                        el.style.backgroundImage = 'url(' + el.getAttribute('data-bg') + ')';
                        el.removeAttribute('data-bg');
                    }
                });
            }
            
            // DOMContentLoaded時に実行
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', convertLazyImages);
            } else {
                convertLazyImages();
            }
            
            // 遅延読み込みライブラリが実行される前に実行
            setTimeout(convertLazyImages, 0);
        })();
        </script>
        <?php
    }
}
add_action('wp_head', 'yokohama_concierge_disable_lazy_load_for_crawlers', 999);
```

---

### 2. プラグインの遅延読み込み無効化（PHPフィルター）

**関数名：** `yokohama_concierge_disable_plugin_lazy_load_for_crawlers()`

**機能：**
- 検索エンジンボット検出時に、主要プラグインの遅延読み込みを無効化
- 対応プラグイン：
  - WP Rocket
  - Autoptimize
  - Smush
  - その他一般的な遅延読み込みプラグイン

**実装コード：**
```php
// 検索エンジンクローラーに対してプラグインの遅延読み込みを無効化
function yokohama_concierge_disable_plugin_lazy_load_for_crawlers() {
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';
    $is_crawler = false;
    
    $crawler_patterns = array(
        'googlebot',
        'bingbot',
        'slurp',
        'duckduckbot',
        'baiduspider',
        'yandexbot',
        'sogou',
        'exabot',
        'facebot',
        'ia_archiver',
        'msnbot',
        'ahrefsbot',
        'semrushbot',
        'dotbot',
        'mj12bot',
    );
    
    foreach ($crawler_patterns as $pattern) {
        if (strpos($user_agent, $pattern) !== false) {
            $is_crawler = true;
            break;
        }
    }
    
    if ($is_crawler) {
        // WP Rocketの遅延読み込みを無効化
        add_filter('rocket_lazyload_enabled', '__return_false');
        
        // Autoptimizeの遅延読み込みを無効化
        add_filter('autoptimize_filter_imgopt_lazy', '__return_false');
        
        // Smushの遅延読み込みを無効化
        add_filter('wp_smush_lazy_load', '__return_false');
        
        // 一般的な遅延読み込みプラグインのフィルター
        add_filter('lazyload_is_enabled', '__return_false');
        add_filter('a3_lazy_load_enable', '__return_false');
    }
}
add_action('init', 'yokohama_concierge_disable_plugin_lazy_load_for_crawlers', 1);
```

---

## 📝 次の確認ステップ

### 1. WordPress管理画面の確認
- [ ] 「設定」→「表示設定」で「検索エンジンがサイトをインデックスしないようにする」が**無効**になっているか確認

### 2. SEOプラグインの設定確認
- [ ] 使用中のSEOプラグインで`noindex`が設定されていないか確認
- [ ] 個別ページ/投稿のSEO設定を確認

### 3. Google Search Consoleでの確認
- [ ] 「URL検査」ツールでページをテスト
- [ ] 「カバレッジレポート」でインデックス状況を確認
- [ ] 「インデックス登録レポート」で具体的なURLを確認

### 4. robots.txtの確認
- [ ] サイトルートの`robots.txt`を確認
- [ ] インデックスがブロックされていないか確認

### 5. キャッシュのクリア
- [ ] キャッシュプラグインのキャッシュをクリア
- [ ] ブラウザキャッシュもクリア

---

## 🎯 期待される効果

- ✅ 検索エンジンクローラーが画像を正しく読み込めるようになる
- ✅ コンテンツが完全に認識され、インデックスされやすくなる
- ✅ 遅延読み込みによるインデックス問題が解消される

---

## ⏰ 確認タイミング

変更を反映後、**数日〜1週間程度**でGoogle Search Consoleの結果を確認してください。

---

## 📌 注意事項

- 実装したコードは検索エンジンクローラーに対してのみ有効
- 通常のユーザーには遅延読み込みの効果が維持される
- 問題が続く場合は、具体的なURLやエラーメッセージを共有してさらに調査が必要

---

**作成日：** 2025年1月
**対象サイト：** YOKOHAMA Concierge





