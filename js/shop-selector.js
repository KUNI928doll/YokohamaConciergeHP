"use strict";

// お店選択機能（CSV対応版）
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

  // ホテル選択ボタン
  if (selectHotelBtn) {
    selectHotelBtn.addEventListener('click', function() {
      currentCategory = 'hotels';
      openShopModal('ホテルを選択');
    });
  }

  // レストラン選択ボタン
  if (selectRestaurantBtn) {
    selectRestaurantBtn.addEventListener('click', function() {
      currentCategory = 'restaurants';
      openShopModal('レストランを選択');
    });
  }

  // アクティビティ選択ボタン
  if (selectActivityBtn) {
    selectActivityBtn.addEventListener('click', function() {
      currentCategory = 'activities';
      openShopModal('アクティビティを選択');
    });
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
  
  // 希望金額でお店をフィルタリング
  function filterShopsByBudget(shops) {
    if (!shops || shops.length === 0) return shops;
    
    // 希望金額を取得
    let budgetValue = null;
    if (currentCategory === 'hotels') {
      const hotelBudget = document.getElementById('hotel-budget');
      if (hotelBudget && hotelBudget.value) {
        budgetValue = hotelBudget.value; // 文字列のまま取得（30000plus等に対応）
      }
    } else if (currentCategory === 'restaurants') {
      const diningBudget = document.getElementById('dining-budget');
      if (diningBudget && diningBudget.value) {
        budgetValue = diningBudget.value; // 文字列のまま取得（30000plus等に対応）
      }
    }
    
    // 希望金額が選択されていない場合は全件表示
    if (!budgetValue) {
      return shops;
    }
    
    // 希望金額に基づいてフィルタリング
    return shops.filter(shop => {
      const shopPrice = shop.priceRange || shop.price || '';
      if (!shopPrice || shopPrice === '要問い合わせ') {
        return true; // 価格情報がない場合は表示
      }
      
      // 価格範囲を解析（例: "¥6,000~¥10,000" や "¥7,000~¥10,000"）
      const priceMatches = shopPrice.match(/¥[\d,]+/g);
      if (!priceMatches || priceMatches.length === 0) {
        return true; // 価格が解析できない場合は表示
      }
      
      // 最小価格と最大価格を取得
      const minPrice = parseInt(priceMatches[0].replace(/[¥,]/g, ''));
      const maxPrice = priceMatches.length > 1 
        ? parseInt(priceMatches[1].replace(/[¥,]/g, '')) 
        : minPrice; // 最大価格がない場合は最小価格と同じとする
      
      // 希望金額の範囲を定義
      const budgetRanges = {
        '3000': { min: 0, max: 3000 },
        '6000': { min: 0, max: 6000 },
        '12000': { min: 0, max: 12000 },
        '20000': { min: 0, max: 20000 },
        '30000': { min: 0, max: 30000 },
        '30000plus': { min: 30000, max: Infinity },
        '50000plus': { min: 50000, max: Infinity }
      };
      
      const range = budgetRanges[budgetValue];
      if (!range) {
        return true; // 範囲が定義されていない場合は表示
      }
      
      // お店の価格範囲が希望金額の範囲と重なるかチェック
      // お店の最小価格が希望金額の最大値以下で、お店の最大価格が希望金額の最小値以上の場合
      if (range.max === Infinity) {
        // 上限なしの場合（30000plus, 50000plus）
        return minPrice >= range.min;
      } else {
        // 上限ありの場合
        // お店の最小価格が希望金額の範囲内にあるか、またはお店の価格範囲が希望金額の範囲と重なるか
        return (minPrice <= range.max && maxPrice >= range.min);
      }
    });
  }

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

  // クリアボタン
  document.querySelectorAll('.reservation-form__clear-btn').forEach(btn => {
    btn.addEventListener('click', function() {
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
