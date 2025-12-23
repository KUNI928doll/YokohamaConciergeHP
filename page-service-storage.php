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
        <section class="guide-fee">
            <div class="guide-fee__inner">
                <div class="guide-fee__info">
                    <div class="guide-fee__info-item">
                        <h3 class="guide-fee__info-title">予約購入可能人数</h3>
                        <p class="guide-fee__info-text">1~6人 (3人目以降は追加料金が発生いたします)</p>
                    </div>
                    <div class="guide-fee__info-item">
                        <h3 class="guide-fee__info-title">対応言語</h3>
                        <p class="guide-fee__info-text">英語・中国語・韓国語</p>
                    </div>
                </div>
                <div class="guide-fee__info-item">
                    <h3 class="guide-fee__info-title">料金</h3>
                    <div class="guide-fee__courses">
                        <div class="guide-fee__course">
                            <h3 class="guide-fee__course-title">半日コース (約3時間)</h3>
                            <div class="guide-fee__options">
                                <div class="guide-fee__option">
                                    <span class="guide-fee__option-label">音声ガイドのみ</span>
                                    <span class="guide-fee__option-price">12,000円</span>
                                </div>
                                <div class="guide-fee__option guide-fee__option--highlight">
                                    <span class="guide-fee__option-label">通訳付き</span>
                                    <span class="guide-fee__option-price">20,000円</span>
                                </div>
                            </div>
                        </div>

                        <div class="guide-fee__course">
                            <h3 class="guide-fee__course-title">1日コース (約8時間)</h3>
                            <div class="guide-fee__options">
                                <div class="guide-fee__option">
                                    <span class="guide-fee__option-label">音声ガイドのみ</span>
                                    <span class="guide-fee__option-price">22,000円</span>
                                </div>
                                <div class="guide-fee__option guide-fee__option--highlight">
                                    <span class="guide-fee__option-label">通訳付き</span>
                                    <span class="guide-fee__option-price">30,000円</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="guide-fee__additional">
                        <h3 class="guide-fee__additional-title">追加項目</h3>
                        <ul class="guide-fee__additional-list">
                            <li>前日・当日の予約 <span class="guide-fee__additional-price">+1,000円</span> (ガイド料金に追加)</li>
                            <li>追加人数3人目以降 (最大6名まで) <span class="guide-fee__additional-price">+1,000円/人</span> (ガイド料金に追加)
                            </li>
                        </ul>
                    </div>

                    <div class="guide-fee__not-included">
                        <h3 class="guide-fee__not-included-title">費用に含まれないもの</h3>
                        <ul class="guide-fee__not-included-list">
                            <li>飲食代・体験料金・交通費など実費でかかる費用</li>
                            <li>飲食店ではガイドスタッフの飲食代もご負担願います</li>
                        </ul>
                    </div>

                    <div class="guide-fee__times">
                        <h3 class="guide-fee__times-title">ガイド時刻</h3>
                        <div class="guide-fee__times-content">
                            <div class="guide-fee__time-item">
                                <strong>半日コース:</strong> 午前の部 9:00~12:00 / 午後の部 14:00~17:00
                            </div>
                            <div class="guide-fee__time-item">
                                <strong>1日コース:</strong> 午前9:00~12:00 - (昼食休憩1時間) - 午後13:00~18:00
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- お困りごと対応セクション -->
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
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-support.png" alt="お困りごと対応アイコン">
                            </div>
                            <h3 class="support__subtitle">お困りごと対応</h3>
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
                                ＊<strong>旅行中の紛失物</strong>の対応方法などのご相談。<br>
                                ＊日程的にどうしてもご対応ができない<strong>お土産品の購入代行</strong>のご相談<br>
                                （横浜近隣で対応可能なもの）</li>
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
        <section class="guide-flow">
            <div class="guide-flow__inner">
                <h2 class="guide-flow__title">ご利用の流れ</h2>

                <div class="guide-flow__steps">
                    <!-- ステップ1 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">1</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">ご希望内容を選択</h3>
                            <p class="guide-flow__step-description">ご予約フォームより、ご希望内容をご選択ください</p>
                            <p class="guide-flow__step-detail">ご希望に沿ったコースのご提案とお見積り金額をメールでご提案いたします</p>
                            <a href="#" class="btn btn--orange btn--md guide-flow__btn">ご予約フォーム
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-link.png" alt="" class="btn__icon" aria-hidden="true">
                            </a>
                        </div>
                    </div>

                    <!-- ステップ2 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">2</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">見積り提案を承認</h3>
                            <p class="guide-flow__step-description">内容ご確認の上、問題がなければメールに「承認」とご返信お願いいたします。</p>
                            <p class="guide-flow__step-detail">承認いただきました時点で、各予約を進めます。</p>
                            <p class="guide-flow__step-detail">お客様に受注予約手配中メールを送信いたします</p>
                        </div>
                    </div>

                    <!-- ステップ3 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">3</div>
                        <div class="guide-flow__step-card">
                            <h3 class="guide-flow__step-title">お支払い確定</h3>
                            <p class="guide-flow__step-description">
                                予約確定後、事前に登録していただいたクレジットカードで弊社サービス代金の自動引き落としをさせていただきます。</p>
                            <p class="guide-flow__step-detail">お支払い後に予約確定通知 (確認書 (バウチャー) をメールで送付いたします</p>
                            <p class="guide-flow__step-detail">実費は現地の各予約店舗へお支払いをお願いいたします</p>
                            <p class="guide-flow__step-detail">当日現金でのお支払いや銀行振込でも対応可能です。</p>
                        </div>
                    </div>

                    <!-- ステップ4 -->
                    <div class="guide-flow__step">
                        <div class="guide-flow__step-number">4</div>
                        <div class="guide-flow__step-card guide-flow__step-card--highlight">
                            <h3 class="guide-flow__step-title">予約完了</h3>
                            <p class="guide-flow__step-description">当日、お時間になりましたら現地へ直接お越しください</p>
                            <p class="guide-flow__step-detail">前日にメールにて再度予定をお知らせいたします</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- サービスカードセクション -->
        <section class="guide-services">
            <div class="guide-services__inner">
                <div class="guide-services__cards">
                    <!-- カード1: 予約代行 -->
                    <div class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-reserve.png" alt="予約代行アイコン">
                        </div>
                        <h3 class="guide-services__title">予約代行</h3>
                    </div>

                    <!-- カード2: トランクお預かり -->
                    <div class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-trunk.png" alt="トランクお預かりアイコン">
                        </div>
                        <h3 class="guide-services__title">トランクお預かり</h3>
                    </div>

                    <!-- カード3: 観光ガイドサービス -->
                    <div class="guide-services__card">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-guide.png" alt="観光ガイドサービスアイコン">
                        </div>
                        <h3 class="guide-services__title">観光ガイドサービス</h3>
                    </div>
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
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--blue btn--md">お問い合わせ・ご相談窓口<span class="btn__arrow">→</span></a>
                        
                        <a href="<?php echo esc_url(home_url('/reservation/')); ?>" class="btn btn--orange btn--md">予約をする
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
