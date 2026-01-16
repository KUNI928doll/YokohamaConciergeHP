<?php
/**
 * Template Name: 投稿詳細ページ
 * 個別投稿用テンプレート
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
                <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-hero.png" alt="横浜の夜景">
            </div>
            <h2 class="sub-hero__title">お知らせ・イベント</h2>
        </div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb__list">
                <li class="breadcrumb__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
                </li>
                <li class="breadcrumb__item">
                    <a href="<?php echo esc_url(home_url('/news/')); ?>">お知らせ・イベント</a>
                </li>
                <li class="breadcrumb__item"><?php the_title(); ?></li>
            </ul>
        </nav>

        <!-- 記事詳細 -->
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
            // カテゴリー取得
            $categories = get_the_category();
            $category_slug = '';
            $category_name = '';
            if (!empty($categories)) {
                $category_slug = $categories[0]->slug;
                $category_name = $categories[0]->name;
            }
        ?>
        <article class="news-detail">
            <div class="news-detail__inner inner">
                <!-- 記事ヘッダー -->
                <header class="news-detail__header">
                    <div class="news-detail__meta">
                        <?php if ($category_name) : ?>
                        <span class="news-detail__label news-detail__label--<?php echo esc_attr($category_slug); ?>"><?php echo esc_html($category_name); ?></span>
                        <?php endif; ?>
                        <time class="news-detail__date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
                    </div>
                    <h2 class="news-detail__title"><?php the_title(); ?></h2>
                </header>

                <!-- アイキャッチ画像 -->
                <?php if (has_post_thumbnail()) : ?>
                <figure class="news-detail__eyecatch">
                    <?php the_post_thumbnail('large'); ?>
                </figure>
                <?php endif; ?>

                <!-- 記事本文 -->
                <div class="news-detail__content">
                    <?php the_content(); ?>
                </div>

                <!-- SNSシェアボタン -->
                <div class="news-detail__share">
                    <p class="news-detail__share-title">この記事をシェア</p>
                    <div class="news-detail__share-buttons">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                           target="_blank" rel="noopener noreferrer" class="news-detail__share-btn news-detail__share-btn--twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                           target="_blank" rel="noopener noreferrer" class="news-detail__share-btn news-detail__share-btn--facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://social-plugins.line.me/lineit/share?url=<?php echo urlencode(get_permalink()); ?>" 
                           target="_blank" rel="noopener noreferrer" class="news-detail__share-btn news-detail__share-btn--line">
                            <i class="fab fa-line"></i>
                        </a>
                    </div>
                </div>

                <!-- 一覧に戻るボタン -->
                <div class="news-detail__back">
                    <a href="<?php echo esc_url(home_url('/news/')); ?>" class="btn btn--outline btn--md">
                        <span class="btn__arrow btn__arrow--left">←</span>
                        一覧に戻る
                    </a>
                </div>
            </div>
        </article>
        <?php endwhile; endif; ?>

        <?php get_template_part('template-parts/contact-section'); ?>
    </main>

<?php get_footer(); ?>
