<?php get_header(); ?>

    <main>
        <div class="error-page__hero">
            <div class="error-page__number">404</div>
            <h1 class="error-page__title">ページが見つかりませんでした</h1>
            <p class="error-page__description">
                お探しのページは、移動または削除された可能性があります。<br>
                以下のリンクから目的のページをお探しください。
            </p>
            <div class="error-page__actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="error-page__home-btn">ホームに戻る</a>
                <div class="error-page__search">
                    <section class="search-area search-area--page">
                        <div class="search-area__inner inner">
                            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-area__form">
                                <input type="text" name="s" class="search-area__input" placeholder="例）トランク お預かり サポート">
                                <button type="submit" class="search-area__btn" aria-label="検索">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png" alt="検索アイコン">
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <section class="error-page__links">
            <div class="error-page__links-inner">
                <h2 class="error-page__links-title">主要ページ</h2>
                <div class="error-page__links-grid">
                    <a href="<?php echo esc_url(home_url('/service-reserve')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">予約代行サービス</h3>
                        <p class="error-page__link-card-description">ホテルや飲食店、観光チケットなどの手配を代行し、旅の準備をスムーズにします。</p>
                    </a>
                    <a href="<?php echo esc_url(home_url('/service-storage/')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">トランクお預かりサービス</h3>
                        <p class="error-page__link-card-description">横浜観光のあいだ、お客様の大切なお荷物を安全にお預かりするサービスです。</p>
                    </a>
                    <a href="<?php echo esc_url(home_url('/service-tour-guide/')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">観光ガイドサービス</h3>
                        <p class="error-page__link-card-description">外国人ゲストにも安心の、通訳付き観光ガイドやカスタムツアーをご提供します。</p>
                    </a>
                    <a href="<?php echo esc_url(home_url('/yokohama/')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">横浜の見どころ</h3>
                        <p class="error-page__link-card-description">横浜の歴史や主要スポットをエリアごとにご紹介します。</p>
                    </a>
                    <a href="<?php echo esc_url(home_url('/#faq')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">よくある質問</h3>
                        <p class="error-page__link-card-description">サービス利用に関する疑問や料金、対応エリアなどのQ&Aをご確認いただけます。</p>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="error-page__link-card">
                        <h3 class="error-page__link-card-title">お問い合わせ</h3>
                        <p class="error-page__link-card-description">電話・メール・フォームから各種お問い合わせを受け付けています。</p>
                    </a>
                </div>
            </div>
        </section>
    </main>

<?php get_footer(); ?>
