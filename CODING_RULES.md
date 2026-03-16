# コーディングルール

このドキュメントは、YOKOHAMA Conciergeテーマの開発における統一されたコーディング規約を定義します。

## 目次

1. [HTML/PHP](#htmlphp)
2. [CSS/SCSS](#cssscss)
3. [JavaScript](#javascript)
4. [アクセシビリティ](#アクセシビリティ)
5. [パフォーマンス](#パフォーマンス)
6. [WordPress規約](#wordpress規約)

---

## HTML/PHP

### 基本ルール

- **インデント**: スペース4つ
- **文字コード**: UTF-8
- **改行コード**: LF (Unix形式)

### セマンティックHTML

```html
<!-- 良い例 -->
<section id="about" class="about">
  <h2>セクションタイトル</h2>
  <p>本文</p>
</section>

<!-- 悪い例 -->
<div class="about">
  <div class="title">セクションタイトル</div>
  <div class="text">本文</div>
</div>
```

### 画像の実装

#### 必須属性

すべての`<img>`タグには以下の属性を必ず含める：

```html
<img
  src="path/to/image.png"
  alt="画像の説明"
  width="800"
  height="600"
  loading="lazy"
>
```

- **alt属性**: 意味のある画像には適切な説明を、装飾画像には`alt=""`を設定
- **width/height属性**: CLSを防ぐため必須
- **loading="lazy"**: ファーストビュー以外の画像には遅延読み込みを設定

#### 装飾画像の扱い

```html
<!-- aria-hidden="true" を併用 -->
<img
  src="decoration.png"
  alt=""
  aria-hidden="true"
  width="100"
  height="100"
  loading="lazy"
>
```

### リンクとボタン

#### 電話番号とメールアドレス

必ず`<a>`タグで実装：

```html
<!-- 電話番号 -->
<a href="tel:0456812737" class="contact__tel">
  <span>045-681-2737</span>
</a>

<!-- メールアドレス -->
<a href="mailto:info@hamanavi-s.jp" class="contact__mail">
  <span>info@hamanavi-s.jp</span>
</a>
```

#### ボタンとリンクの使い分け

```html
<!-- ページ遷移する場合: <a> -->
<a href="/contact/" class="btn">お問い合わせ</a>

<!-- JavaScript動作のみ: <button> -->
<button class="modal-open" aria-label="モーダルを開く">開く</button>
```

### WordPress関数の使用

```php
<!-- 良い例: エスケープ処理を必ず行う -->
<a href="<?php echo esc_url(home_url('/contact/')); ?>">
  <?php echo esc_html(get_the_title()); ?>
</a>

<!-- 悪い例: エスケープなし -->
<a href="<?php echo home_url('/contact/'); ?>">
  <?php echo get_the_title(); ?>
</a>
```

---

## CSS/SCSS

### 命名規則

BEM (Block Element Modifier) を使用：

```scss
// Block
.faq { }

// Element
.faq__item { }
.faq__question { }
.faq__answer { }

// Modifier
.faq__item--active { }
.faq--open { }
```

### ファイル構成

```
scss/
├── abstracts/        # 変数、mixin
│   ├── _variables.scss
│   └── _mixin.scss
├── base/            # ベーススタイル
│   └── _base.scss
├── components/      # コンポーネント
│   ├── _buttons.scss
│   └── _animations.scss
├── layout/          # レイアウト
│   ├── _header.scss
│   └── _footer.scss
├── pages/           # ページ固有スタイル
│   ├── _home.scss
│   └── _faq.scss
└── style.scss       # メインファイル
```

### アニメーション

#### GSAPとCSS transitionの併用禁止

```scss
// 悪い例: GSAPとCSS transitionが競合
.js-fade-up {
  opacity: 0;
  transform: translateY(30px);
  transition: all 0.8s ease; // ❌ 削除必須
}

// 良い例: GSAPのみで制御
.js-fade-up {
  opacity: 0;
  transform: translateY(30px);
  // transitionなし
}
```

#### アニメーション設定

```scss
// GSAPアニメーション (JavaScript側)
gsap.fromTo(
  el,
  { y: 40, opacity: 0 },
  {
    y: 0,
    opacity: 1,
    duration: 0.6,        // 短めに設定
    ease: "power2.out",
    scrollTrigger: {
      trigger: el,
      start: "top 75%",   // 早めにトリガー
    },
  }
);
```

### レスポンシブデザイン

```scss
// モバイルファースト
.element {
  // モバイル用スタイル
  width: 100%;

  // タブレット以上
  @media (min-width: 769px) {
    width: 50%;
  }

  // PC
  @media (min-width: 1200px) {
    width: 33.333%;
  }
}
```

### パフォーマンス最適化

```scss
// スクロールバーのガタつき防止
html {
  scrollbar-gutter: stable;
}

// GPU加速を利用
.animated-element {
  transform: translateZ(0);
  will-change: transform;
}
```

---

## JavaScript

### コーディングスタイル

```javascript
// セミコロンあり
const element = document.querySelector('.selector');

// const/let を使用 (var禁止)
const CONSTANT_VALUE = 100;
let variableValue = 50;

// アロー関数を優先
const handleClick = () => {
  console.log('clicked');
};
```

### DOMセレクタ

```javascript
// 良い例: 明確なセレクタ
const faqButtons = document.querySelectorAll('.faq__question');

// 悪い例: 曖昧なセレクタ
const buttons = document.querySelectorAll('button');
```

### イベントリスナー

```javascript
// DOMContentLoadedで初期化
document.addEventListener("DOMContentLoaded", () => {
  const buttons = document.querySelectorAll('.btn');

  buttons.forEach(button => {
    button.addEventListener('click', handleClick);
  });
});

// イベント委譲を活用
document.querySelector('.list').addEventListener('click', (e) => {
  if (e.target.matches('.list__item')) {
    // 処理
  }
});
```

### GSAPアニメーション

```javascript
// ScrollTrigger設定
gsap.registerPlugin(ScrollTrigger);

gsap.utils.toArray(".js-fade-up").forEach((el) => {
  gsap.fromTo(
    el,
    { y: 40, opacity: 0 },
    {
      y: 0,
      opacity: 1,
      duration: 0.6,        // 0.6秒に統一
      ease: "power2.out",
      scrollTrigger: {
        trigger: el,
        start: "top 75%",   // 75%に統一
      },
    }
  );
});
```

---

## アクセシビリティ

### ARIA属性

#### アコーディオン実装

```html
<!-- button要素でアコーディオンを実装 -->
<button
  class="faq__question"
  aria-expanded="false"
  aria-controls="faq-answer-1"
>
  <span class="faq__text">質問内容</span>
</button>

<div id="faq-answer-1" class="faq__answer" hidden>
  <p>回答内容</p>
</div>
```

```javascript
// JavaScriptで状態を更新
button.addEventListener('click', function() {
  const expanded = this.getAttribute('aria-expanded') === 'true';
  this.setAttribute('aria-expanded', String(!expanded));
  answer.hidden = expanded;
});
```

### セマンティックランドマーク

```html
<!-- ランドマークロールを適切に使用 -->
<header role="banner">
  <nav aria-label="メインナビゲーション">
    <!-- ナビゲーション -->
  </nav>
</header>

<main role="main">
  <section aria-labelledby="faq-heading">
    <h2 id="faq-heading">よくある質問</h2>
    <!-- セクション内容 -->
  </section>
</main>

<footer role="contentinfo">
  <!-- フッター -->
</footer>
```

### キーボード操作

```javascript
// Enterキーとスペースキーでボタン動作
button.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' || e.key === ' ') {
    e.preventDefault();
    handleClick();
  }
});
```

---

## パフォーマンス

### 画像最適化

#### 遅延読み込み

```html
<!-- ファーストビュー以外 -->
<img src="image.jpg" alt="説明" loading="lazy" width="800" height="600">

<!-- ファーストビュー -->
<img src="hero.jpg" alt="説明" loading="eager" width="1920" height="1080">
```

#### WordPressでの自動処理

```php
// functions.php に実装済み
add_filter('post_thumbnail_html', 'yokohama_concierge_add_img_width_height', 10, 5);
add_filter('the_content', 'yokohama_concierge_add_lazy_loading');
```

### JavaScript最適化

```javascript
// 不要なアニメーション削除
const isTabletOrMobile = window.matchMedia("(max-width: 1200px)").matches;

if (isTabletOrMobile) {
  // モバイルでは重いアニメーションをスキップ
  el.style.opacity = "1";
  return;
}
```

### CLS対策

1. **画像にwidth/height属性を必ず指定**
2. **フォント読み込みを最適化**
3. **アニメーション開始位置を調整** (`start: "top 75%"`)

---

## WordPress規約

### テーマファイル構成

```
yokohama-concierge/
├── css/
├── js/
├── images/
├── scss/
├── template-parts/
├── functions.php
├── header.php
├── footer.php
├── front-page.php
├── page-*.php
└── style.css
```

### functions.phpの記述

```php
// 関数名にプレフィックスを付ける
function yokohama_concierge_function_name() {
    // 処理
}

// アクションフック
add_action('wp_enqueue_scripts', 'yokohama_concierge_enqueue_scripts');

// フィルターフック
add_filter('post_thumbnail_html', 'yokohama_concierge_add_img_width_height', 10, 5);
```

### セキュリティ

```php
// エスケープ関数を必ず使用
echo esc_html($text);           // テキスト
echo esc_url($url);             // URL
echo esc_attr($attribute);      // 属性値
echo wp_kses_post($content);    // HTML許可

// Nonce検証
wp_nonce_field('action_name', 'nonce_name');
wp_verify_nonce($_POST['nonce_name'], 'action_name');
```

### データベースクエリ

```php
// WordPress関数を使用
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 10,
);
$query = new WP_Query($args);

// 直接SQLは避ける（必要な場合のみ）
global $wpdb;
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id)
);
```

---

## コミットメッセージ

### フォーマット

```
機能概要

- 変更内容の詳細1
- 変更内容の詳細2
- 変更内容の詳細3

Co-Authored-By: Claude Sonnet 4.5 <noreply@anthropic.com>
```

### 例

```
FAQアクセシビリティ改善

- details要素からbutton要素に変更
- aria-expanded属性とaria-controls属性を追加
- hidden属性で開閉状態を管理
- スクリーンリーダー対応を強化

Co-Authored-By: Claude Sonnet 4.5 <noreply@anthropic.com>
```

---

## バージョン管理

- **ブランチ戦略**: mainブランチで直接開発
- **コミット頻度**: 機能単位で細かくコミット
- **プッシュタイミング**: テスト完了後

---

## 参考リソース

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [BEM Methodology](https://en.bem.info/methodology/)
- [GSAP Documentation](https://greensock.com/docs/)

---

**最終更新日**: 2025-03-16
**バージョン**: 1.0.0
