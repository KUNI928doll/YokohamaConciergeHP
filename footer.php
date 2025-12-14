<footer class="footer">
        <section class="footer-scene">
            <div class="footer__fx" aria-hidden="true">
                <img src="<?php echo get_template_directory_uri(); ?>/images/fireworks4.png" alt="左下の花火のイラスト" class="footer__fx-item footer__fx-item--l1">
                <img src="<?php echo get_template_directory_uri(); ?>/images/fireworks2.png" alt="左上の花火のイラスト" class="footer__fx-item footer__fx-item--l2">
                <img src="<?php echo get_template_directory_uri(); ?>/images/fireworks8.png" alt="右下の花火のイラスト" class="footer__fx-item footer__fx-item--r2">
            </div>
        </section>
        <div class="footer__inner">
            <!-- ロゴ -->
            <div class="footer__logo">
                <img src="<?php echo get_template_directory_uri(); ?>/images/footer_logo.png" alt="YOKOHAMA Concierge ロゴ">
            </div>
            <!-- 住所・連絡先 -->
            <div class="footer__info">
                <p class="footer__address">〒231-0023 神奈川県横浜市中区山下町76-4-1301</p>
                <div class="footer__links">
                    <a href="mailto:info@hamanavi-s.jp" class="footer__link footer__link--mail">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header_mailicon.png" alt="メールアイコン">
                        info@hamanavi-s.jp
                    </a>
                    <a href="https://www.instagram.com/yokohama_concierge?igsh=dmIzeWM4eW43Nmpn&utm_source=qr"
                        target="_blank" rel="noopener noreferrer" class="footer__link footer__link--insta">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/footer_insta.png" alt="Instagramアイコン">
                        Instagram
                    </a>
                </div>
            </div>
        </div>
        <nav class="footer__nav">
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
                <li><a href="<?php echo esc_url(home_url('/privacy')); ?>">プライバシーポリシー</a></li>
                <li><a href="<?php echo esc_url(home_url('/terms')); ?>">利用規約</a></li>
            </ul>
        </nav>

        <p class="footer__copy">
            © 2025 YOKOHAMA Concierge. All Rights Reserved.
        </p>
    </footer>
    <a href="#top" class="pagetop" aria-label="ページの先頭へ">
        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-pagetop.png" alt="ページトップへ">
    </a>
    <?php wp_footer(); ?>
</body>

</html>