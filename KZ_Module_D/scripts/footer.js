const SECTION_IDS = {
    Hotel: '#hotel',
    Rooms: '#rooms',
    Dining: '#dining',
    Wellness: '#wellness',
    Shanghai: '#shanghai',
};

const MESSAGES = {
    empty: 'Please enter your email address.',
    invalid: 'Please enter a valid email address.',
    success: 'Thank you. Shanghai stories are on their way.',
};

const isEmail = (value) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
}

const renderCopy = (copy) => {
    const address = document.querySelector('[data-footer-address]');
    const phone = document.querySelector('[data-footer-phone]');
    const email = document.querySelector('[data-footer-email]');
    const nav = document.querySelector('[data-footer-nav]');
    const social = document.querySelector('[data-footer-social]');

    if (address && copy.address) address.textContent = copy.address;

    if (phone && copy.phone) {
        phone.textContent = copy.phone;
        phone.href = `tel:${copy.phone.replace(/\s+/g, '')}`;
    }

    if (email && copy.email) {
        email.textContent = copy.email;
        email.href = `mailto:${copy.email}`;
    }

    if (nav && Array.isArray(copy.navigation)) {
        nav.innerHTML = '';

        copy.navigation.forEach((label) => {
            const item = document.createElement('li');
            const link = document.createElement('a');

            link.href = SECTION_IDS[label] || '#main';
            link.textContent = label;

            item.append(link);
            nav.append(item);
        });
    }

    if (social && Array.isArray(copy.social)) {
        social.innerHTML = '';

        copy.social.forEach((label) => {
            const item = document.createElement('li');
            item.textContent = label;
            social.append(item);
        });
    }
}

const renderYear = () => {
    const year = document.querySelector('[data-footer-year]');

    if (year) year.textContent = String(new Date().getFullYear());
}

const initNewsletter = () => {
    const form = document.querySelector('[data-newsletter]');

    if (!form) return;

    const input = form.querySelector('[data-newsletter-input]');
    const status = form.querySelector('[data-newsletter-status]');

    const report = (message, success) => {
        status.textContent = message;
        status.classList.toggle('is-error', !success);
        status.classList.toggle('is-success', success);

        if (success) {
            input.removeAttribute('aria-invalid');
        } else {
            input.setAttribute('aria-invalid', 'true');
            input.focus({
                preventScroll: true
            });
        }
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        const value = input.value.trim();

        if (!value) {
            report(MESSAGES.empty, false);
            return;
        }

        if (input.validity.typeMismatch || !isEmail(value)) {
            report(MESSAGES.invalid, false);
            return;
        }

        report(MESSAGES.success, true);
        form.reset();
    });

    input.addEventListener('input', () => {
        if (!status.textContent) return;

        status.textContent = '';
        status.classList.remove('is-error', 'is-success');
        input.removeAttribute('aria-invalid');
    });
}

const initFooter = (copy) => {
    renderCopy(copy);
    renderYear();
    initNewsletter();
}