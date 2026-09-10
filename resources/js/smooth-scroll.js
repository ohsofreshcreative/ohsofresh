export default function initSmoothScroll() {
  if (!window.gsap) return;

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
  const position = { y: window.scrollY };
  let target = position.y;
  let tween;
  let direction = 0;
  let lastScroll = position.y;

  const stop = () => {
    tween?.kill();
    tween = null;
    target = window.scrollY;
    position.y = target;
    direction = 0;
  };

  const isLocked = () => [document.body, document.documentElement].some((element) =>
    ['hidden', 'clip'].includes(getComputedStyle(element).overflowY)
  );

  const usesNativeScroll = (element) => {
    if (element.closest('input, textarea, select, [contenteditable], dialog[open]')) return true;

    // Przewijanie wewnątrz menu, popupów i innych kontenerów pozostaje natywne.
    for (let parent = element; parent && parent !== document.body; parent = parent.parentElement) {
      const style = getComputedStyle(parent);
      if (/(auto|scroll|overlay)/.test(style.overflowY) && parent.scrollHeight > parent.clientHeight) {
        return true;
      }
    }

    return false;
  };

  window.addEventListener('wheel', (event) => {
    if (event.defaultPrevented || !event.cancelable || event.ctrlKey || event.metaKey || event.shiftKey ||
        reducedMotion.matches || !event.deltaY || Math.abs(event.deltaX) > Math.abs(event.deltaY) ||
        !(event.target instanceof Element) || isLocked() || usesNativeScroll(event.target)) {
      stop();
      return;
    }

    const unit = event.deltaMode === 1 ? 16 : event.deltaMode === 2 ? window.innerHeight : 1;
    const delta = event.deltaY * unit;
    const nextDirection = Math.sign(delta);
    const maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);

    if (!tween || direction !== nextDirection) {
      target = window.scrollY;
    }

    target = Math.max(0, Math.min(maxScroll, target + delta));
    if (Math.abs(target - window.scrollY) < 1) {
      stop();
      return;
    }

    event.preventDefault();
    tween?.kill();
    direction = nextDirection;
    position.y = window.scrollY;
    lastScroll = window.scrollY;

    tween = window.gsap.to(position, {
      y: target,
      duration: 0.5,
      ease: 'power2.out',
      onUpdate: () => {
        if (isLocked() || Math.abs(window.scrollY - lastScroll) > 2) {
          stop();
          return;
        }

        window.scrollTo({ top: position.y, left: window.scrollX, behavior: 'instant' });
        lastScroll = window.scrollY;
      },
      onComplete: () => { tween = null; },
    });
  }, { passive: false });

  // Klawiatura, dotyk, kotwice i przeciąganie paska przerywają bezwładność.
  window.addEventListener('pointerdown', stop, { passive: true });
  window.addEventListener('touchstart', stop, { passive: true });
  window.addEventListener('keydown', stop);
  window.addEventListener('hashchange', stop);
  window.addEventListener('resize', stop, { passive: true });
  reducedMotion.addEventListener('change', stop);
}
