"use strict";

// 予約フォーム送信処理
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.reservation-form');
  const confirmBtn = document.getElementById('confirmBtn');
  const confirmModal = document.getElementById('confirmModal');
  const confirmContent = document.getElementById('confirmContent');
  const confirmBackBtn = confirmModal ? confirmModal.querySelector('.reservation-confirm__back') : null;
  const confirmSubmitBtn = confirmModal ? confirmModal.querySelector('.reservation-confirm__submit') : null;
  const confirmOverlay = confirmModal ? confirmModal.querySelector('.reservation-confirm__overlay') : null;
  const i18nContainer = document.getElementById('reservationI18n');
  const getI18nText = key => {
    if (!i18nContainer) return '';
    const node = i18nContainer.querySelector(`[data-key="${key}"]`);
    return node ? node.textContent.trim() : '';
  };
  const requiredMessageText = getI18nText('requiredMessage') || '必須項目を入力してください。';
  const requiredListTitleText = getI18nText('requiredListTitle') || '未入力項目:';
  
  const completeModal = document.getElementById('reservationModal');
  const completeCloseBtn = completeModal ? completeModal.querySelector('.reservation-modal__close') : null;
  const completeOverlay = completeModal ? completeModal.querySelector('.reservation-modal__overlay') : null;

  if (!form || !confirmBtn || !confirmModal || !completeModal) return;

  // 料金テーブル
  const pricingTable = {
    // 観光ガイドサービス
    guide: {
      half: {
        audioOnly: 12000,
        withTranslation: 20000
      },
      full: {
        audioOnly: 22000,
        withTranslation: 30000
      },
      urgentFee: 1000, // 前日・当日予約
      additionalPerson: 1000 // 3人目以降 1人あたり
    },
    // 予約代行サービス
    reservation: {
      basic: 2200, // 基本料金
      urgentFee: 1000 // 前日・当日予約
    },
    // トランクお預かりサービス
    luggage: {
      perDay: 1800, // 1日1個あたり
      urgentFee: 1000 // 前日・当日予約
    }
  };

  // フィールドラベルのマッピング
  const fieldLabels = {
    'name': 'お名前',
    'gender': '性別',
    'nationality': '国籍',
    'address': '住所',
    'passport': 'パスポート番号',
    'stay': '滞在先',
    'phone': '電話番号',
    'email': 'メールアドレス',
    'card': 'クレジットカード番号',
    'cardType': 'カード会社',
    'cvv': 'セキュリティコード',
    'companion': '同伴者情報',
    'guideCourse': 'ご希望コース',
    'guideDate': '予約日',
    'guideArea': 'ご希望エリア',
    'guideAdults': '大人',
    'guideChildren': '子供',
    'guideSpots': 'ご希望スポット場所',
    'guideNotes': 'その他ご要望事項',
    'hotelDate': '予約日',
    'hotelArea': 'エリア選択',
    'hotelBudget': 'ご希望金額',
    'hotelAdults': '大人',
    'hotelChildren': '子供',
    'hotelRequest': 'その他ご希望事項',
    'hotelProposal1': 'ハマナビからの提案',
    'diningDate': '予約日',
    'diningTime': '予約時間',
    'diningAdults': '大人',
    'diningChildren': '子供',
    'diningBudget': 'ご予算',
    'cuisine': 'ジャンル',
    'diningRequest': 'その他ご希望事項',
    'activityDatetime': '予約希望日時',
    'activityAdults': '大人',
    'activityChildren': '子供',
    'activityType': '体験アクティビティ',
    'activityRequest': 'その他ご希望事項',
    'luggageDate': '予約日',
    'luggageTime': 'お預かり時間',
    'luggageCount': '予約個数',
    'luggageNotes': 'その他ご希望事項'
  };

  // セクションの定義
  const sections = {
    '基本入力項目': ['name', 'gender', 'nationality', 'address', 'passport', 'stay', 'phone', 'email', 'card', 'cardType', 'cvv', 'companion'],
    '観光ガイドサービス': ['guideCourse', 'guideDate', 'guideArea', 'guideAdults', 'guideChildren', 'guideSpots', 'guideNotes'],
    'ホテル予約代行サービス': ['hotelDate', 'hotelArea', 'hotelBudget', 'hotelAdults', 'hotelChildren', 'hotelRequest', 'hotelProposal1'],
    '飲食店舗予約代行サービス': ['diningDate', 'diningTime', 'diningAdults', 'diningChildren', 'diningBudget', 'cuisine', 'diningRequest'],
    '体験アクティビティ代行サービス': ['activityDatetime', 'activityAdults', 'activityChildren', 'activityType', 'activityRequest'],
    'トランクお預かりサービス': ['luggageDate', 'luggageTime', 'luggageCount', 'luggageNotes']
  };

  // 確認ボタンのクリック
  confirmBtn.addEventListener('click', function(e) {
    e.preventDefault();

    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;
    const invalidFields = [];

    requiredFields.forEach(field => {
      const value = field.value ? field.value.trim() : '';
      if (!value) {
        isValid = false;
        invalidFields.push(field.name || field.id || '不明');
        field.style.borderColor = '#ff0000';
        field.style.borderWidth = '2px';
        if (!firstInvalidField) {
          firstInvalidField = field;
        }
      } else {
        field.style.borderColor = '';
        field.style.borderWidth = '';
      }
    });

    if (!isValid) {
      // エラーメッセージを表示
      const errorMessage = requiredMessageText + '\n\n' + requiredListTitleText + '\n' + invalidFields.map(field => {
        const label = fieldLabels[field] || field;
        return '・' + label;
      }).join('\n');
      
      alert(errorMessage);
      
      // エラー状態を視覚的に表示
      invalidFields.forEach(fieldName => {
        const field = form.querySelector(`[name="${fieldName}"]`);
        if (field) {
          field.style.borderColor = '#ff0000';
          field.style.borderWidth = '2px';
          field.style.backgroundColor = '#fff0f0';
          
          // 3秒後にエラー表示を解除
          setTimeout(() => {
            field.style.borderColor = '';
            field.style.borderWidth = '';
            field.style.backgroundColor = '';
          }, 3000);
        }
      });
      
      if (firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
          firstInvalidField.focus();
        }, 500);
      }
      return;
    }

    try {
      generateConfirmContent();
      showConfirmModal();
    } catch (error) {
      alert('確認画面の表示中にエラーが発生しました。ページを再読み込みしてください。');
    }
  });

  // 見積もり計算関数
  function calculateEstimate() {
    let total = 0;
    let breakdown = [];

    // 観光ガイドサービス
    const guideCourse = form.elements['guideCourse']?.value;
    if (guideCourse) {
      let guidePrice = 0;
      let guideName = '';
      const courseMap = {
        half_audio: {
          price: pricingTable.guide.half.audioOnly,
          name: '観光ガイド 半日コース（音声ガイド）'
        },
        half_interpreter: {
          price: pricingTable.guide.half.withTranslation,
          name: '観光ガイド 半日コース（通訳付き）'
        },
        full_audio: {
          price: pricingTable.guide.full.audioOnly,
          name: '観光ガイド 1日コース（音声ガイド）'
        },
        full_interpreter: {
          price: pricingTable.guide.full.withTranslation,
          name: '観光ガイド 1日コース（通訳付き）'
        }
      };

      if (courseMap[guideCourse]) {
        guidePrice = courseMap[guideCourse].price;
        guideName = courseMap[guideCourse].name;
      } else {
        // 旧値（half/full）互換
        const guideNotes = form.elements['guideNotes']?.value || '';
        const hasTranslation = guideNotes.toLowerCase().includes('通訳') || guideNotes.includes('翻訳');
        if (guideCourse === 'half') {
          guidePrice = hasTranslation ? pricingTable.guide.half.withTranslation : pricingTable.guide.half.audioOnly;
          guideName = `観光ガイド 半日コース（${hasTranslation ? '通訳付き' : '音声ガイド'}）`;
        } else if (guideCourse === 'full') {
          guidePrice = hasTranslation ? pricingTable.guide.full.withTranslation : pricingTable.guide.full.audioOnly;
          guideName = `観光ガイド 1日コース（${hasTranslation ? '通訳付き' : '音声ガイド'}）`;
        }
      }

      if (guidePrice > 0) {
        breakdown.push({ name: guideName, price: guidePrice });
        total += guidePrice;
      }
    }

    // ホテル予約代行
    const hotelDate = form.elements['hotelDate']?.value;
    if (hotelDate) {
      breakdown.push({ name: 'ホテル予約代行', price: pricingTable.reservation.basic });
      total += pricingTable.reservation.basic;
    }

    // 飲食店舗予約代行
    const diningDate = form.elements['diningDate']?.value;
    if (diningDate) {
      breakdown.push({ name: '飲食店舗予約代行', price: pricingTable.reservation.basic });
      total += pricingTable.reservation.basic;
    }

    // 体験アクティビティ予約代行
    const activityDatetime = form.elements['activityDatetime']?.value;
    if (activityDatetime) {
      breakdown.push({ name: '体験アクティビティ予約代行', price: pricingTable.reservation.basic });
      total += pricingTable.reservation.basic;
    }

    // トランクお預かり
    const luggageCount = parseInt(form.elements['luggageCount']?.value) || 0;
    if (luggageCount > 0) {
      const luggagePrice = pricingTable.luggage.perDay * luggageCount;
      breakdown.push({ name: `トランクお預かり（${luggageCount}個 × 1日）`, price: luggagePrice });
      total += luggagePrice;
    }

    // 緊急予約料金のチェック（前日・当日予約）
    const now = new Date();
    const tomorrow = new Date(now);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    let urgentCount = 0;
    
    // 各サービスの日時をチェック
    const datetimeFields = ['hotelDate', 'diningDate', 'activityDatetime', 'luggageDate'];
    datetimeFields.forEach(fieldName => {
      const datetime = form.elements[fieldName]?.value;
      if (datetime) {
        const reservationDate = new Date(datetime);
        if (reservationDate <= tomorrow) {
          urgentCount++;
        }
      }
    });

    if (urgentCount > 0) {
      const urgentFee = 1000 * urgentCount;
      breakdown.push({ name: `前日・当日予約料金（${urgentCount}件）`, price: urgentFee });
      total += urgentFee;
    }

    return { total, breakdown };
  }

  // HTMLエスケープ関数
  function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  // 確認画面の内容を生成
  function generateConfirmContent() {
    if (!confirmContent) return;

    let html = '';

    Object.keys(sections).forEach(sectionTitle => {
      const fields = sections[sectionTitle];
      let sectionHtml = '';
      let hasData = false;

      fields.forEach(fieldName => {
        const field = form.elements[fieldName];
        if (!field) return;
        
        let value = '';
        
        // テキストエリアやテキスト入力の場合
        if (field.tagName === 'TEXTAREA' || field.tagName === 'INPUT') {
          value = field.value ? field.value.trim() : '';
        }
        // セレクトボックスの場合、選択されたテキストを取得
        else if (field.tagName === 'SELECT') {
          if (field.selectedIndex > 0) {
            value = field.options[field.selectedIndex].text;
          }
        }
        // チェックボックスの場合
        else if (field.type === 'checkbox') {
          value = field.checked ? '選択済み' : '';
        }

        // クレジットカード番号はマスク
        if (fieldName === 'card' && value) {
          value = value.replace(/\d(?=\d{4})/g, '*');
        }

        // CVVはマスク
        if (fieldName === 'cvv' && value) {
          value = '***';
        }

        // 値がある場合、または人数フィールドの場合（0も有効な値）
        if (value || fieldName.includes('Adult') || fieldName.includes('Child') || fieldName.includes('Count')) {
          hasData = true;
          const displayValue = value || '未入力';
          const emptyClass = value ? '' : ' reservation-confirm__value--empty';
          
          sectionHtml += `
            <div class="reservation-confirm__item">
              <div class="reservation-confirm__label">${fieldLabels[fieldName] || fieldName}</div>
              <div class="reservation-confirm__value${emptyClass}">${escapeHtml(displayValue)}</div>
            </div>
          `;
        }
      });


      if (hasData) {
        html += `
          <div class="reservation-confirm__section">
            <h3 class="reservation-confirm__section-title">${sectionTitle}</h3>
            ${sectionHtml}
          </div>
        `;
      }
    });

    // 見積もりセクションを追加
    const estimate = calculateEstimate();
    if (estimate.breakdown.length > 0) {
      let estimateHtml = `
        <div class="reservation-confirm__section reservation-confirm__section--estimate">
          <h3 class="reservation-confirm__section-title">概算見積もり</h3>
          <div class="reservation-estimate">
            <div class="reservation-estimate__note">
              ※こちらは当サービスの手数料のみの概算です。実際の宿泊料金・飲食代・体験料金・交通費などは含まれておりません。
            </div>
            <div class="reservation-estimate__breakdown">
      `;

      estimate.breakdown.forEach(item => {
        estimateHtml += `
          <div class="reservation-estimate__item">
            <span class="reservation-estimate__name">${item.name}</span>
            <span class="reservation-estimate__price">¥${item.price.toLocaleString()}</span>
          </div>
        `;
      });

      estimateHtml += `
            </div>
            <div class="reservation-estimate__total">
              <span class="reservation-estimate__total-label">合計（税込）</span>
              <span class="reservation-estimate__total-price">¥${estimate.total.toLocaleString()}</span>
            </div>
            <div class="reservation-estimate__footer">
              ※最終的な料金は、ご予約内容確定後に改めてご案内いたします。
            </div>
          </div>
        </div>
      `;

      html += estimateHtml;
    }

    if (html === '') {
      html = '<p>入力された内容がありません。</p>';
    }
    
    confirmContent.innerHTML = html;
  }

  // 確認モーダル表示
  function showConfirmModal() {
    if (!confirmModal) {
      alert('確認画面を表示できませんでした。');
      return;
    }

    confirmModal.style.display = 'flex';
    confirmModal.style.visibility = 'visible';
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
      confirmModal.classList.add('is-active');
      confirmModal.style.opacity = '1';
    });
  }

  // 確認モーダルを閉じる
  function closeConfirmModal() {
    if (!confirmModal) return;
    
    confirmModal.classList.remove('is-active');
    confirmModal.style.opacity = '0';
    
    setTimeout(() => {
      confirmModal.style.display = 'none';
      confirmModal.style.visibility = 'hidden';
      document.body.style.overflow = '';
    }, 300);
  }

  // 戻るボタン
  if (confirmBackBtn) {
    confirmBackBtn.addEventListener('click', closeConfirmModal);
  }

  // 確認画面のオーバーレイ
  if (confirmOverlay) {
    confirmOverlay.addEventListener('click', closeConfirmModal);
  }

  // Stripe決済ボタン
  const stripePaymentBtn = document.getElementById('stripePaymentBtn');
  if (stripePaymentBtn) {
    stripePaymentBtn.addEventListener('click', function(e) {
      // 旧実装で<a>だった場合の遷移を確実に止める（button化済みだが安全のため残す）
      if (e && typeof e.preventDefault === 'function') e.preventDefault();
      if (e && typeof e.stopPropagation === 'function') e.stopPropagation();

      // ボタンを無効化（二重送信防止）
      stripePaymentBtn.disabled = true;
      stripePaymentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 処理中...';

      // 見積もりを計算
      const estimate = calculateEstimate();
      const totalAmount = estimate.total;

      // フォームデータを作成
      const formData = new FormData(form);
      
      // Stripe決済セッション作成用のアクションを追加
      formData.append('action', window.yokohamaReservation?.stripeAction || 'create_stripe_session');
      
      // nonceを追加（セキュリティチェック用）
      if (window.yokohamaReservation?.nonce) {
        formData.append('reservation_nonce', window.yokohamaReservation.nonce);
      }
      
      // 見積もり金額を追加（サーバー側でも計算するが、クライアント側の計算も送信）
      formData.append('estimated_amount', totalAmount);

      const ajaxurl = window.yokohamaReservation?.ajaxurl || '/wp-admin/admin-ajax.php';

      fetch(ajaxurl, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      })
      .then(response => {
        const contentType = response.headers.get('content-type');

        if (contentType && (contentType.includes('application/xml') || contentType.includes('text/xml'))) {
          return response.text().then(text => {
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(text, 'text/xml');
            const errorCode = xmlDoc.querySelector('Code')?.textContent || '不明';
            const errorMessage = xmlDoc.querySelector('Message')?.textContent || 'Access Denied';
            throw new Error('アクセス拒否エラーが発生しました。\n\nエラーコード: ' + errorCode + '\nメッセージ: ' + errorMessage + '\n\nサーバー設定やセキュリティプラグインを確認してください。');
          });
        }

        if (!response.ok) {
          return response.text().then(text => {
            throw new Error('サーバーエラー: ' + response.status + '\n\n' + text.substring(0, 500));
          });
        }

        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          return response.text().then(text => {
            throw new Error('サーバーがJSON以外のレスポンスを返しました。\n\n' + text.substring(0, 500));
          });
        }
      })
      .then(data => {
        if (data.success && data.data && data.data.url) {
          window.location.href = data.data.url;
        } else {
          let errorMessage = 'Stripe決済セッションの作成に失敗しました。';
          if (data.data && data.data.message) {
            errorMessage = data.data.message;
          }
          alert(errorMessage);
          stripePaymentBtn.disabled = false;
          stripePaymentBtn.innerHTML = '<i class="fas fa-credit-card"></i> Stripe決済へ進む';
        }
      })
      .catch(error => {
        alert('エラーが発生しました。もう一度お試しください。\n' + error.message);
        stripePaymentBtn.disabled = false;
        stripePaymentBtn.innerHTML = '<i class="fas fa-credit-card"></i> Stripe決済へ進む';
      });
    });
  }

  // 送信ボタン
  if (confirmSubmitBtn) {
    confirmSubmitBtn.addEventListener('click', function() {
      // ボタンを無効化（二重送信防止）
      confirmSubmitBtn.disabled = true;
      confirmSubmitBtn.textContent = '送信中...';

      const formData = new FormData(form);

      // nonceを追加（CSRF対策）
      if (window.yokohamaReservation?.nonce) {
        formData.append('reservation_nonce', window.yokohamaReservation.nonce);
      }

      fetch('./api/send-reservation.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        closeConfirmModal();
        confirmSubmitBtn.disabled = false;
        confirmSubmitBtn.textContent = '送信する';

        if (data.success) {
          setTimeout(() => {
            showCompleteModal();
          }, 400);
        } else {
          alert(data.message || '送信に失敗しました。もう一度お試しください。');
        }
      })
      .catch(() => {
        closeConfirmModal();
        confirmSubmitBtn.disabled = false;
        confirmSubmitBtn.textContent = '送信する';
        alert('送信に失敗しました。もう一度お試しください。');
      });
    });
  }

  // 完了モーダル表示
  function showCompleteModal() {
    completeModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
      completeModal.classList.add('is-active');
    }, 10);
  }

  // 完了モーダルを閉じる
  function closeCompleteModal() {
    completeModal.classList.remove('is-active');
    
    setTimeout(() => {
      completeModal.style.display = 'none';
      document.body.style.overflow = '';
      
      // フォームをリセット
      form.reset();
      
      // トップページにリダイレクト（オプション）
      // window.location.href = 'index.html';
    }, 300);
  }

  // 完了モーダルの閉じるボタン
  if (completeCloseBtn) {
    completeCloseBtn.addEventListener('click', closeCompleteModal);
  }

  // 完了モーダルのオーバーレイ
  if (completeOverlay) {
    completeOverlay.addEventListener('click', closeCompleteModal);
  }

  // ESCキーでモーダルを閉じる
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      if (confirmModal.style.display === 'flex') {
        closeConfirmModal();
      } else if (completeModal.style.display === 'flex') {
        closeCompleteModal();
      }
    }
  });
});
