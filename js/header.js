"use strict";

document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.header__toggle');
  const nav = document.querySelector('.header__nav--sp');
  const overlay = document.querySelector('.spmenu__overlay');

  if (toggle && nav && overlay) {
    const toggleMenu = (open) => {
      toggle.classList.toggle('is-active', open);
      nav.classList.toggle('is-open', open);
      overlay.classList.toggle('is-active', open);
      document.body.classList.toggle('spmenu-open', open);
      document.body.style.overflow = open ? 'hidden' : '';
    };

    toggle.addEventListener('click', () => {
      const open = !nav.classList.contains('is-open');
      toggleMenu(open);
    });

    overlay.addEventListener('click', () => {
      toggleMenu(false);
    });

    // SPメニュー内のCLOSEボタン
    const closeBtn = document.querySelector('.js-spmenu-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        toggleMenu(false);
      });
    }

    // 画面幅変更時にオーバーレイだけ残ってクリックを奪うことがあるため、
    // ハンバーガーが非表示になる幅では強制的にメニューを閉じる
    window.addEventListener('resize', () => {
      const toggleDisplay = window.getComputedStyle(toggle).display;
      if (toggleDisplay === 'none' && nav.classList.contains('is-open')) {
        toggleMenu(false);
      }
    });
  }

  const initDropdown = (buttonSelector, itemSelector) => {
    const buttons = document.querySelectorAll(buttonSelector);
    if (!buttons.length) return;

    const closeAll = () => {
      buttons.forEach((btn) => {
        const item = btn.closest(itemSelector);
        if (item) {
          item.classList.remove('is-open');
          btn.setAttribute('aria-expanded', 'false');
        }
      });
    };

    buttons.forEach((btn) => {
      const item = btn.closest(itemSelector);
      if (!item) return;

      btn.addEventListener('click', (event) => {
        event.stopPropagation();
        const isOpen = item.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', String(isOpen));

        buttons.forEach((otherBtn) => {
          if (otherBtn === btn) return;
          const otherItem = otherBtn.closest(itemSelector);
          otherItem?.classList.remove('is-open');
          otherBtn.setAttribute('aria-expanded', 'false');
        });
      });

      item.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
          item.classList.remove('is-open');
          btn.setAttribute('aria-expanded', 'false');
        });
      });
    });

    document.addEventListener('click', (event) => {
      if (!(event.target instanceof Element)) return;
      if (!event.target.closest(itemSelector)) {
        closeAll();
      }
    });

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeAll();
      }
    });
  };

  initDropdown('.js-pyoko-dropdown', '.header-pyoko__item--has-sub');
  initDropdown('.js-footer-dropdown', '.footer__item--has-sub');
  initDropdown('.js-spmenu-dropdown', '.spmenu__item--has-sub');

  initDropdown('.js-inner-dropdown', '.inner-nav__item--has-sub');

  // SP用の多言語切り替えボタン
  const spLanguageToggle = document.querySelector('.spmenu .spmenu__top .header__language-wrapper.lang-switch') || 
                            document.querySelector('.spmenu .header__language-wrapper.lang-switch');
  if (spLanguageToggle) {
    // 言語切り替えボタン全体のクリック処理
    spLanguageToggle.addEventListener('click', (event) => {
      // 言語リンク自体のクリックは通常通り動作させる
      if (event.target.closest('a')) {
        // リンクのクリックは通常通り動作させる（preventDefaultしない）
        return;
      }
      
      // ボタン部分のクリックのみ処理
      event.stopPropagation();
      event.preventDefault();
      spLanguageToggle.classList.toggle('is-open');
    });

    // 外側をクリックしたら閉じる
    document.addEventListener('click', (event) => {
      if (!(event.target instanceof Element)) return;
      if (!event.target.closest('.spmenu .spmenu__top .header__language-wrapper.lang-switch') && 
          !event.target.closest('.spmenu .header__language-wrapper.lang-switch')) {
        spLanguageToggle.classList.remove('is-open');
      }
    });

    // 言語リンクをクリックしたら閉じる（リンクの動作は妨げない）
    spLanguageToggle.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', (event) => {
        // リンクの通常の動作は妨げない
        spLanguageToggle.classList.remove('is-open');
        // リンクの遷移は通常通り実行される
      });
    });
  }

  // PC版・タブレット版の多言語切り替えボタン（ヘッダー内、SPメニュー外）
  const allLanguageToggles = document.querySelectorAll('.header__language-wrapper.lang-switch');
  allLanguageToggles.forEach((languageToggle) => {
    // SPメニュー内のものは既に処理済みなのでスキップ
    if (languageToggle.closest('.spmenu')) {
      return;
    }

    // クリック/タッチで言語リストを表示
    languageToggle.addEventListener('click', (event) => {
      // 言語リンク自体のクリックは通常通り動作させる
      if (event.target.closest('a')) {
        return;
      }
      event.stopPropagation();
      event.preventDefault();
      languageToggle.classList.toggle('is-open');
    });

    // 外側をクリックしたら閉じる
    document.addEventListener('click', (event) => {
      if (!(event.target instanceof Element)) return;
      if (!event.target.closest('.header__language-wrapper.lang-switch')) {
        languageToggle.classList.remove('is-open');
      }
    });

    // 言語リンクをクリックしたら閉じる
    languageToggle.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        languageToggle.classList.remove('is-open');
      });
    });
  });
});

