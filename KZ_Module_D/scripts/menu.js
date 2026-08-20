const query = window.matchMedia('(prefers-reduced-motion: reduce)');

const prefersReducedMotion =() => {
    return query.matches;
}

const CLOSE_DELAY = 450;

const createModal = (dialog, options = {}) => {
    const { onOpen, onClose, initialFocus } = options;

    let timer = 0;

    function open() {
        window.clearTimeout(timer);

        if (dialog.open) {
            dialog.classList.add('is-open');
            return;
        }

        dialog.showModal();
        document.body.classList.add('is-locked');

        void dialog.offsetWidth;
        dialog.classList.add('is-open');

        if (typeof onOpen === 'function') onOpen();

        const target = typeof initialFocus === 'function' ? initialFocus() : null;

        if (target) target.focus({
            preventScroll: true
        });
    }

    function close() {
        if (!dialog.open) return;

        dialog.classList.remove('is-open');
        document.body.classList.remove('is-locked');

        window.clearTimeout(timer);
        timer = window.setTimeout(
            () => dialog.close(),
            prefersReducedMotion() ? 0 : CLOSE_DELAY
        );
    }

    dialog.addEventListener('cancel', (event) => {
        event.preventDefault(); /* Escape animates out instead of vanishing. */
        close();
    });

    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) close();
    });

    dialog.addEventListener('close', () => {
        dialog.classList.remove('is-open');

        if (!document.querySelector('dialog[open]')) {
            document.body.classList.remove('is-locked');
        }

        if (typeof onClose === 'function') onClose();
    });

    return {
        dialog,
        open,
        close
    };
}

const initMenu = () => {
    const dialog = document.querySelector('[data-menu]');
    const toggle = document.querySelector('[data-menu-open]');

    if (!dialog || !toggle) return null;

    const closeButton = dialog.querySelector('[data-menu-close]');

    const modal = createModal(dialog, {
        initialFocus: () => closeButton,
        onOpen: () => toggle.setAttribute('aria-expanded', 'true'),
        onClose: () => toggle.setAttribute('aria-expanded', 'false'),
    });

    toggle.addEventListener('click', () => modal.open());

    dialog
        .querySelectorAll('[data-menu-close], [data-menu-link]')
        .forEach((control) => {
            control.addEventListener('click', () => modal.close());
        });

    const desktop = window.matchMedia('(min-width: 861px)');

    desktop.addEventListener('change', (event) => {
        if (event.matches) modal.close();
    });

    return modal;
}