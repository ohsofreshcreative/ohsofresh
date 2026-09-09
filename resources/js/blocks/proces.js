document.querySelectorAll('.b-proces').forEach((section) => {
  const cards = Array.from(section.querySelectorAll('[data-process-card]'));

  if (!cards.length || section.dataset.procesReady === 'true') return;

  section.dataset.procesReady = 'true';
  let activeIndex = -1;

  const activate = (activeCard) => {
    activeIndex = cards.indexOf(activeCard);
    cards.forEach((card) => {
      const isActive = card === activeCard;
      const trigger = card.querySelector('[data-process-trigger]');
      const panel = card.querySelector('[data-process-panel]');

      card.classList.toggle('is-active', isActive);
      trigger?.setAttribute('aria-expanded', String(isActive));

      if (!panel) return;

      panel.setAttribute('aria-hidden', String(!isActive));

      if (isActive) {
        panel.removeAttribute('inert');
        panel.style.maxHeight = `${panel.firstElementChild.getBoundingClientRect().height}px`;
      } else {
        panel.setAttribute('inert', '');
        panel.style.maxHeight = '0px';
      }
    });
  };

  const activateOnScroll = () => {
    const activationLine = window.innerHeight * 0.72;
    let expandedHeight = 0;
    let nextIndex = activeIndex;

    // Odejmujemy wysokość paneli, żeby animacja nie przesuwała progów przełączania.
    cards.forEach((card, index) => {
      const top = card.getBoundingClientRect().top - expandedHeight;
      if (top <= activationLine - 32 && index > nextIndex) nextIndex = index;
      if (top > activationLine + 32 && index <= nextIndex) nextIndex = index - 1;
      expandedHeight += card.querySelector('[data-process-panel]')?.getBoundingClientRect().height || 0;
    });

    nextIndex = Math.max(0, nextIndex);
    if (nextIndex !== activeIndex) activate(cards[nextIndex]);
  };

  let frameRequested = false;
  const requestScrollUpdate = () => {
    if (frameRequested) return;
    frameRequested = true;
    window.requestAnimationFrame(() => {
      activateOnScroll();
      frameRequested = false;
    });
  };

  cards.forEach((card) => {
    const trigger = card.querySelector('[data-process-trigger]');

    trigger?.addEventListener('click', () => activate(card));
  });

  window.addEventListener('scroll', requestScrollUpdate, { passive: true });
  window.addEventListener('resize', () => {
    activate(cards.find((card) => card.classList.contains('is-active')) || cards[0]);
  });

  activate(cards[0]);
  requestScrollUpdate();
});
