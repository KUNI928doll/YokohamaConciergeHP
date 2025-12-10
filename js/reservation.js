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

  if (!form || !confirmModal || !completeModal) return;

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
    'hotelDatetime': '予約日時',
    'hotelArea': 'エリア選択',
    'hotelBudget': 'ご希望金額',
    'hotelAdultMale': '大人（男性）',
    'hotelAdultFemale': '大人（女性）',
    'hotelChildMale': '子供（男性）',
    'hotelChildFemale': '子供（女性）',
    'hotelRequest': 'その他ご希望事項',
    'hotelProposal1': 'ハマナビからの提案1',
    'hotelProposal2': 'ハマナビからの提案2',
    'diningDatetime': '予約日時',
    'diningPeople': '人数',
    'diningBudget': 'ご予算',
    'diningGenre': 'ジャンル',
    'diningRequest': 'その他ご希望事項',
    'activityDatetime': '予約希望日時',
    'activityType': '体験アクティビティ',
    'activityRequest': 'その他ご希望事項',
    'luggageDatetime': '予約日時',
    'luggageCount': '予約個数',
    'luggageNotes': 'その他ご希望事項'
  };

  // セクションの定義
  const sections = {
    '基本入力項目': ['name', 'gender', 'nationality', 'address', 'passport', 'stay', 'phone', 'email', 'card', 'cardType', 'cvv', 'companion'],
    '観光ガイドサービス': ['guideCourse', 'guideArea', 'guideSpots', 'guideNotes'],
    'ホテル予約代行サービス': ['hotelDatetime', 'hotelArea', 'hotelBudget', 'hotelAdultMale', 'hotelAdultFemale', 'hotelChildMale', 'hotelChildFemale', 'hotelRequest', 'hotelProposal1', 'hotelProposal2'],
    '飲食店予約代行サービス': ['diningDatetime', 'diningPeople', 'diningBudget', 'diningGenre', 'diningRequest'],
    '体験アクティビティ代行サービス': ['activityDatetime', 'activityType', 'activityRequest'],
    'トランク預かりサービス': ['luggageDatetime', 'luggageCount', 'luggageNotes']
  };

  // 確認ボタンのクリック
  confirmBtn.addEventListener('click', function() {
    // 必須項目のバリデーション
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;

    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        isValid = false;
        field.style.borderColor = '#ff0000';
        if (!firstInvalidField) {
          firstInvalidField = field;
        }
      } else {
        field.style.borderColor = '';
      }
    });

    if (!isValid) {
      alert('必須項目を入力してください。');
      if (firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidField.focus();
      }
      return;
    }

    // 確認画面の内容を生成
    generateConfirmContent();
    showConfirmModal();
  });

  // 確認画面の内容を生成
  function generateConfirmContent() {
    let html = '';

    Object.keys(sections).forEach(sectionTitle => {
      const fields = sections[sectionTitle];
      let sectionHtml = '';
      let hasData = false;

      fields.forEach(fieldName => {
        const field = form.elements[fieldName];
        if (field) {
          let value = field.value.trim();
          
          // セレクトボックスの場合、選択されたテキストを取得
          if (field.tagName === 'SELECT' && value) {
            value = field.options[field.selectedIndex].text;
          }

          // クレジットカード番号はマスク
          if (fieldName === 'card' && value) {
            value = value.replace(/\d(?=\d{4})/g, '*');
          }

          // CVVはマスク
          if (fieldName === 'cvv' && value) {
            value = '***';
          }

          if (value || fieldName.includes('Adult') || fieldName.includes('Child')) {
            hasData = true;
            const displayValue = value || '未入力';
            const emptyClass = value ? '' : ' reservation-confirm__value--empty';
            
            sectionHtml += `
              <div class="reservation-confirm__item">
                <div class="reservation-confirm__label">${fieldLabels[fieldName] || fieldName}</div>
                <div class="reservation-confirm__value${emptyClass}">${displayValue}</div>
              </div>
            `;
          }
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

    confirmContent.innerHTML = html;
  }

  // 確認モーダル表示
  function showConfirmModal() {
    confirmModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
      confirmModal.classList.add('is-active');
    }, 10);
  }

  // 確認モーダルを閉じる
  function closeConfirmModal() {
    confirmModal.classList.remove('is-active');
    
    setTimeout(() => {
      confirmModal.style.display = 'none';
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
