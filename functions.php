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
            '1.0.0',
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
    
    // メール送信処理（必要に応じて実装）
    $to = get_option('admin_email');
    $subject = '【YOKOHAMA Concierge】予約フォームからのお問い合わせ';
    $message = "予約フォームからお問い合わせがありました。\n\n";
    $message .= "お名前: " . $name . "\n";
    $message .= "メールアドレス: " . $email . "\n";
    $message .= "電話番号: " . $phone . "\n";
    // その他のフィールドも追加...
    
    wp_mail($to, $subject, $message);
    
    // リダイレクト
    wp_redirect(add_query_arg('reservation', 'success', home_url('/reservation/')));
    exit;
}
add_action('admin_post_submit_reservation', 'yokohama_concierge_handle_reservation_submit');
add_action('admin_post_nopriv_submit_reservation', 'yokohama_concierge_handle_reservation_submit');

// Stripe決済セッション作成
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
            
            if ($guideCourse === 'half') {
                $amount += $hasTranslation ? 20000 : 12000;
            } else {
                $amount += $hasTranslation ? 30000 : 22000;
            }
        }
        
        // ホテル予約代行サービス
        if (isset($_POST['hotelDate']) && !empty($_POST['hotelDate'])) {
            $amount += 2200;
        }
        
        // 飲食店予約代行サービス
        if (isset($_POST['diningDate']) && !empty($_POST['diningDate'])) {
            $amount += 2200;
        }
        
        // トランク預かりサービス
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
    
    $description = 'YOKOHAMA Concierge 予約代行サービス';
    
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
                    'session_id' => '{CHECKOUT_SESSION_ID}'
                ),
                home_url('/reservation/')
            ),
            'cancel_url' => add_query_arg(
                array('reservation' => 'cancelled'),
                home_url('/reservation/')
            ),
            'customer_email' => $email,
            'metadata[name]' => $name,
            'metadata[email]' => $email,
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
            $error_data = json_decode($response, true);
            $error_message = isset($error_data['error']['message']) 
                ? $error_data['error']['message'] 
                : 'Stripeセッションの作成に失敗しました。';
            wp_send_json_error(array('message' => $error_message));
        }
    } catch (Exception $e) {
        wp_send_json_error(array('message' => 'エラーが発生しました: ' . $e->getMessage()));
    }
}
add_action('wp_ajax_create_stripe_session', 'yokohama_concierge_create_stripe_session');
add_action('wp_ajax_nopriv_create_stripe_session', 'yokohama_concierge_create_stripe_session');
