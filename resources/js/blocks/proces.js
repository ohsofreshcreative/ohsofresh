document.querySelectorAll('.b-proces').forEach((section) => {
  const cardsContainer = section.querySelector('.__cards');
  const cards = Array.from(section.querySelectorAll('[data-process-card]'));

  if (!cardsContainer || !cards.length || section.dataset.procesReady === 'true') return;

  section.dataset.procesReady = 'true';

  const activate = (activeCard) => {
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
        panel.style.maxHeight = `${panel.scrollHeight}px`;
      } else {
        panel.setAttribute('inert', '');
        panel.style.maxHeight = '0px';
      }
    });
  };

  const activateNearestCard = () => {
    const containerRect = cardsContainer.getBoundingClientRect();
    const viewportHeight = window.innerHeight;

    if (containerRect.top > viewportHeight * 0.85 || containerRect.bottom < viewportHeight * 0.15) {
      return;
    }

    const activationLine = viewportHeight * 0.72;
    let activeCard = cards[0];

    cards.forEach((card) => {
      const trigger = card.querySelector('[data-process-trigger]');
      const triggerTop = trigger?.getBoundingClientRect().top ?? card.getBoundingClientRect().top;

      if (triggerTop <= activationLine) activeCard = card;
    });

    activate(activeCard);
  };

  let frameRequested = false;

  const requestScrollUpdate = () => {
    if (frameRequested) return;

    frameRequested = true;
    window.requestAnimationFrame(() => {
      activateNearestCard();
      frameRequested = false;
    });
  };

  cards.forEach((card) => {
    const trigger = card.querySelector('[data-process-trigger]');

    trigger?.addEventListener('click', () => activate(card));
    trigger?.addEventListener('focus', () => activate(card));
  });

  window.addEventListener('scroll', requestScrollUpdate, { passive: true });
  window.addEventListener('resize', () => {
    activate(cards.find((card) => card.classList.contains('is-active')) || cards[0]);
    requestScrollUpdate();
  });

  activate(cards[0]);
  requestScrollUpdate();
});
