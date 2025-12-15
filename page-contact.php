<?php
/**
 * Template Name: お問い合わせ
 * Description: お問い合わせフォームのテンプレート
 */
get_header(); 
?>

<?php get_template_part('template-parts/inner-nav'); ?>

    <main>
        <div class="sub-hero">
            <div class="sub-hero__decoration">
            <img src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true">
            </div>
            <div class="sub-hero__img">
                <img src="<?php echo get_template_directory_uri(); ?>/images/contact/contact-hero.png" alt="ベイブリッチ">
            </div>
            <h1 class="sub-hero__title">お問い合わせ</h1>
            <p class="sub-hero__text">サービス内容やご予約、見積もりについてなど、お気軽にご相談ください。必須の項目は必ずご入力ください。</p>
        </div>

        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb__list">
                <li class="breadcrumb__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
                </li>
                <li class="breadcrumb__item">お問い合わせ</li>
            </ul>
        </nav>

        <section class="contact contact--page inquiry">
            <div class="inquiry__inner inner">
                <!-- Contact Form 7 のショートコードをここに貼り付けてください -->
                <!-- 例: <?php echo do_shortcode('[contact-form-7 id="123" title="お問い合わせフォーム"]'); ?> -->
                <?php
                // Contact Form 7 が有効化されているか確認
                if (function_exists('wpcf7_contact_form')) {
                    // 最新のコンタクトフォームを取得して表示
                    $args = array(
                        'post_type' => 'wpcf7_contact_form',
                        'posts_per_page' => 1,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $forms = get_posts($args);
                    
                    if (!empty($forms)) {
                        $form_id = $forms[0]->ID;
                        echo do_shortcode('[contact-form-7 id="' . $form_id . '"]');
                    } else {
                        echo '<p>お問い合わせフォームが設定されていません。管理画面から Contact Form 7 のフォームを作成してください。</p>';
                    }
                } else {
                    echo '<p>Contact Form 7 プラグインをインストール・有効化してください。</p>';
                    echo '<p><a href="' . admin_url('plugin-install.php?s=contact+form+7&tab=search&type=term') . '">プラグインをインストール</a></p>';
                }
                ?>
            </div>
        </section>
    </main>

<?php get_footer(); ?>