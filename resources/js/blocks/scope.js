document.querySelectorAll('.b-scope .js-scope').forEach((root) => {
  if (root.dataset.scopeReady === 'true') return;

  const navScroll = root.querySelector('.__nav-scroll');
  const tabs = Array.from(root.querySelectorAll('[role="tab"]'));
  const panels = Array.from(root.querySelectorAll('[role="tabpanel"]'));

  if (!tabs.length || tabs.length !== panels.length) return;

  root.dataset.scopeReady = 'true';

  let activeIndex = Math.max(
    0,
    tabs.findIndex((tab) => tab.classList.contains('is-active'))
  );

  const activate = (nextIndex, { focus = false, scroll = false } = {}) => {
    activeIndex = (nextIndex + tabs.length) % tabs.length;

    tabs.forEach((tab, index) => {
      const isActive = index === activeIndex;

      tab.classList.toggle('is-active', isActive);
      tab.setAttribute('aria-selected', String(isActive));
      tab.tabIndex = isActive ? 0 : -1;
      panels[index].hidden = !isActive;
    });

    const activeTab = tabs[activeIndex];

    if (focus) activeTab.focus();

    if (scroll && navScroll && navScroll.scrollWidth > navScroll.clientWidth) {
      activeTab.scrollIntoView({
        behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches
          ? 'auto'
          : 'smooth',
        block: 'nearest',
        inline: 'center',
      });
    }
  };

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => activate(index, { scroll: true }));

    tab.addEventListener('keydown', (event) => {
      let nextIndex = null;

      if (event.key === 'ArrowRight') nextIndex = activeIndex + 1;
      if (event.key === 'ArrowLeft') nextIndex = activeIndex - 1;
      if (event.key === 'Home') nextIndex = 0;
      if (event.key === 'End') nextIndex = tabs.length - 1;

      if (nextIndex === null) return;

      event.preventDefault();
      activate(nextIndex, { focus: true, scroll: true });
    });
  });
});
