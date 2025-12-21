// 予約フォーム送信処理
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.reservation-form');
  const confirmBtn = document.getElementById('confirmBtn');
  const confirmModal = document.getElementById('confirmModal');
  const confirmContent = document.getElementById('confirmContent');
  const confirmBackBtn = confirmModal ? confirmModal.querySelector('.reservation-confirm__back') : null;
  const confirmSubmitBtn = confirmModal ? confirmModal.querySelector('.reservation-confirm__submit') : null;
  const confirmOverlay = confirmModal ? confirmModal.querySelector('.reservation-confirm__overlay') : null;
  
  const completeModal = document.getElementById('reservationModal');
  const completeCloseBtn = completeModal ? completeModal.querySelector('.reservation-modal__close') : null;
  const completeOverlay = completeModal ? completeModal.querySelector('.reservation-modal__overlay') : null;

  if (!form || !confirmBtn || !confirmModal || !completeModal) {
    console.warn('予約フォームの必要な要素が見つかりません:', {
      form: !!form,
      confirmBtn: !!confirmBtn,
      confirmModal: !!confirmModal,
      completeModal: !!completeModal
    });
    return;
  }

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
    // トランク預かりサービス
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
    'guideArea': 'ご希望エリア',
    'guideSpots': 'ご希望スポット場所',
    'guideNotes': 'その他ご要望事項',
    'hotelDate': '予約日',
    'hotelArea': 'エリア選択',
    'hotelBudget': 'ご希望金額',
    'hotelAdults': '大人',
    'hotelChildren': '子供',
    'hotelRequest': 'その他ご希望事項',
    'hotelProposal1': 'ハマナビからの提案1',
    'hotelProposal2': 'ハマナビからの提案2',
    'diningDate': '予約日',
    'diningAdults': '大人',
    'diningChildren': '子供',
    'diningBudget': 'ご予算',
    'diningGenre': 'ジャンル',
    'diningRequest': 'その他ご希望事項',
    'activityDatetime': '予約希望日時',
    'activityAdults': '大人',
    'activityChildren': '子供',
    'activityType': '体験アクティビティ',
    'activityRequest': 'その他ご希望事項',
    'luggageDate': '予約日',
    'luggageCount': '予約個数',
    'luggageNotes': 'その他ご希望事項'
  };

  // セクションの定義
  const sections = {
    '基本入力項目': ['name', 'gender', 'nationality', 'address', 'passport', 'stay', 'phone', 'email', 'card', 'cardType', 'cvv', 'companion'],
    '観光ガイドサービス': ['guideCourse', 'guideArea', 'guideSpots', 'guideNotes'],
    'ホテル予約代行サービス': ['hotelDate', 'hotelArea', 'hotelBudget', 'hotelAdults', 'hotelChildren', 'hotelRequest', 'hotelProposal1', 'hotelProposal2'],
    '飲食店予約代行サービス': ['diningDate', 'diningAdults', 'diningChildren', 'diningBudget', 'diningGenre', 'diningRequest'],
    '体験アクティビティ代行サービス': ['activityDatetime', 'activityAdults', 'activityChildren', 'activityType', 'activityRequest'],
    'トランク預かりサービス': ['luggageDate', 'luggageCount', 'luggageNotes']
  };

  // 確認ボタンのクリック
  confirmBtn.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('確認ボタンがクリックされました');
    
    // 必須項目のバリデーション
    const requiredFields = form.querySelectorAll('[required]');
    console.log('必須項目の数:', requiredFields.length);
    
    let isValid = true;
    let firstInvalidField = null;
    const invalidFields = [];

    requiredFields.forEach(field => {
      const value = field.value ? field.value.trim() : '';
      console.log(`フィールド ${field.name || field.id}: "${value}"`);
      
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

    console.log('バリデーション結果:', isValid);
    if (invalidFields.length > 0) {
      console.log('未入力の必須項目:', invalidFields);
    }

    if (!isValid) {
      // エラーメッセージを表示
      const errorMessage = '必須項目を入力してください。\n\n未入力項目:\n' + invalidFields.map(field => {
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

    console.log('バリデーション成功。確認画面を表示します。');
    
    try {
      // 確認画面の内容を生成
      generateConfirmContent();
      console.log('確認内容を生成しました');
      
      // 確認モーダルを表示
      showConfirmModal();
      console.log('確認モーダルを表示しました');
    } catch (error) {
      console.error('確認画面の表示中にエラーが発生しました:', error);
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
      const guideNotes = form.elements['guideNotes']?.value || '';
      const hasTranslation = guideNotes.toLowerCase().includes('通訳') || guideNotes.includes('翻訳');
      
      let guidePrice = 0;
      let guideName = '';
      
      if (guideCourse === 'half') {
        guidePrice = hasTranslation ? pricingTable.guide.half.withTranslation : pricingTable.guide.half.audioOnly;
        guideName = `観光ガイド 半日コース（${hasTranslation ? '通訳付き' : '音声ガイド'}）`;
      } else if (guideCourse === 'full') {
        guidePrice = hasTranslation ? pricingTable.guide.full.withTranslation : pricingTable.guide.full.audioOnly;
        guideName = `観光ガイド 1日コース（${hasTranslation ? '通訳付き' : '音声ガイド'}）`;
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

    // 飲食店予約代行
    const diningDate = form.elements['diningDate']?.value;
    if (diningDate) {
      breakdown.push({ name: '飲食店予約代行', price: pricingTable.reservation.basic });
      total += pricingTable.reservation.basic;
    }

    // 体験アクティビティ予約代行
    const activityDatetime = form.elements['activityDatetime']?.value;
    if (activityDatetime) {
      breakdown.push({ name: '体験アクティビティ予約代行', price: pricingTable.reservation.basic });
      total += pricingTable.reservation.basic;
    }

    // トランク預かり
    const luggageCount = parseInt(form.elements['luggageCount']?.value) || 0;
    if (luggageCount > 0) {
      const luggagePrice = pricingTable.luggage.perDay * luggageCount;
      breakdown.push({ name: `トランク預かり（${luggageCount}個 × 1日）`, price: luggagePrice });
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
    if (!confirmContent) {
      console.error('confirmContent要素が見つかりません');
      return;
    }
    
    let html = '';
    console.log('確認内容を生成開始');

    Object.keys(sections).forEach(sectionTitle => {
      const fields = sections[sectionTitle];
      let sectionHtml = '';
      let hasData = false;

      fields.forEach(fieldName => {
        const field = form.elements[fieldName];
        if (!field) {
          console.warn(`フィールド "${fieldName}" が見つかりません`);
          return;
        }
        
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
    console.log('確認内容を設定しました。HTMLの長さ:', html.length);
  }

  // 確認モーダル表示
  function showConfirmModal() {
    if (!confirmModal) {
      console.error('確認モーダルが見つかりません');
      alert('確認画面を表示できませんでした。');
      return;
    }
    
    console.log('確認モーダルを表示します');
    console.log('confirmModal要素:', confirmModal);
    console.log('現在のdisplay:', confirmModal.style.display);
    
    confirmModal.style.display = 'flex';
    confirmModal.style.visibility = 'visible';
    document.body.style.overflow = 'hidden';
    
    // 強制的に表示を確実にする
    requestAnimationFrame(() => {
      confirmModal.classList.add('is-active');
      confirmModal.style.opacity = '1';
      console.log('is-activeクラスを追加しました');
      console.log('モーダルの現在の状態:', {
        display: confirmModal.style.display,
        visibility: confirmModal.style.visibility,
        opacity: confirmModal.style.opacity,
        hasActiveClass: confirmModal.classList.contains('is-active')
      });
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

  // 送信ボタン
  if (confirmSubmitBtn) {
    confirmSubmitBtn.addEventListener('click', function() {
      // ボタンを無効化（二重送信防止）
      confirmSubmitBtn.disabled = true;
      confirmSubmitBtn.textContent = '送信中...';

      // フォームデータを作成
      const formData = new FormData(form);

      // デバッグ: フォームデータの内容を確認
      console.log('送信するデータ:');
      for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
      }

      // サーバーに送信を試みる
      fetch('./api/send-reservation.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        console.log('Response status:', response.status);
        
        // レスポンスがJSONでない場合もハンドリング
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          // PHPが動作していない場合のフォールバック
          console.warn('PHPサーバーが動作していません。デモモードで動作します。');
          return { success: true, demo: true };
        }
      })
      .then(data => {
        // 確認モーダルを閉じる
        closeConfirmModal();
        
        // ボタンを元に戻す
        confirmSubmitBtn.disabled = false;
        confirmSubmitBtn.textContent = '送信する';

        if (data.success) {
          // デモモードの場合は警告を表示
          if (data.demo) {
            console.warn('デモモード: 実際のメール送信は行われていません。');
            console.log('本番環境ではPHPサーバーが必要です。');
          }
          
          // 成功時：完了モーダルを表示
          setTimeout(() => {
            showCompleteModal();
          }, 400);
        } else {
          // エラー時
          alert(data.message || '送信に失敗しました。もう一度お試しください。');
        }
      })
      .catch(error => {
        console.error('送信エラー:', error);
        console.log('エラー詳細:', error.message);
        
        // PHPサーバーが動作していない場合のフォールバック
        // ローカル開発環境では完了画面を表示
        if (window.location.protocol === 'file:' || !window.location.hostname) {
          console.warn('ローカルファイルとして開かれています。デモモードで動作します。');
          
          // 確認モーダルを閉じる
          closeConfirmModal();
          
          // ボタンを元に戻す
          confirmSubmitBtn.disabled = false;
          confirmSubmitBtn.textContent = '送信する';
          
          // 完了モーダルを表示（デモ）
          setTimeout(() => {
            showCompleteModal();
            console.log('【デモモード】実際のメール送信は行われていません。');
            console.log('本番環境ではPHPサーバーで ./api/send-reservation.php が動作します。');
          }, 400);
        } else {
          // 確認モーダルを閉じる
          closeConfirmModal();
          
          // ボタンを元に戻す
          confirmSubmitBtn.disabled = false;
          confirmSubmitBtn.textContent = '送信する';
          
          alert('送信に失敗しました。\n\nPHPサーバーが動作していない可能性があります。\n本番環境では正常に動作します。\n\n開発者コンソール（F12）で詳細を確認してください。');
        }
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
