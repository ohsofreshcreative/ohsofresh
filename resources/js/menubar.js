document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  let c, currentScrollTop = 0;
  const navbar = document.querySelector('.fixed-top');
  if (!navbar) return;

  window.addEventListener('scroll', function () {
    const a = window.scrollY;
    const b = navbar.offsetHeight;

    currentScrollTop = a;

    if (c < currentScrollTop && a > b) {
      navbar.classList.add('scrollUp');
      navbar.classList.remove('scrollTop');
    } else if (c > currentScrollTop && !(a <= b)) {
      navbar.classList.remove('scrollUp');
      navbar.classList.add('scrollDown');
      navbar.classList.remove('scrollTop');
    } else if (document.documentElement.scrollTop < 500) {
      navbar.classList.add('scrollTop');
      navbar.classList.remove('scrollUp', 'scrollDown');
    }

    c = currentScrollTop;
  });
});
/*--- Przełącznik języka GTranslate ---*/
document.addEventListener('DOMContentLoaded', function () {
  const targets = document.querySelectorAll('[data-language-target]');
  if (!targets.length) return;

  let previousLanguage;
  const syncLanguage = () => {
    const cookie = document.cookie.match(/(?:^|;\s*)googtrans=([^;]*)/);
    const language = cookie && /(?:\/|%2f)en$/i.test(cookie[1]) ? 'en' : 'pl';
    if (language === previousLanguage) return;
    previousLanguage = language;

    targets.forEach((target) => {
      target.hidden = target.dataset.languageTarget === language;
    });
  };

  // GTranslate zapisuje cookie asynchronicznie, bez przeładowania strony.
  syncLanguage();
  window.setInterval(() => {
    if (!document.hidden) syncLanguage();
  }, 300);
  window.addEventListener('pageshow', syncLanguage);
});
