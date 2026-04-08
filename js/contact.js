"use strict";

// HTML5標準バリデーションを無効化（ブラウザ固定メッセージを回避）
document.addEventListener('DOMContentLoaded', function() {
  const cf7Form = document.querySelector('.wpcf7-form');
  if (cf7Form) {
    cf7Form.setAttribute('novalidate', 'novalidate');
  }
});

// //Contact Form 7 に「確認モーダル」をプラスしているjs

// // お問い合わせフォーム送信処理（「準備完了してから実行」）
// document.addEventListener('DOMContentLoaded', function() {
//   console.log('contact.js が読み込まれました');
  
//   // Contact Form 7のフォームを取得（CF7のフォームがあるか？なければ自作フォームか？どっちでも動くように設定）
//   const cf7Form = document.querySelector('.wpcf7-form');
//   const customForm = document.querySelector('.inquiry-form');
//   const form = cf7Form || customForm;
  
//   console.log('cf7Form:', cf7Form);
//   console.log('customForm:', customForm);
  
//   // 確認画面の要素
//   const confirmModal = document.getElementById('contactConfirmModal');
//   const confirmContent = document.getElementById('contactConfirmContent');
//   const confirmBackBtn = confirmModal ? confirmModal.querySelector('.contact-confirm__back') : null;
//   const confirmSubmitBtn = confirmModal ? confirmModal.querySelector('.contact-confirm__submit') : null;
//   const confirmOverlay = confirmModal ? confirmModal.querySelector('.reservation-confirm__overlay') : null;
  
//   // 完了モーダルの要素
//   const thanksModal = document.getElementById('contactThanksModal');
//   const thanksCloseBtn = thanksModal ? thanksModal.querySelector('.contact-modal__close') : null;
  
//   if (!form) return;

//   // フォームデータを保存
//   let formDataCache = null;

//   // Contact Form 7の場合
//   if (cf7Form) {
//     // CF7の標準動作を完全に止めている
//     cf7Form.addEventListener('submit', function(e) {
//       console.log('フォーム送信イベント');
//       e.preventDefault();
//       e.stopPropagation();
      
//       // バリデーションチェック（CF7のバリデーションを再実装している状態）
//       if (validateForm()) {
//         // 確認画面を表示
//         generateConfirmContent();
//         showConfirmModal();
//       }
      
//       return false;
//     });
    
//     // 送信ボタンのクリックイベントもインターセプト
//     const submitBtn = cf7Form.querySelector('input[type="submit"]');
//     console.log('送信ボタン:', submitBtn);
    
//     if (submitBtn) {
//       console.log('送信ボタンにイベントリスナーを設定');
//       submitBtn.addEventListener('click', function(e) {
//         console.log('送信ボタンがクリックされました');
//         e.preventDefault();
//         e.stopPropagation();
        
//         // バリデーションチェック
//         if (validateForm()) {
//           // 確認画面を表示
//           generateConfirmContent();
//           showConfirmModal();
//         }
        
//         return false;
//       });
//     } else {
//       console.error('送信ボタンが見つかりません');
//     }

//     // 確認画面から実際の送信
//     if (confirmSubmitBtn) {
//       confirmSubmitBtn.addEventListener('click', function() {
//         closeConfirmModal();
        
//         // Contact Form 7の送信をトリガー
//         const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
//         cf7Form.dispatchEvent(submitEvent);
//       });
//     }

//     // Contact Form 7の送信成功イベント
//     document.addEventListener('wpcf7mailsent', function(event) {
//       showThanksModal();
//       cf7Form.reset();
//     }, false);

//     // Contact Form 7の送信失敗イベント
//     document.addEventListener('wpcf7mailfailed', function(event) {
//       alert('送信に失敗しました。もう一度お試しください。');
//     }, false);

//     // Contact Form 7のバリデーションエラー
//     document.addEventListener('wpcf7invalid', function(event) {
//       const invalidFields = event.detail.apiResponse.invalid_fields;
//       if (invalidFields && invalidFields.length > 0) {
//         let errorMessage = '以下の項目を確認してください：\n\n';
//         invalidFields.forEach(field => {
//           errorMessage += '・' + field.message + '\n';
//         });
//         alert(errorMessage);
        
