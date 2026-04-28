"use strict";

// Make Webhook URL（変更しないでください）
const MAKE_WEBHOOK_URL = 'https://hook.us2.make.com/q4s664foazn8sn737ccpojfh964enyuu';

// 言語検出（TranslatePress の trp_data を優先、html lang 属性にフォールバック）
function getLang() {
  if (typeof trp_data !== 'undefined' && trp_data.trp_current_language) {
    const l = trp_data.trp_current_language;
    if (l === 'en_US') return 'en';
    if (l === 'zh_HK' || l === 'zh_TW') return 'zh';
    if (l === 'ko_KR') return 'ko';
    return 'ja';
  }
  const htmlLang = (document.documentElement.lang || 'ja').toLowerCase();
  if (htmlLang.startsWith('en')) return 'en';
  if (htmlLang.startsWith('zh')) return 'zh';
  if (htmlLang.startsWith('ko')) return 'ko';
  return 'ja';
}

// UI テキスト翻訳テーブル
// {name} はお店名のプレースホルダー
const TRANSLATIONS = {
  ja: {
    loading:              'データを読み込み中です。しばらくお待ちください。',
    modalTitleHotel:      'ホテルを選択',
    modalTitleRestaurant: 'レストランを選択',
    noResults:            '条件に合うお店が見つかりませんでした。<br>エリア・料理ジャンル・ご希望金額の条件を変更してお試しください。',
    priceUnknown:         '要確認',
    coupon:               'クーポンあり',
    website:              'ウェブサイト',
    addToProposal:        '提案に追加',
    toastAdded:           '{name} を提案に追加しました',
    infoArea:             'エリア',
    infoDesc:             '特徴',
    infoHours:            '営業時間',
    infoAddress:          '住所',
    infoPhone:            '電話',
    sending:              '送信中...',
    toastApprove:         '予約リクエストを送信しました',
    toastError:           '送信に失敗しました。もう一度お試しください。',
    toastSectionClear:    'セクションをクリアしました',
    toastClear:           'クリアしました'
  },
  en: {
    loading:              'Loading data. Please wait a moment.',
    modalTitleHotel:      'Select Hotel',
    modalTitleRestaurant: 'Select Restaurant',
    noResults:            'No shops found matching your criteria.<br>Please try changing the area, cuisine type, or budget.',
    priceUnknown:         'Contact us',
    coupon:               'Coupon available',
    website:              'Website',
    addToProposal:        'Add to Proposal',
    toastAdded:           '{name} added to proposal',
    infoArea:             'Area',
    infoDesc:             'About',
    infoHours:            'Hours',
    infoAddress:          'Address',
    infoPhone:            'Phone',
    sending:              'Sending...',
    toastApprove:         'Reservation request sent',
    toastError:           'Failed to send. Please try again.',
    toastSectionClear:    'Section cleared',
    toastClear:           'Cleared'
  },
  zh: {
    loading:              '正在加载数据，请稍候。',
    modalTitleHotel:      '选择酒店',
    modalTitleRestaurant: '选择餐厅',
    noResults:            '未找到符合条件的店铺。<br>请尝试更改地区、菜系或预算条件。',
    priceUnknown:         '请咨询',
    coupon:               '有优惠券',
    website:              '网站',
    addToProposal:        '添加到提案',
    toastAdded:           '{name} 已添加到提案',
    infoArea:             '地区',
    infoDesc:             '特色',
    infoHours:            '营业时间',
    infoAddress:          '地址',
    infoPhone:            '电话',
    sending:              '发送中...',
    toastApprove:         '预约申请已发送',
    toastError:           '发送失败，请重试。',
    toastSectionClear:    '已清空该部分',
    toastClear:           '已清空'
  },
  ko: {
    loading:              '데이터를 불러오는 중입니다. 잠시 기다려 주세요.',
    modalTitleHotel:      '호텔 선택',
    modalTitleRestaurant: '레스토랑 선택',
    noResults:            '조건에 맞는 가게를 찾을 수 없습니다.<br>지역, 요리 종류, 예산 조건을 변경해 주세요.',
    priceUnknown:         '문의 필요',
    coupon:               '쿠폰 있음',
    website:              '웹사이트',
    addToProposal:        '제안에 추가',
    toastAdded:           '{name} 제안에 추가되었습니다',
    infoArea:             '지역',
    infoDesc:             '특징',
    infoHours:            '영업시간',
    infoAddress:          '주소',
    infoPhone:            '전화',
    sending:              '전송 중...',
    toastApprove:         '예약 요청을 전송했습니다',
    toastError:           '전송에 실패했습니다. 다시 시도해 주세요.',
    toastSectionClear:    '섹션을 초기화했습니다',
    toastClear:           '초기화했습니다'
  }
};

