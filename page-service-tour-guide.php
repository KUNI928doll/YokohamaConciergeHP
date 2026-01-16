<?php
/**
 * Template Name: Tour Guide Service
 */
get_header(); 
?>

<?php get_template_part('template-parts/inner-nav'); ?>

    <main>
    <!-- サブヒーロー -->
    <div class="sub-hero js-fade-up">
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
            <li class="breadcrumb__item">サービス紹介（観光ガイドサービス）</li>
        </ul>
    </nav>
        <section class="guide-overview js-fade-up">
            <div class="guide-overview__inner">

                <!-- タイトル -->
                <div class="guide-overview__title-block">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-flag.svg" alt="" class="guide-overview__title-icon" aria-hidden="true">
                    <h2 class="guide-overview__title">観光ガイドサービス</h2>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-wave.svg" alt="" class="guide-overview__title-wave" aria-hidden="true">
                </div>

                <!-- 説明文 -->
                <div class="guide-overview__text">
                    <p><strong>観光案内のお時間：半日コース（3時間）／ 1日コース（8時間）</strong></p>

                    <p>
                        ご案内のコースにつきましては、横浜市内の元町・山手エリア、中華街・山下公園エリア、
                        日本大通りエリア、馬車道エリア、桜木町エリア、関内エリア、みなとみらいエリアの各地区地域を中心に、
                        必須の名所や行きたい場所を選定、記載いただき、申し込みいただいた日程やお客様のご希望内容に沿った、
                        時間内に最大限お楽しみいただけるコースをご提案いたします。
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
                    </ul>
                </div>

            </div>
        </section>

        <!-- 主なみどころ（立ち寄り所） -->
        <section class="guide-spots js-fade-up" id="guide-spots">
            <div class="guide-spots__inner">
                <div class="guide-spots__title">
                    <p class="guide-spots__eyebrow">主なみどころ（立ち寄り所）</p>
                </div>

                <div class="guide-spots__body">
                    <!-- 左側：エリア選択ボタン -->
                    <div class="guide-spots__nav" role="tablist" aria-label="観光エリア">
                        <button class="guide-spots__nav-btn is-active" type="button" role="tab" data-area="motomachi"
                            aria-selected="true" aria-controls="panel-motomachi" id="tab-motomachi">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-motomachi.png" alt="" aria-hidden="true">
                            元町・山手エリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="chinatown"
                            aria-selected="false" aria-controls="panel-chinatown" id="tab-chinatown">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-chukagai.png" alt="" aria-hidden="true">
                            中華街・山下公園エリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="nihondori"
                            aria-selected="false" aria-controls="panel-nihondori" id="tab-nihondori">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-nihondori.png" alt="" aria-hidden="true">
                            日本大通りエリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="kannai"
                            aria-selected="false" aria-controls="panel-kannai" id="tab-kannai">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-kannai.png" alt="" aria-hidden="true">
                            関内エリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="bashamichi"
                            aria-selected="false" aria-controls="panel-bashamichi" id="tab-bashamichi">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-bashamichi.png" alt="" aria-hidden="true">
                            馬車道エリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="sakuragicho"
                            aria-selected="false" aria-controls="panel-sakuragicho" id="tab-sakuragicho">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-sakuragicho.png" alt="" aria-hidden="true">
                            桜木町エリア
                        </button>
                        <button class="guide-spots__nav-btn" type="button" role="tab" data-area="minatomirai"
                            aria-selected="false" aria-controls="panel-minatomirai" id="tab-minatomirai">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-minatomirai.png" alt="" aria-hidden="true">
                            みなとみらいエリア
                        </button>
                    </div>

                    <!-- 右側：エリア別コンテンツ -->
                    <div class="guide-spots__content">
                        <!-- 元町・山手エリア -->
                        <div class="guide-spots__panel is-active" data-area-panel="motomachi" role="tabpanel"
                            id="panel-motomachi" aria-labelledby="tab-motomachi" aria-hidden="false">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">①</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-motomachi.png" alt="" aria-hidden="true">
                                        元町・山手エリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo1.png" alt="港の見える丘公園">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://www.motomachi.or.jp/" class="guide-spots__spot-name">元町ショッピングストリート (元町・中華街/徒歩1分)</a>
                                    </li>
                                    <li>
                                        <a href="https://hare-tabi.jp/databox/data.php/guide_minatonomieruoka_park_ja/code" class="guide-spots__spot-name">横浜港の見える丘公園 (元町・中華街/徒歩5分)</a>
                                    </li>
                                    <li>
                                        <a href="http://www.yfgc-japan.com/" class="guide-spots__spot-name">横浜外国人墓地 (元町・中華街/徒歩5分)</a>
                                    </li>
                                    <li>
                                        <a href="https://www.hama-midorinokyokai.or.jp/yamate-seiyoukan/" class="guide-spots__spot-name">横浜山手西洋館 (元町・中華街/徒歩10分)</a>
                                    </li>
                                    <li>
                                        <a href="https://www.sankeien.or.jp/" class="guide-spots__spot-name">横浜三渓園 (元町・中華街/バス15分)</a>
                                    </li>
                                    <li>
                                        <a href="https://www.hama-midorinokyokai.or.jp/park/negishi/" class="guide-spots__spot-name">根岸森林公園 (根岸・山手/徒歩15分)</a>
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo2.png" alt="山手西洋館">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo3.png" alt="三溪園の景色">
                                    </div>
                                    <div class="guide-spots__footer">
                                        <a href="<?php echo esc_url(home_url('/yokohama/#map-motomachi')); ?>" class="guide-spots__map-link">
                                            <span>MAPへ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 中華街・山下公園エリア -->
                        <div class="guide-spots__panel" data-area-panel="chinatown" role="tabpanel" id="panel-chinatown"
                            aria-labelledby="tab-chinatown" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">②</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-chukagai.png" alt="" aria-hidden="true">
                                        中華街・山下公園エリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo4.png" alt="マリンタワー
                                    の景色">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://www.welcome.city.yokohama.jp/spot/details.php?bbid=190" class="guide-spots__spot-name">山下公園 (元町・中華街/徒歩5分)</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://marinetower.yokohama/" class="guide-spots__spot-name">横浜マリンタワー (元町・中華街/徒歩3分)</a>
                                    </a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://www.doll-museum.jp/" class="guide-spots__spot-name">横浜人形の家（元町・中華街/徒歩3分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://www.chinatown.or.jp/" class="guide-spots__spot-name">横浜中華街（元町・中華街/徒歩2分）</a>
                                    </li>
                                    <li>
                                        <a href="https://yokohama-kanteibyo.com/" class="guide-spots__spot-name">横浜中華街関帝廟（元町・中華街/徒歩3分）</a>
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo5.png" alt="中華街の門">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo6.png" alt="横浜人形の家">
                                </div>
                                    <div class="guide-spots__footer">
                                <a href="<?php echo esc_url(home_url('/yokohama/#map-chinatown')); ?>" class="guide-spots__map-link">
                                    
                                    <span>MAPへ</span>
                                </a>
                            </div>
                                </div>
                            </div>
                        </div>

                        <!-- 日本大通りエリア -->
                        <div class="guide-spots__panel" data-area-panel="nihondori" role="tabpanel" id="panel-nihondori"
                            aria-labelledby="tab-nihondori" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">③</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-nihondori.png" alt="" aria-hidden="true">
                                        日本大通りエリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo7.png" alt="日本新聞博物館ニュースパーク（日本大通り">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://www.welcome.city.yokohama.jp/spot/details.php?bbid=187" class="guide-spots__spot-name">横浜三塔キング・クイーン・ジャック（馬車道・日本大通り/徒歩2～5分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="http://www.eurasia.city.yokohama.jp/" class="guide-spots__spot-name">横浜ユーラシア文化館（日本大通り/徒歩1分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://newspark.jp/" class="guide-spots__spot-name">日本新聞博物館ニュースパーク（日本大通り/徒歩2分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://www.welcome.city.yokohama.jp/spot/details.php?bbid=827" class="guide-spots__spot-name">横浜公園（関内・日本大通り/徒歩2分）</a>
                                        
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo8.png" alt="横浜市開港記念会館(ジャックの塔)">
                                </div>
                                    <div class="guide-spots__footer">

                                <a href="<?php echo esc_url(home_url('/yokohama/#map-nihondori')); ?>" class="guide-spots__map-link">
                                    
                                    <span>MAPへ</span>
                                </a>
                            </div>
                                </div>
                            </div>
                        </div>

                        <!-- 関内エリア -->
                        <div class="guide-spots__panel" data-area-panel="kannai" role="tabpanel" id="panel-kannai"
                            aria-labelledby="tab-kannai" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">④</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-kannai.png" alt="" aria-hidden="true">
                                        関内エリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo9.png" alt="伊勢佐木町商店街">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://www.isezaki.jp/" class="guide-spots__spot-name">伊勢佐木町商店街</a>
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                    </div>
                                    <div class="guide-spots__footer">
                                        <a href="<?php echo esc_url(home_url('/yokohama/#map-kannai')); ?>" class="guide-spots__map-link">
                                            <span>MAPへ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 馬車道エリア -->
                        <div class="guide-spots__panel" data-area-panel="bashamichi" role="tabpanel"
                            id="panel-bashamichi" aria-labelledby="tab-bashamichi" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">⑤</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-bashamichi.png" alt=""
                                            aria-hidden="true">
                                        馬車道エリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo10.png" alt="赤煉瓦倉庫">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="#" class="guide-spots__spot-name">赤レンガ倉庫（馬車道・日本大通り/徒歩6分）</a>  
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                    </div>
                                    <div class="guide-spots__footer">
                                        <a href="yokohama.html#map-bashamichi" class="guide-spots__map-link">
                                            <span>MAPへ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 桜木町エリア -->
                        <div class="guide-spots__panel" data-area-panel="sakuragicho" role="tabpanel"
                            id="panel-sakuragicho" aria-labelledby="tab-sakuragicho" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">⑥</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-sakuragicho.png" alt=""
                                            aria-hidden="true">
                                        桜木町エリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo11.png" alt="野毛商店街">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://noge-town.net" class="guide-spots__spot-name">野毛地区街つくり会</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://www.noge-miyakobashi.com/" class="guide-spots__spot-name">野毛都橋商店街</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://nogehondoorikai.com/index.html" class="guide-spots__spot-name">野毛本通商店街</a>
                                        
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                    </div>
                                    <div class="guide-spots__footer">
                                        <a href="<?php echo esc_url(home_url('/yokohama/#map-sakuragicho')); ?>" class="guide-spots__map-link">
                                            <span>MAPへ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- みなとみらいエリア -->
                        <div class="guide-spots__panel" data-area-panel="minatomirai" role="tabpanel"
                            id="panel-minatomirai" aria-labelledby="tab-minatomirai" aria-hidden="true">
                            <div class="guide-spots__panel-header">
                                <div class="guide-spots__panel-title-wrapper">
                                    <p class="guide-spots__panel-index">⑦</p>
                                    <p class="guide-spots__panel-title">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/about-yokohama/icon-minatomirai.png" alt=""
                                            aria-hidden="true">
                                        みなとみらいエリア
                                    </p>
                                </div>
                                <div class="guide-spots__panel-map">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo12.png" alt="ランドマークタワー">
                                </div>
                            </div>

                            <div class="guide-spots__panel-body">
                                <ul class="guide-spots__list">
                                    <li>
                                        <a href="https://www.yokohama-landmark.jp/skygarden/access/" class="guide-spots__spot-name">横浜ランドマークタワー（みなとみらい/徒歩2分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://cosmoworld.jp/" class="guide-spots__spot-name">横浜コスモワールド（みなとみらい/徒歩3分）</a>
                                        
                                    </li>
                                    <li>
                                        <a href="https://www.yokohama-anpanman.jp/" class="guide-spots__spot-name">横浜アンパンマンこどもミュージアム（新高島/徒歩3分）</a>
                                    </li>
                                    <li>
                                        <a href="https://www.hara-mrm.com/" class="guide-spots__spot-name">原鉄道模型博物館（新高島/徒歩3分）</a>
                                    </li>
                                    <li>
                                        <a href="https://www.cupnoodles-museum.jp/ja/yokohama/" class="guide-spots__spot-name">カップヌードルミュージアム（みなとみらい・馬車道/8分）</a>
                                    </li>
                                    <li>
                                        <a href="https://www.welcome.city.yokohama.jp/spot/details.php?bbid=143" class="guide-spots__spot-name">TOY MUSEUM（旧 横浜ブリキのおもちゃ博物館）
                                            （新高島/徒歩7分）</a>
                                    </li>
                                </ul>

                                <div class="guide-spots__right">
                                    <div class="guide-spots__gallery">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo13.png" alt="コスモワールド">
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/service-tour-guide_photo14.png" alt="美術館">
                                    </div>
                                    <div class="guide-spots__footer">
                                        <a href="<?php echo esc_url(home_url('/yokohama/#map-minatomirai')); ?>" class="guide-spots__map-link">
                                            <span>MAPへ</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="guide-spots__area-btn">
                <a href="<?php echo esc_url(home_url('/yokohama/#guide-overview')); ?>" class="btn btn--blue btn--md btn--with-arrow">
                    <span>各エリアについて知る</span>
                    <span class="btn__arrow" aria-hidden="true">→</span>
                </a>
            </div>
        </section>
        <section class="guide-points js-fade-up">
            <div class="guide-points__inner">
                <h2 class="guide-points__title">
                    <svg class="guide-points__curve" viewBox="0 0 600 160" aria-hidden="true">
                        <defs>
                            <path id="guidePointsCurvePath" d="M 60 130 Q 300 30 540 130" />
                        </defs>
                        <text fill="#0D3063" font-size="26" font-weight="600" font-family="Noto Sans JP, sans-serif">
                            <textPath href="#guidePointsCurvePath" startOffset="50%" text-anchor="middle">
                                ハマナビサービス観光ガイドのポイント
                            </textPath>
                        </text>
                    </svg>
                </h2>
                <div class="guide-points__wrapper">
                    <ul class="guide-points__features">
                        <li class="guide-points__feature">
                            <div class="guide-points__icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-points1.png" alt="特徴1のまるアイコン">
                            </div>
                            <p class="guide-points__head">直前・緊急対応</p>
                            <p class="guide-points__text">（前日・当日OK）</p>
                        </li>
                    </ul>
                    <ul class="guide-points__features">
                        <li class="guide-points__feature">
                            <div class="guide-points__icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-points2.png" alt="特徴2のまるアイコン">
                            </div>
                            <p class="guide-points__head">多言語サポート</p>
                            <p class="guide-points__text">英語・中国語・韓国語</p>
                        </li>
                    </ul>
                    <ul class="guide-points__features">
                        <li class="guide-points__feature">
                            <div class="guide-points__icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/service-tour-guide/guide-points3.png" alt="特徴3のまるアイコン">
                            </div>
                            <p class="guide-points__head">地元横浜に精通</p>
                            <p class="guide-points__text">横浜をよく知る<br>スタッフ同行で安心</p>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- 料金セクション -->
        <section class="guide-fee js-fade-up">
            <div class="guide-fee__inner">
                <div class="guide-fee__info">
                    <div class="guide-fee__info-item">
                        <h3 class="guide-fee__info-title">予約購入可能人数</h3>
                        <p class="guide-fee__info-text">1~3人</p>
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
        <section class="guide-services js-fade-up">
            <div class="guide-services__inner">
                <div class="guide-services__cards">
                    <!-- カード1: 予約代行 -->
                    <a class="guide-services__card" href="<?php echo esc_url(home_url('/service-reserve/')); ?>">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-reserve.png" alt="予約代行アイコン">
                        </div>
                        <h3 class="guide-services__title">予約代行</h3>
                    </a>

                    <!-- カード2: トランクお預かり -->
                    <a class="guide-services__card" href="<?php echo esc_url(home_url('/service-storage/')); ?>">
                        <div class="guide-services__corner"></div>
                        <div class="guide-services__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/service/icon-trunk.png" alt="トランクお預かりアイコン">
                        </div>
                        <h3 class="guide-services__title">トランクお預かり</h3>
                    </a>

                    <!-- カード3: 観光ガイドサービス -->
                    <a class="guide-services__card" href="<?php echo esc_url(home_url('/service-tour-guide/')); ?>">
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

        <section class="contact contact--bottom js-fade-up" id="contact">
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