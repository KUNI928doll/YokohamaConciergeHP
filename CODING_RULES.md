# コーディングルール — YOKOHAMA Concierge

このドキュメントは、YOKOHAMA Conciergeテーマの開発における統一されたコーディング規約です。
グローバルルール（`/Users/kunisakiayaka/docs/coding-rules.md`）とプロジェクト固有ルールを統合しています。

**最終更新日**: 2026-04-29 / **バージョン**: 2.0.0

---

## 目次

1. [技術スタック](#技術スタック)
2. [HTML/PHP](#htmlphp)
3. [CSS/SCSS](#cssscss)
4. [JavaScript](#javascript)
5. [アクセシビリティ](#アクセシビリティ)
6. [パフォーマンス](#パフォーマンス)
7. [WordPress規約](#wordpress規約)
8. [Git・バージョン管理](#gitバージョン管理)
9. [チェックリスト](#チェックリスト)

---

## 技術スタック

- **HTML**: HTML5（WordPress テンプレート）
- **CSS**: SCSS → コンパイル済み CSS（`style.css`）
- **JavaScript**: バニラ JS（ES6+）、`"use strict";` を先頭に記載
- **PHP**: WordPress テンプレート・フォーム処理
- **外部ライブラリ**: GSAP（アニメーション）、Slick（スライダー）、Font Awesome（アイコン）、TranslatePress（多言語）

---

## HTML/PHP

### インデント

- **PHP / HTML**: スペース **4つ**
- **JS / SCSS**: スペース **2つ**（タブ不使用）

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
</div>
```

- `<header>`: サイトヘッダーのみ（セクション内の見出し部分には使わない）
- `<main>`: ページ内に1つのみ
- `<section>`: 見出し（`<h2>` 以上）を持つ意味ある区切り。見出しがない場合は `<div>`
- `<footer>`: サイトフッターのみ

### 見出し構造

- `<h1>`: 1ページに1つのみ
- `<h2>`: セクションタイトル（`<section>` の直下）
- `<h3>`: セクション内の小見出し
- 見出しレベルは飛ばさない（h1 → h3 は禁止）

### セクション区切りコメント

```html
<!-- Header -->
<!-- Hero / First View -->
<!-- Service -->
<!-- FAQ -->
<!-- Footer -->
```

### 画像

```html
<!-- テーマ内の静的画像：WebP + フォールバック（推奨） -->
<picture>
    <source srcset="images/photo.webp" type="image/webp">
    <img src="images/photo.jpg" alt="説明文" width="560" height="560" loading="lazy">
</picture>

<!-- シンプルな場合（装飾・アイコン等） -->
<img
    src="<?php echo get_template_directory_uri(); ?>/images/icon.png"
    alt=""
    aria-hidden="true"
    width="52"
    height="52"
    loading="lazy"
>
```

- `alt` は必ず記載（装飾画像は `alt=""`）
- `width` / `height` 属性は必須（CLS 防止）
- ファーストビュー以外は `loading="lazy"` 必須
- 装飾画像は `aria-hidden="true"` を併用

### ボタンとリンクの使い分け

```html
<!-- ページ遷移する場合: <a> -->
<a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn">お問い合わせ</a>

<!-- 外部リンク: rel 必須 -->
<a href="https://example.com" target="_blank" rel="noopener noreferrer">外部サイト</a>

<!-- JavaScript動作のみ: <button> -->
<button type="button" class="modal-open" aria-label="モーダルを開く">開く</button>
```

`target="_blank"` を使う場合は必ず `rel="noopener noreferrer"` を付ける（タブナビング攻撃防止）。

### フォーム

```html
<label for="reservation-name" class="reservation-form__label">お名前</label>
<input id="reservation-name" type="text" name="name" class="reservation-form__input">

<label for="reservation-email" class="reservation-form__label">メールアドレス</label>
<input id="reservation-email" type="email" name="email" class="reservation-form__input">
```

- `<label>` と `<input>` は必ず `for`/`id` で紐付ける
- `<input>` に適切な `type` を指定（`text` / `email` / `tel` / `date` / `number` 等）
- `<button>` には `type="button"` または `type="submit"` を必ず明示

### WordPress関数の使用

```php
<!-- 必ずエスケープ処理を行う -->
<a href="<?php echo esc_url(home_url('/contact/')); ?>">
    <?php echo esc_html(get_the_title()); ?>
</a>

<!-- 属性値 -->
<img alt="<?php echo esc_attr($alt_text); ?>">
```

---

## CSS/SCSS

### 命名規則（BEM）

```scss
// Block
.faq {}

// Element
.faq__item {}
.faq__question {}
.faq__answer {}

// Modifier
.faq__item--active {}
.btn--primary {}

// 状態クラス（JS で付け外し）
.is-active
.is-open
.is-visible

// JS専用セレクタ（CSS でスタイルを当てない）
.js-modal-open
.js-fade-up
```

**BEMネスト禁止ルール**: `__` は2階層まで。`block__element__element` はNG。

```scss
// OK
.card__title {}

// NG
.card__body__text {}  // → .card__text {} に分割する
```

### ファイル構成

```
scss/
├── abstracts/
│   ├── _variables.scss   # 変数定義
│   └── _mixin.scss       # mixin 定義
├── base/
│   └── _base.scss        # 全体の基本スタイル
├── components/
│   ├── _buttons.scss
│   └── _animations.scss
├── layout/
│   ├── _header.scss
│   └── _footer.scss
├── pages/
│   ├── _home.scss
│   └── _reservation.scss
└── style.scss            # エントリーポイント
```

### レスポンシブ（デスクトップファースト）

PC基準で書き、小さい画面で上書きする。

```scss
// ✅ 基本パターン
.hero__content {
    display: flex;
    gap: 60px;

    @media (max-width: 768px) {
        flex-direction: column;
        gap: 32px;
    }
}
```

### 余白ルール

- 余白は `gap` または `padding` で管理する
- `margin` を使う場合は **`margin-bottom` に統一**（`margin-top` は使わない）
- セクション余白はSPで縮める（目安: PCの60%程度）

```scss
// 推奨
.card-list {
    display: flex;
    gap: 24px;
}

// margin が許容されるケース
.btn {
    margin-bottom: 24px;
}

// 避ける
.card {
    margin-top: 32px;    // → margin-bottom または gap/padding に変更
    margin-right: 24px;  // → gap で管理
}
```

### z-index管理

変数で一元管理する。直書き禁止。

```scss
$z-base:    1;
$z-header:  100;
$z-drawer:  150;
$z-modal:   200;
$z-tooltip: 300;
```

### アニメーション

#### GSAPとCSS transitionの併用禁止

```scss
// 悪い例：GSAPとCSS transitionが競合
.js-fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;  // ❌ 削除必須
}

// 良い例：GSAPのみで制御
.js-fade-up {
    opacity: 0;
    transform: translateY(30px);
}
```

#### prefers-reduced-motion対応（必須）

```scss
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}
```

#### SPではアニメーションを無効化

```scss
.js-fade-up {
    opacity: 0;
    transform: translateY(20px);

    &.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        opacity: 1;
        transform: none;
        transition: none;
    }
}
```

### はみ出し・横スクロール対策

- `100vw` は基本使わない（スクロールバー幅分のはみ出しが発生するため）
- `overflow-x: hidden` は `body` に設定する（`html` には当てない）

### その他

- `line-height` は単位なし数値で指定（本文: `1.8`、見出し: `1.3`）
- ホバーはタッチデバイスを除外する: `@media (hover: hover) { &:hover {} }`

---

## JavaScript

### 基本スタイル

```javascript
"use strict";

// const/let のみ（var 禁止）
const CONSTANT_VALUE = 100;
let variableValue = 50;

// アロー関数を優先
const handleClick = () => {
  // 処理
};

// セミコロン必須
const element = document.querySelector('.selector');
```

### 関数命名ルール

| プレフィックス | 用途 | 例 |
|---|---|---|
| `init` | 初期化（イベント登録・状態セット） | `initMobileMenu` |
| `handle` | イベントハンドラ | `handleMenuClick` |
| `get` | 値の取得 | `getScrollY` |
| `update` | 状態・表示の更新 | `updateActiveTab` |
| `toggle` | 表示切り替え | `toggleModal` |

### 初期化パターン

```javascript
"use strict";

const initAccordion = () => { /* ... */ };
const initModal = () => { /* ... */ };

document.addEventListener('DOMContentLoaded', () => {
  initAccordion();
  initModal();
});
```

### セレクタキャッシュ

DOM取得は関数の先頭でまとめてキャッシュする。同じ要素を何度も `querySelector` しない。

```javascript
const initModal = () => {
  const trigger  = document.querySelector('.js-modal-open');
  const modal    = document.querySelector('.modal');
  const closeBtn = document.querySelector('.js-modal-close');

  if (!trigger || !modal) return;  // 存在確認
  // 以降は変数を使う
};
```

### 状態管理

スタイルの変化はクラス操作で行う。`element.style` の直接操作は最小限に。

```javascript
// 推奨
element.classList.add('is-visible');
element.classList.toggle('is-active', condition);

// 許容（動的な値が必要な場合のみ）
answer.style.maxHeight = answer.scrollHeight + 'px';  // アコーディオン
document.body.style.overflow = 'hidden';              // スクロールロック
```

### モーダルパターン

```javascript
const openModal = () => {
  modal.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  setTimeout(() => modal.classList.add('is-active'), 10);
};

const closeModal = () => {
  modal.classList.remove('is-active');
  setTimeout(() => {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  }, 300);  // CSSトランジション時間と合わせる
};
```

### アコーディオンパターン

```javascript
// 開く
answer.removeAttribute('hidden');
item.classList.add('is-active');
requestAnimationFrame(() => {
  answer.style.maxHeight = answer.scrollHeight + 'px';
});
btn.setAttribute('aria-expanded', 'true');

// 閉じる
answer.style.maxHeight = answer.scrollHeight + 'px';
requestAnimationFrame(() => { answer.style.maxHeight = '0px'; });
item.classList.remove('is-active');
btn.setAttribute('aria-expanded', 'false');
setTimeout(() => { answer.setAttribute('hidden', ''); }, 400);
```

### DOMセレクタ

```javascript
// 良い例: 明確なセレクタ
const faqButtons = document.querySelectorAll('.faq__question');

// 悪い例: 曖昧なセレクタ
const buttons = document.querySelectorAll('button');
```

---

## アクセシビリティ

### ARIA属性

```html
<!-- アコーディオン -->
<button
    class="faq__question"
    type="button"
    aria-expanded="false"
    aria-controls="faq-answer-1"
>
    質問内容
</button>
<dd id="faq-answer-1" class="faq__answer" hidden>
    回答内容
</dd>

<!-- テキストなしアイコンボタン -->
<button type="button" aria-label="メニューを閉じる">
    <i class="fas fa-times" aria-hidden="true"></i>
</button>

<!-- 装飾アイコン -->
<i class="fas fa-hotel" aria-hidden="true"></i>
```

### セマンティックランドマーク

```html
<header role="banner">
    <nav aria-label="グローバルナビゲーション">...</nav>
</header>

<main role="main">
    <section aria-labelledby="faq-heading">
        <h2 id="faq-heading">よくある質問</h2>
    </section>
</main>

<footer role="contentinfo">...</footer>
```

---

## パフォーマンス

### 画像最適化

```html
<!-- ファーストビュー以外 -->
<img src="image.jpg" alt="説明" loading="lazy" width="800" height="600">

<!-- ファーストビュー -->
<img src="hero.jpg" alt="説明" width="1920" height="1080">
```

### CLS対策

1. 画像に `width`/`height` 属性を必ず指定
2. フォント読み込みを最適化（`display=swap`）
3. GSAPアニメーション開始位置: `start: "top 75%"`

### GPUアクセラレーション

```scss
.animated-element {
    transform: translateZ(0);
    will-change: transform;
}
```

---

## WordPress規約

### テーマファイル構成

```
yokohama-concierge/
├── css/
├── js/
├── images/
├── scss/
├── data/              # CSVデータ等
├── template-parts/
├── CODING_RULES.md
├── functions.php
├── header.php
├── footer.php
├── front-page.php
└── page-*.php
```

### functions.phpの記述

```php
// 関数名にプレフィックスを付ける
function yokohama_concierge_function_name() {
    // 処理
}

add_action('wp_enqueue_scripts', 'yokohama_concierge_enqueue_scripts');
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
wp_nonce_field('reservation_form', 'reservation_nonce');
if (!wp_verify_nonce($_POST['reservation_nonce'], 'reservation_form')) {
    wp_die('不正なリクエストです。');
}
```

### データベースクエリ

```php
// WordPress関数を優先
$query = new WP_Query(['post_type' => 'post', 'posts_per_page' => 10]);

// 直接SQLは wpdb->prepare() 必須
$results = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id)
);
```

---

## Git・バージョン管理

- `git add .` / `git add -A` は使わない（変更ファイルを個別に追加）
- SCSS を編集した場合は必ずコンパイルして `style.css` も一緒にコミット
- `.DS_Store` などのシステムファイルは除外

### コミットメッセージ

```
<type>: <概要（日本語）>
```

`type` の種類: `feat` / `fix` / `refactor` / `docs` / `chore` / `style`

```
feat: 多言語翻訳対応を追加（日英中韓）
fix: アコーディオンのhidden属性未除去バグを修正
```

---

## チェックリスト

### HTML/PHP
- [ ] `<h1>` は1ページに1つだけか
- [ ] 見出しレベルを飛ばしていないか（h1→h2→h3 の順）
- [ ] 見出しのない区切りに `<section>` を使っていないか（`<div>` を使う）
- [ ] `target="_blank"` のリンクに `rel="noopener noreferrer"` を付けたか
- [ ] フォームの `<label>` と `<input>` の `for`/`id` を紐付けたか
- [ ] `<button>` に `type` 属性を付けたか
- [ ] `width`/`height` 属性を画像に付けたか
- [ ] ファーストビュー以外の画像に `loading="lazy"` を付けたか
- [ ] 装飾画像に `alt=""` と `aria-hidden="true"` を付けたか
- [ ] テキストなしアイコンに `aria-label` を付けたか
- [ ] WordPress のエスケープ関数（`esc_url` / `esc_html` 等）を使ったか
- [ ] フォームに Nonce 検証を実装したか

### CSS/SCSS
- [ ] BEM の `__` ネストが2階層以内になっているか
- [ ] 余白を `gap` / `padding` で管理しているか（`margin` は `margin-bottom` のみ）
- [ ] z-index を変数で管理しているか（直書き禁止）
- [ ] `100vw` を使っていないか
- [ ] 横スクロールが出ていないか確認したか
- [ ] GSAPと CSS transition を併用していないか
- [ ] SP でアニメーションを無効化しているか
- [ ] `prefers-reduced-motion` に対応しているか

### JavaScript
- [ ] `"use strict";` を先頭に記載したか
- [ ] `var` を使っていないか（`const`/`let` のみ）
- [ ] セミコロンを付けているか
- [ ] DOM要素の存在確認（`if (!element) return`）をしているか
- [ ] セレクタをキャッシュしているか（同じ要素を何度も取得しない）
- [ ] スタイル変化をクラス操作（`classList`）で行っているか
- [ ] `aria-expanded` をトグル操作と同期しているか
- [ ] `console.log` を本番コードに残していないか

### アクセシビリティ
- [ ] アコーディオンに `aria-expanded` と `aria-controls` を付けたか
- [ ] アイコンのみのボタンに `aria-label` を付けたか
- [ ] 装飾アイコン（Font Awesome 等）に `aria-hidden="true"` を付けたか
- [ ] キーボード操作（Tab / Enter / Escape）が正常に動くか

---

## 参考リソース

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [BEM Methodology](https://en.bem.info/methodology/)
- [GSAP Documentation](https://greensock.com/docs/)
