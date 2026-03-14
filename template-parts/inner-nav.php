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
                    <li><a href="<?php echo esc_url(home_url('/service-reserve/')); ?>">予約代行</a></li>
                    <li><a href="<?php echo esc_url(home_url('/service-storage/')); ?>">トランクお預かり</a></li>
                    <li><a href="<?php echo esc_url(home_url('/service-tour-guide/#guide-spots')); ?>">横浜観光ガイドサービス</a></li>
                </ul>
            </li>
            <li class="inner-nav__item">
                <a href="<?php echo esc_url(home_url('/yokohama/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-yokohama.png" alt="">
                    <span>横浜について</span>
                </a>
            </li>
            <li class="inner-nav__item">
                <a href="<?php echo esc_url(home_url('/#faq')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-faq.png" alt="">
                    <span>よくある質問</span>
                </a>
            </li>
            <li class="inner-nav__item">
                <a href="<?php echo esc_url(home_url('/news/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-news.png" alt="">
                    <span>お知らせ<br>イベント</span>
                </a>
            </li>
            <li class="inner-nav__item">
                <a href="<?php echo esc_url(home_url('/contact/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-mail.png" alt="">
                    <span>お問い合わせ</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
<?php get_template_part('template-parts/search-form', null, array('modifier' => 'service')); ?>
        <div class="sub-hero">
            <div class="sub-hero__decoration">
                <img src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true">
            </div>
        </div>