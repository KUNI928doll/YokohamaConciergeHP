// 特徴ポップアップ機能（スライド式）
document.addEventListener('DOMContentLoaded', function() {
  const featureCircles = document.querySelectorAll('.features__circle');
  const modal = document.getElementById('featuresModal');
  const modalTitle = modal ? modal.querySelector('.features-modal__title') : null;
  const modalText = modal ? modal.querySelector('.features-modal__text') : null;
  const closeBtn = modal ? modal.querySelector('.features-modal__close') : null;
  const overlay = modal ? modal.querySelector('.features-modal__overlay') : null;
  const prevBtn = modal ? modal.querySelector('.features-modal__prev') : null;
  const nextBtn = modal ? modal.querySelector('.features-modal__next') : null;

  if (!modal) return;

  let currentFeatureId = 1;

  // 各特徴の詳細テキスト
  const featureDetails = {
    1: {
      title: 'ネットで簡単一括手配',
      text: '宿泊施設や飲食店、体験アクティビティなど、お客様のご希望に合わせて代わりに予約します。ネットで出ている場合、ネットに出ていない場合も対応可能です。ネットで簡単にスムーズに予約、ネットに出ていないショップでも可能な限り対応いたします。'
    },
    2: {
      title: '当日や緊急時も対応可能',
      text: '急な予定変更や当日の予約にも柔軟に対応します。5日以内の予約は緊急予約料金となりますが、可能な限りご要望にお応えいたします。まずはお気軽にご相談ください。旅先での緊急トラブルにも迅速に対応します。'
    },
    3: {
      title: '文化や色の希望に対応',
      text: '各国の文化や宗教、食事の制限などに配慮したサービスを提供します。ハラル対応、ベジタリアン対応など、お客様の個別のニーズに合わせて最適なプランをご提案いたします。横浜在住民だからこそできる、細やかな対応が可能です。'
    },
    4: {
      title: 'お得でシンプルな料金体系',
      text: '明確でわかりやすい料金設定。予約代行手数料は事前にお知らせし、追加料金なども事前に説明します。安心してご利用いただける透明性の高い料金体系です。各店舗での利用料金は現地にて事業者へ直接お支払いをお願いいたします。'
    }
  };

  // 特徴を表示
  function showFeature(featureId) {
    const detail = featureDetails[featureId];
    if (detail && modalTitle && modalText) {
      modalTitle.textContent = detail.title;
      modalText.textContent = detail.text;
      currentFeatureId = featureId;
    }
  }

  // 特徴をクリックしたらモーダルを開く
  featureCircles.forEach(circle => {
    circle.addEventListener('click', function() {
      const featureId = parseInt(this.getAttribute('data-feature'));
      showFeature(featureId);
      openModal();
    });
  });

  // 前へボタン
  if (prevBtn) {
    prevBtn.addEventListener('click', function() {
      currentFeatureId = currentFeatureId === 1 ? 4 : currentFeatureId - 1;
      showFeature(currentFeatureId);
    });
  }

  // 次へボタン
  if (nextBtn) {
    nextBtn.addEventListener('click', function() {
      currentFeatureId = currentFeatureId === 4 ? 1 : currentFeatureId + 1;
      showFeature(currentFeatureId);
    });
  }

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

  // 閉じるボタン
  if (closeBtn) {
    closeBtn.addEventListener('click', closeModal);
  }

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

