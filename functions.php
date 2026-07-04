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

// アイキャッチ画像にwidth/height属性を自動付与
function yokohama_concierge_add_img_width_height($html, $post_id, $post_thumbnail_id, $size, $attr) {
    // すでにwidth/height属性が設定されている場合はスキップ
    if (strpos($html, 'width=') !== false && strpos($html, 'height=') !== false) {
        return $html;
    }

    // 画像のメタデータを取得
    $image_meta = wp_get_attachment_metadata($post_thumbnail_id);

    if (!$image_meta) {
        return $html;
    }

    // サイズが指定されている場合
    if (is_string($size) && isset($image_meta['sizes'][$size])) {
        $width = $image_meta['sizes'][$size]['width'];
        $height = $image_meta['sizes'][$size]['height'];
    } else {
        // フルサイズまたは配列でサイズ指定されている場合
        $width = $image_meta['width'];
        $height = $image_meta['height'];
    }

    // width/height属性を追加
    if ($width && $height) {
        $html = str_replace('<img', '<img width="' . esc_attr($width) . '" height="' . esc_attr($height) . '"', $html);
    }

    return $html;
}
add_filter('post_thumbnail_html', 'yokohama_concierge_add_img_width_height', 10, 5);

// コンテンツ画像に loading="lazy" を自動追加
function yokohama_concierge_add_lazy_loading($content) {
    // 既に loading 属性が設定されている画像はスキップ
    $content = preg_replace_callback(
        '/<img([^>]+?)>/i',
        function($matches) {
            $img_tag = $matches[0];

            // 既に loading 属性がある場合はそのまま返す
            if (strpos($img_tag, 'loading=') !== false) {
                return $img_tag;
            }

            // loading="lazy" を追加
            $img_tag = str_replace('<img', '<img loading="lazy"', $img_tag);

            return $img_tag;
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'yokohama_concierge_add_lazy_loading');
add_filter('post_thumbnail_html', 'yokohama_concierge_add_lazy_loading');
add_filter('get_avatar', 'yokohama_concierge_add_lazy_loading');

// 管理バーをフロントエンドから非表示（管理者以外）
add_filter('show_admin_bar', function($show) {
    return current_user_can('administrator') ? $show : false;
});

// 構造化データ(JSON-LD)を出力
function yokohama_concierge_schema_markup() {
    $schema = null;
    $business = array(
        '@type' => 'LocalBusiness',
        'name' => 'YOKOHAMA Concierge',
        'url' => esc_url(home_url('/')),
        'image' => esc_url(get_template_directory_uri() . '/images/header_logo-pc.png'),
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

    if (is_front_page()) {
        $schema = array_merge(array('@context' => 'https://schema.org'), $business);

        // FAQPageスキーマを追加出力
        $faq_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array(
                array(
                    '@type' => 'Question',
                    'name' => '予約後のキャンセルはできますか？',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => 'はい、できます。代行予約料金はご利用日の48時間前までは無料でキャンセル可能です。なお、他のサービスは各事業者様のキャンセルルールに基づくものとなります。'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name' => '当日予約も可能ですか？',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => 'できる限り対応いたします。まずはご相談ください。ご相談いただければ、可能な限りご対応いたします。5日以内の予約は緊急予約料金となりますのでご了承ください。（条件変更など相談させていただく場合もございますので、要ご相談ください）'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name' => '支払いはどのようにするのでしょうか？',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => '基本的にクレジットカード決済（Stripe決済）の支払いとなります。予約代行料金は基本的にクレジットカード決済（Stripe決済）の支払いとなります。簡単、安心決済対応いたします。トランクお預かり、観光ガイドサービス、お困りごとの解決は現金または銀行振込も可能です。なお、弊社サービス以外のご利用代金については、各事業者様ルールによる決済でお願いいたします。'
                    )
                ),
                array(
                    '@type' => 'Question',
                    'name' => 'お困りごとの解決サービスの具体的な内容はどのようなことがありますか？',
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => '幅広い内容に対応しております。1.突然の交通トラブルによる交通機関予約や宿泊先予約、飲食店舗予約（横浜近隣施設）2.突然の体調不良による交通機関予約や宿泊先予約、飲食店舗予約（横浜近隣施設）＊別途、病院の紹介や交通機関の利用方法などもご相談ください。3.旅行中の日程予定変更による各種ご予約（横浜近隣施設）＊旅行中の紛失物の対応方法などのご相談。4.その他旅行中にご相談事がある場合、弊社でご対応できる内容であれば対応いたしますので、ご相談ください。'
                    )
                )
            )
        );

        // 2つ目のスキーマとしてFAQPageを出力
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($faq_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    } elseif (is_page(array('service-tour-guide', 'service-storage', 'service-reserve', 'reservation'))) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => get_the_title(),
            'url' => get_permalink(),
            'provider' => $business
        );
        $desc = trim(wp_strip_all_tags(get_the_excerpt()));
        if ($desc !== '') {
            $schema['description'] = $desc;
        }
    } elseif (is_page('contact')) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => get_the_title(),
            'url' => get_permalink(),
            'about' => $business
        );
    } elseif (is_page('news') || is_home()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => get_the_title(),
            'url' => get_permalink()
        );
    } elseif (is_singular('post')) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => 'YOKOHAMA Concierge',
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => esc_url(get_template_directory_uri() . '/images/header_logo-pc.png')
                )
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            )
        );
        $image = get_the_post_thumbnail_url(null, 'full');
        if ($image) {
            $schema['image'] = esc_url($image);
        }
    } elseif (is_page()) {
        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => get_the_title(),
            'url' => get_permalink()
        );
        $desc = trim(wp_strip_all_tags(get_the_excerpt()));
        if ($desc !== '') {
            $schema['description'] = $desc;
        }
    }

    if (!$schema) {
        return;
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}
add_action('wp_head', 'yokohama_concierge_schema_markup');

// OGP(Open Graph Protocol)タグを出力
function yokohama_concierge_add_ogp_tags() {
    // プラグインでOGP設定されている場合はスキップ
    if (defined('WPSEO_VERSION') || class_exists('All_in_One_SEO_Pack')) {
        return;
    }

    $site_name = 'YOKOHAMA Concierge（ハマナビサービス）';
    $og_title = wp_get_document_title();
    $og_type = is_front_page() ? 'website' : 'article';
    $og_description = yokohama_concierge_get_meta_description();
    $og_image = get_template_directory_uri() . '/images/header_logo-pc.png';

    // URLの取得（アーカイブ等でget_permalink()がfalseになるのを防ぐ）
    if (is_front_page()) {
        $og_url = home_url('/');
    } elseif (is_home() && get_option('page_for_posts')) {
        $og_url = get_permalink(get_option('page_for_posts'));
    } else {
        $og_url = get_permalink();
    }

    // アイキャッチ画像がある場合は優先
    if (is_singular() && has_post_thumbnail()) {
        $og_image = get_the_post_thumbnail_url(null, 'full');
    }

    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    if ($og_url) {
        echo '<meta property="og:url" content="' . esc_url($og_url) . '">' . "\n";
    }
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";

    // Twitter Card
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($og_image) . '">' . "\n";
}
add_action('wp_head', 'yokohama_concierge_add_ogp_tags', 1);

