<?php

/**
 * Template Name: ご予約
 */
get_header();
?>
<?php get_template_part('template-parts/inner-nav'); ?>

<main>
    <section class="sub-hero sub-hero--reservation">
        <div class="sub-hero__decoration">
            <img src="<?php echo get_template_directory_uri(); ?>/images/sub-hero__decoration.png" alt="" aria-hidden="true">
        </div>
        <div class="sub-hero__inner inner">
            <h1 class="sub-hero__title">ご予約フォーム</h1>
            <p class="sub-hero__lead">観光ガイドから各種予約代行、トランクお預かりまで、必要な項目をご入力ください。担当者が内容を確認のうえ、折り返しご連絡いたします。
            </p>
        </div>
    </section>

    <nav class="breadcrumb" aria-label="Breadcrumb">
        <ul class="breadcrumb__list">
            <li class="breadcrumb__item"><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
            <li class="breadcrumb__item">ご予約</li>
        </ul>
    </nav>

    <section class="reservation">
        <div class="reservation__inner inner">
            <div class="reservation__head">
                <p class="reservation__text">下記フォームに必要情報をご入力ください<span
                        class="reservation-form__required reservation-form__required--inline">必須</span>の項目は必ずご入力ください。
                </p>
                <ul class="reservation__list">
                    <li>代表者さまの情報を先にご入力ください。</li>
                    <li>複数サービスを同時にご依頼いただけます。不要な項目は空欄のままで構いません。</li>
                    <li>同伴者がいる場合は、お名前・性別・連絡先をご記入ください。</li>
                </ul>
            </div>
            <div class="reservation__price">
  <h3 class="reservation__price-title">ハマナビサービス 価格表</h3>

  <!-- 観光ガイドサービス -->
  <div class="reservation__price-block">
    <h4 class="reservation__price-subtitle">観光ガイドサービス</h4>
    <table class="reservation__price-table">
      <thead>
        <tr>
          <th>内容</th>
          <th>料金（税込）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>半日／音声ガイド</td>
          <td>¥12,000</td>
        </tr>
        <tr>
          <td>半日／通訳ガイド付</td>
          <td>¥20,000</td>
        </tr>
        <tr>
          <td>1日／音声ガイド</td>
          <td>¥22,000</td>
        </tr>
        <tr>
          <td>1日／通訳ガイド付</td>
          <td>¥30,000</td>
        </tr>
      </tbody>
    </table>
    <p class="reservation__price-note">※ 内容詳細はサービス詳細をご参照ください。</p>
  </div>

  <!-- 予約代行サービス -->
  <div class="reservation__price-block">
    <h4 class="reservation__price-subtitle">予約代行サービス</h4>
    <table class="reservation__price-table">
      <thead>
        <tr>
          <th>内容</th>
          <th>料金（税込）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>ホテル予約</td>
          <td>¥2,200</td>
        </tr>
        <tr>
          <td>飲食店舗予約</td>
          <td>¥2,200</td>
        </tr>
        <tr>
          <td>体験・アクティビティ予約</td>
          <td>¥2,200</td>
        </tr>
      </tbody>
    </table>
    <p class="reservation__price-note">
      ※ 予約代行以外のお支払いは、現地事業者への実費精算となります。
    </p>
  </div>

  <!-- トランク預かりサービス -->
  <div class="reservation__price-block">
    <h4 class="reservation__price-subtitle">トランク預かりサービス</h4>
    <table class="reservation__price-table">
      <thead>
        <tr>
          <th>内容</th>
          <th>料金（税込）</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>トランク預かり（1個／1日）</td>
          <td>¥1,800</td>
        </tr>
      </tbody>
    </table>
    <p class="reservation__price-note">
      ※ トランクサイズは <strong>1m × 1m 以内</strong> に限ります。<br>
      ※ 最終請求金額はカード会社のレートにより変動する場合があります。
    </p>
  </div>
