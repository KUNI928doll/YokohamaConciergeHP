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
                <?php
                // Contact Form 7 のフォームを表示
                echo do_shortcode('[contact-form-7 id="1707367" title="お問い合わせフォーム"]');
                ?>
            </div>
        </section>
    </main>

<?php get_footer(); ?>