// ページに応じたmeta descriptionの文言を返す
function yokohama_concierge_get_meta_description() {
    // 固定ページごとの説明文（スラッグ => 説明文）
    $page_descriptions = array(
        'service-reserve'    => '横浜のホテル・飲食店・体験アクティビティの予約を代行するサービスです。言葉の心配なく、ご希望の日時・条件に合わせてYOKOHAMA Conciergeのスタッフが手配いたします。',
        'service-storage'    => '横浜観光を手ぶらで楽しめるトランク（スーツケース・手荷物）お預かりサービスです。チェックイン前・チェックアウト後の観光に便利にご利用いただけます。',
        'service-tour-guide' => '元町・中華街・みなとみらいなど横浜の名所を、半日コース・1日コースでご案内する観光ガイドサービスです。通訳付きプランもご用意しています。',
        'yokohama'           => '元町・山手、中華街・山下公園、日本大通り、馬車道、桜木町、関内、みなとみらいなど、横浜の主要エリアの見どころとアクセスをご紹介します。',
        'contact'            => 'YOKOHAMA Concierge（ハマナビサービス）へのお問い合わせページです。サービス内容やご予約、お見積もりについてお気軽にご相談ください。対応時間10:00〜18:00。',
        'reservation'        => '予約代行・トランクお預かり・観光ガイドサービスのご予約フォームです。安全なオンライン決済（Stripe）に対応しています。',
        'news'               => 'YOKOHAMA Concierge（ハマナビサービス）からのお知らせと、横浜のイベント情報をお届けします。',
        'privacy'            => 'YOKOHAMA Concierge（ハマナビサービス）のプライバシーポリシー（個人情報保護方針）です。',
        'terms'              => 'YOKOHAMA Concierge（ハマナビサービス）の利用規約です。',
        'commercial'         => 'YOKOHAMA Concierge（ハマナビサービス）の特定商取引法に基づく表記です。',
    );

    // トップページ
    if (is_front_page()) {
        return '横浜を訪れる外国人旅行者向けコンシェルジュサービス「YOKOHAMA Concierge（ハマナビサービス）」。ホテル・飲食店の予約代行、トランクお預かり、観光ガイドで横浜での特別な体験をサポートします。';
    }

    // 投稿一覧（お知らせ・イベント）
    if (is_home()) {
        return $page_descriptions['news'];
    }

    // 個別投稿は抜粋を使用
    if (is_singular('post')) {
        $excerpt = get_the_excerpt();
        if ($excerpt) {
            // 自動抜粋の省略記号（ [&hellip;] ）を除去してから切り詰める
            $excerpt = wp_strip_all_tags($excerpt);
            $excerpt = str_replace(array('[&hellip;]', '[…]'), '', $excerpt);
            return mb_substr(trim($excerpt), 0, 120);
        }
    }

    // 固定ページはスラッグから取得
    if (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        if (isset($page_descriptions[$slug])) {
            return $page_descriptions[$slug];
        }
    }

    return get_bloginfo('description');
}

// meta descriptionを出力
function yokohama_concierge_add_meta_description() {
    // プラグインでSEO設定されている場合はスキップ
    if (defined('WPSEO_VERSION') || class_exists('All_in_One_SEO_Pack')) {
        return;
    }

    // 検索結果・404には出力しない
    if (is_search() || is_404()) {
        return;
    }

    $description = yokohama_concierge_get_meta_description();
    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
}
add_action('wp_head', 'yokohama_concierge_add_meta_description', 1);

// canonicalを出力（個別投稿・固定ページはWP標準のrel_canonicalが出力するため対象外）
function yokohama_concierge_add_canonical() {
    if (is_singular()) {
        return;
    }

    $canonical = '';
    if (is_front_page()) {
        $canonical = home_url('/');
    } elseif (is_home() && get_option('page_for_posts')) {
        $canonical = get_permalink(get_option('page_for_posts'));
    }

    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    }
}
add_action('wp_head', 'yokohama_concierge_add_canonical', 1);