</div>


            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="reservation-form">
                <?php wp_nonce_field('reservation_form', 'reservation_nonce'); ?>
                <input type="hidden" name="action" value="submit_reservation">

                <div class="reservation-form__section">
                    <h3 class="reservation-form__legend">基本入力項目（代表者）</h3>
                    <p class="reservation-form__description">代表者さまの基本情報をご入力ください。ご入力内容をもとに、担当者がお電話またはメールでご連絡いたします。
                    </p>
                    <div class="reservation-form__grid">
                        <div class="reservation-form__field">
                            <label for="reservation-name" class="reservation-form__label">お名前<span
                                    class="reservation-form__required">必須</span></label>
                            <input type="text" id="reservation-name" name="name" class="reservation-form__input"
                                placeholder="例）横浜 太郎" required>
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-gender" class="reservation-form__label">性別</label>
                            <select id="reservation-gender" name="gender" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="male">男性</option>
                                <option value="female">女性</option>
                                <option value="other">その他</option>
                            </select>
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-nationality" class="reservation-form__label">国籍</label>
                            <input type="text" id="reservation-nationality" name="nationality"
                                class="reservation-form__input" placeholder="例）Japan">
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-address" class="reservation-form__label">住所</label>
                            <input type="text" id="reservation-address" name="address"
                                class="reservation-form__input" placeholder="例）神奈川県横浜市中区〜">
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-passport" class="reservation-form__label">パスポート番号</label>
                            <input type="text" id="reservation-passport" name="passport"
                                class="reservation-form__input" placeholder="例）TR1234567">
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-stay" class="reservation-form__label">滞在先（他宿泊先）</label>
                            <input type="text" id="reservation-stay" name="stay" class="reservation-form__input"
                                placeholder="例）〇〇ホテル 1001号室">
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-phone" class="reservation-form__label">電話番号（携帯番号）<span
                                    class="reservation-form__required">必須</span></label>
                            <input type="tel" id="reservation-phone" name="phone" class="reservation-form__input"
                                placeholder="例）+81-90-1234-5678" required>
                        </div>
                        <div class="reservation-form__field">
                            <label for="reservation-email" class="reservation-form__label">連絡先アドレス（メールアドレス）<span
                                    class="reservation-form__required">必須</span></label>
                            <input type="email" id="reservation-email" name="email" class="reservation-form__input"
                                placeholder="info@example.com" required>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="reservation-companion" class="reservation-form__label">同伴者情報</label>
                        <textarea id="reservation-companion" name="companion" class="reservation-form__textarea"
                            rows="4" placeholder="例）山田 花子／女性／+81-80-0000-0000／hanako@example.com"></textarea>
                        <p class="reservation-form__note">同伴者がいる場合は、お名前・性別・連絡先（携帯番号 / メールアドレス）をご入力ください。</p>
                    </div>
                </div>

                <div class="reservation-form__section">
                    <h3 class="reservation-form__legend">観光ガイドサービス</h3>
                    <p class="reservation-form__description">専任ガイドがご案内します。ご希望のコースとエリア、訪れたいスポットをご指定ください。</p>
                    <div class="reservation-form__grid">
                        <div class="reservation-form__field">
                            <label for="guide-course" class="reservation-form__label">ご希望コース</label>
                            <select id="guide-course" name="guideCourse" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="half">半日コース</option>
                                <option value="full">1日コース</option>
                            </select>
                        </div>
                        <div class="reservation-form__field">
                            <label for="guide-area" class="reservation-form__label">ご希望エリア</label>
                            <select id="guide-area" name="guideArea" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="motomachi">元町・山手</option>
                                <option value="yamashita">山下公園・中華街</option>
                                <option value="nihonodori">日本大通り</option>
                                <option value="bashamichi">馬車道</option>
                                <option value="kannai">関内</option>
                                <option value="minatomirai">みなとみらい</option>
                                <option value="sakuragicho">桜木町</option>
                            </select>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="guide-spots" class="reservation-form__label">ご希望スポット場所</label>
                        <textarea id="guide-spots" name="guideSpots" class="reservation-form__textarea" rows="4"
                            placeholder="訪問したい施設や体験したい内容をご記入ください"></textarea>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="guide-notes" class="reservation-form__label">その他ご要望事項</label>
                        <textarea id="guide-notes" name="guideNotes" class="reservation-form__textarea" rows="4"
                            placeholder="通訳の有無、特別対応などございましたらご入力ください"></textarea>
                    </div>
                </div>

                <div class="reservation-form__section">
                    <h3 class="reservation-form__legend">ホテル（宿泊先）予約代行サービス</h3>
                    <p class="reservation-form__description">ご希望の宿泊条件を入力ください。空室状況を確認のうえ、手配可否をご連絡します。</p>
                    <div class="reservation-form__grid">
                        <div class="reservation-form__field">
                            <label for="hotel-date" class="reservation-form__label">予約日</label>
                            <input type="date" id="hotel-date" name="hotelDate"
                                class="reservation-form__input">
                        </div>
                        <div class="reservation-form__field">
                            <label for="hotel-area" class="reservation-form__label">エリア選択</label>
                            <select id="hotel-area" name="hotelArea" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="motomachi">元町・山手</option>
                                <option value="yamashita">山下公園・中華街</option>
                                <option value="nihonodori">日本大通り</option>
                                <option value="bashamichi">馬車道</option>
                                <option value="kannai">関内</option>
                                <option value="minatomirai">みなとみらい</option>
                                <option value="sakuragicho">桜木町</option>
                            </select>
                        </div>
                        <div class="reservation-form__field">
                            <label for="hotel-budget" class="reservation-form__label">ご希望金額</label>
                            <select id="hotel-budget" name="hotelBudget" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="6000">〜6,000円</option>
                                <option value="12000">〜12,000円</option>
                                <option value="20000">〜20,000円</option>
                                <option value="30000">〜30,000円</option>
                                <option value="30000plus">30,000円〜</option>
                                <option value="50000plus">50,000円〜</option>
                            </select>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <p class="reservation-form__label">人数</p>
                        <div class="reservation-form__inline-grid reservation-form__inline-grid--simple">
                            <label for="hotel-adults" class="reservation-form__inline-field">
                                <span>大人</span>
                                <input type="number" id="hotel-adults" name="hotelAdults"
                                    class="reservation-form__input" min="0" value="0">
                            </label>
                            <label for="hotel-children" class="reservation-form__inline-field">
                                <span>子供</span>
                                <input type="number" id="hotel-children" name="hotelChildren"
                                    class="reservation-form__input" min="0" value="0">
                            </label>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="hotel-request" class="reservation-form__label">その他ご希望事項</label>
                        <textarea id="hotel-request" name="hotelRequest" class="reservation-form__textarea" rows="4"
                            placeholder="部屋タイプ、ベッド数、送迎希望など"></textarea>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <p class="reservation-form__label">ハマナビからの提案</p>
                        <p class="reservation-form__proposal-description">
                            以下は、お客さまのご希望条件に基づき選定した2つの候補です。内容をご確認のうえ、いずれか1案について「予約代行を依頼する」場合のみ、下記ボタンを押してください。本提案には、条件に合う場合、ハマナビサービス提携事業者（特典のご案内が可能な場合を含む）を優先的に含めることがあります。
                            ＊発注（決済）が行われない場合、本提案は自動的に（キャンセル）となります。
                        </p>
                        <div class="reservation-form__shop-selector">
                            <button type="button" class="btn btn--outline btn--sm" id="selectHotelBtn">
                                <i class="fas fa-hotel"></i> ホテルから選ぶ
                            </button>
                        </div>
                        <div class="reservation-form__proposal-grid">
                            <div class="reservation-form__proposal-item">
                                <label for="hotel-proposal-1" class="reservation-form__proposal-label">
                                    提案（1）
                                    <button type="button" class="reservation-form__clear-btn" data-target="hotel-proposal-1" title="クリア">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </label>
                                <textarea id="hotel-proposal-1" name="hotelProposal1" class="reservation-form__textarea"
                                    rows="4" placeholder="ホテルを選択するか、直接入力してください" readonly></textarea>
                                <input type="hidden" id="hotel-proposal-1-id" name="hotelProposal1Id">
                            </div>
                            <div class="reservation-form__proposal-item">
                                <label for="hotel-proposal-2" class="reservation-form__proposal-label">
                                    提案（2）
                                    <button type="button" class="reservation-form__clear-btn" data-target="hotel-proposal-2" title="クリア">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </label>
                                <textarea id="hotel-proposal-2" name="hotelProposal2" class="reservation-form__textarea"
                                    rows="4" placeholder="ホテルを選択するか、直接入力してください" readonly></textarea>
                                <input type="hidden" id="hotel-proposal-2-id" name="hotelProposal2Id">
                            </div>
                        </div>
                        <div class="reservation-form__field reservation-form__field--full">
                            <p class="reservation-form__label">最終選択<span class="reservation-form__required">必須</span></p>
                            <div class="reservation-form__final-selection">
                                <label class="reservation-form__radio-label">
                                    <input type="radio" name="hotelFinalSelection" value="1" class="reservation-form__radio" id="hotel-final-1">
                                    <span>提案（1）を選択</span>
                                </label>
                                <label class="reservation-form__radio-label">
                                    <input type="radio" name="hotelFinalSelection" value="2" class="reservation-form__radio" id="hotel-final-2">
                                    <span>提案（2）を選択</span>
                                </label>
                            </div>
                            <p class="reservation-form__note">提案（1）と提案（2）の両方を入力した後、どちらかを選択してください。</p>
                        </div>
                    </div>
                </div>

                <div class="reservation-form__section">
                    <h3 class="reservation-form__legend">飲食店予約代行サービス</h3>
                    <p class="reservation-form__description">ご希望の日時・人数・ご予算をお知らせください。条件に合う店舗をご提案します。</p>
                    <div class="reservation-form__grid">
                        <div class="reservation-form__field">
                            <label for="dining-date" class="reservation-form__label">予約日</label>
                            <input type="date" id="dining-date" name="diningDate"
                                class="reservation-form__input">
                        </div>
                        <div class="reservation-form__field">
                            <label for="dining-area" class="reservation-form__label">エリア選択</label>
                            <select id="dining-area" name="diningArea" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="motomachi">元町・山手</option>
                                <option value="yamashita">山下公園・中華街</option>
                                <option value="nihonodori">日本大通り</option>
                                <option value="bashamichi">馬車道</option>
                                <option value="kannai">関内</option>
                                <option value="minatomirai">みなとみらい</option>
                                <option value="sakuragicho">桜木町</option>
                            </select>
                        </div>
                        <div class="reservation-form__field">
                            <label for="dining-cuisine" class="reservation-form__label">料理ジャンル</label>
                            <select id="dining-cuisine" name="diningCuisine" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="japanese">日本食</option>
                                <option value="chinese">中華</option>
                                <option value="french">フレンチ</option>
                                <option value="italian">イタリアン</option>
                                <option value="spanish">スペイン</option>
                                <option value="grill">グリル</option>
                                <option value="yakiniku">焼肉</option>
                                <option value="steak">ステーキ</option>
                                <option value="vege">ベジタリアン</option>
                                <option value="cafe">カフェ</option>
                                <option value="other">その他（ご要望欄へ）</option>
                            </select>
                        </div>
                        <div class="reservation-form__field">
                            <label for="dining-budget" class="reservation-form__label">ご希望金額</label>
                            <select id="dining-budget" name="diningBudget" class="reservation-form__select">
                                <option value="" disabled selected>選択してください</option>
                                <option value="3000">〜3,000円</option>
                                <option value="6000">〜6,000円</option>
                                <option value="12000">〜12,000円</option>
                                <option value="20000">〜20,000円</option>
                                <option value="30000">〜30,000円</option>
                                <option value="30000plus">30,000円〜</option>
                                <option value="50000plus">50,000円〜</option>
                            </select>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <p class="reservation-form__label">人数</p>
                        <div class="reservation-form__inline-grid reservation-form__inline-grid--simple">
                            <label for="dining-adults" class="reservation-form__inline-field">
                                <span>大人</span>
                                <input type="number" id="dining-adults" name="diningAdults"
                                    class="reservation-form__input" min="0" value="0">
                            </label>
                            <label for="dining-children" class="reservation-form__inline-field">
                                <span>子供</span>
                                <input type="number" id="dining-children" name="diningChildren"
                                    class="reservation-form__input" min="0" value="0">
                            </label>
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="dining-request" class="reservation-form__label">その他ご希望事項</label>
                        <textarea id="dining-request" name="diningRequest" class="reservation-form__textarea"
                            rows="4" placeholder="アレルギーや記念日利用などございましたらご入力ください"></textarea>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <p class="reservation-form__label">ハマナビからの提案</p>
                        <p class="reservation-form__proposal-description">
                            以下は、お客さまのご希望条件に基づき選定した2つの候補です。内容をご確認のうえ、いずれか1案について「予約代行を依頼する」場合のみ、下記ボタンを押してください。本提案には、条件に合う場合、ハマナビサービス提携事業者（特典のご案内が可能な場合を含む）を優先的に含めることがあります。
                            ＊発注（決済）が行われない場合、本提案は自動的に（キャンセル）となります。
                        </p>
                        <div class="reservation-form__shop-selector">
                            <button type="button" class="btn btn--outline btn--sm" id="selectRestaurantBtn">
                                <i class="fas fa-utensils"></i> レストランから選ぶ
                            </button>
                        </div>
                        <div class="reservation-form__proposal-grid">
                            <div class="reservation-form__proposal-item">
                                <label for="dining-proposal-1" class="reservation-form__proposal-label">
                                    提案（1）
                                    <button type="button" class="reservation-form__clear-btn" data-target="dining-proposal-1" title="クリア">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </label>
                                <textarea id="dining-proposal-1" name="diningProposal1"
                                    class="reservation-form__textarea" rows="4" placeholder="レストランを選択するか、直接入力してください" readonly></textarea>
                                <input type="hidden" id="dining-proposal-1-id" name="diningProposal1Id">
                            </div>
                            <div class="reservation-form__proposal-item">
                                <label for="dining-proposal-2" class="reservation-form__proposal-label">
                                    提案（2）
                                    <button type="button" class="reservation-form__clear-btn" data-target="dining-proposal-2" title="クリア">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </label>
                                <textarea id="dining-proposal-2" name="diningProposal2"
                                    class="reservation-form__textarea" rows="4" placeholder="レストランを選択するか、直接入力してください" readonly></textarea>
                                <input type="hidden" id="dining-proposal-2-id" name="diningProposal2Id">
                            </div>
                        </div>
                        <div class="reservation-form__field reservation-form__field--full">
                            <p class="reservation-form__label">最終選択<span class="reservation-form__required">必須</span></p>
                            <div class="reservation-form__final-selection">
                                <label class="reservation-form__radio-label">
                                    <input type="radio" name="diningFinalSelection" value="1" class="reservation-form__radio" id="dining-final-1">
                                    <span>提案（1）を選択</span>
                                </label>
                                <label class="reservation-form__radio-label">
                                    <input type="radio" name="diningFinalSelection" value="2" class="reservation-form__radio" id="dining-final-2">
                                    <span>提案（2）を選択</span>
                                </label>
                            </div>
                            <p class="reservation-form__note">提案（1）と提案（2）の両方を入力した後、どちらかを選択してください。</p>
                        </div>
                    </div>
                </div>

                <div class="reservation-form__section">
                    <h3 class="reservation-form__legend">トランク預かりサービス</h3>
                    <p class="reservation-form__description">大きなお荷物も安心してお預けください。お預かり数や日時をご入力ください。</p>
                    <div class="reservation-form__grid">
                        <div class="reservation-form__field">
                            <label for="luggage-date" class="reservation-form__label">予約日</label>
                            <input type="date" id="luggage-date" name="luggageDate"
                                class="reservation-form__input">
                        </div>
                        <div class="reservation-form__field">
                            <label for="luggage-count" class="reservation-form__label">予約個数</label>
                            <input type="number" id="luggage-count" name="luggageCount"
                                class="reservation-form__input" min="0" placeholder="例）2">
                        </div>
                    </div>
                    <div class="reservation-form__field reservation-form__field--full">
                        <label for="luggage-notes" class="reservation-form__label">その他ご希望事項</label>
                        <textarea id="luggage-notes" name="luggageNotes" class="reservation-form__textarea" rows="4"
                            placeholder="サイズや受け渡し希望時間など"></textarea>
                    </div>
                </div>

                <div class="reservation-form__notice">
                    <div class="reservation-form__notice-block">
                        <h4 class="reservation-form__notice-title">お支払い方法について</h4>
                        <p class="reservation-form__notice-text">
                            ご予約手配が必要な場合、後日、ハマナビサービスより
                            <strong>安全なオンライン決済ページ（Stripe）</strong> をご案内いたします。
                            当フォームでは、クレジットカード番号・セキュリティコード等の情報は取得いたしません。
                            カード情報は Stripe により暗号化され、安全に処理されます。
                        </p>
                    </div>

                    <div class="reservation-form__notice-block">
                        <h4 class="reservation-form__notice-title">送信後の流れについて</h4>
                        <p class="reservation-form__notice-text">
                            ご依頼内容を確認後、担当者よりメールまたはお電話にてご連絡いたします。
                            予約手配が必要なサービスについては、内容確定後に
                            <strong>オンライン決済ページ（Stripe）</strong> をご案内いたします。
                            決済完了後に正式な予約確定となります。
                        </p>
                    </div>
                </div>


                <div class="reservation-form__actions">
                    <button type="button" id="confirmBtn" class="btn btn--blue btn--md">入力内容を確認する</button>
                </div>
            </form>
        </div>
    </section>

    <!-- 確認画面モーダル -->
    <div id="confirmModal" class="reservation-confirm" style="display: none;">
        <div class="reservation-confirm__overlay"></div>
        <div class="reservation-confirm__content">
            <h2 class="reservation-confirm__title">予約内容の確認</h2>
            <p class="reservation-confirm__lead">以下の内容でよろしければ「この内容で予約代行を依頼する」ボタンを押してStripe決済画面に進んでください。<br>※決済完了後に正式な予約依頼となります。</p>

            <div id="confirmContent" class="reservation-confirm__body">
                <!-- JavaScriptで動的に生成 -->
            </div>

            <div class="reservation-confirm__actions">
                <button type="button" class="btn btn--outline btn--md reservation-confirm__back">戻る</button>
                <a href="https://buy.stripe.com/xxxx" target="_blank" rel="noopener noreferrer" class="btn btn--orange btn--md reservation-confirm__stripe" id="stripePaymentBtn">
                    <i class="fas fa-credit-card"></i> この内容で予約代行を依頼する
                </a>
            </div>
        </div>
    </div>

    <!-- 送信完了モーダル -->
    <div id="reservationModal" class="reservation-modal" style="display: none;">
        <div class="reservation-modal__overlay"></div>
        <div class="reservation-modal__content">
            <div class="reservation-modal__icon">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="40" cy="40" r="38" stroke="#4CAF50" stroke-width="4" fill="none" />
                    <path d="M25 40L35 50L55 30" stroke="#4CAF50" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <h2 class="reservation-modal__title">ご予約を承りました</h2>
            <p class="reservation-modal__message">
                この度はYOKOHAMA Conciergeをご利用いただき、誠にありがとうございます。<br>
                ご入力いただいた内容を確認後、すぐに担当者からご連絡させていただきます。<br><br>
                ご登録のメールアドレス宛に受付完了メールをお送りしておりますので、ご確認ください。
            </p>
            <button type="button" class="btn btn--blue btn--md reservation-modal__close">閉じる</button>
        </div>
    </div>

    <!-- お店選択モーダル -->
    <div id="shopSelectModal" class="shop-select-modal" style="display: none;">
        <div class="shop-select-modal__overlay"></div>
        <div class="shop-select-modal__content">
            <div class="shop-select-modal__header">
                <h3 class="shop-select-modal__title" id="shopModalTitle">お店を選択</h3>
                <button type="button" class="shop-select-modal__close-btn" aria-label="閉じる">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="shop-select-modal__search">
                <input type="text" id="shopSearch" class="shop-select-modal__search-input" placeholder="お店を検索...">
            </div>
            <div class="shop-select-modal__body" id="shopList">
                <!-- JavaScriptで動的に生成 -->
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>