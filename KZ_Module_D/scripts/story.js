const COUNT_DURATION = 1600;

const renderStory = (copy) => {
    const eyebrow = document.querySelector('[data-story-eyebrow]');
    const heading = document.querySelector('[data-story-heading]');
    const body = document.querySelector('[data-story-body]');
    const list = document.querySelector('[data-story-stats]');

    if (eyebrow && copy.eyebrow) eyebrow.textContent = copy.eyebrow;
    if (heading && copy.heading) heading.textContent = copy.heading;
    if (body && copy.body) body.textContent = copy.body;

    if (!list || !Array.isArray(copy.stats)) return;

    list.innerHTML = '';

    copy.stats.forEach((stat) => {
        const item = document.createElement('div');
        item.className = 'story__stat';

        const value = document.createElement('dt');
        value.className = 'story__value';

        const number = document.createElement('span');
        number.dataset.countTo = String(stat.value);
        number.textContent = prefersReducedMotion() ? String(stat.value) : '0';

        value.append(number, document.createTextNode(stat.suffix || ''));

        const label = document.createElement('dd');
        label.className = 'story__label';
        label.textContent = stat.label;

        item.append(value, label);
        list.append(item);
    });

    observeCounters(list);
}

const observeCounters = (list) => {
    const numbers = Array.from(list.querySelectorAll('[data-count-to]'));

    if (!numbers.length) return;

    if (prefersReducedMotion()) {
        numbers.forEach((node) => {
            node.textContent = node.dataset.countTo;
        });

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                observer.unobserve(entry.target);
                numbers.forEach(countUp);
            });
        },
        {
            threshold: 0.4
        }
    );

    observer.observe(list);
}

const countUp = (node) => {
    const target = Number(node.dataset.countTo);

    if (!Number.isFinite(target)) return;

    const start = performance.now();

    const step = (now) => {
        const progress = Math.min((now - start) / COUNT_DURATION, 1);
        const eased = 1 - Math.pow(1 - progress, 3);

        node.textContent = String(Math.round(target * eased));

        if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
}