// 検索結果ページをnoindexにする（重複・低品質ページのインデックス防止）
add_filter('wp_robots', 'wp_robots_noindex_search');



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
        ),
        array(
            'title' => 'ご予約',
            'slug' => 'reservation',
            'template' => 'page-reservation.php',
            'content' => '<p>ご予約ページ</p>'
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
        filemtime(get_template_directory() . '/css/style.css') // ファイルの更新日時を自動的にバージョンとして使用
    );
    
    // jQuery（WordPressに含まれているものを使用）
    wp_enqueue_script('jquery');
    
    // GSAP（フッターで読み込み・バージョン固定でCDNの勝手な更新による破損を防ぐ）
    wp_enqueue_script(
        'gsap',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
        array(),
        '3.12.5',
        true // フッターで読み込み
    );

    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        array('gsap'),
        '3.12.5',
        true // フッターで読み込み
    );

    // Slick Carousel（フッターで読み込み）
    wp_enqueue_script(
        'slick-carousel',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        array('jquery'),
        '1.8.1',
        true // フッターで読み込み
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
        filemtime(get_template_directory() . '/js/about.js'),
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
    
    // 予約代行ページ専用スクリプト
    if (is_page_template('page-service-reserve.php') || is_page('service-reserve')) {
        wp_enqueue_script(
            'yokohama-service-reserve',
            get_template_directory_uri() . '/js/service-reserve.js',
            array('jquery', 'slick-carousel'),
            '1.0.0',
            true
        );
    }
    
    // 横浜についてページ専用スクリプト
    if (is_page_template('page-yokohama.php') || is_page('yokohama')) {
        wp_enqueue_script(
            'yokohama-yokohama',
            get_template_directory_uri() . '/js/yokohama.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
    
    // ご予約ページ専用スクリプト
    if (is_page_template('page-reservation.php') || is_page('reservation')) {
        wp_enqueue_script(
            'yokohama-shop-selector',
            get_template_directory_uri() . '/js/shop-selector.js',
            array('jquery'),
            '1.4.0',
            true
        );
        
        // テーマディレクトリURIをJavaScriptに渡す
        wp_localize_script('yokohama-shop-selector', 'yokohamaConciergeThemeUri', array(
            'themeUri' => get_template_directory_uri()
        ));
        
        wp_enqueue_script(
            'yokohama-reservation',
            get_template_directory_uri() . '/js/reservation.js',
            array('jquery', 'yokohama-shop-selector'),
            '1.0.0',
            true
        );
        
        // ajaxurlとStripe決済用のnonceをJavaScriptに渡す
        wp_localize_script('yokohama-reservation', 'yokohamaReservation', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('reservation_form'),
            'stripeAction' => 'create_stripe_session'
        ));
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

// カスタム投稿タイプ「予約」の登録
function yokohama_concierge_register_reservation_post_type() {
    $labels = array(
        'name' => '予約',
        'singular_name' => '予約',
        'menu_name' => '予約管理',
        'add_new' => '新規追加',
        'add_new_item' => '新しい予約を追加',
        'edit_item' => '予約を編集',
        'new_item' => '新しい予約',
        'view_item' => '予約を表示',
        'search_items' => '予約を検索',
        'not_found' => '予約が見つかりませんでした',
        'not_found_in_trash' => 'ゴミ箱に予約はありません',
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 25,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array('title', 'editor', 'custom-fields'),
        'show_in_rest' => false,
    );

    register_post_type('reservation', $args);
}
add_action('init', 'yokohama_concierge_register_reservation_post_type');

// 予約カスタム投稿タイプの管理画面カラムをカスタマイズ
function yokohama_concierge_reservation_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = '予約ID';
    $new_columns['reservation_name'] = 'お名前';
    $new_columns['reservation_email'] = 'メールアドレス';
    $new_columns['reservation_phone'] = '電話番号';
    $new_columns['reservation_status'] = 'ステータス';
    $new_columns['date'] = '登録日時';
    return $new_columns;
}
add_filter('manage_reservation_posts_columns', 'yokohama_concierge_reservation_columns');

// 予約カスタム投稿タイプの管理画面カラム内容を表示
function yokohama_concierge_reservation_column_content($column, $post_id) {
    switch ($column) {
        case 'reservation_name':
            echo esc_html(get_post_meta($post_id, '_reservation_name', true));
            break;
        case 'reservation_email':
            echo esc_html(get_post_meta($post_id, '_reservation_email', true));
            break;
        case 'reservation_phone':
            echo esc_html(get_post_meta($post_id, '_reservation_phone', true));
            break;
        case 'reservation_status':
            $status = get_post_meta($post_id, '_reservation_status', true);
            $status_labels = array(
                'pending' => '未対応',
                'processing' => '対応中',
                'completed' => '完了',
                'cancelled' => 'キャンセル',
            );
            $status_label = isset($status_labels[$status]) ? $status_labels[$status] : '未対応';
            echo '<span class="reservation-status reservation-status--' . esc_attr($status ?: 'pending') . '">' . esc_html($status_label) . '</span>';
            break;
    }
}
add_action('manage_reservation_posts_custom_column', 'yokohama_concierge_reservation_column_content', 10, 2);

// 予約カスタム投稿タイプの管理画面にメタボックスを追加
function yokohama_concierge_reservation_meta_boxes() {
    add_meta_box(
        'reservation_details',
        '予約詳細情報',
        'yokohama_concierge_reservation_meta_box_callback',
        'reservation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'yokohama_concierge_reservation_meta_boxes');

// 予約メタボックスの内容
function yokohama_concierge_reservation_meta_box_callback($post) {
    wp_nonce_field('yokohama_concierge_reservation_meta_box', 'yokohama_concierge_reservation_meta_box_nonce');
    
    $name = get_post_meta($post->ID, '_reservation_name', true);
    $email = get_post_meta($post->ID, '_reservation_email', true);
    $phone = get_post_meta($post->ID, '_reservation_phone', true);
    $gender = get_post_meta($post->ID, '_reservation_gender', true);
    $nationality = get_post_meta($post->ID, '_reservation_nationality', true);
    $address = get_post_meta($post->ID, '_reservation_address', true);
    $passport = get_post_meta($post->ID, '_reservation_passport', true);
    $stay = get_post_meta($post->ID, '_reservation_stay', true);
    $companion = get_post_meta($post->ID, '_reservation_companion', true);
    $status = get_post_meta($post->ID, '_reservation_status', true);
    
    // 全フォームデータを取得（JSON形式で保存されている場合）
    $form_data = get_post_meta($post->ID, '_reservation_form_data', true);
    if (is_string($form_data)) {
        $form_data = json_decode($form_data, true);
    }
    
    ?>
    <table class="form-table">
        <tr>
            <th><label for="reservation_status">ステータス</label></th>
            <td>
                <select name="reservation_status" id="reservation_status">
                    <option value="pending" <?php selected($status, 'pending'); ?>>未対応</option>
                    <option value="processing" <?php selected($status, 'processing'); ?>>対応中</option>
                    <option value="completed" <?php selected($status, 'completed'); ?>>完了</option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>>キャンセル</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label>お名前</label></th>
            <td><?php echo esc_html($name); ?></td>
        </tr>
        <tr>
            <th><label>メールアドレス</label></th>
            <td><?php echo esc_html($email); ?></td>
        </tr>
        <tr>
            <th><label>電話番号</label></th>
            <td><?php echo esc_html($phone); ?></td>
        </tr>
        <?php if ($gender): ?>
        <tr>
            <th><label>性別</label></th>
            <td><?php echo esc_html($gender === 'male' ? '男性' : ($gender === 'female' ? '女性' : 'その他')); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($nationality): ?>
        <tr>
            <th><label>国籍</label></th>
            <td><?php echo esc_html($nationality); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($address): ?>
        <tr>
            <th><label>住所</label></th>
            <td><?php echo esc_html($address); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($passport): ?>
        <tr>
            <th><label>パスポート番号</label></th>
            <td><?php echo esc_html($passport); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($stay): ?>
        <tr>
            <th><label>滞在先</label></th>
            <td><?php echo esc_html($stay); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($companion): ?>
        <tr>
            <th><label>同伴者情報</label></th>
            <td><?php echo nl2br(esc_html($companion)); ?></td>
        </tr>
        <?php endif; ?>
    </table>
    
    <?php if ($form_data && is_array($form_data)): ?>
    <h3>その他のフォームデータ</h3>
    <table class="form-table">
        <?php foreach ($form_data as $key => $value): ?>
            <?php if (!empty($value) && !in_array($key, array('name', 'email', 'phone', 'gender', 'nationality', 'address', 'passport', 'stay', 'companion'))): ?>
            <tr>
                <th><label><?php echo esc_html(ucfirst(str_replace('_', ' ', $key))); ?></label></th>
                <td><?php echo is_array($value) ? esc_html(implode(', ', $value)) : nl2br(esc_html($value)); ?></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    
    <style>
        .reservation-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        .reservation-status--pending { background: #fff3cd; color: #856404; }
        .reservation-status--processing { background: #cfe2ff; color: #084298; }
        .reservation-status--completed { background: #d1e7dd; color: #0f5132; }
        .reservation-status--cancelled { background: #f8d7da; color: #842029; }
    </style>
    <?php
}

// 予約メタボックスの保存
function yokohama_concierge_reservation_save_meta_box($post_id) {
    // 自動保存の場合は処理をスキップ
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // 権限チェック
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // ノンスチェック
    if (!isset($_POST['yokohama_concierge_reservation_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['yokohama_concierge_reservation_meta_box_nonce'], 'yokohama_concierge_reservation_meta_box')) {
        return;
    }
    
    // ステータスの保存
    if (isset($_POST['reservation_status'])) {
        update_post_meta($post_id, '_reservation_status', sanitize_text_field($_POST['reservation_status']));
    }
}
add_action('save_post_reservation', 'yokohama_concierge_reservation_save_meta_box');

// 予約フォーム送信処理
function yokohama_concierge_handle_reservation_submit() {
    // セキュリティチェック
    if (!isset($_POST['reservation_nonce']) || !wp_verify_nonce($_POST['reservation_nonce'], 'reservation_form')) {
        wp_die('セキュリティチェックに失敗しました。');
    }
    
    // フォームデータの取得とサニタイズ
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    
    // 必須項目チェック
    if (empty($name) || empty($email) || empty($phone)) {
        wp_redirect(add_query_arg('reservation', 'error', home_url('/reservation/')));
        exit;
    }
    
    // すべてのフォームデータを取得
    $form_data = array();
    foreach ($_POST as $key => $value) {
        // セキュリティ関連のフィールドは除外
        if (in_array($key, array('reservation_nonce', 'action', '_wp_http_referer'))) {
            continue;
        }
        
        if (is_array($value)) {
            $form_data[$key] = array_map('sanitize_text_field', $value);
        } else {
            $form_data[$key] = sanitize_text_field($value);
        }
    }
    
    // カスタム投稿タイプ「予約」として保存
    $post_data = array(
        'post_type' => 'reservation',
        'post_title' => sprintf('予約: %s (%s)', $name, date('Y-m-d H:i:s')),
        'post_content' => '',
        'post_status' => 'publish',
        'meta_input' => array(
            '_reservation_name' => $name,
            '_reservation_email' => $email,
            '_reservation_phone' => $phone,
            '_reservation_gender' => isset($_POST['gender']) ? sanitize_text_field($_POST['gender']) : '',
            '_reservation_nationality' => isset($_POST['nationality']) ? sanitize_text_field($_POST['nationality']) : '',
            '_reservation_address' => isset($_POST['address']) ? sanitize_text_field($_POST['address']) : '',
            '_reservation_passport' => isset($_POST['passport']) ? sanitize_text_field($_POST['passport']) : '',
            '_reservation_stay' => isset($_POST['stay']) ? sanitize_text_field($_POST['stay']) : '',
            '_reservation_companion' => isset($_POST['companion']) ? sanitize_textarea_field($_POST['companion']) : '',
            '_reservation_status' => 'pending',
            '_reservation_form_data' => json_encode($form_data, JSON_UNESCAPED_UNICODE),
        ),
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (is_wp_error($post_id)) {
        wp_redirect(add_query_arg('reservation', 'error', home_url('/reservation/')));
        exit;
    }
    
    // 個別のメタフィールドとしても保存（検索・表示用）
    foreach ($form_data as $key => $value) {
        if (!empty($value) && !in_array($key, array('name', 'email', 'phone', 'gender', 'nationality', 'address', 'passport', 'stay', 'companion'))) {
            if (is_array($value)) {
                update_post_meta($post_id, '_reservation_' . $key, $value);
            } else {
                update_post_meta($post_id, '_reservation_' . $key, $value);
            }
        }
    }
    
    // Make Webhook送信（エラーでも処理は続行）
    yokohama_concierge_send_to_make_webhook($post_id, $form_data);
    
    // メール送信処理
    $to = get_option('admin_email');
    $subject = '【YOKOHAMA Concierge】予約フォームからのお問い合わせ';
    $message = "予約フォームからお問い合わせがありました。\n\n";
    $message .= "予約ID: #" . $post_id . "\n";
    $message .= "お名前: " . $name . "\n";
    $message .= "メールアドレス: " . $email . "\n";
    $message .= "電話番号: " . $phone . "\n\n";
    $message .= "詳細は管理画面でご確認ください: " . admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";
    
    wp_mail($to, $subject, $message);
    
    // リダイレクト
    wp_redirect(add_query_arg('reservation', 'success', home_url('/reservation/')));
    exit;
}
add_action('admin_post_submit_reservation', 'yokohama_concierge_handle_reservation_submit');
add_action('admin_post_nopriv_submit_reservation', 'yokohama_concierge_handle_reservation_submit');

// Stripe決済セッション作成
/**
 * Stripe Secret Key を正規化（不可視文字/改行/スペース等の混入を除去）
 * - Stripeのキーは英数字とアンダースコアのみのため、それ以外は削除する
 */
function yokohama_concierge_normalize_stripe_secret_key($key) {
    if (!is_string($key)) return '';
    $key = trim($key);
    // 目に見えない空白や改行、コピペ時の混入文字を除去
    $key = preg_replace('/[^A-Za-z0-9_]/', '', $key);
    return $key;
}

function yokohama_concierge_create_stripe_session() {
    // セキュリティチェック
    if (!isset($_POST['reservation_nonce']) || !wp_verify_nonce($_POST['reservation_nonce'], 'reservation_form')) {
        wp_send_json_error(array('message' => 'セキュリティチェックに失敗しました。'));
        return;
    }
    
    // Stripe APIキーの設定（環境変数またはオプションから取得）
    $stripe_secret_key = defined('STRIPE_SECRET_KEY') ? STRIPE_SECRET_KEY : get_option('stripe_secret_key', '');
    
    if (empty($stripe_secret_key)) {
        wp_send_json_error(array('message' => 'Stripe APIキーが設定されていません。'));
        return;
    }
    
    // APIキーの正規化（不可視文字/改行/スペース等を除去）
    $stripe_secret_key = yokohama_concierge_normalize_stripe_secret_key($stripe_secret_key);
    
    // デバッグ（サーバーログのみ）
    if (defined('WP_DEBUG') && WP_DEBUG) {
        error_log('Stripe API Key Debug - Length: ' . strlen($stripe_secret_key));
    }
    
    // APIキーの形式をチェック
    $key_prefix = substr($stripe_secret_key, 0, 8); // sk_test_ / sk_live_
    if ($key_prefix !== 'sk_test_' && $key_prefix !== 'sk_live_') {
        wp_send_json_error(array(
            'message' => 'Stripe APIキーの形式が正しくありません。sk_test_ または sk_live_ で始まるキーを設定してください。'
        ));
        return;
    }
    
    // キーの長さをチェック（通常のStripe APIキーは約100文字以上）
    if (strlen($stripe_secret_key) < 50) {
        wp_send_json_error(array(
            'message' => 'Stripe APIキーが短すぎます。キーが完全に保存されていない可能性があります。'
        ));
        return;
    }
    
    // Stripe PHP SDKの読み込み（Composer経由でインストールされている場合）
    // require_once get_template_directory() . '/vendor/autoload.php';
    // または、Stripe PHP SDKを直接インストールしている場合
    // require_once get_template_directory() . '/includes/stripe-php/init.php';
    
    // フォームデータの取得
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    
    // 見積もり計算（クライアント側から送信された金額を使用、またはサーバー側で計算）
    $estimated_amount = isset($_POST['estimated_amount']) ? intval($_POST['estimated_amount']) : 0;
    
    if ($estimated_amount > 0) {
        $amount = $estimated_amount;
    } else {
        // サーバー側で計算（フォールバック）
        $amount = 0;
        
        // 観光ガイドサービス
        if (isset($_POST['guideCourse']) && !empty($_POST['guideCourse'])) {
            $guideCourse = sanitize_text_field($_POST['guideCourse']);
            $guideNotes = isset($_POST['guideNotes']) ? sanitize_text_field($_POST['guideNotes']) : '';
            $hasTranslation = (stripos($guideNotes, '通訳') !== false || stripos($guideNotes, '翻訳') !== false);

            switch ($guideCourse) {
                case 'half_audio':
                    $amount += 12000;
                    break;
                case 'half_interpreter':
                    $amount += 20000;
                    break;
                case 'full_audio':
                    $amount += 22000;
                    break;
                case 'full_interpreter':
                    $amount += 30000;
                    break;
                case 'half':
                    $amount += $hasTranslation ? 20000 : 12000;
                    break;
                case 'full':
                    $amount += $hasTranslation ? 30000 : 22000;
                    break;
            }
        }
        
        // ホテル予約代行サービス
        if (isset($_POST['hotelDate']) && !empty($_POST['hotelDate'])) {
            $amount += 2200;
        }
        
        // 飲食店舗予約代行サービス
        if (isset($_POST['diningDate']) && !empty($_POST['diningDate'])) {
            $amount += 2200;
        }
        
        // トランクお預かりサービス
        if (isset($_POST['luggageDate']) && !empty($_POST['luggageDate'])) {
            $luggageCount = isset($_POST['luggageCount']) ? intval($_POST['luggageCount']) : 1;
            $amount += 1800 * $luggageCount;
        }
        
        // 緊急予約料金のチェック
        $now = time();
        $tomorrow = $now + (24 * 60 * 60);
        $urgentCount = 0;
        
        $datetimeFields = array('hotelDate', 'diningDate', 'luggageDate');
        foreach ($datetimeFields as $fieldName) {
            if (isset($_POST[$fieldName]) && !empty($_POST[$fieldName])) {
                $reservationDate = strtotime($_POST[$fieldName]);
                if ($reservationDate <= $tomorrow) {
                    $urgentCount++;
                }
            }
        }
        
        if ($urgentCount > 0) {
            $amount += 1000 * $urgentCount;
        }
        
        // 最低金額を設定
        if ($amount < 1000) {
            $amount = 1000;
        }
    }
    
    // フォームデータを一時保存（24時間有効）
    $form_data_to_save = array();
    foreach ($_POST as $key => $value) {
        // セキュリティ関連のフィールドは除外
        if (in_array($key, array('reservation_nonce', 'action', '_wp_http_referer'))) {
            continue;
        }
        
        if (is_array($value)) {
            $form_data_to_save[$key] = array_map('sanitize_text_field', $value);
        } else {
            $form_data_to_save[$key] = sanitize_text_field($value);
        }
    }
    
    $form_data_json = json_encode($form_data_to_save, JSON_UNESCAPED_UNICODE);
    $temp_key = 'stripe_form_' . time() . '_' . wp_generate_password(12, false);
    set_transient($temp_key, $form_data_json, 24 * HOUR_IN_SECONDS);
    
    $description = 'YOKOHAMA Concierge 予約代行サービス';
    // 観光ガイドサービス
    // Stripe metadata 用の値を抽出（存在するものだけ）
    $area = '';
    if (!empty($_POST['guideArea'])) {
        $area = sanitize_text_field($_POST['guideArea']);
    } elseif (!empty($_POST['diningArea'])) {
        $area = sanitize_text_field($_POST['diningArea']);
    } elseif (!empty($_POST['hotelArea'])) {
        $area = sanitize_text_field($_POST['hotelArea']);
    }

    $food_type = '';
    if (!empty($_POST['cuisine'])) {
        $food_type = sanitize_text_field($_POST['cuisine']);
    } elseif (!empty($_POST['diningGenre'])) {
        $food_type = sanitize_text_field($_POST['diningGenre']);
    } elseif (!empty($_POST['diningCuisine'])) {
        $food_type = sanitize_text_field($_POST['diningCuisine']);
    }

    $price_range = '';
    if (!empty($_POST['diningBudget'])) {
        $price_range = sanitize_text_field($_POST['diningBudget']);
    } elseif (!empty($_POST['hotelBudget'])) {
        $price_range = sanitize_text_field($_POST['hotelBudget']);
    }

    $coupon = !empty($_POST['coupon']) ? sanitize_text_field($_POST['coupon']) : '';
    $priority = !empty($_POST['priority']) ? sanitize_text_field($_POST['priority']) : '';

    $note_parts = array();
    if (!empty($_POST['guideNotes'])) $note_parts[] = sanitize_text_field($_POST['guideNotes']);
    if (!empty($_POST['diningRequest'])) $note_parts[] = sanitize_text_field($_POST['diningRequest']);
    if (!empty($_POST['hotelRequest'])) $note_parts[] = sanitize_text_field($_POST['hotelRequest']);
    if (!empty($_POST['luggageNotes'])) $note_parts[] = sanitize_text_field($_POST['luggageNotes']);
    $note = implode(' / ', $note_parts);

    // Stripe metadata の長さ制限対策（念のため）
    $max_meta_len = 500;
    $area = substr($area, 0, $max_meta_len);
    $food_type = substr($food_type, 0, $max_meta_len);
    $price_range = substr($price_range, 0, $max_meta_len);
    $coupon = substr($coupon, 0, $max_meta_len);
    $priority = substr($priority, 0, $max_meta_len);
    $note = substr($note, 0, $max_meta_len);
    
    // Stripe Checkout Sessionを作成
    try {
        // Stripe APIを直接呼び出す（cURL使用）
        $session_data = array(
            'payment_method_types[0]' => 'card',
            'line_items[0][price_data][currency]' => 'jpy',
            'line_items[0][price_data][product_data][name]' => $description,
            'line_items[0][price_data][unit_amount]' => $amount,
            'line_items[0][quantity]' => 1,
            'mode' => 'payment',
            'success_url' => add_query_arg(
                array(
                    'reservation' => 'success',
                    'session_id' => '{CHECKOUT_SESSION_ID}',
                    'temp_key' => $temp_key  // 一時キーを追加
                ),
                home_url('/reservation/')
            ),
            'cancel_url' => add_query_arg(
                array('reservation' => 'cancelled'),
                home_url('/reservation/')
            ),
            'customer_email' => $email,
            'payment_intent_data[receipt_email]' => $email,
            'metadata[name]' => $name,
            'metadata[email]' => $email,
            'metadata[temp_key]' => $temp_key,  // メタデータにも保存
            'metadata[area]' => $area,
            'metadata[food_type]' => $food_type,
            'metadata[price_range]' => $price_range,
            'metadata[coupon]' => $coupon,
            'metadata[priority]' => $priority,
            'metadata[note]' => $note,
        );
        
        // Stripe APIを呼び出し
        $ch = curl_init('https://api.stripe.com/v1/checkout/sessions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($session_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $stripe_secret_key,
            'Content-Type: application/x-www-form-urlencoded',
        ));
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);
        
        if ($curl_error) {
            wp_send_json_error(array('message' => 'cURLエラー: ' . $curl_error));
            return;
        }
        
        if ($http_code === 200) {
            $session = json_decode($response, true);
            if (isset($session['id']) && isset($session['url'])) {
                wp_send_json_success(array(
                    'session_id' => $session['id'],
                    'url' => $session['url']
                ));
            } else {
                wp_send_json_error(array('message' => 'Stripeセッションの作成に失敗しました。レスポンス: ' . $response));
            }
        } else {
            // エラーレスポンスの詳細をログに記録
            error_log('Stripe API Error - HTTP Code: ' . $http_code);
            error_log('Stripe API Error - Response: ' . $response);
            error_log('Stripe API Error - Key length: ' . strlen($stripe_secret_key));
            error_log('Stripe API Error - Key prefix: ' . substr($stripe_secret_key, 0, 20) . '...');
            error_log('Stripe API Error - Key suffix: ...' . substr($stripe_secret_key, -10));
            
            $error_data = json_decode($response, true);
            $error_message = isset($error_data['error']['message']) 
                ? $error_data['error']['message'] 
                : 'Stripeセッションの作成に失敗しました。HTTPステータス: ' . $http_code;
            
            // エラーの詳細情報を追加
            if (isset($error_data['error'])) {
                if (isset($error_data['error']['code'])) {
                    $error_message .= '\nエラーコード: ' . $error_data['error']['code'];
                }
                if (isset($error_data['error']['type'])) {
                    $error_message .= '\nエラータイプ: ' . $error_data['error']['type'];
                }
            }
            
            // 画面にはキー情報を出さない（漏えい対策）
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $error_message .= '\n\n（デバッグ）Stripeレスポンス: ' . substr($response, 0, 500);
            }
            
            wp_send_json_error(array(
                'message' => $error_message
            ));
        }
    } catch (Exception $e) {
        wp_send_json_error(array('message' => 'エラーが発生しました: ' . $e->getMessage()));
    }
}
add_action('wp_ajax_create_stripe_session', 'yokohama_concierge_create_stripe_session');
add_action('wp_ajax_nopriv_create_stripe_session', 'yokohama_concierge_create_stripe_session');

// Stripe決済成功時の処理
function yokohama_concierge_handle_stripe_success() {
    // セッションIDと一時キーを取得
    $session_id = isset($_GET['session_id']) ? sanitize_text_field($_GET['session_id']) : '';
    $temp_key = isset($_GET['temp_key']) ? sanitize_text_field($_GET['temp_key']) : '';
    
    if (empty($session_id)) {
        // セッションIDがない場合は通常の予約ページを表示
        return;
    }
    
    // 既に処理済みかチェック（二重処理防止）
    $processed_key = 'stripe_processed_' . $session_id;
    if (get_transient($processed_key)) {
        return;
    }
    
    // Stripe APIキーの設定
    $stripe_secret_key = defined('STRIPE_SECRET_KEY') ? STRIPE_SECRET_KEY : get_option('stripe_secret_key', '');
    
    if (empty($stripe_secret_key)) {
        return;
    }
    $stripe_secret_key = yokohama_concierge_normalize_stripe_secret_key($stripe_secret_key);
    
    // Stripeセッション情報を取得
    $ch = curl_init('https://api.stripe.com/v1/checkout/sessions/' . $session_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $stripe_secret_key,
    ));
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code !== 200) {
        return;
    }
    
    $session = json_decode($response, true);
    
    // 決済が完了していない場合はスキップ
    if (!isset($session['payment_status']) || $session['payment_status'] !== 'paid') {
        return;
    }
    
    // セッションから顧客情報を取得
    $customer_email = isset($session['customer_details']['email']) ? $session['customer_details']['email'] : '';
    $customer_name = isset($session['customer_details']['name']) ? $session['customer_details']['name'] : '';
    
    // 決済金額を取得
    $amount_total = isset($session['amount_total']) ? intval($session['amount_total']) : 0;
    
    // 一時保存されたフォームデータを取得
    $form_data_json = null;
    
    // まず一時キーから取得を試みる
    if (!empty($temp_key)) {
        $form_data_json = get_transient($temp_key);
    }
    
    // 一時キーから取得できない場合は、Stripeのメタデータから取得
    if (!$form_data_json && isset($session['metadata']['temp_key'])) {
        $temp_key_from_metadata = $session['metadata']['temp_key'];
        $form_data_json = get_transient($temp_key_from_metadata);
    }
    
    if (!$form_data_json) {
        // フォームデータが取得できない場合は処理をスキップ
        return;
    }
    
    $form_data = json_decode($form_data_json, true);
    
    if (!$form_data || !is_array($form_data)) {
        return;
    }
    
    // カスタム投稿タイプ「予約」として保存
    $post_data = array(
        'post_type' => 'reservation',
        'post_title' => sprintf('予約: %s (%s)', $customer_name ?: (isset($form_data['name']) ? $form_data['name'] : '不明'), date('Y-m-d H:i:s')),
        'post_content' => '',
        'post_status' => 'publish',
        'meta_input' => array(
            '_reservation_name' => $customer_name ?: (isset($form_data['name']) ? $form_data['name'] : ''),
            '_reservation_email' => $customer_email ?: (isset($form_data['email']) ? $form_data['email'] : ''),
            '_reservation_phone' => isset($form_data['phone']) ? $form_data['phone'] : '',
            '_reservation_gender' => isset($form_data['gender']) ? $form_data['gender'] : '',
            '_reservation_nationality' => isset($form_data['nationality']) ? $form_data['nationality'] : '',
            '_reservation_address' => isset($form_data['address']) ? $form_data['address'] : '',
            '_reservation_passport' => isset($form_data['passport']) ? $form_data['passport'] : '',
            '_reservation_stay' => isset($form_data['stay']) ? $form_data['stay'] : '',
            '_reservation_companion' => isset($form_data['companion']) ? $form_data['companion'] : '',
            '_reservation_status' => 'confirmed',
            '_reservation_payment_status' => 'completed',
            '_reservation_stripe_session_id' => $session_id,
            '_reservation_payment_amount' => $amount_total,
            '_reservation_form_data' => $form_data_json,
        ),
    );
    
    $post_id = wp_insert_post($post_data);
    
    if (!is_wp_error($post_id)) {
        // 個別のメタフィールドとしても保存
        foreach ($form_data as $key => $value) {
            if (!empty($value) && !in_array($key, array('name', 'email', 'phone', 'gender', 'nationality', 'address', 'passport', 'stay', 'companion', 'reservation_nonce', 'action'))) {
                if (is_array($value)) {
                    update_post_meta($post_id, '_reservation_' . $key, $value);
                } else {
                    update_post_meta($post_id, '_reservation_' . $key, sanitize_text_field($value));
                }
            }
        }
        
        // Make Webhook送信（エラーでも処理は続行）
        yokohama_concierge_send_to_make_webhook($post_id, $form_data);
        
        // メール送信処理
        yokohama_concierge_send_reservation_emails($post_id, $form_data, $amount_total);
        
        // 処理済みフラグを設定（24時間有効）
        set_transient($processed_key, true, 24 * HOUR_IN_SECONDS);
        
        // 一時データを削除
        if (!empty($temp_key)) {
            delete_transient($temp_key);
        }
        if (isset($session['metadata']['temp_key'])) {
            delete_transient($session['metadata']['temp_key']);
        }
    }
}
add_action('template_redirect', 'yokohama_concierge_handle_stripe_success');

// Make Webhook送信関数
function yokohama_concierge_send_to_make_webhook($post_id, $form_data) {
    $webhook_url = 'https://hook.us2.make.com/q4s664foazn8sn737ccpojfh964enyuu';

    $fd = $form_data;

    $body = array(
        'reservation_id'   => (string)$post_id,
        'name'             => $fd['name']        ?? '',
        'email'            => $fd['email']       ?? '',
        'phone'            => $fd['phone']       ?? '',
        'gender'           => $fd['gender']      ?? '',
        'nationality'      => $fd['nationality'] ?? '',
        'address'          => $fd['address']     ?? '',
        'passport'         => $fd['passport']    ?? '',
        'stay'             => $fd['stay']        ?? '',
        'companion'        => $fd['companion']   ?? '',
        'cuisine'          => $fd['cuisine'] ?? ($fd['diningCuisine'] ?? ($fd['diningGenre'] ?? '')),
        'partner_name'     => ($fd['hotelProposal1Id']  ?? '') ?: ($fd['diningProposal1Id']  ?? ''),
        'partner_address'  => ($fd['hotelShopAddress']  ?? '') ?: ($fd['diningShopAddress']  ?? ''),
        'partner_phone'    => ($fd['hotelShopPhone']    ?? '') ?: ($fd['diningShopPhone']    ?? ''),
        'reservation_date' => ($fd['hotelDate']  ?? '') ?: ($fd['diningDate']  ?? '') ?: ($fd['guideDate']   ?? '') ?: ($fd['luggageDate'] ?? ''),
        'reservation_time' => ($fd['diningTime'] ?? '') ?: ($fd['luggageTime'] ?? ''),
        'adult_count'      => ($fd['hotelAdults']    ?? '') ?: ($fd['diningAdults']    ?? '') ?: ($fd['guideAdults']   ?? ''),
        'child_count'      => ($fd['hotelChildren']  ?? '') ?: ($fd['diningChildren']  ?? '') ?: ($fd['guideChildren'] ?? ''),
        'trunk_count'      => $fd['luggageCount'] ?? '',
        'guide_course'     => $fd['guideCourse']  ?? '',
        'raw_form_data'    => wp_json_encode($fd, JSON_UNESCAPED_UNICODE),
        'submitted_at'     => current_time('mysql'),
        'source'           => 'wordpress',
        'form_name'        => 'reservation',
    );

    // payload全体をJSON文字列化したものを raw_payload として同梱
    $body['raw_payload'] = wp_json_encode($body, JSON_UNESCAPED_UNICODE);

    $response = wp_remote_post($webhook_url, array(
        'method'  => 'POST',
        'headers' => array('Content-Type' => 'application/json'),
        'body'    => wp_json_encode($body, JSON_UNESCAPED_UNICODE),
        'timeout' => 20,
    ));

    // 失敗時の最低限ログ
    if (is_wp_error($response)) {
        error_log('[Make webhook] WP_Error: ' . $response->get_error_message());
        return false;
    }
    $code = wp_remote_retrieve_response_code($response);
    if ($code < 200 || $code >= 300) {
        error_log('[Make webhook] HTTP ' . $code . ' body=' . wp_remote_retrieve_body($response));
        return false;
    }
    return true;
}

// 予約メール送信処理
function yokohama_concierge_send_reservation_emails($post_id, $form_data, $amount_total) {
    $name = isset($form_data['name']) ? $form_data['name'] : '';
    $email = isset($form_data['email']) ? $form_data['email'] : '';
    $phone = isset($form_data['phone']) ? $form_data['phone'] : '';
    
    // 管理者へのメール
    $admin_to = 'info@hamanavi-s.jp';
    $admin_subject = '【YOKOHAMA Concierge】予約フォームからのお問い合わせ（決済完了）';
    $admin_message = "予約フォームからお問い合わせがありました（決済完了）。\n\n";
    $admin_message .= "予約ID: #" . $post_id . "\n";
    $admin_message .= "お名前: " . $name . "\n";
    $admin_message .= "メールアドレス: " . $email . "\n";
    $admin_message .= "電話番号: " . $phone . "\n";
    $admin_message .= "決済金額: ¥" . number_format($amount_total) . "\n\n";
    
    // 予約内容の詳細を追加
    if (isset($form_data['guideCourse'])) {
        $course_label = $form_data['guideCourse'];
        $course_map = array(
            'half_audio' => '半日コース（音声ガイド）',
            'half_interpreter' => '半日コース（通訳付き）',
            'full_audio' => '1日コース（音声ガイド）',
            'full_interpreter' => '1日コース（通訳付き）',
            'half' => '半日コース',
            'full' => '1日コース'
        );
        if (isset($course_map[$course_label])) {
            $course_label = $course_map[$course_label];
        }
        $admin_message .= "観光ガイドサービス: " . $course_label . "\n";
        if (!empty($form_data['guideDate'])) {
            $admin_message .= "  予約日: " . $form_data['guideDate'] . "\n";
        }
        $guide_adults = isset($form_data['guideAdults']) ? intval($form_data['guideAdults']) : 0;
        $guide_children = isset($form_data['guideChildren']) ? intval($form_data['guideChildren']) : 0;
        if ($guide_adults > 0 || $guide_children > 0) {
            $admin_message .= "  人数: 大人{$guide_adults}名 / 子供{$guide_children}名\n";
        }
    }
    if (isset($form_data['hotelDate'])) {
        $admin_message .= "ホテル予約代行: " . $form_data['hotelDate'] . "\n";
        if (isset($form_data['hotelFinalSelection'])) {
            $admin_message .= "  選択された提案: 提案(" . $form_data['hotelFinalSelection'] . ")\n";
        }
    }
    if (isset($form_data['diningDate'])) {
        $admin_message .= "飲食店舗予約代行: " . $form_data['diningDate'] . "\n";
        if (!empty($form_data['diningTime'])) {
            $admin_message .= "  予約時間: " . $form_data['diningTime'] . "\n";
        }
        if (isset($form_data['diningFinalSelection'])) {
            $admin_message .= "  選択された提案: 提案(" . $form_data['diningFinalSelection'] . ")\n";
        }
    }
    if (isset($form_data['luggageCount'])) {
        $admin_message .= "トランクお預かり: " . $form_data['luggageCount'] . "個\n";
        if (!empty($form_data['luggageTime'])) {
            $admin_message .= "  お預かり時間: " . $form_data['luggageTime'] . "\n";
        }
    }
    
    $admin_message .= "\n詳細は管理画面でご確認ください: " . admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: YOKOHAMA Concierge <info@hamanavi-s.jp>',
        'Reply-To: info@hamanavi-s.jp',
        'Bcc: yukichikun0202@gmail.com',
    );

    wp_mail($admin_to, $admin_subject, $admin_message, $admin_headers);
    
    // 顧客への自動返信メール（api/send-reservation.php の generateCustomerEmailBody と整合）
    $customer_subject = '【YOKOHAMA Concierge】ご予約受付完了／現在手配中のお知らせ';
    $customer_message = $name . " 様\n";
    $customer_message .= "この度はYOKOHAMA Concierge（ハマナビサービス）をご利用いただき、誠にありがとうございます。\n";
    $customer_message .= "ご予約のお申し込みおよび決済を確認いたしました。\n";
    $customer_message .= "現在、ご希望内容に基づき提携店舗・提携事業者へ予約手配を進めております。\n";
    $customer_message .= "ご希望の日時・内容にて手配が完了次第、担当者より正式な「予約確定メール」を改めてお送りいたしますので、今しばらくお待ちください。\n";
    $customer_message .= "なお、満席・満室・予約不可等によりご希望内容での手配が難しい場合は、同等条件の代替候補をご提案させていただく場合がございます。その際はメールにてご相談申し上げます。\n";
    $customer_message .= "\n";
    $customer_message .= "受付内容\n";
    $customer_message .= "予約ID：#" . $post_id . "\n";
    $customer_message .= "お名前：" . $name . "\n";
    $customer_message .= "電話番号：" . $phone . "\n";
    $customer_message .= "メールアドレス：" . $email . "\n";
    $customer_message .= "お支払い金額：¥" . number_format($amount_total) . "\n";
    
    // 予約内容の詳細
    if (isset($form_data['guideCourse'])) {
        $course_label = $form_data['guideCourse'];
        $course_map = array(
            'half_audio' => '半日コース（音声ガイド）',
            'half_interpreter' => '半日コース（通訳付き）',
            'full_audio' => '1日コース（音声ガイド）',
            'full_interpreter' => '1日コース（通訳付き）',
            'half' => '半日コース',
            'full' => '1日コース'
        );
        if (isset($course_map[$course_label])) {
            $course_label = $course_map[$course_label];
        }
        $customer_message .= "【観光ガイドサービス】\n";
        $customer_message .= "コース：" . $course_label . "\n";
        if (isset($form_data['guideArea'])) {
            $customer_message .= "エリア：" . $form_data['guideArea'] . "\n";
        }
        if (!empty($form_data['guideDate'])) {
            $customer_message .= "予約日：" . $form_data['guideDate'] . "\n";
        }
        $guide_adults = isset($form_data['guideAdults']) ? intval($form_data['guideAdults']) : 0;
        $guide_children = isset($form_data['guideChildren']) ? intval($form_data['guideChildren']) : 0;
        if ($guide_adults > 0 || $guide_children > 0) {
            $customer_message .= "人数：大人{$guide_adults}名 / 子供{$guide_children}名\n";
        }
        $customer_message .= "\n";
    }
    if (isset($form_data['hotelDate'])) {
        $customer_message .= "【ホテル予約代行サービス】\n";
        $customer_message .= "予約日：" . $form_data['hotelDate'] . "\n";
        if (isset($form_data['hotelFinalSelection'])) {
            $proposal_num = $form_data['hotelFinalSelection'];
            $proposal_text = isset($form_data['hotelProposal' . $proposal_num]) ? $form_data['hotelProposal' . $proposal_num] : '';
            $customer_message .= "ご提案内容：" . $proposal_text . "\n";
        }
        $customer_message .= "\n";
    }
    if (isset($form_data['diningDate'])) {
        $customer_message .= "【飲食店舗予約代行サービス】\n";
        $customer_message .= "予約日：" . $form_data['diningDate'] . "\n";
        if (!empty($form_data['diningTime'])) {
            $customer_message .= "予約時間：" . $form_data['diningTime'] . "\n";
        }
        if (isset($form_data['diningFinalSelection'])) {
            $proposal_num = $form_data['diningFinalSelection'];
            $proposal_text = isset($form_data['diningProposal' . $proposal_num]) ? $form_data['diningProposal' . $proposal_num] : '';
            $customer_message .= "ご提案内容：" . $proposal_text . "\n";
        }
        $customer_message .= "\n";
    }
    if (isset($form_data['luggageCount']) && intval($form_data['luggageCount']) > 0) {
        $customer_message .= "【トランクお預かりサービス】\n";
        $customer_message .= "個数：" . $form_data['luggageCount'] . "個\n";
        if (!empty($form_data['luggageTime'])) {
            $customer_message .= "お預かり時間：" . $form_data['luggageTime'] . "\n";
        }
        $customer_message .= "\n";
    }

    $customer_message .= "\n";
    $customer_message .= "【お問い合わせ先】\n";
    $customer_message .= "YOKOHAMA Concierge（ハマナビサービス）\n";
    $customer_message .= "Email：info@hamanavi-s.jp\n";
    $customer_message .= "TEL：070-1526-3845\n";
    $customer_message .= "※このメールは自動送信されています。\n";
    $customer_message .= "※正式な予約確定は、担当者からの別途ご連絡をもって完了となります。\n";
    
    $customer_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: YOKOHAMA Concierge <' . get_option('admin_email') . '>',
        'Reply-To: info@hamanavi-s.jp',
        'Bcc: info@hamanavi-s.jp, yukichikun0202@gmail.com',
    );

    wp_mail($email, $customer_subject, $customer_message, $customer_headers);
}

// Contact Form 7 の自動返信をTranslatePressの言語に合わせて切り替え
function yokohama_concierge_cf7_switch_autoreply_by_language($contact_form) {
    if (!is_object($contact_form)) {
        return;
    }

    $is_target_form = false;
    $form_title = method_exists($contact_form, 'title') ? $contact_form->title() : '';
    if ($form_title === 'お問い合わせフォーム') {
        $is_target_form = true;
    }

    if (method_exists($contact_form, 'hash')) {
        $form_hash = $contact_form->hash();
        if ($form_hash === '8f7b03f') {
            $is_target_form = true;
        }
    }

    if (!$is_target_form) {
        return;
    }

    $lang = function_exists('trp_get_current_language') ? trp_get_current_language() : '';
    if ($lang !== 'en' && $lang !== 'en_US') {
        return;
    }

    $props = $contact_form->get_properties();
    if (isset($props['mail_2']) && is_array($props['mail_2'])) {
        $props['mail_2']['subject'] = '【YOKOHAMA Concierge】We received your inquiry';
        $props['mail_2']['body'] =
            "[your-name] 様\n\n" .
            "Thank you for contacting YOKOHAMA Concierge.\n" .
            "We will get back to you within 2 business days.\n\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
            "Inquiry Details\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
            "Name: [your-name]\n" .
            "Email: [your-email]\n\n" .
            "Message:\n[your-message]\n\n" .
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
            "YOKOHAMA Concierge\n" .
            "Email: info@hamanavi-s.jp\n\n" .
            "※ This email was sent automatically.\n";
    }

    $contact_form->set_properties($props);
}
add_action('wpcf7_before_send_mail', 'yokohama_concierge_cf7_switch_autoreply_by_language');

// Stripe設定ページを追加
function yokohama_concierge_add_stripe_settings_page() {
    add_options_page(
        'Stripe設定',
        'Stripe設定',
        'manage_options',
        'yokohama-stripe-settings',
        'yokohama_concierge_stripe_settings_page'
    );
}
add_action('admin_menu', 'yokohama_concierge_add_stripe_settings_page');

// Stripe設定ページの内容
function yokohama_concierge_stripe_settings_page() {
    // 設定を保存
    if (isset($_POST['submit']) && isset($_POST['stripe_secret_key'])) {
        check_admin_referer('yokohama_stripe_settings');
        // キーを正規化して保存（不可視文字/改行/スペース等を除去）
        $stripe_key = yokohama_concierge_normalize_stripe_secret_key($_POST['stripe_secret_key']);
        update_option('stripe_secret_key', $stripe_key);
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
    }
    
    $current_key = get_option('stripe_secret_key', '');
    $is_configured = !empty($current_key) || defined('STRIPE_SECRET_KEY');
    
    // 画面上にキー断片を出さない（漏えい対策）
    $debug_info = '';
    if (defined('WP_DEBUG') && WP_DEBUG && !empty($current_key)) {
        $key_length = strlen($current_key);
        $debug_info = '<p class="description" style="color: #666; font-size: 12px; margin-top: 5px;">';
        $debug_info .= '（デバッグ）キーの長さ=' . $key_length . '文字';
        $debug_info .= '</p>';
    }
    ?>
    <div class="wrap">
        <h1>Stripe決済設定</h1>
        <form method="post" action="">
            <?php wp_nonce_field('yokohama_stripe_settings'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="stripe_secret_key">Stripe Secret Key</label>
                    </th>
                    <td>
                        <?php if (defined('STRIPE_SECRET_KEY')): ?>
                            <p class="description">
                                <strong>注意:</strong> APIキーは<code>wp-config.php</code>で設定されています。
                                ここでの設定は無視されます。
                            </p>
                            <input type="text" 
                                   id="stripe_secret_key" 
                                   name="stripe_secret_key" 
                                   value="<?php echo esc_attr($current_key); ?>" 
                                   class="regular-text" 
                                   placeholder="sk_test_... または sk_live_..."
                                   disabled>
                        <?php else: ?>
                            <input type="text" 
                                   id="stripe_secret_key" 
                                   name="stripe_secret_key" 
                                   value="<?php echo esc_attr($current_key); ?>" 
                                   class="regular-text" 
                                   placeholder="sk_test_... または sk_live_...">
                            <p class="description">
                                テスト環境: <code>sk_test_...</code><br>
                                本番環境: <code>sk_live_...</code><br>
                                <a href="https://dashboard.stripe.com/apikeys" target="_blank" rel="noopener noreferrer">Stripeダッシュボード</a>から取得してください。
                            </p>
                            <?php echo $debug_info; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">設定状況</th>
                    <td>
                        <?php if ($is_configured): ?>
                            <span style="color: green;">✓ APIキーが設定されています</span>
                        <?php else: ?>
                            <span style="color: red;">✗ APIキーが設定されていません</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php if (!defined('STRIPE_SECRET_KEY')): ?>
                <?php submit_button('設定を保存'); ?>
            <?php endif; ?>
        </form>
        
        <h2>設定方法</h2>
        <h3>方法1: wp-config.phpで設定（推奨）</h3>
        <p><code>wp-config.php</code>に以下を追加してください：</p>
        <pre><code>define('STRIPE_SECRET_KEY', 'sk_test_...'); // テスト環境
// または
define('STRIPE_SECRET_KEY', 'sk_live_...'); // 本番環境</code></pre>
        
        <h3>方法2: このページから設定</h3>
        <p>上記のフォームから設定することもできます（<code>wp-config.php</code>で設定されていない場合のみ有効）。</p>
        
        <h2>Stripe APIキーの取得方法</h2>
        <ol>
            <li><a href="https://dashboard.stripe.com/apikeys" target="_blank" rel="noopener noreferrer">Stripeダッシュボード</a>にログイン</li>
            <li>「開発者」→「APIキー」に移動</li>
            <li>「シークレットキーを表示」をクリック</li>
            <li>表示されたキーをコピーして設定してください</li>
        </ol>
        
        <p><strong>注意:</strong> テスト環境では<code>sk_test_</code>で始まるキー、本番環境では<code>sk_live_</code>で始まるキーを使用してください。</p>
    </div>
    <?php
}