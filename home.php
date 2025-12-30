<?php
/*
Template Name: お知らせ・イベント一覧
*/
get_header();
?>

<main>
    <div class="nav-inner-wrapper u-visible-pc">
        <nav class="inner-nav">
            <ul class="inner-nav__list">
                <li class="inner-nav__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-home.png" alt="ホームアイコン">ホーム</a>
                </li>
                <li class="inner-nav__item inner-nav__item--has-sub">
                    <button type="button" class="inner-nav__trigger js-inner-dropdown" aria-expanded="false">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-service.png" alt="">
                        <span>サービス紹介</span>
                        <span class="inner-nav__caret" aria-hidden="true"></span>
                    </button>
                    <ul class="inner-nav__sub" aria-label="サービス紹介のメニュー">
                        <li><a href="<?php echo home_url('/service-reserve/'); ?>">予約代行</a></li>
                        <li><a href="<?php echo home_url('/service-storage/'); ?>">トランクお預かり</a></li>
                        <li><a href="<?php echo home_url('/service-tour-guide/'); ?>">観光ガイドサービス</a></li>
                    </ul>
                </li>

                <li class="inner-nav__item">
                    <a href="<?php echo home_url('/yokohama/'); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-yokohama.png" alt="">
                        <span>横浜について</span>
                    </a>
                </li>

                <li class="inner-nav__item">
                    <a href="<?php echo home_url('/#faq'); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-faq.png" alt="">
                        <span>よくある質問</span>
                    </a>
                </li>

                <li class="inner-nav__item">
                    <a href="<?php echo home_url('/news/'); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-news.png" alt="">
                        <span>お知らせ<br>イベント</span>
                    </a>
                </li>

                <li class="inner-nav__item">
                    <a href="<?php echo home_url('/contact/'); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-mail.png" alt="">
                        <span>お問い合わせ</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="search-area search-area--service">
        <form action="<?php echo esc_url(home_url("/")); ?>" method="get" class="search-area__form">
            <input type="text" name="s" class="search-area__input" placeholder="サイト内検索">
            <button type="submit" class="search-area__btn" aria-label="検索">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png" alt="検索アイコン">
            </button>
        </form>

        <div class="search-area__links">
            <a href="#" class="search-area__link search-area__link--map">MAPで探す</a>
        </div>
    </div>

    <div class="sub-hero">
        <div class="sub-hero__decoration">
            <img src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true">
        </div>
        <div class="sub-hero__img">
            <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-hero.png" alt="横浜の夜景">
        </div>
        <h1 class="sub-hero__title">お知らせ・イベント</h1>
    </div>
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <ul class="breadcrumb__list">
            <li class="breadcrumb__item">
                <a href="<?php echo esc_url(home_url("/")); ?>">ホーム</a>
            </li>
            <li class="breadcrumb__item">お知らせ・イベント</li>
        </ul>
    </nav>

    <!-- お知らせ・イベント一覧 -->
    <section class="news-list">
        <div class="news-list__inner inner">
            <!-- フィルター -->
            <div class="news-list__filter">
                <label class="news-list__filter-item">
                    <input type="radio" name="news-list-filter" value="all" checked>
                    <span>全て</span>
                </label>
                <label class="news-list__filter-item">
                    <input type="radio" name="news-list-filter" value="notice">
                    <span>お知らせ</span>
                </label>
                <label class="news-list__filter-item">
                    <input type="radio" name="news-list-filter" value="event">
                    <span>イベント</span>
                </label>
            </div>

            <!-- 記事一覧 -->
            <div class="news-list__grid">
            <?php
            $args = [
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC'
            ];

            $query = new WP_Query($args);

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    // カテゴリーを取得（お知らせorイベント）
                    $categories = get_the_category();
                    $category_slug = !empty($categories) ? $categories[0]->slug : 'notice';
                    $category_name = !empty($categories) ? $categories[0]->name : 'お知らせ';
            ?>
                    <article class="news-list__card" data-category="<?php echo esc_attr($category_slug); ?>">
                        <a href="<?php the_permalink(); ?>" class="news-list__card-link">
                            <div class="news-list__card-img">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', ['alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/no-image.png" alt="No Image">
                                <?php endif; ?>
                                <span class="news-list__card-label news-list__card-label--<?php echo esc_attr($category_slug); ?>">
                                    <?php echo esc_html($category_name); ?>
                                </span>
                            </div>
                            <div class="news-list__card-body">
                                <p class="news-list__card-date"><?php echo get_the_date('Y.m.d'); ?></p>
                                <h3 class="news-list__card-title"><?php the_title(); ?></h3>
                                <p class="news-list__card-text"><?php echo wp_trim_words(get_the_excerpt(), 40, '...'); ?></p>
                            </div>
                        </a>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="news-list__empty">
                    <div class="news-list__empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <p class="news-list__empty-text">現在、お知らせ・イベント情報はありません。</p>
                    <p class="news-list__empty-subtext">新しい情報が入り次第、こちらでお知らせいたします。</p>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="contact contact--bottom" id="contact">
        <div class="contact__inner">
            <h2 class="section-title section-title--sm section-title--contact">
                <span class="section-title__text">お問い合わせ</span>
                <img src="<?php echo get_template_directory_uri(); ?>/images/about/about_title-wave.svg" alt="" aria-hidden="true" class="section-title__icon section-title__icon--wave">
            </h2>

            <div class="contact__box">
                <ul class="contact__list">
                    <li class="contact__item contact__item--tel">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_phoneicon.png" alt="">
                        <span>045-681-2737</span>
                    </li>
                    <li class="contact__item contact__item--mobile">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_mobileicon.png" alt="">
                        <span>070-1526-3845</span>
                    </li>
                    <li class="contact__item contact__item--time">対応時間：10:00〜18:00／不定休</li>
                    <li class="contact__item contact__item--mail">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="">
                        <span>info@hamanavi-s.jp</span>
                    </li>
                </ul>

                <div class="contact__btns">
                    <a href="<?php echo esc_url(home_url("/contact/")); ?>" class="btn btn--blue btn--md">お問い合わせ・ご相談窓口<span class="btn__arrow">→</span></a>

                    <a href="<?php echo esc_url(home_url("/reservation/")); ?>" class="btn btn--orange btn--md">予約をする
                        <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-link.png" alt="" class="btn__icon" aria-hidden="true"></a>
                </div>
            </div>

            <div class="contact__decos">
                <div class="speech-bubble-imgwrap speech-bubble-imgwrap--contact">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/bubble.png" class="speech-bubble-img" aria-hidden="true">
                    <p class="speech-bubble-text speech-bubble-text--contact">
                        ハマナビサービスで<br>横浜を楽しんでいってね！
                    </p>
                </div>
                <figure class="character character--contact">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/contact/bird.png" alt="ハマナビくん">
                </figure>
            </div>
        </div>
    </section>
</main>

<script>
jQuery(document).ready(function($) {
    $('input[name="news-list-filter"]').on('change', function() {
        var filterValue = $(this).val();
        
        if (filterValue === 'all') {
            $('.news-list__card').fadeIn(300);
        } else {
            $('.news-list__card').each(function() {
                var category = $(this).attr('data-category');
                if (category === filterValue) {
                    $(this).fadeIn(300);
                } else {
                    $(this).fadeOut(300);
                }
            });
        }
    });
});
</script>

<?php get_footer(); ?>