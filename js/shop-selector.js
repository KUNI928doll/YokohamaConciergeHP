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

  // CSVを読み込んでJSONに変換
  fetch('./data/shop-list.csv')
    .then(response => response.text())
    .then(csvText => {
      shopData = parseCSV(csvText);
      console.log('お店データを読み込みました:', shopData);
    })
    .catch(error => {
      console.error('CSVの読み込みに失敗しました:', error);
      // フォールバック: JSONを試す
      return fetch('./data/shop-list.json')
        .then(response => response.json())
        .then(data => {
          shopData = data;
          console.log('JSONからお店データを読み込みました:', shopData);
        });
    });

  // CSV解析関数
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
    renderShopList(shopData[currentCategory]);
    showModal();
  }

  // お店リストを表示
  function renderShopList(shops) {
    if (!shops || shops.length === 0) {
      shopList.innerHTML = '<p class="shop-select-modal__empty">お店が見つかりませんでした。</p>';
      return;
    }

    let html = '<div class="shop-list">';
    shops.forEach(shop => {
      html += `
        <div class="shop-card" data-shop-id="${shop.id}">
          <div class="shop-card__header">
            <h4 class="shop-card__name">${shop.name}</h4>
            <span class="shop-card__price">${shop.price}</span>
          </div>
          <div class="shop-card__meta">
            <span class="shop-card__category"><i class="fas fa-tag"></i> ${shop.category}</span>
            <span class="shop-card__area"><i class="fas fa-map-marker-alt"></i> ${shop.area}</span>
          </div>
          <p class="shop-card__description">${shop.description}</p>
          <div class="shop-card__features">
            ${shop.features.map(f => `<span class="shop-card__feature">${f}</span>`).join('')}
          </div>
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
        const slot = parseInt(e.target.dataset.slot);
        const shop = shops.find(s => s.id === shopId);
        
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
      hiddenInput.value = shop.id;
      
      closeModal();
      
      // 成功メッセージ
      showToast(`${shop.name} を提案（${slot}）に追加しました`);
    }
  }

  // お店情報をフォーマット
  function formatShopInfo(shop) {
    return `【${shop.name}】
エリア: ${shop.area}
価格帯: ${shop.price}
特徴: ${shop.features.join('、')}

${shop.description}

${shop.url && shop.url !== '#' ? 'URL: ' + shop.url : ''}`.trim();
  }

  // 検索機能
  if (shopSearch) {
    shopSearch.addEventListener('input', function(e) {
      const query = e.target.value.toLowerCase();
      const shops = shopData[currentCategory];
      
      if (!query) {
        renderShopList(shops);
        return;
      }

      const filtered = shops.filter(shop => {
        return shop.name.toLowerCase().includes(query) ||
               shop.area.toLowerCase().includes(query) ||
               shop.category.toLowerCase().includes(query) ||
               shop.description.toLowerCase().includes(query);
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
