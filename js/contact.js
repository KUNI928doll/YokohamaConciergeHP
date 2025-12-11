// お問い合わせフォーム送信処理
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.inquiry-form');
  const submitBtn = form ? form.querySelector('.btn[type="submit"]') : null;
  
  if (!form) return;

  // フォーム送信処理
  form.addEventListener('submit', function(e) {
    e.preventDefault();

    let isValid = true;
    let firstInvalidField = null;

    // お問い合わせ種別のチェックボックスのバリデーション
    const typeCheckboxes = form.querySelectorAll('input[name="type[]"]');
    const isTypeSelected = Array.from(typeCheckboxes).some(cb => cb.checked);
    const typeContainer = form.querySelector('.inquiry-form__checkboxes');
    
    if (!isTypeSelected) {
      isValid = false;
      if (typeContainer) {
        typeContainer.style.border = '2px solid #ff0000';
        typeContainer.style.padding = '10px';
        typeContainer.style.borderRadius = '4px';
        if (!firstInvalidField) {
          firstInvalidField = typeContainer;
        }
      }
    } else {
      if (typeContainer) {
        typeContainer.style.border = '';
        typeContainer.style.padding = '';
      }
    }

    // プライバシーポリシーの同意チェック
    const privacyCheckbox = document.getElementById('privacy-agree');
    if (!privacyCheckbox || !privacyCheckbox.checked) {
      isValid = false;
      if (privacyCheckbox) {
        const privacyLabel = privacyCheckbox.closest('label');
        if (privacyLabel) {
          privacyLabel.style.border = '2px solid #ff0000';
          privacyLabel.style.padding = '5px';
          privacyLabel.style.borderRadius = '4px';
          if (!firstInvalidField) {
            firstInvalidField = privacyCheckbox;
          }
        }
      }
    } else {
      if (privacyCheckbox) {
        const privacyLabel = privacyCheckbox.closest('label');
        if (privacyLabel) {
          privacyLabel.style.border = '';
          privacyLabel.style.padding = '';
        }
      }
    }

    // テキスト入力の必須項目のバリデーション（チェックボックスを除く）
    const requiredFields = form.querySelectorAll('[required]:not([type="checkbox"])');

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
      alert('必須項目を入力してください。\n\n・お問い合わせ種別を1つ以上選択してください\n・プライバシーポリシーに同意してください');
      if (firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (firstInvalidField.focus) {
          firstInvalidField.focus();
        }
      }
      return;
    }

    // ボタンを無効化（二重送信防止）
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = '送信中...';
    }

    // フォームデータを作成
    const formData = new FormData(form);

    // デバッグ: フォームデータの内容を確認
    console.log('送信するデータ:');
    for (let [key, value] of formData.entries()) {
      console.log(key + ': ' + value);
    }

    // サーバーに送信を試みる
    fetch('./api/send-contact.php', {
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
      // ボタンを元に戻す
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = '送信する';
      }

      if (data.success) {
        // デモモードの場合は警告を表示
        if (data.demo) {
          console.warn('デモモード: 実際のメール送信は行われていません。');
          console.log('本番環境ではPHPサーバーが必要です。');
        }
        
        // 成功時：完了モーダルを表示
        showThanksModal();
        
        // フォームをリセット
        form.reset();
      } else {
        // エラー時
        alert(data.message || '送信に失敗しました。もう一度お試しください。');
      }
    })
    .catch(error => {
      console.error('送信エラー:', error);
      console.log('エラー詳細:', error.message);
      
      // ボタンを元に戻す
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = '送信する';
      }
      
      // PHPサーバーが動作していない場合のフォールバック
      if (window.location.protocol === 'file:' || !window.location.hostname) {
        console.warn('ローカルファイルとして開かれています。デモモードで動作します。');
        
        // 完了モーダルを表示（デモ）
        showThanksModal();
        
        // フォームをリセット
        form.reset();
        
        console.log('【デモモード】実際のメール送信は行われていません。');
        console.log('本番環境ではPHPサーバーで ./api/send-contact.php が動作します。');
      } else {
        alert('送信に失敗しました。\n\nPHPサーバーが動作していない可能性があります。\n本番環境では正常に動作します。\n\n開発者コンソール（F12）で詳細を確認してください。');
      }
    });
  });

  // 完了モーダル表示
  function showThanksModal() {
    const modal = document.getElementById('inquiryThanksModal');
    if (!modal) return;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
      modal.classList.add('is-active');
    }, 10);
  }

  // 完了モーダルを閉じる
  function closeThanksModal() {
    const modal = document.getElementById('inquiryThanksModal');
    if (!modal) return;

    modal.classList.remove('is-active');
    
    setTimeout(() => {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }, 300);
  }

  // 完了モーダルの閉じるボタン
  const thanksModal = document.getElementById('inquiryThanksModal');
  if (thanksModal) {
    const closeBtn = thanksModal.querySelector('.inquiry-thanks-modal__close');
    const overlay = thanksModal.querySelector('.inquiry-thanks-modal__overlay');

    if (closeBtn) {
      closeBtn.addEventListener('click', closeThanksModal);
    }

    if (overlay) {
      overlay.addEventListener('click', closeThanksModal);
    }
  }

  // ESCキーでモーダルを閉じる
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && thanksModal && thanksModal.style.display === 'flex') {
      closeThanksModal();
    }
  });
});