//         // 最初のエラーフィールドにスクロール
//         const firstErrorField = cf7Form.querySelector('.wpcf7-not-valid');
//         if (firstErrorField) {
//           firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
//           setTimeout(() => {
//             firstErrorField.focus();
//           }, 500);
//         }
//       }
//     }, false);
//   }

//   // カスタムフォームの場合（既存のコード）
//   if (customForm) {
//     customForm.addEventListener('submit', function(e) {
//       e.preventDefault();

//       let isValid = true;
//       let firstInvalidField = null;

//       // お問い合わせ種別のチェックボックスのバリデーション
//       const typeCheckboxes = customForm.querySelectorAll('input[name="type[]"]');
//       const isTypeSelected = Array.from(typeCheckboxes).some(cb => cb.checked);
//       const typeContainer = customForm.querySelector('.inquiry-form__checkboxes');
      
//       if (!isTypeSelected) {
//         isValid = false;
//         if (typeContainer) {
//           typeContainer.style.border = '2px solid #ff0000';
//           typeContainer.style.padding = '10px';
//           typeContainer.style.borderRadius = '4px';
//           if (!firstInvalidField) {
//             firstInvalidField = typeContainer;
//           }
//         }
//       } else {
//         if (typeContainer) {
//           typeContainer.style.border = '';
//           typeContainer.style.padding = '';
//         }
//       }

//       // プライバシーポリシーの同意チェック
//       const privacyCheckbox = document.getElementById('privacy-agree');
//       if (!privacyCheckbox || !privacyCheckbox.checked) {
//         isValid = false;
//         if (privacyCheckbox) {
//           const privacyLabel = privacyCheckbox.closest('label');
//           if (privacyLabel) {
//             privacyLabel.style.border = '2px solid #ff0000';
//             privacyLabel.style.padding = '5px';
//             privacyLabel.style.borderRadius = '4px';
//             if (!firstInvalidField) {
//               firstInvalidField = privacyCheckbox;
//             }
//           }
//         }
//       } else {
//         if (privacyCheckbox) {
//           const privacyLabel = privacyCheckbox.closest('label');
//           if (privacyLabel) {
//             privacyLabel.style.border = '';
//             privacyLabel.style.padding = '';
//           }
//         }
//       }

//       // テキスト入力の必須項目のバリデーション（チェックボックスを除く）
//       const requiredFields = customForm.querySelectorAll('[required]:not([type="checkbox"])');

//       requiredFields.forEach(field => {
//         if (!field.value.trim()) {
//           isValid = false;
//           field.style.borderColor = '#ff0000';
//           if (!firstInvalidField) {
//             firstInvalidField = field;
//           }
//         } else {
//           field.style.borderColor = '';
//         }
//       });

//       if (!isValid) {
//         alert('必須項目を入力してください。\n\n・お問い合わせ種別を1つ以上選択してください\n・プライバシーポリシーに同意してください');
//         if (firstInvalidField) {
//           firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
//           if (firstInvalidField.focus) {
//             firstInvalidField.focus();
//           }
//         }
//         return;
//       }

//       // フォームデータを作成
//       const formData = new FormData(customForm);

//       // サーバーに送信
//       fetch('./api/send-contact.php', {
//         method: 'POST',
//         body: formData
//       })
//       .then(response => response.json())
//       .then(data => {
//         if (data.success) {
//           showThanksModal();
//           customForm.reset();
//         } else {
//           alert(data.message || '送信に失敗しました。もう一度お試しください。');
//         }
//       })
//       .catch(error => {
//         console.error('送信エラー:', error);
//         alert('送信に失敗しました。');
//       });
//     });
//   }

//   // バリデーション関数
//   function validateForm() {
//     let isValid = true;
//     let errorMessages = [];
//     let firstErrorElement = null;

//     console.log('バリデーション開始');

//     // 必須テキストフィールドのチェック
//     const requiredFields = cf7Form.querySelectorAll('input[aria-required="true"]:not([type="checkbox"]), textarea[aria-required="true"], select[aria-required="true"]');
//     console.log('必須フィールド数:', requiredFields.length);
    
