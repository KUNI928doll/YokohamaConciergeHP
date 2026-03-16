    <?php
    /**
     * Template Name: お問い合わせ
     * Description: お問い合わせフォームのテンプレート
     */
    get_header(); 
    ?>

    <?php get_template_part('template-parts/inner-nav'); ?>

        <main id="main-content">
            <div class="sub-hero">
                <div class="sub-hero__decoration">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true">
                </div>
                <div class="sub-hero__img">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/contact/contact-hero.png" alt="ベイブリッチ">
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

            <section class="inquiry">
                <div class="inquiry__inner inner">
                    <?php
                    // Contact Form 7 のフォームを表示
                    echo do_shortcode('[contact-form-7 id="8f7b03f" title="お問い合わせフォーム"]');
                    ?>
                </div>
            </section>

            <!-- 確認画面モーダル -->
            <div id="contactConfirmModal" class="reservation-confirm" style="display: none;">
                <div class="reservation-confirm__overlay"></div>
                <div class="reservation-confirm__content">
                    <h2 class="reservation-confirm__title">入力内容の確認</h2>
                    <p class="reservation-confirm__lead">以下の内容でよろしければ「送信する」ボタンを押してください。</p>

                    <div id="contactConfirmContent" class="reservation-confirm__body">
                        <!-- JavaScriptで動的に生成 -->
                    </div>

                    <div class="reservation-confirm__actions">
                        <button type="button" class="btn btn--outline btn--md contact-confirm__back">戻る</button>
                        <button type="button" class="btn btn--orange btn--md contact-confirm__submit">送信する</button>
                    </div>
                </div>
            </div>

            <!-- 送信完了モーダル -->
            <div id="contactThanksModal" class="reservation-modal" style="display: none;">
                <div class="reservation-modal__content">
                    <div class="reservation-modal__icon">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="38" stroke="#4CAF50" stroke-width="4" fill="none" />
                            <path d="M25 40L35 50L55 30" stroke="#4CAF50" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h2 class="reservation-modal__title">お問い合わせを承りました</h2>
                    <p class="reservation-modal__message">
                        この度はYOKOHAMA Conciergeをご利用いただき、誠にありがとうございます。<br>
                        ご入力いただいた内容を確認後、担当者からご連絡させていただきます。<br><br>
                        ご登録のメールアドレス宛に受付完了メールをお送りしておりますので、ご確認ください。
                    </p>
                    <button type="button" class="btn btn--blue btn--md contact-modal__close">閉じる</button>
                </div>
            </div>
        </main>

    <?php get_footer(); ?>
