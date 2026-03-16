<?php
/**
 * Template Name: 横浜について
 */
get_header(); 
?>
<?php get_template_part('template-parts/inner-nav'); ?>

    <main id="main-content">

        <div class="sub-hero">
            <div class="sub-hero__decoration">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true" width="1730" height="92">
            </div>
            <div class="sub-hero__img">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-hero.png" alt="横浜の夜景" width="2734" height="746">
            </div>
            <h1 class="sub-hero__title">横浜について</h1>
        </div>
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <ul class="breadcrumb__list">
                <li class="breadcrumb__item">
                    <a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a>
                </li>
                <li class="breadcrumb__item">横浜について</li>
            </ul>
        </nav>
        <section class="guide-overview">
            <div class="guide-overview__inner">

                <!-- タイトル -->
                <div class="guide-overview__title-block">
                    <h2 class="guide-overview__title">横浜について</h2>
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-wave.svg" alt="" class="guide-overview__title-wave"
                        aria-hidden="true">
                </div>
            </div>
        </section>

        <!-- 横浜の地図 -->
        <section class="yokohama-area" id="yokohama-area">
            <div class="guide-spots__inner">
                <div class="guide-spots__nav" role="group" aria-label="観光エリア">
                    <button class="guide-spots__nav-btn is-active" type="button" data-target="map-motomachi">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-motomachi.png" alt="" aria-hidden="true">
                        元町・山手エリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-chinatown">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-chukagai.png" alt="" aria-hidden="true">
                        中華街・山下公園エリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-nihondori">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-nihondori.png" alt="" aria-hidden="true">
                        日本大通りエリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-kannai">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-kannai.png" alt="" aria-hidden="true">
                        関内エリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-bashamichi">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-bashamichi.png" alt="" aria-hidden="true">
                        馬車道エリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-sakuragicho">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-sakuragicho.png" alt="" aria-hidden="true">
                        桜木町エリア
                    </button>
                    <button class="guide-spots__nav-btn" type="button" data-target="map-minatomirai">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-minatomirai.png" alt="" aria-hidden="true">
                        みなとみらいエリア
                    </button>
                </div>

                <div class="yokohama-area__maps">
                    <div class="yokohama-area__map is-active" id="map-motomachi">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/motomati-map@2x.jpg" alt="元町・山手エリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-chinatown">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/tyukamati-map@2x.jpg" alt="中華街・山下公園エリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-nihondori">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/nihondori-map.jpg" alt="日本大通りエリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-kannai">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/kannai-map@2x.jpg" alt="関内エリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-bashamichi">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/bashamichi-map.jpg" alt="馬車道エリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-sakuragicho">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/sakuragi-map.jpg" alt="桜木町エリアの地図" width="2577" height="1471">
                    </div>
                    <div class="yokohama-area__map" id="map-minatomirai">
                        <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/minatomirai-map@2x.jpg" alt="みなとみらいエリアの地図" width="2577" height="1471">
                    </div>
                </div>
            </div>
        </section>

        <section class="yokohama">
            <div class="yokohama-tab__inner">
                <div class="tabs">
                    <ul class="tab-list">
                        <li class="tab-item active" tabindex="0">元町・山手エリア</li>
                        <li class="tab-item" tabindex="0">中華街・山下公園エリア</li>
                        <li class="tab-item" tabindex="0">日本大通りエリア</li>
                        <li class="tab-item" tabindex="0">関内エリア</li>
                        <li class="tab-item" tabindex="0">馬車道エリア</li>
                        <li class="tab-item" tabindex="0">桜木町エリア</li>
                        <li class="tab-item" tabindex="0">みなとみらい<br>エリア</li>
                    </ul>
                    <div class="tab-content">
                        <!-- 元町・山手 -->
                        <div class="tab-panel active">
                            <div class="tab-wrapper">
                                <h2 class="guide-spots__panel-title">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-chukagai.png" alt="" aria-hidden="true">
                                    元町・山手エリア
                                </h2>
                                <div class="tab-img">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/motomati-tab01@2x.png" alt="元町・山手エリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                            <p class="tab-text">
                                洗練されたブティックやカフェが並ぶ「元町ショッピングストリート」と、洋館が立ち並ぶ山手の丘エリアは、横浜の異国情緒をもっとも感じられる場所。石畳の道や西洋建築など、まるでヨーロッパを歩いているような雰囲気を味わえます。<br>ゆったり散策や、ティータイムにぴったりのエリアです。
                            </p>
                            <h3 class="tab-sub-title">見どころスポット</h3>
                            <p class="tab-text">アメリカ山公園　　屋上庭園のような公園。港や街並みを見下ろす美しい景色が楽しめます。</p>
                            <div class="tab-img2">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/motomati-tab02@2x.png" alt="元町・山手エリアの写真" loading="lazy"
                                    decoding="async">
                            </div>
                            <div class="tab__map-button">
                                <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-motomachi">
                                    <span aria-hidden="true">↑</span>
                                    <span>MAPへ</span>
                                </a>
                            </div>

                        </div>
                        <!-- 中華街 -->
                        <div class="tab-panel">
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-chukagai.png" alt="" aria-hidden="true">
                                中華街・山下公園エリア
                            </h2>
                            <div class="tab-panel-wrap">
                                <p class="tab-text">
                                    世界最大級の規模を誇る横浜中華街では、カラフルな牌楼（門）と活気ある屋台が旅行者を出迎えます。本格中華料理や点心の食べ歩きはもちろんのこと、伝統的な寺院や雑貨屋巡りも人気。すぐ近くの山下公園は海風を感じながら散歩でき、氷川丸やベイブリッジを眺めることができる絶景スポットです。
                                </p>
                                <div class="tab-img2">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/tyukamati-tab01@2x.png" alt="中華街・山下公園エリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                            <div class="tab-spot">
                                <h3 class="tab-sub-title">見どころスポット</h3>
                                <p class="tab-text">横浜大世界　　中国文化をテーマにした複合施設。雑貨、アート、フードが楽しめます。</p>
                                <div class="tab-img3">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/tyukamati-tab02@2x.png" alt="中華街・山下公園エリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                                <div class="tab__map-button tab__map-button--position">
                                    <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-chinatown">
                                        <span aria-hidden="true">↑</span>
                                        <span>MAPへ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- 日本大通り -->
                        <div class="tab-panel">
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-nihondori.png" alt="" aria-hidden="true">
                                日本大通りエリア
                            </h2>
                            <p class="tab-text">
                                銀杏並木が美しい日本大通りは、横浜開港当時から歴史を刻むクラシカルな街並み。歴史的建造物が立ち並び、重厚な雰囲気を楽しめます。秋には黄金色に染まる並木道を散策でき、歴史と自然が調和した落ち着きあるエリアです。
                            </p>

                            <h3 class="tab-sub-title">見どころスポット</h3>
                            <div class="tab-wrapper2 tab-wrapper2--vertical">
                                <ul class="tab-text">
                                    <li>• 象の鼻パーク　開港当時の防波堤が復元されている、海沿いの散策・休憩スポット。開放感抜群です。

                                    </li>
                                    <li>• 大さん橋（メリケン波止場）　クルーズ船発着であり、夜景スポットへも近い、日本で最も古い桟橋です。</li>
                                </ul>
                                <div class="tab-img4">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/nihonodori-tab01@2x.png" alt="日本大通りエリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                            <div class="tab__map-button">
                                <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-nihondori">
                                    <span aria-hidden="true">↑</span>
                                    <span>MAPへ</span>
                                </a>
                            </div>
                        </div>
                        <!-- 関内 -->
                        <div class="tab-panel">
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-kannai.png" alt="" aria-hidden="true">
                                関内エリア
                            </h2>
                            <div class="tab-panel-wrap">
                                <p class="tab-text">文明開化の時代に外国人居留地として栄えた馬車道は、ガス灯とレンガ造りの建物が並ぶ、レトロな雰囲気漂うエリア。アイスクリームやガス灯発祥の地としても知られ、昔ながらの洋食店やアートスポットが点在しています。レトロとモダンが調和した散策におすすめの場所です。
                                </p>
                                </p>
                                <div class="tab-img2">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/kannai-tab01@2x.png" alt="関内エリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                            <div class="tab-spot">
                                <h3 class="tab-sub-title">見どころスポット</h3>
                                <p class="tab-text">横浜スタジアム　　プロ野球の試合や大型イベントが開催される、横浜の象徴的な球場です。</p>
                                <div class="tab-img3">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/kannai-tab02@2x.png" alt="横浜スタジアムの写真" loading="lazy"
                                        decoding="async">
                                </div>
                                <div class="tab__map-button tab__map-button--position">
                                    <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-chinatown">
                                        <span aria-hidden="true">↑</span>
                                        <span>MAPへ</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- 馬車道 -->
                        <div class="tab-panel">
                            <div class="tab-img5">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/kannai-tab01@2x.png" alt="関内エリアの写真" loading="lazy" decoding="async">
                            </div>
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-bashamichi.png" alt="" aria-hidden="true">馬車道エリア
                            </h2>
                            <p class="tab-text">
                                文明開化の時代に外国人居留地として栄えた馬車道は、ガス灯とレンガ造りの建物が並ぶ、レトロな雰囲気漂うエリア。アイスクリームやガス灯発祥の地としても知られ、昔ながらの洋食店やアートスポットが点在しています。レトロとモダンが調和した散策におすすめの場所です。
                            </p>
                            <h3 class="tab-sub-title">見どころスポット</h3>
                            <div class="tab-wrapper2">
                                <ul class="tab-text">
                                    <li> • 神奈川県立歴史博物館　 重厚な石造りの建物。日本や神奈川、横浜の歴史を学べます。
                                    </li>
                                    <li>• 横浜アイス発祥の碑（太陽の母子）　アイスクリーム誕生地を感じられる小さな史跡。</li>
                                    <li> • 横浜スタジアム　野球観戦やイベントで盛り上がる拠点です。</li>
                                    <li> • ガス灯通り　文明開化の象徴、ガス灯が今も街を照らすレトロな通り。</li>
                                    <li> • 馬車道十番館 　喫茶店とバーが併設されたクラシックな洋館のフレンチレストラン。お食事も楽しめます。</li>
                                    <li> • 旧横浜銀行本店　重厚な石造りの建物。昭和初期の建築美が残されています
                                    </li>
                                </ul>
                            </div>
                            <div class="tab__map-button">
                                <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-bashamichi">
                                    <span aria-hidden="true">↑</span>
                                    <span>MAPへ</span>
                                </a>
                            </div>
                        </div>
                        <!-- 桜木町エリア -->
                        <div class="tab-panel">
                            <div class="tab-img5">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/sakuragimachi-tab01@2x.png" alt="桜木町エリアの写真" loading="lazy"
                                    decoding="async">
                            </div>
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-sakuragicho.png" alt="" aria-hidden="true">桜木町エリア
                            </h2>
                            <p class="tab-text">
                                横浜観光の玄関口である桜木町駅周辺は、海と高層ビルの風景が広がり、夜景の美しさでも有名です。駅前には、桜木町と新港地区を結ぶロープウェイ「YOKOHAMA AIR
                                CABIN」の乗降場も。アクセスの良さに加え動物園もあり、家族連れに人気のエリアです。
                            </p>
                            <h3 class="tab-sub-title">見どころスポット</h3>
                            <div class="tab-wrapper2">
                                <ul class="tab-text">
                                    <li> • 汽車道　みなとみらいへ続く、廃線跡を利用した遊歩道。海とビル群の絶景を楽しみながら散策できる。
                                    </li>
                                    <li> • 桜木町駅前広場　横浜観光の起点となる場所。待ち合わせの定番でもある</li>
                                    <li> • 野毛山動物園　入園無料の動物園。ライオンやキリンなどを気軽に見ることができます。</li>
                                </ul>
                            </div>
                            <div class="tab__map-button">
                                <a href="#yokohama-area" class="guide-spots__map-link" data-target="map-sakuragicho">
                                    <span aria-hidden="true">↑</span>
                                    <span>MAPへ</span>
                                </a>
                            </div>
                        </div>
                        <!-- みなとみらいエリア -->
                        <div class="tab-panel">
                            <h2 class="guide-spots__panel-title">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-minatomirai.png" alt="" aria-hidden="true">
                                みなとみらいエリア
                            </h2>
                            <div class="tab-panel-wrap">
                                <p class="tab-text">
                                    横浜のシンボルともいえるみなとみらいは、近未来的な高層ビル群。と海辺の景色が融合する大人気エリア。ショッピングモールやアミューズメント施設、美術観光などが楽しめます。
                                </p>
                                <div class="tab-img2">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/minatomirai-tab01@2x.png" alt="みなとみらいエリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                            </div>
                            <div class="tab-spot">
                                <h3 class="tab-sub-title">見どころスポット</h3>
                                <ul class="tab-text">
                                    <li> • クイーンズスクエア横浜　大型ショッピングモール。買い物や食事に便利。
                                    </li>
                                    <li>• 横浜美術館　国内外の近現代美術を鑑賞できる文化スポット</li>
                                </ul>
                                <div class="tab-img3">
                                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/yokohama/minatomitai-tab02@2x.png" alt="みなとみらいエリアの写真" loading="lazy"
                                        decoding="async">
                                </div>
                                <div class="tab__map-button tab__map-button--position">
                                    <a href="#yokohama-area" class="guide-spots__map-link"
                                        data-target="map-minatomirai">
                                        <span aria-hidden="true">↑</span>
                                        <span>MAPへ</span>
                                    </a>
                                </div>
                            </div>
                        </div> <!-- tab-content -->
                    </div> <!-- tab-content -->
                </div> <!-- tabs -->
            </div> <!-- inner -->
        </section>

                <!-- ホームに戻るボタン -->
                <div class="yokohama-home-btn">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-home">
                        <span class="btn-home__icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="btn-home__text">ホームへ</span>
                    </a>
                </div>
        <section class="contact contact--bottom" id="contact">
            <div class="contact__decos">
                <div class="speech-bubble-imgwrap speech-bubble-imgwrap--contact">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/bubble.png" class="speech-bubble-img" aria-hidden="true">
                    <p class="speech-bubble-text speech-bubble-text--contact">
                        ハマナビサービスで<br>横浜を楽しんでいってね！
                    </p>
                </div>
                <figure class="character character--contact">
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/contact/bird.png" alt="ハマナビくん">
                </figure>
            </div>
            <div class="contact__inner">
                <h2 class="section-title section-title--sm section-title--contact">
                    <span class="section-title__text">お問い合わせ</span>
                    <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/about/about_title-wave.svg" alt="" aria-hidden="true" class="section-title__icon section-title__icon--wave">
                </h2>

                <div class="contact__box">
                    <ul class="contact__list">
                        <li class="contact__item contact__item--tel">
                            <a href="tel:0456812737" class="contact__tel">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_phoneicon.png" alt="" aria-hidden="true">
                                <span>045-681-2737</span>
                            </a>
                        </li>

                        <li class="contact__item contact__item--mobile">
                            <a href="tel:07015263845" class="contact__tel">
                                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/header_mobileicon.png" alt="" aria-hidden="true">
                                <span>070-1526-3845</span>
                            </a>
                        </li>
                        <li class="contact__item contact__item--time">対応時間：10:00〜18:00／不定休</li>
                        <li class="contact__item contact__item--mail">
                            <a href="mailto:info@hamanavi-s.jp" class="contact__mail">
                                <img loading="lazy" src="<?php echo esc_url(get_template_directory_uri()); ?>/images/header_mailicon.png" alt="" aria-hidden="true">
                                <span>info@hamanavi-s.jp</span>
                            </a>
                        </li>
                    </ul>

                    <div class="contact__btns">
                        <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn--blue btn--md">お問い合わせ・ご相談窓口<span class="btn__arrow">→</span></a>
                        
                        <a href="<?php echo esc_url(home_url('/reservation/')); ?>" class="btn btn--orange btn--md">予約する
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/service/icon-link.png" alt="" class="btn__icon" aria-hidden="true"></a>
                    </div>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/contact-section'); ?>

        <section class="transport-links">
            <div class="transport-links__inner">
                <!-- 上のバナー画像 -->
                <div class="transport-links__banner">
                    <a href="https://www.instagram.com/yokohama_concierge/" target="_blank" rel="noopener noreferrer">
                        <picture>
                            <source media="(max-width: 768px)" srcset="<?php echo get_template_directory_uri(); ?>/images/influencer/influencer-header-sp.png">
                            <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/images/influencer/influencer-header.png" alt="マイクロインフルエンサー募集バナー" width="2098" height="276">
                        </picture>
                    </a>
                </div>
                                <!-- 動画セクション -->
                                <div class="influencer__video">
                    <video class="influencer__video-player" controls>
                        <source src="<?php echo get_template_directory_uri(); ?>/videos/influencer-video.mp4" type="video/mp4">
                        <source src="<?php echo get_template_directory_uri(); ?>/videos/influencer-video.webm" type="video/webm">
                        お使いのブラウザは動画タグをサポートしていません。
                    </video>
                </div>
                
                <!-- リンクボックス一覧 -->
                <div class="transport-links__grid">
                    <!-- 1 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">有名スポットに1本で移動できる連接バス</p>
                            <p class="transport-links__title">BAYSIDE BLUE</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">横浜観光情報公式サイト</span>
                        </div>
                    </a>
                    <!-- 2 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">横濱ハンマーヘッドや赤レンガ倉庫など、<br>横浜人気観光スポットを巡る</p>
                            <p class="transport-links__title">周遊バス「あかいくつ」</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">横浜市交通局公式サイト</span>
                        </div>
                    </a>

                    <!-- 3 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">横浜駅周辺及び元町中華街・関内周辺の</p>
                            <p class="transport-links__title">電動キックボード</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">LUUP公式サイト</span>
                        </div>
                    </a>

                    <!-- 4 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">日本初！世界最先端の都市型循環式ロープウェイ</p>
                            <p class="transport-links__title">YOKOHAMA AIR CABIN</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">YOKOHAMA AIR CABIN公式サイト</span>
                        </div>
                    </a>

                    <!-- 5 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">インバウンド顧客対応</p>
                            <p class="transport-links__title">タクシーアプリ</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">GO株式会社</span>
                        </div>
                    </a>

                    <!-- 6 -->
                    <a href="#" class="transport-links__item" target="_blank" rel="noopener noreferrer">
                        <div class="transport-links__box">
                            <p class="transport-links__desc">横浜のコミュニティサイクル</p>
                            <p class="transport-links__title">バイクシェアサービス</p>
                        </div>
                        <div class="transport-links__link-wrap">
                            <span class="transport-links__link">baybike公式サイト</span>
                        </div>
                    </a>
                </div>
                <p class="note">
                    本ホームページ上のイラスト画像はあくまでもイメージ画像で、実際とは多少異なる箇所もございますので、ご了承くださいませ。
                </p>
            </div>
        </section>
    </main>

<?php get_footer(); ?>

