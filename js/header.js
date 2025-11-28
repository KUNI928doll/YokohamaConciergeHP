document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.header__toggle');
  const nav = document.querySelector('.header__nav--sp');
  const overlay = document.querySelector('.spmenu__overlay');
  const text = document.querySelector('.header__toggle-text');

  if (toggle && nav && overlay) {
    const toggleMenu = (open) => {
      toggle.classList.toggle('is-active', open);
      nav.classList.toggle('is-open', open);
      overlay.classList.toggle('is-active', open);
      document.body.style.overflow = open ? 'hidden' : '';
      if (text) text.textContent = open ? 'CLOSE' : 'MENU';
    };

    toggle.addEventListener('click', () => {
      const open = !nav.classList.contains('is-open');
      toggleMenu(open);
    });

    overlay.addEventListener('click', () => {
      toggleMenu(false);
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

  // デバッグ用
  console.log('Initializing inner-nav dropdown...');
  const innerNavButtons = document.querySelectorAll('.js-inner-dropdown');
  console.log('Found inner-nav buttons:', innerNavButtons.length);
  innerNavButtons.forEach((btn, index) => {
    console.log(`Button ${index}:`, btn);
    const item = btn.closest('.inner-nav__item--has-sub');
    console.log(`Item ${index}:`, item);
  });

  initDropdown('.js-inner-dropdown', '.inner-nav__item--has-sub');
});

