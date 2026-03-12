<?php
/**
 * Template Name: Storage Service
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
            <h1 class="sub-hero__title">サービス紹介</h1>
        </div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb__list">
                <li class="breadcrumb__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
                </li>
                <li class="breadcrumb__item">サービス紹介（トランクお預かり）</li>
            </ul>
        </nav>
        <section class="guide-overview">
            <div class="guide-overview__inner">

                <!-- タイトル -->
                <div class="guide-overview__title-block">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-storage.svg" alt="" class="guide-overview__title-icon"
                        aria-hidden="true">
                    <h2 class="guide-overview__title">トランクお預かり</h2>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-wave.svg" alt="" class="guide-overview__title-wave"
                        aria-hidden="true">
                </div>

                <!-- 説明文 -->
                <div class="guide-overview__text luggage">
                    <p class="luggage__text">トランクを預けて、横浜観光を身軽に楽しめる安心サービスです。
                        <br>トランクは指定場所または店舗でのお受け取りとなります。
                    </p>
                </div>

            </div>
        </section>
        <!-- 料金セクション -->
        <section class="guide-fee storage-guide-fee">
            <div class="guide-fee__inner">
                <div class="guide-fee__info">
                    <div class="guide-fee__info-item">
                        <h3 class="guide-fee__info-title">予約可能個数</h3>
                        <p class="guide-fee__info-text">1~6個</p>
                    </div>
                </div>
                <div class="guide-fee__info-item">
                    <h3 class="guide-fee__info-title">料金</h3>

                    <div class="guide-fee__additional">

                        <!-- 基本料金 -->
                        <dl class="price">
                            <dt class="price__term">1トランク１日あたり</dt>
                            <dd class="price__value">
                                <span class="price__dot"></span>
                                <span class="price__desc">1,800円</span>
                                <span class="price__note"></span>
                            </dd>
                        </dl>
                    </div>

                </div>
            </div>
        </section>

        <!-- お困りごとの解決セクション -->
        <section class="support support--tour-guide js-fade-up">
            <div class="support__inner">
                <h2 class="support__title support__title--tour-guide">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/support-title-line_left.svg" alt="" aria-hidden="true"
                        class="support__title-decoration support__title-decoration--left">
                    <span class="support__title-text">全てのサービスにサポート付き!</span>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/support-title-line_right.svg" alt="" aria-hidden="true"
                        class="support__title-decoration support__title-decoration--right">
                </h2>
                <div class="support__box">
                    <div class="support__top">
                        <div class="support__header">
                            <div class="support__icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-support.png" alt="お困りごとの解決アイコン">
                            </div>
                            <h3 class="support__subtitle">お困りごとの解決</h3>
                        </div>
                        <p class="support__text">
                            旅行中には予期せぬことが起こるものです。予定変更、体調不良、トラブルなどでお困りの際は、横浜ロコが「おもてなし」の心で迅速に対応いたします。
                            お電話・メール・お問い合わせフォームで迅速にサポートしますので、お気軽にご相談ください。
                        </p>
                    </div>
                    <div class="support__body">
                        <ol class="support__list">
                            <li class="support__list-item">
                                1 　<strong>突然の交通トラブル</strong>による交通機関予約や宿泊先予約、飲食店の予約（横浜近隣施設）</strong>
                            </li>
                            <li class="support__list-item">
                                2 　<strong>突然の体調不良</strong>による交通機関予約や宿泊先予約、飲食店の予約（横浜近隣施設） <br>
                                ＊別途、病院の紹介や交通機関の利用方法などもご相談ください。
                            </li>
                            <li class="support__list-item">
                                3 　旅行中の<strong>日程予定変更</strong>による各種ご予約（横浜近隣施設）<br>
                                ＊<strong>旅行中の紛失物</strong>の対応方法などのご相談。</li>
                            <li class="support__list-item">
                                4 　その他旅行中に<strong>ご相談事</strong>がある場合<br>
                                ＊弊社でご対応できる内容であれば対応いたしますので、ご相談ください。</strong>
                            </li>
                        </ol>
                    </div>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--blue btn--md btn--support">ご相談はこちら
                        <span class="btn__arrow">→</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ご利用の流れセクション -->
        <section class="guide-flow js-fade-up">
            <div class="guide-flow__inner">
                <h2 class="guide-flow__title">ご利用の流れ</h2>
                <div class="guide-flow__steps">
                    <!-- ステップ1 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">1</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">ご希望内容の入力</h3>
                            <p class="guide-flow__step-description">ご予約フォームより、ご希望のサービス内容・日時・条件をご入力ください。</p>
                            <p class="guide-flow__step-detail">内容をご確認のうえ、「この内容で予約代行を依頼する」ボタンを押してください。</p>
                            <a href="<?php echo esc_url(home_url('/reservation/')); ?>" class="btn btn--orange btn--md guide-flow__btn">ご予約フォーム
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-link.png" alt="" class="btn__icon" aria-hidden="true">
                            </a>
                        </div>
                    </div>

                    <!-- ステップ2 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">2</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">予約内容の確認</h3>
                            <p class="guide-flow__step-description">画面上に表示される予約内容をご確認ください。</p>
                            <p class="guide-flow__step-detail">内容に問題がなければ、そのままお支払い手続きへお進みいただきます。</p>
                            <p class="guide-flow__step-detail">ご提案内容は24時間以内にお手続きがない場合、自動的に無効となります。</p>
                        </div>
                    </div>

                    <!-- ステップ3 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">3</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">お支払い（Stripe決済）</h3>
                            <p class="guide-flow__step-description">
                            Stripeの安全な決済画面に移動し、予約代行手数料またはサービス料金のお支払いを行っていただきます。</p>
                            <p class="guide-flow__step-detail">クレジットカード情報は当社では保持いたしません。</p>
                            <p class="guide-flow__step-detail">宿泊費・飲食代・体験料金等は含まれておりません。</p>
                        </div>
                    </div>

                    <!-- ステップ4 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">4</div>
                        <div class="guide-flow__step-card guide-flow__step-card--highlight">
                            <h3 class="guide-flow__step-title">予約手配・完了</h3>
                            <p class="guide-flow__step-description">お支払い完了後、当社にて正式に予約手配を開始いたします。</p>
                            <p class="guide-flow__step-detail">予約が確定次第、メールにてご連絡いたします。当日は、指定された日時・場所へ直接お越しください</p>
                        </div>
                    </div>
                </div>
                
                <!-- ご注意事項 -->
                <div class="guide-flow__notice">
                    <h3 class="guide-flow__notice-title">ご注意事項</h3>
                    <ul class="guide-flow__notice-list">
                        <li class="guide-flow__notice-item">本サービスは予約代行サービスです</li>
                        <li class="guide-flow__notice-item">実際のサービス料金（宿泊費・飲食代等）は、各事業者の条件に従い、現地または指定方法でお支払いください</li>
                        <li class="guide-flow__notice-item">予約代行手数料は、予約成立後は返金不可となります</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- サービスカードセクション -->
        <section class="guide-services">
            <div class="guide-services__inner">
                <div class="guide-services__cards">
                    <!-- カード1: 予約代行 -->
                    <a href="<?php echo esc_url(home_url('/service-reserve/')); ?>" class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-reserve.png" alt="予約代行アイコン">
                        </div>
                        <h3 class="guide-services__title">予約代行</h3>
                    </a>

                    <!-- カード2: トランクお預かり -->
                    <a href="<?php echo esc_url(home_url('/service-storage/')); ?>" class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-trunk.png" alt="トランクお預かりアイコン">
                        </div>
                        <h3 class="guide-services__title">トランクお預かり</h3>
                    </a>

                    <!-- カード3: 観光ガイドサービス -->
                    <a href="<?php echo esc_url(home_url('/service-tour-guide/')); ?>" class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-guide.png" alt="観光ガイドサービスアイコン">
                        </div>
                        <h3 class="guide-services__title">観光ガイドサービス</h3>
                    </a>
                </div>

                <div class="guide-services__home">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="guide-services__home-btn">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/icon-home.png" alt="ホームアイコン">
                        <span>ホームへ</span>
                    </a>
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
                            <a href="tel:0456812737" class="contact__tel">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header_phoneicon.png" alt="" aria-hidden="true">
                                <span>045-681-2737</span>
                            </a>
                        </li>

                        <li class="contact__item contact__item--mobile">
                            <a href="tel:07015263845" class="contact__tel">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header_mobileicon.png" alt="" aria-hidden="true">
                                <span>070-1526-3845</span>
                            </a>
                        </li>
                        <li class="contact__item contact__item--time">対応時間：10:00〜18:00／不定休</li>
                        <li class="contact__item contact__item--mail">
                            <a href="mailto:info@hamanavi-s.jp" class="contact__mail">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/header_mailicon.png" alt="" aria-hidden="true">
                                <span>info@hamanavi-s.jp</span>
                            </a>
                        </li>
                    </ul>

                    <div class="contact__btns">
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--blue btn--md">お問い合わせ・ご相談窓口<span class="btn__arrow">→</span></a>
                        
                        <a href="<?php echo esc_url(home_url('/reservation/')); ?>" class="btn btn--orange btn--md">予約する
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

<?php get_footer(); ?>
