"use strict";

// Make Webhook URL（シナリオ作成後に差し替え）
const MAKE_WEBHOOK_URL = 'https://hook.us2.make.com/q4s664foazn8sn737ccpojfh964enyuu';

// お店選択機能（Make連携版）
document.addEventListener('DOMContentLoaded', function() {
  const selectHotelBtn = document.getElementById('selectHotelBtn');
  const selectRestaurantBtn = document.getElementById('selectRestaurantBtn');
  const selectActivityBtn = document.getElementById('selectActivityBtn');
  const shopModal = document.getElementById('shopSelectModal');
  const shopModalTitle = document.getElementById('shopModalTitle');
  const shopList = document.getElementById('shopList');
  const shopSearch = document.getElementById('shopSearch');
  const shopModalClose = shopModal ? shopModal.querySelector('.shop-select-modal__close-btn') : null;
  const shopModalOverlay = shopModal ? shopModal.querySelector('.shop-select-modal__overlay') : null;

  let shopData = {
    hotels: [],
    restaurants: [],
    activities: []
  };
  let currentCategory = null;

  // WordPressテーマディレクトリのパスを取得
  const themeUri = (window.yokohamaConciergeThemeUri && window.yokohamaConciergeThemeUri.themeUri) || '/wp-content/themes/yokohama-concierge';
  
  // CSVを読み込んでJSONに変換（新しい事業者用CSV対応）
  fetch(themeUri + '/data/business-list.csv')
    .then(response => {
      if (!response.ok) throw new Error('CSV not found');
      return response.text();
    })
    .then(csvText => {
      shopData = parseBusinessCSV(csvText);
      console.log('事業者データを読み込みました:', shopData);
    })
    .catch(error => {
      console.error('CSVの読み込みに失敗しました:', error);
      // フォールバック: 旧CSVまたはJSONを試す
      return fetch(themeUri + '/data/shop-list.csv')
        .then(response => {
          if (!response.ok) throw new Error('CSV not found');
          return response.text();
        })
        .then(csvText => {
          shopData = parseCSV(csvText);
          console.log('旧CSVからお店データを読み込みました:', shopData);
        })
        .catch(() => {
          return fetch(themeUri + '/data/shop-list.json')
            .then(response => {
              if (!response.ok) throw new Error('JSON not found');
              return response.json();
            })
            .then(data => {
              shopData = data;
              console.log('JSONからお店データを読み込みました:', shopData);
            })
            .catch(err => {
              console.error('データの読み込みに完全に失敗しました:', err);
            });
        });
    });

  // 新しい事業者用CSV解析関数
  function parseBusinessCSV(csvText) {
    const lines = csvText.split('\n').filter(line => line.trim());
    const data = {
      hotels: [],
      restaurants: [],
      activities: []
    };

    // ヘッダー行をスキップ（1行目）
    for (let i = 2; i < lines.length; i++) {
      const values = parseCSVLine(lines[i]);
      if (values.length < 3) continue;

      const area = values[0] || '';
      const name = values[1] || '';
      const category = values[2] || '';
      const address = values[3] || '';
      const phone = values[4] || '';
      const email = values[5] || '';
      const website = values[6] || '';
      const sns = values[7] || '';
      const features = values[8] || '';
      const facilities = values[9] || '';
      const seats = values[10] || '';
      const priceRange = values[11] || '';
      const hours = values[12] || '';

      const item = {
        area: area,
        name: name,
        category: category,
        address: address,
        phone: phone,
        email: email,
        website: website,
        sns: sns,
        features: features,
        facilities: facilities,
        seats: seats,
        priceRange: priceRange,
        hours: hours
      };

      // カテゴリに応じて分類
      const categoryLower = category.toLowerCase();
      if (categoryLower.includes('ホテル') || categoryLower.includes('宿泊') || categoryLower.includes('hotel')) {
        data.hotels.push(item);
      } else if (categoryLower.includes('飲食') || categoryLower.includes('レストラン') || categoryLower.includes('カフェ') || 
                 categoryLower.includes('料理') || categoryLower.includes('食堂') || categoryLower.includes('居酒屋')) {
        data.restaurants.push(item);
      } else if (categoryLower.includes('体験') || categoryLower.includes('アクティビティ') || categoryLower.includes('観光')) {
        data.activities.push(item);
      }
    }

    return data;
  }

  // CSV解析関数（旧形式用）
  function parseCSV(csvText) {
    const lines = csvText.split('\n').filter(line => line.trim());
    const headers = lines[0].split(',');
    const data = {
      hotels: [],
      restaurants: [],
      activities: []
    };

    for (let i = 1; i < lines.length; i++) {
      const values = parseCSVLine(lines[i]);
      if (values.length < headers.length) continue;

      const item = {};
      headers.forEach((header, index) => {
        const value = values[index] ? values[index].trim() : '';
        
        // 特殊な処理
        if (header === 'features') {
          item[header] = value.split('|').map(f => f.trim());
        } else if (header === 'price') {
          item[header] = value.replace(/¥(\d+)-(\d+)/, '¥$1-$2');
        } else {
          item[header] = value;
        }
      });

      // カテゴリに応じて振り分け
      const category = item.category;
      if (category === 'ホテル') {
        data.hotels.push(item);
      } else if (category.includes('料理') || category.includes('フレンチ') || category.includes('鉄板') || category.includes('カフェ')) {
        data.restaurants.push(item);
      } else if (category.includes('クルーズ') || category.includes('体験') || category.includes('着物')) {
        data.activities.push(item);
      }
    }

    return data;
  }

  // CSVの1行を解析（カンマ区切り、クォート対応）
  function parseCSVLine(line) {
    const result = [];
    let current = '';
    let inQuotes = false;

    for (let i = 0; i < line.length; i++) {
      const char = line[i];
      
      if (char === '"') {
        inQuotes = !inQuotes;
      } else if (char === ',' && !inQuotes) {
        result.push(current);
        current = '';
      } else {
        current += char;
      }
    }
    
    result.push(current);
    return result;
  }

  // ホテル選択ボタン → Make連携
  if (selectHotelBtn) {
    selectHotelBtn.addEventListener('click', function() {
      fetchProposalsFromMake('hotels');
    });
  }

  // レストラン選択ボタン → Make連携
  if (selectRestaurantBtn) {
    selectRestaurantBtn.addEventListener('click', function() {
      fetchProposalsFromMake('restaurants');
    });
  }

  // アクティビティ選択ボタン（既存）
  if (selectActivityBtn) {
    selectActivityBtn.addEventListener('click', function() {
      currentCategory = 'activities';
      openShopModal('アクティビティを選択');
    });
  }

  // Make Webhookから提案を取得
  function fetchProposalsFromMake(category) {
    currentCategory = category;

    // フォームから条件を収集
    const conditions = collectConditions(category);

    // ボタンをローディング状態に
    const btn = category === 'hotels' ? selectHotelBtn : selectRestaurantBtn;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 検索中...';

    fetch(MAKE_WEBHOOK_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ type: category, ...conditions })
    })
      .then(response => {
        if (!response.ok) throw new Error('Makeからの応答エラー');
        return response.json();
      })
      .then(data => {
        console.log('MAKEレスポンス全体:', JSON.stringify(data, null, 2));
        const proposals = data.proposals || [];
        if (proposals.length === 0) {
          showToast('条件に合う提案が見つかりませんでした');
          return;
        }
        console.log('提案[0]のキー一覧:', Object.keys(proposals[0]));
        applyProposals(category, proposals);
        showToast(`${proposals.length}件の提案を取得しました`);
      })
      .catch(err => {
        console.error('Make連携エラー:', err);
        showToast('提案の取得に失敗しました。URLの設定をご確認ください。');
      })
      .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
      });
  }

  // フォームの選択値 → シートのテキスト値マッピング
  const BUDGET_MAP = {
    '2000':      '～2,000円',
    '3000':      '～3,000円',
    '6000':      '～6,000円',
    '12000':     '～12,000円',
    '20000':     '～20,000円',
    '30000':     '～30,000円',
    '30000plus': '30,000円～',
    '50000plus': '50,000円～'
  };

  const AREA_MAP = {
    'motomachi':      '元町',
    'yamashita':      '山下公園',
    'nihonodori':     '日本大通り',
    'bashamichi':     '馬車道',
    'kannai':         '関内',
    'minatomirai':    'みなとみらい',
    'sakuragicho':    '桜木町',
    'other_yokohama': ''
  };

  const CUISINE_MAP = {
    'washoku':   '和食',
    'sushi':     '寿司',
    'tempura':   '天ぷら',
    'soba_udon': 'そば・うどん',
    'chinese':   '中華',
    'indian':    'インド料理',
    'french':    'フレンチ',
    'italian':   'イタリアン',
    'spanish':   'スペイン料理',
    'grill':     'グリル',
    'yakiniku':  '焼肉',
    'steak':     'ステーキ',
    'vege':      'ベジタリアン',
    'cafe':      'カフェ',
    'other':     ''
  };

  // フォームから条件を収集（シートのテキスト値に変換して送信）
  function collectConditions(category) {
    if (category === 'hotels') {
      const budgetVal = document.getElementById('hotel-budget')?.value || '';
      const areaVal   = document.getElementById('hotel-area')?.value || '';
      return {
        type:     'hotel',
        area:     AREA_MAP[areaVal] || '',
        budget:   BUDGET_MAP[budgetVal] || '',
        date:     document.getElementById('hotel-date')?.value || '',
        adults:   document.getElementById('hotel-adults')?.value || '0',
        children: document.getElementById('hotel-children')?.value || '0',
        request:  document.getElementById('hotel-request')?.value || ''
      };
    } else {
      const budgetVal  = document.getElementById('dining-budget')?.value || '';
      const areaVal    = document.getElementById('dining-area')?.value || '';
      const cuisineVal = document.getElementById('dining-cuisine')?.value || '';
      return {
        type:     'restaurant',
        area:     AREA_MAP[areaVal] || '',
        budget:   BUDGET_MAP[budgetVal] || '',
        cuisine:  CUISINE_MAP[cuisineVal] || '',
        date:     document.getElementById('dining-date')?.value || '',
        time:     document.getElementById('dining-time')?.value || '',
        adults:   document.getElementById('dining-adults')?.value || '0',
        children: document.getElementById('dining-children')?.value || '0',
        request:  document.getElementById('dining-request')?.value || ''
      };
    }
  }

  // 取得した提案をテキストエリアに反映
  function applyProposals(category, proposals) {
    proposals.slice(0, 1).forEach((shop, i) => {
      const slot = i + 1;
      const prefix = category === 'hotels' ? 'hotel' : 'dining';
      const textarea = document.getElementById(`${prefix}-proposal-${slot}`);
      const hidden   = document.getElementById(`${prefix}-proposal-${slot}-id`);
      if (!textarea) return;
      textarea.value = formatShopInfo(shop);
      textarea.removeAttribute('readonly');
      if (hidden) hidden.value = shop.name || '';
    });
    updateFinalSelectionState();
  }

  // モーダルを開く
  function openShopModal(title) {
    if (!shopData || (shopData.hotels.length === 0 && shopData.restaurants.length === 0 && shopData.activities.length === 0)) {
      alert('お店データを読み込んでいます。しばらくお待ちください。');
      return;
    }

    shopModalTitle.textContent = title;
    
    // 希望金額でフィルタリング
    let filteredShops = filterShopsByBudget(shopData[currentCategory]);
    renderShopList(filteredShops);
    showModal();
  }
  
  // フォーム条件（金額・エリア・ジャンル）でお店をフィルタリング
  function filterShops(shops) {
    if (!shops || shops.length === 0) return shops;

    let filtered = shops;

    // --- 希望金額フィルター ---
    let budgetValue = null;
    if (currentCategory === 'hotels') {
      const el = document.getElementById('hotel-budget');
      if (el && el.value) budgetValue = el.value;
    } else if (currentCategory === 'restaurants') {
      const el = document.getElementById('dining-budget');
      if (el && el.value) budgetValue = el.value;
    }

    if (budgetValue) {
      const budgetRanges = {
        '2000':      { min: 0,     max: 2000 },
        '3000':      { min: 0,     max: 3000 },
        '6000':      { min: 0,     max: 6000 },
        '12000':     { min: 0,     max: 12000 },
        '20000':     { min: 0,     max: 20000 },
        '30000':     { min: 0,     max: 30000 },
        '30000plus': { min: 30000, max: Infinity },
        '50000plus': { min: 50000, max: Infinity }
      };
      const range = budgetRanges[budgetValue];
      if (range) {
        filtered = filtered.filter(shop => {
          const shopPrice = shop.priceRange || shop.price || '';
          if (!shopPrice || shopPrice === '要問い合わせ') return true;
          const nums = shopPrice.match(/[\d,]+/g);
          if (!nums || nums.length === 0) return true;
          const minPrice = parseInt(nums[0].replace(/,/g, ''));
          const maxPrice = nums.length > 1 ? parseInt(nums[1].replace(/,/g, '')) : minPrice;
          if (range.max === Infinity) return minPrice >= range.min;
          return minPrice <= range.max && maxPrice >= range.min;
        });
      }
    }

    // --- エリアフィルター ---
    const areaMap = {
      'motomachi':      ['元町', '山手'],
      'yamashita':      ['山下公園', '山下町', '中華街'],
      'nihonodori':     ['日本大通り'],
      'bashamichi':     ['馬車道'],
      'kannai':         ['関内'],
      'minatomirai':    ['みなとみらい'],
      'sakuragicho':    ['桜木町'],
      'other_yokohama': []
    };

    let areaValue = null;
    if (currentCategory === 'hotels') {
      const el = document.getElementById('hotel-area');
      if (el && el.value) areaValue = el.value;
    } else if (currentCategory === 'restaurants') {
      const el = document.getElementById('dining-area');
      if (el && el.value) areaValue = el.value;
    }

    if (areaValue && areaValue !== 'other_yokohama') {
      const keywords = areaMap[areaValue] || [];
      if (keywords.length > 0) {
        filtered = filtered.filter(shop => {
          const shopArea = shop.area || '';
          return keywords.some(kw => shopArea.includes(kw));
        });
      }
    }

    // --- 料理ジャンルフィルター（飲食店のみ）---
    if (currentCategory === 'restaurants') {
      const cuisineEl = document.getElementById('dining-cuisine');
      if (cuisineEl && cuisineEl.value && cuisineEl.value !== 'other') {
        const cuisineMap = {
          'washoku':   ['和食', 'うなぎ', '鍋', '割烹'],
          'sushi':     ['寿司', 'お寿司', '鮨', 'すし'],
          'tempura':   ['天ぷら', '天麩羅'],
          'soba_udon': ['そば', 'うどん', '蕎麦'],
          'chinese':   ['中華', '台湾', '上海', '四川', '広東', '湖南'],
          'indian':    ['インド'],
          'french':    ['フレンチ', 'フランス'],
          'italian':   ['イタリアン', 'イタリア'],
          'spanish':   ['スペイン'],
          'grill':     ['グリル', '鉄板'],
          'yakiniku':  ['焼肉', '焼き肉'],
          'steak':     ['ステーキ'],
          'vege':      ['ベジタリアン', '野菜'],
          'cafe':      ['カフェ']
        };
        const keywords = cuisineMap[cuisineEl.value] || [];
        if (keywords.length > 0) {
          filtered = filtered.filter(shop => {
            const shopCategory = shop.category || '';
            return keywords.some(kw => shopCategory.includes(kw));
          });
        }
      }
    }

    return filtered;
  }

  // 後方互換のエイリアス
  function filterShopsByBudget(shops) { return filterShops(shops); }

  // お店リストを表示
  function renderShopList(shops) {
    if (!shops || shops.length === 0) {
      shopList.innerHTML = '<p class="shop-select-modal__empty">お店が見つかりませんでした。</p>';
      return;
    }

    let html = '<div class="shop-list">';
    shops.forEach((shop, index) => {
      const shopId = shop.id || `shop-${index}`;
      const features = shop.features ? (Array.isArray(shop.features) ? shop.features : shop.features.split('、')) : [];
      const price = shop.priceRange || shop.price || '要問い合わせ';
      const description = shop.features || shop.description || '';
      
      html += `
        <div class="shop-card" data-shop-id="${shopId}" data-shop-name="${shop.name}">
          <div class="shop-card__header">
            <h4 class="shop-card__name">${shop.name}</h4>
            <span class="shop-card__price">${price}</span>
          </div>
          <div class="shop-card__meta">
            <span class="shop-card__category"><i class="fas fa-tag"></i> ${shop.category}</span>
            <span class="shop-card__area"><i class="fas fa-map-marker-alt"></i> ${shop.area}</span>
          </div>
          ${description ? `<p class="shop-card__description">${description}</p>` : ''}
          ${shop.hours ? `<p class="shop-card__hours"><i class="fas fa-clock"></i> ${shop.hours}</p>` : ''}
          ${features.length > 0 ? `
            <div class="shop-card__features">
              ${features.slice(0, 3).map(f => `<span class="shop-card__feature">${f}</span>`).join('')}
            </div>
          ` : ''}
          ${shop.website ? `<p class="shop-card__website"><a href="${shop.website}" target="_blank" rel="noopener"><i class="fas fa-link"></i> ウェブサイト</a></p>` : ''}
          <div class="shop-card__actions">
            <button type="button" class="btn btn--sm btn--outline shop-select-btn" data-slot="1">提案（1）に追加</button>
            <button type="button" class="btn btn--sm btn--outline shop-select-btn" data-slot="2">提案（2）に追加</button>
          </div>
        </div>
      `;
    });
    html += '</div>';

    shopList.innerHTML = html;

    // 選択ボタンのイベント
    shopList.querySelectorAll('.shop-select-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const card = e.target.closest('.shop-card');
        const shopId = card.dataset.shopId;
        const shopName = card.dataset.shopName;
        const slot = parseInt(e.target.dataset.slot);
        const shop = shops.find(s => (s.id || `shop-${shops.indexOf(s)}`) === shopId) || 
                     shops.find(s => s.name === shopName);
        
        if (shop) {
          selectShop(shop, slot);
        }
      });
    });
  }

  // お店を選択
  function selectShop(shop, slot) {
    // ホテルの場合
    let textarea = document.getElementById(`hotel-proposal-${slot}`);
    let hiddenInput = document.getElementById(`hotel-proposal-${slot}-id`);
    
    // レストランの場合
    if (currentCategory === 'restaurants') {
      textarea = document.getElementById(`dining-proposal-${slot}`);
      hiddenInput = document.getElementById(`dining-proposal-${slot}-id`);
    }
    
    if (textarea && hiddenInput) {
      // フォーマットしてテキストエリアに設定
      const text = formatShopInfo(shop);
      textarea.value = text;
      textarea.removeAttribute('readonly');
      hiddenInput.value = shop.id || shop.name;
      
      closeModal();
      
      // 成功メッセージ
      showToast(`${shop.name} を提案（${slot}）に追加しました`);
      
      // 最終選択のラジオボタンの状態を更新
      updateFinalSelectionState();
    }
  }
  
  // 最終選択のラジオボタンの状態を更新
  function updateFinalSelectionState() {
    // ホテルの場合
    const hotelProposal1 = document.getElementById('hotel-proposal-1');
    const hotelProposal2 = document.getElementById('hotel-proposal-2');
    const hotelFinal1 = document.getElementById('hotel-final-1');
    const hotelFinal2 = document.getElementById('hotel-final-2');
    
    if (hotelProposal1 && hotelProposal2 && hotelFinal1 && hotelFinal2) {
      const hasProposal1 = hotelProposal1.value.trim() !== '';
      const hasProposal2 = hotelProposal2.value.trim() !== '';
      
      // 両方入力されている場合のみ有効化
      if (hasProposal1 && hasProposal2) {
        hotelFinal1.disabled = false;
        hotelFinal2.disabled = false;
        hotelFinal1.closest('.reservation-form__radio-label').classList.remove('is-disabled');
        hotelFinal2.closest('.reservation-form__radio-label').classList.remove('is-disabled');
      } else {
        hotelFinal1.disabled = true;
        hotelFinal2.disabled = true;
        hotelFinal1.checked = false;
        hotelFinal2.checked = false;
        hotelFinal1.closest('.reservation-form__radio-label').classList.add('is-disabled');
        hotelFinal2.closest('.reservation-form__radio-label').classList.add('is-disabled');
      }
    }
    
    // レストランの場合
    const diningProposal1 = document.getElementById('dining-proposal-1');
    const diningProposal2 = document.getElementById('dining-proposal-2');
    const diningFinal1 = document.getElementById('dining-final-1');
    const diningFinal2 = document.getElementById('dining-final-2');
    
    if (diningProposal1 && diningProposal2 && diningFinal1 && diningFinal2) {
      const hasProposal1 = diningProposal1.value.trim() !== '';
      const hasProposal2 = diningProposal2.value.trim() !== '';
      
      // 両方入力されている場合のみ有効化
      if (hasProposal1 && hasProposal2) {
        diningFinal1.disabled = false;
        diningFinal2.disabled = false;
        diningFinal1.closest('.reservation-form__radio-label').classList.remove('is-disabled');
        diningFinal2.closest('.reservation-form__radio-label').classList.remove('is-disabled');
      } else {
        diningFinal1.disabled = true;
        diningFinal2.disabled = true;
        diningFinal1.checked = false;
        diningFinal2.checked = false;
        diningFinal1.closest('.reservation-form__radio-label').classList.add('is-disabled');
        diningFinal2.closest('.reservation-form__radio-label').classList.add('is-disabled');
      }
    }
  }
  
  // 提案テキストエリアの変更を監視（既存のDOMContentLoaded内で実行）
  const hotelProposal1 = document.getElementById('hotel-proposal-1');
  const hotelProposal2 = document.getElementById('hotel-proposal-2');
  const diningProposal1 = document.getElementById('dining-proposal-1');
  const diningProposal2 = document.getElementById('dining-proposal-2');
  
  if (hotelProposal1) {
    hotelProposal1.addEventListener('input', updateFinalSelectionState);
    hotelProposal1.addEventListener('change', updateFinalSelectionState);
  }
  if (hotelProposal2) {
    hotelProposal2.addEventListener('input', updateFinalSelectionState);
    hotelProposal2.addEventListener('change', updateFinalSelectionState);
  }
  if (diningProposal1) {
    diningProposal1.addEventListener('input', updateFinalSelectionState);
    diningProposal1.addEventListener('change', updateFinalSelectionState);
  }
  if (diningProposal2) {
    diningProposal2.addEventListener('input', updateFinalSelectionState);
    diningProposal2.addEventListener('change', updateFinalSelectionState);
  }
  
  // 初期状態を設定（少し遅延させて確実に実行）
  setTimeout(() => {
    updateFinalSelectionState();
  }, 100);

  // お店情報をフォーマット
  function formatShopInfo(shop) {
    const features = shop.features ? (Array.isArray(shop.features) ? shop.features.join('、') : shop.features) : '';
    const price = shop.priceRange || shop.price || '要問い合わせ';
    const description = shop.features || shop.description || '';
    const url = shop.website || shop.url || '';
    
    let text = `【${shop.name}】\n`;
    if (shop.area) text += `エリア: ${shop.area}\n`;
    if (shop.category) text += `カテゴリ: ${shop.category}\n`;
    if (price) text += `価格帯: ${price}\n`;
    if (shop.hours) text += `営業時間: ${shop.hours}\n`;
    if (features) text += `特徴: ${features}\n`;
    if (shop.address) text += `住所: ${shop.address}\n`;
    if (shop.phone) text += `電話: ${shop.phone}\n`;
    if (url && url !== '#') text += `URL: ${url}\n`;
    
    return text.trim();
  }

  // 検索機能
  if (shopSearch) {
    shopSearch.addEventListener('input', function(e) {
      const query = e.target.value.toLowerCase();
      let shops = shopData[currentCategory];
      
      // まず希望金額でフィルタリング
      shops = filterShopsByBudget(shops);
      
      if (!query) {
        renderShopList(shops);
        return;
      }

      const filtered = shops.filter(shop => {
        const searchFields = [
          shop.name || '',
          shop.area || '',
          shop.category || '',
          shop.description || '',
          shop.features || '',
          shop.address || ''
        ].map(f => f.toLowerCase());
        
        return searchFields.some(field => field.includes(query));
      });

      renderShopList(filtered);
    });
  }

  // モーダル表示
  function showModal() {
    shopModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    shopSearch.value = '';
    
    setTimeout(() => {
      shopModal.classList.add('is-active');
    }, 10);
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

  // 閉じるボタン
  if (shopModalClose) {
    shopModalClose.addEventListener('click', closeModal);
  }

  // オーバーレイ
  if (shopModalOverlay) {
    shopModalOverlay.addEventListener('click', closeModal);
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
      { id: 'hotel-date',        type: 'input' },
      { id: 'hotel-area',        type: 'select' },
      { id: 'hotel-budget',      type: 'select' },
      { id: 'hotel-adults',      type: 'number' },
      { id: 'hotel-children',    type: 'number' },
      { id: 'hotel-request',     type: 'textarea' },
      { id: 'hotel-proposal-1',  type: 'proposal' },
      { id: 'hotel-proposal-1-id', type: 'hidden' }
    ],
    dining: [
      { id: 'dining-date',        type: 'input' },
      { id: 'dining-time',        type: 'select' },
      { id: 'dining-area',        type: 'select' },
      { id: 'dining-cuisine',     type: 'select' },
      { id: 'dining-budget',      type: 'select' },
      { id: 'dining-adults',      type: 'number' },
      { id: 'dining-children',    type: 'number' },
      { id: 'dining-request',     type: 'textarea' },
      { id: 'dining-proposal-1',  type: 'proposal' },
      { id: 'dining-proposal-1-id', type: 'hidden' }
    ],
    luggage: [
      { id: 'luggage-date',   type: 'input' },
      { id: 'luggage-time',   type: 'select' },
      { id: 'luggage-count',  type: 'input' },
      { id: 'luggage-notes',  type: 'textarea' }
    ]
  };

  document.querySelectorAll('.reservation-form__section-clear-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const section = this.dataset.section;
      const fields = sectionFields[section] || [];
      fields.forEach(({ id, type }) => {
        const el = document.getElementById(id);
        if (!el) return;
        if (type === 'number') {
          el.value = '0';
        } else if (type === 'select') {
          el.selectedIndex = 0;
        } else if (type === 'proposal') {
          el.value = '';
          el.setAttribute('readonly', 'readonly');
        } else {
          el.value = '';
        }
      });
      showToast('セクションをクリアしました');
    });
  });

  // 提案テキストエリアのクリアボタン
  document.querySelectorAll('.reservation-form__clear-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const target = this.dataset.target;
      const textarea = document.getElementById(target);
      const hiddenInput = document.getElementById(`${target}-id`);
      
      if (textarea) {
        textarea.value = '';
        textarea.setAttribute('readonly', 'readonly');
      }
      if (hiddenInput) {
        hiddenInput.value = '';
      }
      
      // 最終選択のラジオボタンの状態を更新
      updateFinalSelectionState();
      
      showToast('クリアしました');
    });
  });

  // トースト通知
  function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
      toast.classList.add('show');
    }, 10);

    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => {
        toast.remove();
      }, 300);
    }, 3000);
  }

  // ESCキーでモーダルを閉じる
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && shopModal.style.display === 'flex') {
      closeModal();
    }
  });
});
