<footer class="footer<?php 
    if (is_front_page() || is_page('yokohama')) {
        echo ' footer--special';
    } elseif (is_page('privacy') || is_page('terms') || is_page('commercial') || is_page('contact') || is_page('reservation') || 
              is_page_template('page-privacy.php') || is_page_template('page-terms.php') || is_page_template('page-commercial.php') || is_page_template('page-contact.php') || is_page_template('page-reservation.php')) {
        echo ' footer--legal';
    } elseif (is_single()) {
        echo ' footer--event';
    } elseif (!is_front_page()) {
        echo ' footer--inner';
    }
?>">
        <section class="footer-scene">
            <div class="footer__fx" aria-hidden="true">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/fireworks4.png" alt="左下の花火のイラスト" class="footer__fx-item footer__fx-item--l1" width="156" height="350">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/fireworks2.png" alt="左上の花火のイラスト" class="footer__fx-item footer__fx-item--l2" width="287" height="455">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/fireworks8.png" alt="右下の花火のイラスト" class="footer__fx-item footer__fx-item--r2" width="249" height="465">
            </div>
        </section>
        <div class="footer__inner">
            <!-- ロゴ -->
            <div class="footer__logo">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/footer_logo.png" alt="YOKOHAMA Concierge ロゴ" width="476" height="123">
            </div>
            <!-- 住所・連絡先 -->
            <div class="footer__info">
                <p class="footer__address">〒231-0023 神奈川県横浜市中区山下町76-4-1301</p>
                <div class="footer__links">
                    <a href="mailto:info@hamanavi-s.jp" class="footer__link footer__link--mail">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="メールアイコン" width="25" height="18">
                        info@hamanavi-s.jp
                    </a>
                    <a href="https://www.instagram.com/yokohama_concierge?igsh=dmIzeWM4eW43Nmpn&utm_source=qr"
                        target="_blank" rel="noopener noreferrer" class="footer__link footer__link--insta">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/footer_insta.png" alt="Instagramアイコン" width="22" height="22">
                        Instagram
                    </a>
                </div>
            </div>
        </div>
        <nav class="footer__nav" aria-label="フッターナビゲーション">
            <ul class="footer__menu">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
                <li class="footer__item footer__item--has-sub">
                    <button type="button" class="footer__trigger js-footer-dropdown" aria-expanded="false">
                        サービス紹介
                        <span class="footer__caret" aria-hidden="true"></span>
                    </button>
                    <ul class="footer__sub" aria-label="サービス紹介のメニュー">
                        <li><a href="<?php echo esc_url(home_url('/service-reserve')); ?>">予約代行</a></li>
                        <li><a href="<?php echo esc_url(home_url('/service-storage')); ?>">トランクお預かり</a></li>
                        <li><a href="<?php echo esc_url(home_url('/service-tour-guide')); ?>">観光ガイドサービス</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo esc_url(home_url('/yokohama')); ?>">横浜について</a></li>
                <li><a href="<?php echo esc_url(home_url('/#faq')); ?>">よくある質問</a></li>
                <li><a href="<?php echo esc_url(home_url('/news')); ?>">お知らせ・イベント</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact')); ?>">お問い合わせ</a></li>
            </ul>
            <ul class="footer__policy">
                <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms/')); ?>">利用規約</a></li>
                <li><a href="<?php echo esc_url(home_url('/commercial/')); ?>">特定商取引法に基づく表記</a></li>
            </ul>
        </nav>

        <p class="footer__copy">
            © 2025 YOKOHAMA Concierge. All Rights Reserved.
        </p>
    </footer>
    <a href="#top" class="pagetop" aria-label="ページの先頭へ">
        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/icon-pagetop.png" alt="ページトップへ" width="192" height="192">
    </a>
    <?php wp_footer(); ?>
</body>

</html>