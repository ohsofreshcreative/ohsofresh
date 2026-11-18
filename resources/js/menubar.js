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

  const html = document.documentElement;
  let previousLanguage;

  const setLanguage = (language) => {
    if (language === previousLanguage) return;
    previousLanguage = language;

    targets.forEach((target) => {
      target.hidden = target.dataset.languageTarget === language;
    });
  };

  // Google Translate dodaje do <html> klasę translated-ltr/rtl tylko gdy strona jest przetłumaczona.
  // Cookie googtrans bywa zduplikowane (host + domena) i nieaktualne, więc jest tylko fallbackiem.
  const detectLanguage = () => {
    if (html.classList.contains('translated-ltr') || html.classList.contains('translated-rtl')) return 'en';
    if (previousLanguage !== undefined) return 'pl';

    const cookies = document.cookie.match(/(?:^|;\s*)googtrans=[^;]*/g) || [];
    return cookies.some((cookie) => /(?:\/|%2f)en$/i.test(cookie.trim())) ? 'en' : 'pl';
  };

  const syncLanguage = () => setLanguage(detectLanguage());

  targets.forEach((target) => {
    target.addEventListener('click', () => {
      setLanguage(target.dataset.languageTarget);
    });
  });

  new MutationObserver(syncLanguage).observe(html, { attributes: true, attributeFilter: ['class'] });
  syncLanguage();
  window.addEventListener('pageshow', syncLanguage);
});