//     requiredFields.forEach(field => {
//       const value = field.value.trim();
//       const fieldName = field.getAttribute('name');
      
//       if (!value) {
//         isValid = false;
//         field.classList.add('wpcf7-not-valid');
//         field.style.borderColor = '#ff0000';
//         field.style.borderWidth = '2px';
        
//         if (!firstErrorElement) {
//           firstErrorElement = field;
//         }
        
//         // フィールド名を取得
//         const wrapper = field.closest('.wpcf7-form-control-wrap');
//         let fieldLabel = fieldName;
        
//         if (wrapper) {
//           const parentLabel = wrapper.previousElementSibling;
//           if (parentLabel && parentLabel.tagName === 'LABEL') {
//             fieldLabel = parentLabel.textContent.replace('必須', '').trim();
//           }
//         }
        
//         errorMessages.push(`${fieldLabel}を入力してください`);
//       } else {
//         field.classList.remove('wpcf7-not-valid');
//         field.style.borderColor = '';
//         field.style.borderWidth = '';
//       }
//     });

//     // チェックボックスグループのチェック（お問い合わせ種別など）
//     const checkboxGroups = cf7Form.querySelectorAll('.wpcf7-checkbox[aria-required="true"], .wpcf7-radio[aria-required="true"]');
//     checkboxGroups.forEach(group => {
//       const checkboxes = group.querySelectorAll('input[type="checkbox"], input[type="radio"]');
//       const isChecked = Array.from(checkboxes).some(cb => cb.checked);
      
//       if (!isChecked) {
//         isValid = false;
//         group.style.border = '2px solid #ff0000';
//         group.style.padding = '10px';
//         group.style.borderRadius = '4px';
        
//         if (!firstErrorElement) {
//           firstErrorElement = group;
//         }
        
//         errorMessages.push('お問い合わせ種別を1つ以上選択してください');
//       } else {
//         group.style.border = '';
//         group.style.padding = '';
//       }
//     });

//     // 同意チェックボックスのチェック（プライバシーポリシー）
//     const acceptCheckboxes = cf7Form.querySelectorAll('.wpcf7-acceptance input[type="checkbox"]');
//     acceptCheckboxes.forEach(acceptCheckbox => {
//       if (!acceptCheckbox.checked) {
//         isValid = false;
//         const acceptWrapper = acceptCheckbox.closest('.wpcf7-acceptance') || acceptCheckbox.closest('.wpcf7-form-control-wrap');
//         const acceptLabel = acceptCheckbox.closest('label');
        
//         if (acceptLabel) {
//           acceptLabel.style.border = '2px solid #ff0000';
//           acceptLabel.style.padding = '5px';
//           acceptLabel.style.borderRadius = '4px';
//           acceptLabel.style.display = 'inline-block';
//         } else if (acceptWrapper) {
//           acceptWrapper.style.border = '2px solid #ff0000';
//           acceptWrapper.style.padding = '10px';
//           acceptWrapper.style.borderRadius = '4px';
//         }
        
//         if (!firstErrorElement) {
//           firstErrorElement = acceptCheckbox;
//         }
        
//         errorMessages.push('プライバシーポリシーに同意してください');
//       } else {
//         const acceptLabel = acceptCheckbox.closest('label');
//         const acceptWrapper = acceptCheckbox.closest('.wpcf7-acceptance') || acceptCheckbox.closest('.wpcf7-form-control-wrap');
        
//         if (acceptLabel) {
//           acceptLabel.style.border = '';
//           acceptLabel.style.padding = '';
//         } else if (acceptWrapper) {
//           acceptWrapper.style.border = '';
//           acceptWrapper.style.padding = '';
//         }
//       }
//     });

//     console.log('バリデーション結果:', isValid);
//     console.log('エラーメッセージ:', errorMessages);

//     if (!isValid && errorMessages.length > 0) {
//       alert('以下の項目を確認してください：\n\n' + errorMessages.map(msg => '・' + msg).join('\n'));
      
