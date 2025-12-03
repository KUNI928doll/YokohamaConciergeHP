document.addEventListener('DOMContentLoaded', () => {
  const buttons = document.querySelectorAll('.guide-spots__nav-btn');
  const maps = document.querySelectorAll('.yokohama-area__map');
  const mapLinks = document.querySelectorAll('.guide-spots__map-link');
  const areaSection = document.getElementById('yokohama-area');

  // URLハッシュに基づいてタブを切り替える関数
  const activateTabFromHash = () => {
    const hash = window.location.hash.substring(1); // #を除去
    if (hash && hash.startsWith('map-')) {
      const targetMap = document.getElementById(hash);
      if (targetMap) {
        // 地図表示切り替え
        maps.forEach(map => map.classList.remove('is-active'));
        targetMap.classList.add('is-active');

        // ボタンのアクティブ切り替え
        buttons.forEach(btn => {
          btn.classList.toggle('is-active', btn.dataset.target === hash);
        });

        // スクロール
        if (areaSection) {
          setTimeout(() => {
            areaSection.scrollIntoView({ behavior: 'smooth' });
          }, 100);
        }
      }
    }
  };

  // ページ読み込み時にハッシュをチェック
  activateTabFromHash();

  // ハッシュ変更時にも対応
  window.addEventListener('hashchange', activateTabFromHash);

  // ① 地図ボタンの切り替え
  buttons.forEach(button => {
    button.addEventListener('click', () => {
      const targetId = button.dataset.target;

      // ボタンのアクティブ切り替え
      buttons.forEach(btn => btn.classList.remove('is-active'));
      button.classList.add('is-active');

      // 地図の表示切り替え
      maps.forEach(map => {
        map.classList.toggle('is-active', map.id === targetId);
      });
    });
  });

  // ② タブ内「MAPへ」ボタンクリック処理
  mapLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();

      const targetId = link.getAttribute('data-target');
      const targetMap = document.getElementById(targetId);

      if (!targetMap || !areaSection) return;

      // 地図表示切り替え
      maps.forEach(panel => panel.classList.remove('is-active'));
      targetMap.classList.add('is-active');

      // ボタンのアクティブ切り替えも行う（必要なら）
      buttons.forEach(btn => {
        const btnTarget = btn.dataset.target;
        btn.classList.toggle('is-active', btnTarget === targetId);
      });

      // スクロール
      areaSection.scrollIntoView({ behavior: 'smooth' });
    });
  });
});




// タブの見出し（tab-item）を取得
const tabItems = document.querySelectorAll(".tab-item");

tabItems.forEach((tabItem) => {
  tabItem.addEventListener("click", () => {
    // すべてのタブを非アクティブにする
    tabItems.forEach((t) => {
      t.classList.remove("active");
    });
    // すべてのコンテンツを非表示にする
    const tabPanels = document.querySelectorAll(".tab-panel");
    tabPanels.forEach((tabPanel) => {
      tabPanel.classList.remove("active");
    });

    // クリックされたタブをアクティブにする
    tabItem.classList.add("active");

    // 対応するコンテンツを表示
    const tabIndex = Array.from(tabItems).indexOf(tabItem);
    tabPanels[tabIndex].classList.add("active");
  });
});