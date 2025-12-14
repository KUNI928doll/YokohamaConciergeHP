<?php
/**
 * テーマ functions
 */

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

// スクリプトとスタイルの読み込み
function yokohama_concierge_enqueue_scripts() {
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
}
add_action('wp_enqueue_scripts', 'yokohama_concierge_enqueue_scripts');
