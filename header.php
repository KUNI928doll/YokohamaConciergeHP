<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo esc_url(get_template_directory_uri()); ?>/images/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/reset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css?v=20241214005">
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
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_logo-pc.png" alt="YOKOHAMA Concierge ロゴ（PC）">
                    </a>
                </div>

                <!-- SP用ロゴ -->
                <div class="u-visible-sp">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_logo-sp.png" alt="YOKOHAMA Concierge ロゴ（SP）">
                    </a>
                </div>
            </div>

            <nav class="header__nav u-visible-pc" aria-label="グローバルナビゲーション">
                <div class="header__utility">
                    <!-- 左：Language / メール -->
                    <ul class="header__utility-list">
                        <li class="header__utility-item header__utility-item--wide header__utility-item--language">
                            <div class="header__language-wrapper">
                                <button type="button" class="header__utility-link is-column header__language-trigger" aria-expanded="false" aria-haspopup="true">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/header_globeicon.png" alt="地球アイコン"
                                        class="header__icon header__icon--globe">
                                    <span class="header__language-text">
                                        <?php
                                        // TranslatePressの現在の言語を取得
                                        $current_lang_name = 'Language';
                                        if (class_exists('TRP_Translate_Press')) {
                                            $trp = TRP_Translate_Press::get_trp_instance();
                                            $trp_settings = $trp->get_component('settings');
                                            $settings = $trp_settings->get_settings();
                                            $current_lang = $trp->get_component('url_converter')->get_lang_from_url_string();
                                            
                                            if (isset($settings['translation-languages'][$current_lang])) {
                                                $current_lang_name = $settings['translation-languages'][$current_lang]['name'];
                                            } elseif (isset($settings['default-language']) && $current_lang === $settings['default-language']) {
                                                $current_lang_name = isset($settings['publish-languages'][$current_lang]) 
                                                    ? $settings['publish-languages'][$current_lang]['name'] 
                                                    : '日本語';
                                            }
                                        } elseif (function_exists('trp_get_current_language')) {
                                            $current_lang = trp_get_current_language();
                                            $languages = function_exists('trp_get_languages') ? trp_get_languages() : array();
                                            if (isset($languages[$current_lang])) {
                                                $current_lang_name = $languages[$current_lang]['name'];
                                            }
                                        }
                                        echo esc_html($current_lang_name);
                                        ?>
                                    </span>
                                </button>
                                <div class="header__language-dropdown" style="display: none;">
                                    <?php
                                    // TranslatePressの言語スイッチャーを表示
                                    if (class_exists('TRP_Translate_Press')) {
                                        $trp = TRP_Translate_Press::get_trp_instance();
                                        $trp_settings = $trp->get_component('settings');
                                        $settings = $trp_settings->get_settings();
                                        $current_lang = $trp->get_component('url_converter')->get_lang_from_url_string();
                                        $url_converter = $trp->get_component('url_converter');
                                        
                                        $all_languages = array_merge(
                                            array($settings['default-language'] => $settings['publish-languages'][$settings['default-language']]),
                                            $settings['translation-languages']
                                        );
                                        
                                        foreach ($all_languages as $lang_code => $lang_data) {
                                            $url = $url_converter->get_url_for_language($lang_code, false);
                                            if (!$url) {
                                                $url = home_url('/');
                                            }
                                            
                                            $is_active = ($lang_code === $current_lang);
                                            $class = $is_active ? 'header__language-item header__language-item--active' : 'header__language-item';
                                            $flag = isset($lang_data['flag']) ? $lang_data['flag'] : '🌐';
                                            $name = isset($lang_data['name']) ? $lang_data['name'] : $lang_code;
                                            
                                            echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '" data-lang="' . esc_attr($lang_code) . '">';
                                            echo '<span class="header__language-flag">' . esc_html($flag) . '</span>';
                                            echo '<span class="header__language-name">' . esc_html($name) . '</span>';
                                            echo '</a>';
                                        }
                                    } elseif (function_exists('trp_get_languages')) {
                                        $languages = trp_get_languages();
                                        $current_lang = function_exists('trp_get_current_language') ? trp_get_current_language() : 'ja';
                                        
                                        foreach ($languages as $lang_code => $lang_data) {
                                            $url = function_exists('trp_translate_page_url') 
                                                ? trp_translate_page_url(get_permalink(), $lang_code) 
                                                : home_url('/');
                                            
                                            $is_active = ($lang_code === $current_lang);
                                            $class = $is_active ? 'header__language-item header__language-item--active' : 'header__language-item';
                                            
                                            echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '" data-lang="' . esc_attr($lang_code) . '">';
                                            echo '<span class="header__language-flag">' . esc_html(isset($lang_data['flag']) ? $lang_data['flag'] : '🌐') . '</span>';
                                            echo '<span class="header__language-name">' . esc_html(isset($lang_data['name']) ? $lang_data['name'] : $lang_code) . '</span>';
                                            echo '</a>';
                                        }
                                    } else {
                                        // TranslatePressが無効な場合のフォールバック
                                        echo '<a href="#" class="header__language-item">日本語</a>';
                                        echo '<a href="#" class="header__language-item">English</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li class="header__utility-item header__utility-item--xwide">
                            <a href="mailto:info@hamanavi-s.jp" class="header__utility-link is-column is-gap-large">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="メールアイコン"
                                    class="header__icon header__icon--mail">
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
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_phoneicon.png" alt="電話アイコン"
                                            class="header__icon header__icon--phone">
                                        045-681-2737
                                    </a>
                                </li>
                                <li class="header__nav-item">
                                    <a href="tel:+817015263845" class="header__nav-link tel-orange">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_mobileicon.png" alt="携帯アイコン"
                                            class="header__icon header__icon--mobile">
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

            <nav id="global-nav" class="header__nav header__nav--sp u-visible-sp">
                <div class="spmenu">
                    <div class="spmenu__top">
                        <a href="<?php echo esc_url(home_url('/reservation')); ?>" class="btn btn--orange btn--sm spmenu__reserve">予約をする</a>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="spmenu__home">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/icon-home.png" alt="ホームアイコン">
                            <span>ホームへ戻る</span>
                        </a>
                        <button type="button" class="spmenu__close js-spmenu-close" aria-label="メニューを閉じる">
                            <span class="spmenu__close-icon"></span>
                            <span class="spmenu__close-text">CLOSE</span>
                        </button>
                    </div>
                    <ul class="spmenu__list">
                        <li class="spmenu__item spmenu__item--has-sub">
                            <button type="button" class="spmenu__trigger js-spmenu-dropdown" aria-expanded="false">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/icon-service.png" alt="" class="spmenu__icon">
                                サービス紹介
                                <span class="spmenu__caret" aria-hidden="true"></span>
                            </button>
                            <ul class="spmenu__sub" aria-label="サービス紹介のメニュー">
                                <li><a href="<?php echo esc_url(home_url('/service-reserve')); ?>">予約代行</a></li>
                                <li><a href="<?php echo esc_url(home_url('/service-storage')); ?>">トランクお預かり</a></li>
                                <li><a href="<?php echo esc_url(home_url('/service-tour-guide')); ?>">観光ガイドサービス</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/yokohama')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-yokohama.png" alt=""
                                    class="spmenu__icon">横浜について</a>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/#faq')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-faq.png" alt="" class="spmenu__icon">よくある質問</a></li>
                        <li><a href="<?php echo esc_url(home_url('/news')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-news.png" alt="" class="spmenu__icon">お知らせ・イベント</a>
                        </li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-mail.png" alt=""
                                    class="spmenu__icon">お問い合わせ</a></li>
                    </ul>
                    <div class="spmenu__bottom">
                        <!-- モバイル用言語選択 -->
                        <div class="spmenu__language">
                            <div class="spmenu__language-label">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header_globeicon.png" alt="地球アイコン" class="spmenu__language-icon">
                                <span>言語選択</span>
                            </div>
                            <div class="spmenu__language-list">
                                <?php
                                // TranslatePressの言語スイッチャーを表示
                                if (class_exists('TRP_Translate_Press')) {
                                    $trp = TRP_Translate_Press::get_trp_instance();
                                    $trp_settings = $trp->get_component('settings');
                                    $settings = $trp_settings->get_settings();
                                    $current_lang = $trp->get_component('url_converter')->get_lang_from_url_string();
                                    $url_converter = $trp->get_component('url_converter');
                                    
                                    $all_languages = array_merge(
                                        array($settings['default-language'] => $settings['publish-languages'][$settings['default-language']]),
                                        $settings['translation-languages']
                                    );
                                    
                                    foreach ($all_languages as $lang_code => $lang_data) {
                                        $url = $url_converter->get_url_for_language($lang_code, false);
                                        if (!$url) {
                                            $url = home_url('/');
                                        }
                                        
                                        $is_active = ($lang_code === $current_lang);
                                        $class = $is_active ? 'spmenu__language-item spmenu__language-item--active' : 'spmenu__language-item';
                                        $flag = isset($lang_data['flag']) ? $lang_data['flag'] : '🌐';
                                        $name = isset($lang_data['name']) ? $lang_data['name'] : $lang_code;
                                        
                                        echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '" data-lang="' . esc_attr($lang_code) . '">';
                                        echo '<span class="spmenu__language-flag">' . esc_html($flag) . '</span>';
                                        echo '<span class="spmenu__language-name">' . esc_html($name) . '</span>';
                                        echo '</a>';
                                    }
                                } elseif (function_exists('trp_get_languages')) {
                                    $languages = trp_get_languages();
                                    $current_lang = function_exists('trp_get_current_language') ? trp_get_current_language() : 'ja';
                                    
                                    foreach ($languages as $lang_code => $lang_data) {
                                        $url = function_exists('trp_translate_page_url') 
                                            ? trp_translate_page_url(get_permalink(), $lang_code) 
                                            : home_url('/');
                                        
                                        $is_active = ($lang_code === $current_lang);
                                        $class = $is_active ? 'spmenu__language-item spmenu__language-item--active' : 'spmenu__language-item';
                                        
                                        echo '<a href="' . esc_url($url) . '" class="' . esc_attr($class) . '" data-lang="' . esc_attr($lang_code) . '">';
                                        echo '<span class="spmenu__language-flag">' . esc_html(isset($lang_data['flag']) ? $lang_data['flag'] : '🌐') . '</span>';
                                        echo '<span class="spmenu__language-name">' . esc_html(isset($lang_data['name']) ? $lang_data['name'] : $lang_code) . '</span>';
                                        echo '</a>';
                                    }
                                } else {
                                    // TranslatePressが無効な場合のフォールバック
                                    echo '<a href="#" class="spmenu__language-item">日本語</a>';
                                    echo '<a href="#" class="spmenu__language-item">English</a>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="spmenu__sns">
                            <a href="https://www.instagram.com/yokohama_concierge/" target="_blank"
                                rel="noopener noreferrer">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/footer_insta.png" alt="Instagramアイコン">
                            </a>
                            <a href="mailto:info@hamanavi-s.jp">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="メールアイコン">
                            </a>
                        </div>

                        <div class="spmenu__tel">
                            <a href="tel:+81456812737" class="tel-blue">045-681-2737</a>
                            <a href="tel:+817015263845" class="tel-orange">070-1526-3845</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <a href="<?php echo esc_url(home_url('/reservation')); ?>" class="header__btn u-visible-pc">予約する</a>
    </header>