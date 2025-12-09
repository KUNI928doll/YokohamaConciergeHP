// お問い合わせフォームの確認機能
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.inquiry-form');
    const confirmButton = document.getElementById('confirm-button');
    const modal = document.getElementById('confirm-modal');
    const modalClose = document.getElementById('modal-close');
    const backButton = document.getElementById('back-button');
    const submitButton = document.getElementById('submit-button');
    const confirmContent = document.getElementById('confirm-content');

    if (!form || !confirmButton || !modal) return;

    // 確認ボタンクリック
    confirmButton.addEventListener('click', function() {
        // フォームのバリデーション
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // プライバシーポリシーの同意チェック
        const privacyCheckbox = document.getElementById('privacy-agree');
        if (!privacyCheckbox.checked) {
            alert('プライバシーポリシーに同意してください。');
            privacyCheckbox.focus();
            return;
        }

        // 確認内容を生成
        const confirmHTML = generateConfirmHTML();
        confirmContent.innerHTML = confirmHTML;

        // モーダルを表示
        modal.classList.add('is-active');
        document.body.style.overflow = 'hidden';
    });

    // モーダルを閉じる
    function closeModal() {
        modal.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    // 閉じるボタン
    modalClose.addEventListener('click', closeModal);

    // 戻るボタン
    backButton.addEventListener('click', closeModal);

    // オーバーレイクリック
    modal.querySelector('.inquiry-confirm-modal__overlay').addEventListener('click', closeModal);

    // 送信ボタン
    submitButton.addEventListener('click', function() {
        // 実際の送信処理をここに実装
        // 例: fetch('/api/contact', { method: 'POST', body: new FormData(form) })
        
        // 確認モーダルを閉じる
        closeModal();
        
        // 送信完了モーダルを表示
        showThanksModal();
        
        // フォームをリセット
        form.reset();
    });

    // 送信完了モーダルの表示
    function showThanksModal() {
        const thanksModal = document.getElementById('thanks-modal');
        if (thanksModal) {
            thanksModal.classList.add('is-active');
            document.body.style.overflow = 'hidden';
        }
    }

    // 確認内容のHTML生成
    function generateConfirmHTML() {
        const formData = new FormData(form);
        let html = '<div class="inquiry-confirm__sections">';

        // 基本情報
        html += '<div class="inquiry-confirm__section">';
        html += '<h4 class="inquiry-confirm__section-title">基本情報</h4>';
        html += '<dl class="inquiry-confirm__list">';
        
        html += '<dt>お名前</dt>';
        html += '<dd>' + escapeHtml(formData.get('name') || '') + '</dd>';
        
        html += '<dt>ふりがな</dt>';
        html += '<dd>' + escapeHtml(formData.get('kana') || '') + '</dd>';
        
        html += '<dt>メールアドレス</dt>';
        html += '<dd>' + escapeHtml(formData.get('email') || '') + '</dd>';
        
        const tel = formData.get('tel');
        if (tel) {
            html += '<dt>電話番号</dt>';
            html += '<dd>' + escapeHtml(tel) + '</dd>';
        }
        
        html += '</dl>';
        html += '</div>';

        // お問い合わせ内容
        html += '<div class="inquiry-confirm__section">';
        html += '<h4 class="inquiry-confirm__section-title">お問い合わせ内容</h4>';
        html += '<dl class="inquiry-confirm__list">';
        
        html += '<dt>お問い合わせ種別</dt>';
        html += '<dd>';
        const types = formData.getAll('type[]');
        const typeLabels = {
            'reservation': '予約について',
            'service': 'サービス内容について',
            'estimate': '見積もり依頼',
            'other': '不明点・その他'
        };
        html += types.map(type => typeLabels[type] || type).join('、');
        html += '</dd>';
        
        html += '<dt>お問い合わせ内容</dt>';
        html += '<dd class="inquiry-confirm__message">' + escapeHtml(formData.get('message') || '').replace(/\n/g, '<br>') + '</dd>';
        
        html += '</dl>';
        html += '</div>';

        html += '</div>';
        return html;
    }

    // HTMLエスケープ
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});

