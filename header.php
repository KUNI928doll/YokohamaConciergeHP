<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.icon.png">
    <link rel="apple-touch-icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/reset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Slick -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">

    <?php wp_head(); ?>
</head>
<body id="top">
    <!-- ヘッダー -->
 <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <!-- PC用ロゴ -->
                <div class="u-visible-pc">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_logo-pc.png" alt="YOKOHAMA Concierge" width="5135" height="1325">
                    </a>
                </div>

                <!-- SP用ロゴ -->
                <div class="u-visible-sp">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_logo-sp.png" alt="YOKOHAMA Concierge" width="1751" height="1786">
                    </a>
                </div>
            </div>

            <nav class="header__nav u-visible-pc" aria-label="グローバルナビゲーション">
                <div class="header__utility">
                    <!-- 左：Language / メール -->
                    <ul class="header__utility-list">
                        <li class="header__utility-item header__utility-item--wide">
                            <div class="header__language-wrapper lang-switch">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_globeicon.png" alt="地球アイコン"
                                    class="header__icon header__icon--globe" width="26" height="24">
                                <?php echo do_shortcode('[language-switcher]'); ?>
                            </div>
                        </li>
                        <li class="header__utility-item header__utility-item--xwide">
                            <a href="/contact/" class="header__utility-link is-column is-gap-large">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="メールアイコン"
                                    class="header__icon header__icon--mail" width="25" height="18">
                                メール
                            </a>
                        </li>
                    </ul>
                    <!-- 中央：電話番号 -->
                    <div class="header__contact">
                        <div class="header__contact-group">
                            <ul class="header__tel-list">
                                <li class="header__nav-item">
                                    <a href="tel:+81456812737" class="header__nav-link tel-blue">
                                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_phoneicon.png" alt="電話アイコン"
                                            class="header__icon header__icon--phone" width="17" height="20">
                                        045-681-2737
                                    </a>
                                </li>
                                <li class="header__nav-item">
                                    <a href="tel:+817015263845" class="header__nav-link tel-orange">
                                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_mobileicon.png" alt="携帯アイコン"
                                            class="header__icon header__icon--mobile" width="14" height="21">
                                        070-1526-3845
                                    </a>
                                </li>
                            </ul>
                            <p class="header__time">
                                対応時間 10:00〜18:00<span class="u-pc">/不定休</span><span class="u-sp"> <br>/不定休</span>
                            </p>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- ハンバーガー -->
            <button class="header__toggle u-visible-sp" aria-controls="global-nav" aria-expanded="false"
                aria-label="メニューを開く">
                <span class="header__toggle-line"></span>
                <span class="header__toggle-line"></span>
                <span class="header__toggle-line"></span>
                <span class="header__toggle-text">MENU</span>
            </button>

            <!-- オーバーレイ -->
            <div class="spmenu__overlay"></div>

            <nav id="global-nav" class="header__nav header__nav--sp u-visible-sp" aria-label="モバイルメニュー">
                <div class="spmenu">
                    <div class="spmenu__top">
                        <a href="<?php echo esc_url(home_url('/reservation')); ?>" class="btn btn--orange btn--sm spmenu__reserve">予約する</a>
                        <div class="header__language-wrapper lang-switch">
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_globeicon.png" alt="地球アイコン"
                                class="header__icon header__icon--globe" width="26" height="24">
                            <?php echo do_shortcode('[language-switcher]'); ?>
                        </div>
                        <button type="button" class="spmenu__close js-spmenu-close" aria-label="メニューを閉じる">
                            <span class="spmenu__close-icon"></span>
                            <span class="spmenu__close-text">CLOSE</span>
                        </button>
                    </div>
                    <ul class="spmenu__list">
                        <li class="spmenu__item spmenu__item--has-sub">
                            <button type="button" class="spmenu__trigger js-spmenu-dropdown" aria-expanded="false">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-service.png" alt="" class="spmenu__icon" aria-hidden="true" width="52" height="52">
                                サービス紹介
                                <span class="spmenu__caret" aria-hidden="true"></span>
                            </button>
                            <ul class="spmenu__sub" aria-label="サービス紹介のメニュー">
                                <li><a href="<?php echo esc_url(home_url('/service-reserve')); ?>">予約代行</a></li>
                                <li><a href="<?php echo esc_url(home_url('/service-storage')); ?>">トランクお預かり</a></li>
                                <li><a href="<?php echo esc_url(home_url('/service-tour-guide')); ?>">観光ガイドサービス</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/yokohama')); ?>"><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-yokohama.png" alt=""
                                    class="spmenu__icon" aria-hidden="true" width="60" height="60">横浜について</a>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/#faq')); ?>"><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-faq.png" alt="" class="spmenu__icon" aria-hidden="true" width="74" height="38">よくある質問</a></li>
                        <li><a href="<?php echo esc_url(home_url('/news')); ?>"><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-news.png" alt="" class="spmenu__icon" aria-hidden="true" width="52" height="52">お知らせ・イベント</a>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-mail.png" alt=""
                                    class="spmenu__icon" aria-hidden="true" width="46" height="44">お問い合わせ</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <a href="<?php echo esc_url(home_url('/reservation')); ?>" class="header__btn u-visible-pc">予約する</a>
    </header>