// 翻訳ヘルパー（{name} プレースホルダーに shop.name を展開）
function t(key, name) {
  const lang = getLang();
  const val = (TRANSLATIONS[lang] && TRANSLATIONS[lang][key]) || TRANSLATIONS.ja[key] || key;
  return name !== undefined ? val.replace('{name}', name) : val;
}

document.addEventListener('DOMContentLoaded', function() {
  const selectHotelBtn      = document.getElementById('selectHotelBtn');
  const selectRestaurantBtn = document.getElementById('selectRestaurantBtn');
  const shopModal           = document.getElementById('shopSelectModal');
  const shopModalTitle      = document.getElementById('shopModalTitle');
  const shopList            = document.getElementById('shopList');
  const shopSearch          = document.getElementById('shopSearch');
  const shopModalClose      = shopModal ? shopModal.querySelector('.shop-select-modal__close-btn') : null;
  const shopModalOverlay    = shopModal ? shopModal.querySelector('.shop-select-modal__overlay') : null;

  let allShops = [];
  let currentCategory = null;
  let currentFilteredShops = [];

  const themeUri = (window.yokohamaConciergeThemeUri && window.yokohamaConciergeThemeUri.themeUri)
    || '/wp-content/themes/yokohama-concierge';

  // オペレーターCSVを読み込む
  fetch(themeUri + '/data/operator-list.csv')
    .then(r => { if (!r.ok) throw new Error('CSV not found'); return r.text(); })
    .then(csvText => {
      allShops = parseOperatorCSV(csvText);
      console.log('オペレーターデータ読み込み完了:', allShops.length, '件');
    })
    .catch(err => console.error('CSVの読み込みに失敗:', err));

  // 新CSVパース
  // 列: area, name, category, address, phone, email, website, sns,
  //     description, cuisine_type, business_hours, price_rank, coupon_available, keywords
  function parseOperatorCSV(csvText) {
    const lines = csvText.split('\n').filter(l => l.trim());
    const shops = [];
    for (let i = 1; i < lines.length; i++) {
      const v = parseCSVLine(lines[i]);
      if (!v[1] || !v[1].trim()) continue;
      shops.push({
        area:            (v[0]  || '').trim(),
        name:            (v[1]  || '').trim(),
        category:        (v[2]  || '').trim().toLowerCase(),
        address:         (v[3]  || '').trim(),
        phone:           (v[4]  || '').trim(),
        email:           (v[5]  || '').trim(),
        website:         (v[6]  || '').trim(),
        sns:             (v[7]  || '').trim(),
        description:     (v[8]  || '').trim(),
        cuisine_type:    (v[9]  || '').trim().toLowerCase(),
        business_hours:  (v[10] || '').trim(),
        price_rank:      (v[11] || '').trim(),
        coupon_available:(v[12] || '').trim(),
        keywords:        (v[13] || '').trim()
      });
    }
    return shops;
  }

  // CSV行パーサ（クォート対応）
  function parseCSVLine(line) {
    const result = [];
    let current = '';
    let inQuotes = false;
    for (let i = 0; i < line.length; i++) {
      const ch = line[i];
      if (ch === '"') {
        inQuotes = !inQuotes;
      } else if (ch === ',' && !inQuotes) {
        result.push(current);
        current = '';
      } else {
        current += ch;
      }
    }
    result.push(current);
    return result;
  }

  // エリアマッピング: フォーム値 → CSV area値
  const AREA_CSV_MAP = {
    'motomachi':      '元町・山手',
    'yamashita':      '山下公園・中華街',
    'nihonodori':     '日本大通り',
    'bashamichi':     '馬車道',
    'kannai':         '関内',
    'minatomirai':    'みなとみらい',
    'sakuragicho':    '桜木町',
    'other_yokohama': ''
  };

  // 料理ジャンルマッピング: フォーム値 → CSV cuisine_type値
  const CUISINE_CSV_MAP = {
    'washoku':   ['japanese', 'ell food', 'meat', 'beef', 'pork cutlet'],
    'sushi':     ['sushi'],
    'tempura':   ['tenpura'],
    'soba_udon': ['japanese'],
    'chinese':   ['chinese'],
    'indian':    ['indian'],
    'french':    ['french'],
    'italian':   ['italian'],
    'spanish':   ['spanish'],
    'grill':     ['grill', 'steak', 'western'],
    'yakiniku':  ['yakiniku', 'korean'],
    'steak':     ['steak', 'beef', 'grill'],
    'vege':      ['vegetarian'],
    'cafe':      ['cafe', 'brunch', 'gelato', 'hawaiian'],
    'other':     []
  };

  // price_rankマッピング: フォーム値 → 数値1〜8
  const PRICE_RANK_MAP = {
    '2000':      1,
    '3000':      2,
    '6000':      3,
    '12000':     4,
    '20000':     5,
    '30000':     6,
    '30000plus': 7,
    '50000plus': 8
  };

  // price_rank表示ラベル（インデックス=ランク番号）
  const PRICE_RANK_LABELS = ['', '～¥2,000', '～¥3,000', '～¥6,000', '～¥12,000', '～¥20,000', '～¥30,000', '¥30,000～', '¥50,000～'];

  // フォーム条件でお店をフィルタリング
  function filterShops(category) {
    // カテゴリで絞り込み
    let shops = allShops.filter(s => {
      if (category === 'hotels')      return s.category === 'hotel';
      if (category === 'restaurants') return s.category === 'restaurant';
      return false;
    });

    // エリアフィルター
    const areaEl  = document.getElementById(category === 'hotels' ? 'hotel-area' : 'dining-area');
    const areaVal = areaEl ? areaEl.value : '';
    if (areaVal && areaVal !== 'other_yokohama') {
      const targetArea = AREA_CSV_MAP[areaVal] || '';
      if (targetArea) {
        shops = shops.filter(s => s.area === targetArea);
      }
    }

    // 料理ジャンルフィルター（飲食のみ）
    if (category === 'restaurants') {
      const cuisineEl  = document.getElementById('dining-cuisine');
      const cuisineVal = cuisineEl ? cuisineEl.value : '';
      if (cuisineVal && cuisineVal !== 'other') {
        const csvTypes = CUISINE_CSV_MAP[cuisineVal] || [];
        if (csvTypes.length > 0) {
          shops = shops.filter(s => {
            const ct = s.cuisine_type;
            return csvTypes.some(type => ct === type || ct.includes(type));
          });
        }
      }
    }

    // price_rankフィルター
    const budgetEl  = document.getElementById(category === 'hotels' ? 'hotel-budget' : 'dining-budget');
    const budgetVal = budgetEl ? budgetEl.value : '';
    if (budgetVal) {
      const selectedRank = PRICE_RANK_MAP[budgetVal];
      if (selectedRank) {
        if (budgetVal === '50000plus') {
          shops = shops.filter(s => parseInt(s.price_rank) >= 8);
        } else if (budgetVal === '30000plus') {
          shops = shops.filter(s => parseInt(s.price_rank) >= 7);
        } else {
          // 選択ランク以下のお店（予算内）
          shops = shops.filter(s => {
            const r = parseInt(s.price_rank);
            return isNaN(r) || r <= selectedRank;
          });
        }
      }
    }

    return shops;
  }

  // ホテル選択ボタン
  if (selectHotelBtn) {
    selectHotelBtn.addEventListener('click', function() {
      if (allShops.length === 0) {
        showToast(t('loading'));
        return;
      }
      currentCategory = 'hotels';
      currentFilteredShops = filterShops('hotels');
      openShopModal(t('modalTitleHotel'), currentFilteredShops);
    });
  }

  // 飲食店選択ボタン
  if (selectRestaurantBtn) {
    selectRestaurantBtn.addEventListener('click', function() {
      if (allShops.length === 0) {
        showToast(t('loading'));
        return;
      }
      currentCategory = 'restaurants';
      currentFilteredShops = filterShops('restaurants');
      openShopModal(t('modalTitleRestaurant'), currentFilteredShops);
    });
  }

  // モーダルを開く
  function openShopModal(title, shops) {
    if (!shopModal) return;
    shopModalTitle.textContent = title;
    renderShopList(shops);
    showModal();
  }

  // お店リストを描画
  function renderShopList(shops) {
    if (!shops || shops.length === 0) {
      shopList.innerHTML = `<p class="shop-select-modal__empty">${t('noResults')}</p>`;
      return;
    }

    let html = '<div class="shop-list">';
    shops.forEach((shop, index) => {
      const shopId     = `shop-${index}`;
      const rankNum    = parseInt(shop.price_rank);
      const priceLabel = (!isNaN(rankNum) && PRICE_RANK_LABELS[rankNum]) ? PRICE_RANK_LABELS[rankNum] : t('priceUnknown');
      const coupon     = shop.coupon_available === '1'
        ? `<span class="shop-card__coupon"><i class="fas fa-tag"></i> ${t('coupon')}</span>`
        : '';

      html += `
        <div class="shop-card" data-shop-id="${shopId}" data-shop-name="${escapeHtml(shop.name)}">
          <div class="shop-card__header">
            <h4 class="shop-card__name">${escapeHtml(shop.name)}</h4>
            <span class="shop-card__price">${priceLabel}</span>
          </div>
          <div class="shop-card__meta">
            <span class="shop-card__area"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(shop.area)}</span>
            ${shop.cuisine_type ? `<span class="shop-card__category"><i class="fas fa-utensils"></i> ${escapeHtml(shop.cuisine_type)}</span>` : ''}
            ${coupon}
          </div>
          ${shop.description ? `<p class="shop-card__description">${escapeHtml(shop.description)}</p>` : ''}
          ${shop.business_hours ? `<p class="shop-card__hours"><i class="fas fa-clock"></i> ${escapeHtml(shop.business_hours)}</p>` : ''}
          ${(shop.website && shop.website !== '#') ? `<p class="shop-card__website"><a href="${escapeHtml(shop.website)}" target="_blank" rel="noopener noreferrer"><i class="fas fa-link"></i> ${t('website')}</a></p>` : ''}
          <div class="shop-card__actions">
            <button type="button" class="btn btn--sm btn--outline shop-select-btn" data-slot="1">${t('addToProposal')}</button>
          </div>
        </div>
      `;
    });
    html += '</div>';
    shopList.innerHTML = html;

    // 選択ボタンイベント
    shopList.querySelectorAll('.shop-select-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const card   = e.target.closest('.shop-card');
        const shopId = card.dataset.shopId;
        const slot   = parseInt(e.target.dataset.slot);
        const idx    = parseInt(shopId.replace('shop-', ''));
        // 検索でフィルタ済みのshopsからindexを取得
        const visibleShops = getVisibleShops();
        const shop = visibleShops[idx];
        if (shop) selectShop(shop, slot);
      });
    });
  }

  // 現在表示中のお店リストを取得（検索テキストを加味）
  function getVisibleShops() {
    const query = shopSearch ? shopSearch.value.toLowerCase().trim() : '';
    if (!query) return currentFilteredShops;
    return currentFilteredShops.filter(s =>
      [s.name, s.area, s.description, s.cuisine_type, s.keywords]
        .map(f => (f || '').toLowerCase())
        .some(f => f.includes(query))
    );
  }

  // HTML エスケープ
  function escapeHtml(str) {
    if (!str) return '';
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  // お店を提案欄にセット
  function selectShop(shop, slot) {
    const prefix   = currentCategory === 'hotels' ? 'hotel' : 'dining';
    const textarea = document.getElementById(`${prefix}-proposal-${slot}`);
    const hidden   = document.getElementById(`${prefix}-proposal-${slot}-id`);
    if (!textarea) return;
    textarea.value = formatShopInfo(shop);
    textarea.removeAttribute('readonly');
    if (hidden) hidden.value = shop.name;
    closeModal();
    showToast(t('toastAdded', shop.name));
  }

  // お店情報フォーマット（言語に合わせてラベルを翻訳）
  function formatShopInfo(shop) {
    let text = `【${shop.name}】\n`;
    if (shop.area)           text += `${t('infoArea')}: ${shop.area}\n`;
    if (shop.description)    text += `${t('infoDesc')}: ${shop.description}\n`;
    if (shop.business_hours) text += `${t('infoHours')}: ${shop.business_hours}\n`;
    if (shop.address)        text += `${t('infoAddress')}: ${shop.address}\n`;
    if (shop.phone)          text += `${t('infoPhone')}: ${shop.phone}\n`;
    if (shop.website && shop.website !== '#') text += `URL: ${shop.website}\n`;
    return text.trim();
  }

  // モーダル内検索
  if (shopSearch) {
    shopSearch.addEventListener('input', function(e) {
      const query = e.target.value.toLowerCase().trim();
      if (!query) {
        renderShopList(currentFilteredShops);
        return;
      }
      const searched = currentFilteredShops.filter(s =>
        [s.name, s.area, s.description, s.cuisine_type, s.keywords]
          .map(f => (f || '').toLowerCase())
          .some(f => f.includes(query))
      );
      renderShopList(searched);
    });
  }

  // モーダル表示
  function showModal() {
    shopModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    if (shopSearch) shopSearch.value = '';
    setTimeout(() => shopModal.classList.add('is-active'), 10);
  }

  // モーダルを閉じる
  function closeModal() {
    shopModal.classList.remove('is-active');
    setTimeout(() => {
      shopModal.style.display = 'none';
      document.body.style.overflow = '';
      shopList.innerHTML = '';
    }, 300);
  }

  if (shopModalClose)   shopModalClose.addEventListener('click', closeModal);
  if (shopModalOverlay) shopModalOverlay.addEventListener('click', closeModal);
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && shopModal && shopModal.style.display === 'flex') closeModal();
  });

  // Make Webhook ボタン（この内容で予約する）
  // <a>のGETではなくフォームデータをPOSTで送信する
  document.querySelectorAll('.make-action-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const section = this.dataset.section;  // 'hotel' or 'dining'
      const status  = this.dataset.status;   // 'approve'
      const payload = collectMakePayload(section, status);

      const originalHtml = this.innerHTML;
      this.disabled = true;
      this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> ${t('sending')}`;
      const self = this;

      fetch(MAKE_WEBHOOK_URL, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      })
      .then(r => r.text())
      .then(() => {
        showToast(t('toastApprove'));
      })
      .catch(() => {
        showToast(t('toastError'));
      })
      .finally(() => {
        self.disabled = false;
        self.innerHTML = originalHtml;
      });
    });
  });

  // Makeに送るフォームデータを収集
  function collectMakePayload(section, status) {
    const data = {
      status:   status,
      type:     section === 'hotel' ? 'hotel' : 'restaurant',
      name:     document.getElementById('reservation-name')?.value  || '',
      email:    document.getElementById('reservation-email')?.value || '',
      phone:    document.getElementById('reservation-phone')?.value || ''
    };

    if (section === 'hotel') {
      data.date     = document.getElementById('hotel-date')?.value     || '';
      data.area     = document.getElementById('hotel-area')?.value     || '';
      data.budget   = document.getElementById('hotel-budget')?.value   || '';
      data.adults   = document.getElementById('hotel-adults')?.value   || '0';
      data.children = document.getElementById('hotel-children')?.value || '0';
      data.request  = document.getElementById('hotel-request')?.value  || '';
      data.proposal = document.getElementById('hotel-proposal-1')?.value || '';
    } else {
      data.date     = document.getElementById('dining-date')?.value     || '';
      data.time     = document.getElementById('dining-time')?.value     || '';
      data.area     = document.getElementById('dining-area')?.value     || '';
      data.cuisine  = document.getElementById('dining-cuisine')?.value  || '';
      data.budget   = document.getElementById('dining-budget')?.value   || '';
      data.adults   = document.getElementById('dining-adults')?.value   || '0';
      data.children = document.getElementById('dining-children')?.value || '0';
      data.request  = document.getElementById('dining-request')?.value  || '';
      data.proposal = document.getElementById('dining-proposal-1')?.value || '';
    }

    return data;
  }

  // セクションクリアボタン
  const sectionFields = {
    guide: [
      { id: 'guide-course',    type: 'select' },
      { id: 'guide-date',      type: 'input' },
      { id: 'guide-area',      type: 'select' },
      { id: 'guide-adults',    type: 'number' },
      { id: 'guide-children',  type: 'number' },
      { id: 'guide-spots',     type: 'textarea' },
      { id: 'guide-notes',     type: 'textarea' }
    ],
    hotel: [
      { id: 'hotel-date',          type: 'input' },
      { id: 'hotel-area',          type: 'select' },
      { id: 'hotel-budget',        type: 'select' },
      { id: 'hotel-adults',        type: 'number' },
      { id: 'hotel-children',      type: 'number' },
      { id: 'hotel-request',       type: 'textarea' },
      { id: 'hotel-proposal-1',    type: 'proposal' },
      { id: 'hotel-proposal-1-id', type: 'hidden' }
    ],
    dining: [
      { id: 'dining-date',          type: 'input' },
      { id: 'dining-time',          type: 'select' },
      { id: 'dining-area',          type: 'select' },
      { id: 'dining-cuisine',       type: 'select' },
      { id: 'dining-budget',        type: 'select' },
      { id: 'dining-adults',        type: 'number' },
      { id: 'dining-children',      type: 'number' },
      { id: 'dining-request',       type: 'textarea' },
      { id: 'dining-proposal-1',    type: 'proposal' },
      { id: 'dining-proposal-1-id', type: 'hidden' }
    ],
    luggage: [
      { id: 'luggage-date',  type: 'input' },
      { id: 'luggage-time',  type: 'select' },
      { id: 'luggage-count', type: 'input' },
      { id: 'luggage-notes', type: 'textarea' }
    ]
  };

  document.querySelectorAll('.reservation-form__section-clear-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const fields = sectionFields[this.dataset.section] || [];
      fields.forEach(({ id, type }) => {
        const el = document.getElementById(id);
        if (!el) return;
        if (type === 'number')        el.value = '0';
        else if (type === 'select')   el.selectedIndex = 0;
        else if (type === 'proposal') { el.value = ''; el.setAttribute('readonly', 'readonly'); }
        else                          el.value = '';
      });
      showToast(t('toastSectionClear'));
    });
  });

  // 提案欄クリアボタン
  document.querySelectorAll('.reservation-form__clear-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const target      = this.dataset.target;
      const textarea    = document.getElementById(target);
      const hiddenInput = document.getElementById(`${target}-id`);
      if (textarea)    { textarea.value = ''; textarea.setAttribute('readonly', 'readonly'); }
      if (hiddenInput) hiddenInput.value = '';
      showToast(t('toastClear'));
    });
  });

  // トースト通知
  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }
});
