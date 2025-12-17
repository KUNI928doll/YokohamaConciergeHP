<?php
/**
 * テーマ functions
 */

// テーマサポート
function yokohama_concierge_theme_support() {
    // タイトルタグのサポート
    add_theme_support('title-tag');
    
    // アイキャッチ画像のサポート
    add_theme_support('post-thumbnails');
    
    // HTML5のサポート
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));
}
add_action('after_setup_theme', 'yokohama_concierge_theme_support');

// 構造化データ(JSON-LD)を出力
function yokohama_concierge_schema_markup() {
    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'YOKOHAMA Concierge',
        'url' => esc_url(home_url('/')),
        'image' => esc_url(get_template_directory_uri() . '/images/ogp.jpg'),
        'telephone' => '+81-45-681-2737',
        'address' => array(
            '@type' => 'PostalAddress',
            'postalCode' => '231-0023',
            'addressRegion' => '神奈川県',
            'addressLocality' => '横浜市中区山下町',
            'streetAddress' => '76−4−1301'
        ),
        'openingHoursSpecification' => array(
            array(
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
                'opens' => '10:00',
                'closes' => '18:00'
            )
        )
    );
    
    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'yokohama_concierge_schema_markup');



// テーマ有効化時の処理
function yokohama_concierge_theme_activation() {
    // 必要な固定ページを自動作成
    $pages = array(
        array(
            'title' => 'プライバシーポリシー',
            'slug' => 'privacy',
            'template' => 'page-privacy.php',
            'content' => '<p>プライバシーポリシーの内容をここに記載してください。</p>'
        ),
        array(
            'title' => '利用規約',
            'slug' => 'terms',
            'template' => 'page-terms.php',
            'content' => '<p>利用規約の内容をここに記載してください。</p>'
        ),
        array(
            'title' => '観光ガイドサービス',
            'slug' => 'service-tour-guide',
            'template' => 'page-service-tour-guide.php',
            'content' => '<p>観光ガイドサービスの内容をここに記載してください。</p>'
        ),
        array(
            'title' => 'トランクお預かりサービス',
            'slug' => 'service-storage',
            'template' => 'page-service-storage.php',
            'content' => '<p>トランクお預かりサービスの内容をここに記載してください。</p>'
        ),
        array(
            'title' => '予約代行サービス',
            'slug' => 'service-reserve',
            'template' => 'page-service-reserve.php',
            'content' => '<p>予約代行サービスの内容をここに記載してください。</p>'
        ),
        array(
            'title' => 'お問い合わせ',
            'slug' => 'contact',
            'template' => 'page-contact.php',
            'content' => '<p>お問い合わせページ</p>'
        ),
        array(
            'title' => 'お知らせ・イベント',
            'slug' => 'news',
            'template' => 'page-news.php',
            'content' => '<p>お知らせ・イベントページ</p>'
        )
    );
    
    foreach ($pages as $page_data) {
        // 既存のページをチェック
        $page_check = get_page_by_path($page_data['slug']);
        
        if (!$page_check) {
            // ページが存在しない場合のみ作成
            $page_id = wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_name' => $page_data['slug'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_author' => 1
            ));
            
            // テンプレートを設定
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page_data['template']);
            }
        }
    }
    
    // パーマリンクをフラッシュ
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'yokohama_concierge_theme_activation');

// 初回読み込み時にもページを確認・作成
function yokohama_concierge_check_pages() {
    // 管理画面でのみ実行（パフォーマンス向上のため）
    if (!is_admin()) {
        return;
    }
    
    // お問い合わせページが存在するか確認
    $contact_page = get_page_by_path('contact');
    
    if (!$contact_page) {
        // ページが存在しない場合は作成
        $page_id = wp_insert_post(array(
            'post_title' => 'お問い合わせ',
            'post_name' => 'contact',
            'post_content' => '<p>お問い合わせページ</p>',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ));
        
        // テンプレートを設定
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-contact.php');
            flush_rewrite_rules();
        }
    }
}
add_action('admin_init', 'yokohama_concierge_check_pages');

// スクリプトとスタイルの読み込み
function yokohama_concierge_enqueue_scripts() {
    // メインスタイルシート
    wp_enqueue_style(
        'yokohama-main-style',
        get_template_directory_uri() . '/css/style.css',
        array(),
        '20241214001'
    );
    
    // jQuery（WordPressに含まれているものを使用）
    wp_enqueue_script('jquery');
    
    // GSAP（ヘッダーで読み込み）
    wp_enqueue_script(
        'gsap',
        'https://unpkg.com/gsap@3/dist/gsap.min.js',
        array(),
        '3.0.0',
        false // ヘッダーで読み込み
    );
    
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.0.0',
        false // ヘッダーで読み込み
    );
    
    // Slick Carousel（フッターで読み込み）
    wp_enqueue_script(
        'slick-carousel',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        array('jquery'),
        '1.8.1',
        true // フッターで読み込み
    );
    
    // Swiper（フッターで読み込み）
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
        array(),
        '10.0.0',
        true
    );
    
    // カスタムスクリプト（フッターで読み込み）
    wp_enqueue_script(
        'yokohama-header',
        get_template_directory_uri() . '/js/header.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script(
        'yokohama-about',
        get_template_directory_uri() . '/js/about.js',
        array('jquery', 'gsap'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script(
        'yokohama-accordion',
        get_template_directory_uri() . '/js/accordion.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script(
        'yokohama-news',
        get_template_directory_uri() . '/js/news.js',
        array('jquery', 'slick-carousel'),
        '9',
        true
    );
    
    wp_enqueue_script(
        'yokohama-pagetop',
        get_template_directory_uri() . '/js/pagetop.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    wp_enqueue_script(
        'yokohama-features-modal',
        get_template_directory_uri() . '/js/features-modal.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // ツアーガイドページ専用スクリプト
    if (is_page_template('page-service-tour-guide.php')) {
        wp_enqueue_script(
            'yokohama-service-tour-guide',
            get_template_directory_uri() . '/js/service-tour-guide.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
    
    // お問い合わせページ専用スクリプト
    if (is_page_template('page-contact.php') || is_page('contact')) {
        wp_enqueue_script(
            'yokohama-contact',
            get_template_directory_uri() . '/js/contact.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        wp_enqueue_script(
            'yokohama-inquiry',
            get_template_directory_uri() . '/js/inquiry.js',
            array('jquery', 'yokohama-contact'),
            '1.0.0',
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'yokohama_concierge_enqueue_scripts');
