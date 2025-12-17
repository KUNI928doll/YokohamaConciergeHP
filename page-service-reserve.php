<?php
/**
 * Template Name: Reserve Service
 */
get_header(); 
?>

    <main>
        <?php get_template_part('template-parts/inner-nav'); ?>

        <div class="search-area search-area--service">
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-area__form">
                <input type="text" name="s" class="search-area__input" placeholder="サイト内検索">
                <button type="submit" class="search-area__btn" aria-label="検索">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/icon-search.png" alt="検索アイコン">
                </button>
            </form>

            <div class="search-area__links">
                <a href="#" class="search-area__link search-area__link--map">MAPで探す</a>
            </div>
        </div>

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
                <li class="breadcrumb__item">サービス紹介（予約代行）</li>
            </ul>
        </nav>
        <section class="guide-overview service-reserve">
            <div class="guide-overview__inner">

                <!-- タイトル -->
                <div class="guide-overview__title-block">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-reserve.png" alt="" class="guide-overview__title-icon"
                        aria-hidden="true">
                    <h2 class="guide-overview__title">予約代行</h2>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-wave.svg" alt="" class="guide-overview__title-wave"
                        aria-hidden="true">
                </div>

                <!-- 説明文 -->
                <div class="guide-overview__text">
                    <p>
                        来日前でも来日後でも、思い立ったときにすぐご依頼いただけます。
                        横浜で人気の宿泊施設や飲食店を、お客様のご希望や食文化のニーズ（ハラル・アレルギー・ヴィーガン対応など）に合わせてご提案し、予約を代行します。
                    </p>

                    <p class="guide-overview__note">
                        ※各施設での宿泊料や飲食代、体験料金は現地での実費精算をお願いいたします。
                    </p>
                </div>

                <!-- 対応エリア -->
                <div class="guide-overview__area">
                    <div class="guide-overview__area-label">
                        対応<br>エリア
                    </div>
                    <ul class="guide-overview__area-list">
                        <li><span class="guide-overview__dot guide-overview__dot--green"></span>元町・山手エリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--pink"></span>中華街・山下公園エリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--yellow"></span>日本大通りエリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--purple"></span>関内エリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--orange"></span>馬車道エリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--rose"></span>桜木町エリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--navy"></span>みなとみらいエリア</li>
                        <li><span class="guide-overview__dot guide-overview__dot--lemon"></span>横浜駅エリア（宿泊施設予約のみ）</li>
                    </ul>
                </div>
                <div class="map-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/yoyakudaiko-map@2x.jpg" alt="" width="567" height="298"
                        loading="lazy" decoding="async">
                </div>
            </div>
        </section>
        <section class="resercation">
            <div class="reservation__inner">
                <div class="reservation__container">
                <h2 class="about__lead js-fade-up">
                    様々なご予約に対応いたします
                </h2>
                <div class="category category--stay">
                    <div class="category__shape">
                        <div class="category__circle">
                            <h3 class="category__title">泊まる</h3>
                            <p class="category__text">
                                リゾートホテル、ビジネスホテル、旅館や民宿まで幅広く対応します。
                            </p>
                        </div>
                    </div>
                    <div class="category__images">
                        <figure class="category__image">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/reservation-circle01@2x.png" alt="ホテルの写真">
                        </figure>
                        <figure class="category__image2">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/reservation-circle02@2x.png" alt="ホテルの写真">
                        </figure>
                    </div>
                </div>
                <div class="reservation__category category--eat">
                    <div class="category__shape">
                        <div class="category__circle">
                            <h3 class="category__title">食べる</h3>
                            <p class="category__text">横浜名物や人気店をご案内し、ご希望に合わせて予約します。</p>
                        </div>
                        <ul class="circle-eat">
                            <li class="circle-eat-img01">
                                <img class="circle-eat-img" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-01nikuryori.png" alt="" width="126"
                                    height="156" loading="lazy" decoding="async">
                                <p class="eat-name">肉料理</p>
                            </li>
                            <li class="circle-eat-img02">
                                <img class="circle-eat-img" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-02bejitarian.png" alt=""
                                    width="118" height="148" loading="lazy" decoding="async">
                                <p class="eat-name">ベジタリアン</p>
                            </li>
                            <li class="circle-eat-img03">
                                <img class="circle-eat-img" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-03tyuka.png" alt="" width="176"
                                    height="207" loading="lazy" decoding="async">
                                <p class="eat-name">中華</p>
                            </li>
                            <li class="circle-eat-img04">
                                <img class="circle-eat-img" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-04washoku.png" alt="" width="182"
                                    height="216" loading="lazy" decoding="async">
                                <p class="eat-name">和食</p>
                            </li>
                            <li class="circle-eat-img05">
                                <img class="circle-eat-img eat-img05" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-05itarian.png" alt=""
                                    width="118" height="152" loading="lazy" decoding="async">
                                <p class="eat-name">イタリア料理</p>
                            </li>
                            <li class="circle-eat-img06">
                                <img class="circle-eat-img eat-img06" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-06runch.png" alt=""
                                    width="118" height="152" loading="lazy" decoding="async">
                                <p class="eat-name">ランチ</p>
                            </li>
                            <li class="circle-eat-img07">
                                <img class="circle-eat-img eat-img07" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-07flench.png" alt=""
                                    width="126" height="156" loading="lazy" decoding="async">
                                <p class="eat-name">フランス料理</p>
                            </li>
                            <li class="circle-eat-img08">
                                <img class="circle-eat-img eat-img08" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-08cafe.png" alt=""
                                    width="115" height="148" loading="lazy" decoding="async">
                                <p class="eat-name">カフェ</p>
                            </li>
                            <li class="circle-eat-img09">
                                <img class="circle-eat-img eat-img09" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-09dinner.png" alt=""
                                    width="164" height="198" loading="lazy" decoding="async">
                                <p class="eat-name">ディナー</p>
                            </li>
                            <li class="circle-eat-img10">
                                <img class="circle-eat-img eat-img10" src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/eat-10indo.png" alt=""
                                    width="143" height="171" loading="lazy" decoding="async">
                                <p class="eat-name">インド料理</p>
                            </li>
                        </ul>
                    </div>
                </div>                <!-- eat -->
                <div class="reservation__category category--play">
                    <div class="category__shape">
                        <div class="category__circle">
                            <h3 class="category__title">あそぶ</h3>
                            <p class="category__text">体験型アクティビティも 多数対応！ <span class="br">横浜在住民ロコが最新で正確な情報をお伝えしながら、
                                    ご希望の体験を手配します。</span></p>
                        </div>
                    </div>
                    <div class="category__box">
                        <h4 class="flow__title">横浜でできる体験アクティビティの例</h4>
                        <div class="container">
                            <div class="slider js-slider">

                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/paly-slider01@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">陶芸教室</p>
                                        <div class="play-slider__bubble">
                                            <p class="">日本ならではの伝統的なハンドメイド体験。お土産にもおすすめです。気軽にできる1日体験で思い出を作りましょう！</p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">陶芸教室　みなとみらい陶芸教室</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider02@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">着物レンタル</p>
                                        <div class="play-slider__bubble">
                                            <p>日本の伝統衣装「着物」をプロの着付けで気軽に体験できます。街歩きや写真撮影にもぴったりです。</p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">横浜着物レンタル バサラホール<span class="br">ディングス　みなとみらい店</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider03@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">人力車体験</p>
                                        <div class="play-slider__bubble play-slider__bubble--width">
                                            <p>観光地を巡るなら、人力車でのんびりと。力強い車夫が案内する昔ながらの街並みや絶景を楽しめます。写真スポットも多く、旅の思い出づくりにおすすめです。
                                            </p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">人力車　株式会社横浜おもてなし<span class="br">家</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider04@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">SUP（スタンドアップパドル）体験</p>
                                        <div class="play-slider__bubble">
                                            <p>初心者OK。運河で楽しむ水上アクティビティ。外国人にも人気です。</p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">SUP体験　横浜SUP倶楽部</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider05@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">水陸両用バス「SKY DUCK」クルーズ</p>
                                        <div class="play-slider__bubble">
                                            <p class="">
                                                陸から海へ、そのままスプラッシュイン！水陸両用バスで街と港を一度に観光。ユニークな体験とガイドの楽しいトークで、大人も子どもも笑顔に。
                                            </p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">スカイダック横浜（水陸両用バス）　SKY BUS TOKYO日の丸自動車株式会社　</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider06@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">マリーンルージュクルーズ</p>
                                        <div class="play-slider__bubble">
                                            <p>ロマンチックな夜景とともに、横浜港を優雅にクルーズ。ライトアップされた街並みとディナーを楽しめる特別な船旅で、忘れられない夜を過ごせます。
                                            </p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">マリーンルージュクルーズ船 Y <span class="br">Cruise株式会社</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="slick-img">
                                    <div class="play-slider__item">
                                        <div class="play-img">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/service-reserve/play-slider07@2x.png" alt="" width=""
                                                height="" loading="lazy" decoding="async">
                                        </div>
                                        <p class="play__label">屋形船</p>
                                        <div class="play-slider__bubble">
                                            <p>伝統的な和船でのんびりと海上散歩。揚げたての天ぷらや和食を味わいながら、夜景や花火を満喫できます。日本文化と美しい景色を一度に楽しむ贅沢な時間です。
                                            </p>
                                        </div>
                                        <div class="play-slider__links">
                                            <a href="#">屋形船　濱進</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <p class="play-note">各種体験アクティビティのお支払いにつきましては現地事業者支払いでお願いいたします。<span class="br">
                            （弊社は予約代行料金のみのご請求を申し込み時にしていていただき、入金いただきます）</span>
                            <span class="br">
                            ＊各体験アクティビティのサービス内容、料金その他詳細につきましては、各サイトでご確認の程、宜しくお願い致します。</span>
                            </p>
                    </div>           <!-- category__box -->
                </div>
                
                </div>                <!-- container -->
                
            </div>              <!-- inner -->
        </section>

        <!-- 予約購入可能人数 -->
        <section class="guide-fee reserve-guide-fee">
            <div class="guide-fee__inner">
                <div class="guide-fee__info">
                    <div class="guide-fee__info-item">
                        <h3 class="guide-fee__info-title">予約購入可能人数</h3>
                        <p class="guide-fee__info-text">1~6人</p>
                    </div>
                </div>
                <div class="guide-fee__info-item">
                    <h3 class="guide-fee__info-title">料金</h3>

                    <div class="guide-fee__additional">

                        <!-- 基本料金 -->
                        <dl class="price">
                            <dt class="price__term">予約代行</dt>
                            <dd class="price__value">
                                <span class="price__dot"></span>
                                <span class="price__desc">2,200円</span>
                                <span class="price__note"></span>
                            </dd>
                        </dl>

                        <!-- 追加項目 -->
                        <div class="price__block">
                            <p class="price__subheading">追加項目</p>

                            <dl class="price">
                                <dt class="price__term price__term--additional">前日・当日の予約</dt>
                                <dd class="price__value">
                                    <span class="price__dot"></span>
                                    <span class="price__desc">+1,000円</span>
                                    <span class="price__note">予約代行料金に追加</span>
                                </dd>
                            </dl>
                        </div>
                    </div>

                    <div class="guide-fee__not-included">
                        <h3 class="guide-fee__info-title">費用に含まれないもの</h3>
                        <div class="guide-fee__not-included-list">
                            宿泊料金・飲食代・体験料金・交通費など実費でかかる費用
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- お困りごと -->
        <section class="support support--tour-guide">
            <div class="support__inner">
                <div class="support__header">
                    <h2 class="support__catchphrase">全てのサービスにサポート付き！</h2>
                </div>
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
                                1<strong>突然の交通トラブル</strong>による交通機関予約や宿泊先予約、飲食店の予約（横浜近隣施設）
                            </li>
                            <li class="support__list-item">
                                2 <strong>突然の体調不良</strong>による交通機関予約や宿泊先予約、飲食店の予約（横浜近隣施設） <br>
                                ＊別途、病院の紹介や交通機関の利用方法などもご相談ください。
                            </li>
                            <li class="support__list-item">
                                3旅行中の<strong>日程予定変更</strong>による各種ご予約（横浜近隣施設）<br>
                                ＊<strong>旅行中の紛失物</strong>の対応方法などのご相談。<br>
                                ＊日程的にどうしてもご対応ができない<strong>お土産品の購入代行</strong>のご相談<br>
                                （横浜近隣で対応可能なもの）</li>
                            <li class="support__list-item">
                                4 その他旅行中に<strong>ご相談事</strong>がある場合<br>
                                ＊弊社でご対応できる内容であれば対応いたしますので、ご相談ください。
                            </li>
                        </ol>
                    </div>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--blue btn--md btn--support">ご相談はこちら
                        <span class="btn__arrow">→</span>
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
