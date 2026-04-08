<?php
/**
 * Template Part: 検索フォーム
 *
 * @param string $modifier クラス名のモディファイア (--service, --page など)
 * @param string $placeholder プレースホルダーテキスト
 * @param bool $show_map_link MAPで探すリンクを表示するか
 */

$modifier = isset($args['modifier']) ? $args['modifier'] : '';
$placeholder = isset($args['placeholder']) ? $args['placeholder'] : 'サイト内検索';
$show_map_link = isset($args['show_map_link']) ? $args['show_map_link'] : true;
$search_value = isset($args['search_value']) ? $args['search_value'] : '';
$wrapper_class = isset($args['wrapper_class']) ? $args['wrapper_class'] : '';
?>

<div class="search-area<?php echo $modifier ? ' search-area--' . esc_attr($modifier) : ''; ?><?php echo $wrapper_class ? ' ' . esc_attr($wrapper_class) : ''; ?>">
    <?php if ($wrapper_class === 'search-area--page'): ?>
        <div class="search-area__inner inner">
    <?php endif; ?>

    <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-area__form" role="search">
        <label for="site-search" class="sr-only">サイト内検索</label>
        <input type="search" id="site-search" name="s" class="search-area__input" placeholder="<?php echo esc_attr($placeholder); ?>" aria-label="サイト内検索"<?php echo $search_value ? ' value="' . esc_attr($search_value) . '"' : ''; ?>>
        <button type="submit" class="search-area__btn" aria-label="検索を実行">
            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png" alt="" aria-hidden="true">
        </button>
    </form>

    <?php if ($show_map_link): ?>
    <div class="search-area__links">
        <a href="<?php echo esc_url(home_url('/yokohama/')); ?>" class="search-area__link search-area__link--map">MAPで探す</a>
    </div>
    <?php endif; ?>

    <?php if ($wrapper_class === 'search-area--page'): ?>
        </div>
    <?php endif; ?>
</div>