//       // 最初のエラーフィールドにスクロール
//       if (firstErrorElement) {
//         firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
//         setTimeout(() => {
//           if (firstErrorElement.focus) {
//             firstErrorElement.focus();
//           }
//         }, 500);
//       }
//     }

//     return isValid;
//   }

//   // 確認画面の内容を生成
//   function generateConfirmContent() {
//     if (!cf7Form || !confirmContent) return;

//     const formData = new FormData(cf7Form);
//     let html = '';

//     // お名前
//     const name = formData.get('your-name');
//     if (name) {
//       html += `
//         <div class="reservation-confirm__section">
//           <h3 class="reservation-confirm__section-title">お名前</h3>
//           <p class="reservation-confirm__value">${escapeHtml(name)}</p>
//         </div>
//       `;
//     }

//     // メールアドレス
//     const email = formData.get('your-email');
//     if (email) {
//       html += `
//         <div class="reservation-confirm__section">
//           <h3 class="reservation-confirm__section-title">メールアドレス</h3>
//           <p class="reservation-confirm__value">${escapeHtml(email)}</p>
//         </div>
//       `;
//     }

//     // 電話番号
//     const tel = formData.get('your-tel');
//     if (tel) {
//       html += `
//         <div class="reservation-confirm__section">
//           <h3 class="reservation-confirm__section-title">電話番号</h3>
//           <p class="reservation-confirm__value">${escapeHtml(tel)}</p>
//         </div>
//       `;
//     }

//     // お問い合わせ種別
//     const types = formData.getAll('inquiry-type[]');
//     if (types && types.length > 0) {
//       html += `
//         <div class="reservation-confirm__section">
//           <h3 class="reservation-confirm__section-title">お問い合わせ種別</h3>
//           <p class="reservation-confirm__value">${types.map(t => escapeHtml(t)).join('、')}</p>
//         </div>
//       `;
//     }

//     // お問い合わせ内容
//     const message = formData.get('your-message');
//     if (message) {
//       html += `
//         <div class="reservation-confirm__section">
//           <h3 class="reservation-confirm__section-title">お問い合わせ内容</h3>
//           <p class="reservation-confirm__value" style="white-space: pre-wrap;">${escapeHtml(message)}</p>
//         </div>
//       `;
//     }

//     confirmContent.innerHTML = html;
//   }

//   // HTMLエスケープ関数
//   function escapeHtml(text) {
//     const div = document.createElement('div');
//     div.textContent = text;
//     return div.innerHTML;
//   }

//   // 確認モーダル表示
//   function showConfirmModal() {
//     if (!confirmModal) return;
    
//     confirmModal.style.display = 'flex';
//     document.body.style.overflow = 'hidden';
    
//     setTimeout(() => {
//       confirmModal.classList.add('is-active');
//     }, 10);
//   }

//   // 確認モーダルを閉じる
//   function closeConfirmModal() {
//     if (!confirmModal) return;
    
//     confirmModal.classList.remove('is-active');
    
//     setTimeout(() => {
//       confirmModal.style.display = 'none';
//       document.body.style.overflow = '';
//     }, 300);
//   }
document.addEventListener('DOMContentLoaded', function () {

  // 完了モーダル要素
  const thanksModal = document.getElementById('contactThanksModal');
  const closeBtn = thanksModal
    ? thanksModal.querySelector('.contact-modal__close')
    : null;

  // 完了モーダルを表示
  function showThanksModal() {
    if (!thanksModal) return;

    thanksModal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
      thanksModal.classList.add('is-active');
    }, 10);
  }

  // 完了モーダルを閉じる
  function closeThanksModal() {
    if (!thanksModal) return;

    thanksModal.classList.remove('is-active');

    setTimeout(() => {
      thanksModal.style.display = 'none';
      document.body.style.overflow = '';
    }, 300);
  }

  // ✅ CF7送信成功時
  document.addEventListener('wpcf7mailsent', function () {
    showThanksModal();
  });

  // 閉じるボタン
  if (closeBtn) {
    closeBtn.addEventListener('click', closeThanksModal);
  }

  // ESCキーで閉じる
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && thanksModal?.classList.contains('is-active')) {
      closeThanksModal();
    }
  });

});
