<?php
get_header(); 
?>

<?php get_template_part('template-parts/inner-nav'); ?>

    <main id="main-content">
        <div class="search-page__hero">
            <h1>サイト内検索</h1>
            <p>知りたいキーワードを入力して、目的のページをお探しください。</p>
        </div>

        <?php get_template_part('template-parts/search-form', null, array(
            'wrapper_class' => 'search-area--page',
            'placeholder' => '例）トランク お預かり サポート',
            'search_value' => get_search_query(),
            'show_map_link' => false
        )); ?>

        <section class="search-results">
            <div class="search-results__inner">
                <?php if (have_posts()) : ?>
                    <p class="search-results__summary" data-search-summary>
                        「<?php echo get_search_query(); ?>」の検索結果: <?php echo $wp_query->found_posts; ?>件
                    </p>
                    
                    <ul class="search-results__list" data-search-list>
                        <?php while (have_posts()) : the_post(); ?>
                            <li class="search-results__item">
                                <article>
                                    <h2 class="search-results__title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="search-results__thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="search-results__excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                    <div class="search-results__meta">
                                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                        <span class="search-results__type">
                                            <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                        </span>
                                    </div>
                                </article>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <?php
                    // ページネーション
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '前へ',
                        'next_text' => '次へ',
                    ));
                    ?>

                <?php else : ?>
                    <p class="search-results__summary" data-search-summary>
                        <?php if (get_search_query()) : ?>
                            「<?php echo get_search_query(); ?>」の検索結果: 0件
                        <?php else : ?>
                            キーワードを入力して検索してください。
                        <?php endif; ?>
                    </p>
                    <div class="search-results__empty" data-search-empty>
                        <?php if (get_search_query()) : ?>
                            お探しのキーワードに一致する情報が見つかりませんでした。<br>
                            別のキーワードで検索してみてください。<br><br>
                        <?php else : ?>
                            検索キーワードを入力すると、該当するページを表示します。<br>
                        <?php endif; ?>
                        人気のキーワード: 
                        <a href="<?php echo esc_url(home_url('/?s=予約')); ?>">予約</a> / 
                        <a href="<?php echo esc_url(home_url('/?s=トランク')); ?>">トランク</a> / 
                        <a href="<?php echo esc_url(home_url('/?s=ガイド')); ?>">ガイド</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

<?php get_footer(); ?>

