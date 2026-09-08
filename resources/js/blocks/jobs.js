const jobsSections = document.querySelectorAll('.b-jobs');

jobsSections.forEach((section) => {
  const dialog = section.querySelector('[data-jobs-dialog]');
  const accordionButtons = section.querySelectorAll('.__summary');
  const openButtons = section.querySelectorAll('.js-jobs-open');
  const closeButton = section.querySelector('[data-jobs-close]');
  let activeTrigger = null;
  let previousBodyOverflow = '';

  accordionButtons.forEach((button) => {
    const panel = button.nextElementSibling;

    if (!panel) return;

    button.addEventListener('click', () => {
      const isOpen = button.getAttribute('aria-expanded') === 'true';

      button.setAttribute('aria-expanded', String(!isOpen));
      panel.setAttribute('aria-hidden', String(isOpen));
      panel.style.maxHeight = isOpen ? '0px' : `${panel.scrollHeight}px`;

      if (isOpen) {
        panel.setAttribute('inert', '');
      } else {
        panel.removeAttribute('inert');
      }
    });
  });

  window.addEventListener('resize', () => {
    accordionButtons.forEach((button) => {
      if (button.getAttribute('aria-expanded') !== 'true') return;

      const panel = button.nextElementSibling;
      if (panel) panel.style.maxHeight = `${panel.scrollHeight}px`;
    });
  });

  if (
    typeof HTMLDialogElement === 'undefined' ||
    !(dialog instanceof HTMLDialogElement) ||
    !closeButton
  ) {
    return;
  }

  openButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const jobTitleInput = dialog.querySelector('input[name="job-title"]');

      activeTrigger = button;

      if (jobTitleInput) {
        jobTitleInput.value = button.dataset.jobTitle || '';
        jobTitleInput.dispatchEvent(new Event('input', { bubbles: true }));
      }

      dialog.showModal();
      previousBodyOverflow = document.body.style.overflow;
      document.body.style.overflow = 'hidden';
    });
  });

  closeButton.addEventListener('click', () => dialog.close());

  dialog.addEventListener('click', (event) => {
    if (event.target === dialog) dialog.close();
  });

  dialog.addEventListener('close', () => {
    document.body.style.overflow = previousBodyOverflow;
    activeTrigger?.focus();
  });
});
