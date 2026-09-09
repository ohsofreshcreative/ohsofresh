import $ from 'jquery';

$(document).ready(function () {
  'use strict';

  let c, currentScrollTop = 0;
  const navbar = $('.fixed-top');

  $(window).on('scroll', function () {
    const a = $(window).scrollTop();
    const b = navbar.height();

    currentScrollTop = a;

    if (c < currentScrollTop && a > b) {
      navbar.addClass('scrollUp').removeClass('scrollTop');
    } else if (c > currentScrollTop && !(a <= b)) {
      navbar.removeClass('scrollUp').addClass('scrollDown').removeClass('scrollTop');
    } else if ($(document).scrollTop() < 500) {
      navbar.addClass('scrollTop').removeClass('scrollUp scrollDown');
    }

    c = currentScrollTop;
  });
});
/*--- Przełącznik języka GTranslate ---*/
$(document).ready(function () {
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
