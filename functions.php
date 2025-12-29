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
        filemtime(get_template_directory() . '/css/style.css') // ファイルの更新日時を自動的にバージョンとして使用
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
    
    // APIキーのトリム（余分なスペースを削除）
    $stripe_secret_key = trim($stripe_secret_key);
    
    // デバッグ: キーの情報をログに記録
    error_log('Stripe API Key Debug - Length: ' . strlen($stripe_secret_key) . ', Prefix: ' . substr($stripe_secret_key, 0, 20) . '...');
    
    // APIキーの形式をチェック
    $key_prefix = substr($stripe_secret_key, 0, 7);
    if ($key_prefix !== 'sk_test' && $key_prefix !== 'sk_live') {
        wp_send_json_error(array(
            'message' => 'Stripe APIキーの形式が正しくありません。sk_test_またはsk_live_で始まる必要があります。',
            'debug' => 'キーの先頭: ' . substr($stripe_secret_key, 0, 20) . '...（長さ: ' . strlen($stripe_secret_key) . '文字）'
        ));
        return;
    }
    
    // キーの長さをチェック（通常のStripe APIキーは約100文字以上）
    if (strlen($stripe_secret_key) < 50) {
        wp_send_json_error(array(
            'message' => 'Stripe APIキーが短すぎます。キーが完全に保存されていない可能性があります。',
            'debug' => 'キーの長さ: ' . strlen($stripe_secret_key) . '文字（通常は100文字以上）'
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
            'metadata[name]' => $name,
            'metadata[email]' => $email,
            'metadata[temp_key]' => $temp_key,  // メタデータにも保存
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
            
            // デバッグ情報を追加
            $debug_info = 'キーの長さ: ' . strlen($stripe_secret_key) . '文字';
            $debug_info .= ', 先頭: ' . substr($stripe_secret_key, 0, 20) . '...';
            $debug_info .= ', 末尾: ...' . substr($stripe_secret_key, -10);
            
            if (defined('WP_DEBUG') && WP_DEBUG) {
                $error_message .= '\n\nデバッグ情報: ' . $debug_info;
                $error_message .= '\nレスポンス: ' . substr($response, 0, 500);
            }
            
            wp_send_json_error(array(
                'message' => $error_message,
                'debug' => $debug_info
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

// 予約メール送信処理
function yokohama_concierge_send_reservation_emails($post_id, $form_data, $amount_total) {
    $name = isset($form_data['name']) ? $form_data['name'] : '';
    $email = isset($form_data['email']) ? $form_data['email'] : '';
    $phone = isset($form_data['phone']) ? $form_data['phone'] : '';
    
    // 管理者へのメール
    $admin_to = get_option('admin_email');
    $admin_subject = '【YOKOHAMA Concierge】予約フォームからのお問い合わせ（決済完了）';
    $admin_message = "予約フォームからお問い合わせがありました（決済完了）。\n\n";
    $admin_message .= "予約ID: #" . $post_id . "\n";
    $admin_message .= "お名前: " . $name . "\n";
    $admin_message .= "メールアドレス: " . $email . "\n";
    $admin_message .= "電話番号: " . $phone . "\n";
    $admin_message .= "決済金額: ¥" . number_format($amount_total) . "\n\n";
    
    // 予約内容の詳細を追加
    if (isset($form_data['guideCourse'])) {
        $admin_message .= "観光ガイドサービス: " . $form_data['guideCourse'] . "\n";
    }
    if (isset($form_data['hotelDate'])) {
        $admin_message .= "ホテル予約代行: " . $form_data['hotelDate'] . "\n";
        if (isset($form_data['hotelFinalSelection'])) {
            $admin_message .= "  選択された提案: 提案(" . $form_data['hotelFinalSelection'] . ")\n";
        }
    }
    if (isset($form_data['diningDate'])) {
        $admin_message .= "飲食店予約代行: " . $form_data['diningDate'] . "\n";
        if (isset($form_data['diningFinalSelection'])) {
            $admin_message .= "  選択された提案: 提案(" . $form_data['diningFinalSelection'] . ")\n";
        }
    }
    if (isset($form_data['luggageCount'])) {
        $admin_message .= "トランク預かり: " . $form_data['luggageCount'] . "個\n";
    }
    
    $admin_message .= "\n詳細は管理画面でご確認ください: " . admin_url('post.php?post=' . $post_id . '&action=edit') . "\n";
    
    wp_mail($admin_to, $admin_subject, $admin_message);
    
    // 顧客への自動返信メール
    $customer_subject = '【YOKOHAMA Concierge】ご予約を承りました';
    $customer_message = $name . " 様\n\n";
    $customer_message .= "この度はYOKOHAMA Conciergeをご利用いただき、誠にありがとうございます。\n\n";
    $customer_message .= "ご予約のお申し込みを承りました。\n";
    $customer_message .= "決済が完了いたしましたので、正式に予約が確定いたしました。\n";
    $customer_message .= "担当者より改めてご連絡させていただきます。\n\n";
    
    $customer_message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    $customer_message .= "お申し込み内容\n";
    $customer_message .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $customer_message .= "予約ID: #" . $post_id . "\n";
    $customer_message .= "お名前: " . $name . "\n";
    $customer_message .= "電話番号: " . $phone . "\n";
    $customer_message .= "メールアドレス: " . $email . "\n";
    $customer_message .= "お支払い金額: ¥" . number_format($amount_total) . "\n\n";
    
    // 予約内容の詳細
    if (isset($form_data['guideCourse'])) {
        $course_name = $form_data['guideCourse'] === 'half' ? '半日コース' : '1日コース';
        $customer_message .= "観光ガイドサービス: " . $course_name . "\n";
        if (isset($form_data['guideArea'])) {
            $customer_message .= "  エリア: " . $form_data['guideArea'] . "\n";
        }
    }
    if (isset($form_data['hotelDate'])) {
        $customer_message .= "ホテル予約代行: " . $form_data['hotelDate'] . "\n";
        if (isset($form_data['hotelFinalSelection'])) {
            $proposal_num = $form_data['hotelFinalSelection'];
            $proposal_text = isset($form_data['hotelProposal' . $proposal_num]) ? $form_data['hotelProposal' . $proposal_num] : '';
            $customer_message .= "  選択された提案: " . $proposal_text . "\n";
        }
    }
    if (isset($form_data['diningDate'])) {
        $customer_message .= "飲食店予約代行: " . $form_data['diningDate'] . "\n";
        if (isset($form_data['diningFinalSelection'])) {
            $proposal_num = $form_data['diningFinalSelection'];
            $proposal_text = isset($form_data['diningProposal' . $proposal_num]) ? $form_data['diningProposal' . $proposal_num] : '';
            $customer_message .= "  選択された提案: " . $proposal_text . "\n";
        }
    }
    if (isset($form_data['luggageCount']) && intval($form_data['luggageCount']) > 0) {
        $customer_message .= "トランク預かり: " . $form_data['luggageCount'] . "個\n";
    }
    
    $customer_message .= "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    $customer_message .= "【お問い合わせ先】\n";
    $customer_message .= "YOKOHAMA Concierge\n";
    $customer_message .= "Email: info@hamanavi-s.jp\n\n";
    
    $customer_message .= "※このメールは自動送信されています。\n";
    $customer_message .= "※ご不明な点がございましたら、上記連絡先までお問い合わせください。\n";
    
    $customer_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: YOKOHAMA Concierge <' . get_option('admin_email') . '>',
    );
    
    wp_mail($email, $customer_subject, $customer_message, $customer_headers);
}

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
        // トリムして余分なスペースを削除
        $stripe_key = trim(sanitize_text_field($_POST['stripe_secret_key']));
        update_option('stripe_secret_key', $stripe_key);
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
        
        // デバッグ情報（開発環境のみ）
        if (defined('WP_DEBUG') && WP_DEBUG) {
            echo '<div class="notice notice-info"><p>デバッグ情報: 保存されたキーの長さ=' . strlen($stripe_key) . '文字, 先頭=' . substr($stripe_key, 0, 20) . '...</p></div>';
        }
    }
    
    $current_key = get_option('stripe_secret_key', '');
    $is_configured = !empty($current_key) || defined('STRIPE_SECRET_KEY');
    
    // デバッグ情報（開発環境のみ）
    $debug_info = '';
    if (defined('WP_DEBUG') && WP_DEBUG && !empty($current_key)) {
        $key_length = strlen($current_key);
        $key_prefix = substr($current_key, 0, 7);
        $debug_info = '<p class="description" style="color: #666; font-size: 12px; margin-top: 5px;">';
        $debug_info .= 'デバッグ情報: キーの長さ=' . $key_length . '文字, 先頭=' . $key_prefix;
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
                                <a href="https://dashboard.stripe.com/apikeys" target="_blank">Stripeダッシュボード</a>から取得してください。
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
            <li><a href="https://dashboard.stripe.com/apikeys" target="_blank">Stripeダッシュボード</a>にログイン</li>
            <li>「開発者」→「APIキー」に移動</li>
            <li>「シークレットキーを表示」をクリック</li>
            <li>表示されたキーをコピーして設定してください</li>
        </ol>
        
        <p><strong>注意:</strong> テスト環境では<code>sk_test_</code>で始まるキー、本番環境では<code>sk_live_</code>で始まるキーを使用してください。</p>
    </div>
    <?php
}