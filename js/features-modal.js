// 特徴ポップアップ機能（スライド式）
document.addEventListener('DOMContentLoaded', function() {
  const featureCircles = document.querySelectorAll('.features__circle');
  const modal = document.getElementById('featuresModal');
  const modalContents = modal ? modal.querySelectorAll('.features-modal__content') : [];
  const overlay = modal ? modal.querySelector('.features-modal__overlay') : null;
  const labelText = modal ? modal.querySelector('.features-modal__label-text') : null;

  if (!modal) return;

  let currentFeatureId = 1;

  // 各特徴のラベルテキスト
  const labelTexts = {
    1: 'ラクラク！',
    2: 'スピーディー！',
    3: '安心！',
    4: 'わかりやすい！'
  };

  // 特徴を表示（HTMLに記述された各コンテンツを切り替え）
  function showFeature(featureId) {
    modalContents.forEach(content => {
      const contentFeatureId = parseInt(content.getAttribute('data-feature'));
      if (contentFeatureId === featureId) {
        content.style.display = 'flex';
      } else {
        content.style.display = 'none';
      }
    });
    
    // ラベルテキストを更新
    if (labelText) {
      labelText.textContent = labelTexts[featureId];
    }
    
    currentFeatureId = featureId;
  }

  // 特徴をクリックしたらモーダルを開く
  featureCircles.forEach(circle => {
    circle.addEventListener('click', function() {
      const featureId = parseInt(this.getAttribute('data-feature'));
      showFeature(featureId);
      openModal();
    });
  });

  // 前へ・次へボタンのイベント設定
  modalContents.forEach(content => {
    const prevBtn = content.querySelector('.features-modal__prev');
    const nextBtn = content.querySelector('.features-modal__next');
    
    if (prevBtn) {
      prevBtn.addEventListener('click', function() {
        currentFeatureId = currentFeatureId === 1 ? 4 : currentFeatureId - 1;
        showFeature(currentFeatureId);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function() {
        currentFeatureId = currentFeatureId === 4 ? 1 : currentFeatureId + 1;
        showFeature(currentFeatureId);
      });
    }
  });

  // モーダルを開く
  function openModal() {
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
      modal.classList.add('is-active');
    }, 10);
  }

  // モーダルを閉じる
  function closeModal() {
    modal.classList.remove('is-active');
    
    setTimeout(() => {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }, 300);
  }

  // 閉じるボタンのイベント設定
  modalContents.forEach(content => {
    const closeBtn = content.querySelector('.features-modal__close');
    if (closeBtn) {
      closeBtn.addEventListener('click', closeModal);
    }
  });

  // オーバーレイをクリック
  if (overlay) {
    overlay.addEventListener('click', closeModal);
  }

  // ESCキーで閉じる
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modal.classList.contains('is-active')) {
      closeModal();
    }
  });

  // 矢印キーでスライド
  document.addEventListener('keydown', function(e) {
    if (!modal.classList.contains('is-active')) return;
    
    if (e.key === 'ArrowLeft') {
      currentFeatureId = currentFeatureId === 1 ? 4 : currentFeatureId - 1;
      showFeature(currentFeatureId);
    } else if (e.key === 'ArrowRight') {
      currentFeatureId = currentFeatureId === 4 ? 1 : currentFeatureId + 1;
      showFeature(currentFeatureId);
    }
  });
});

