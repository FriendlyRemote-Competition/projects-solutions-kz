const initHeader = () => {
    const header = document.querySelector('[data-header]');
    const hero = document.querySelector('#hero');
    const links = Array.from(document.querySelectorAll('.header__link'));

    if (!header) return;

    const updateBg = () => {
        const value = (hero ? hero.offsetHeight : window.innerHeight) * 0.2;

        header.classList.toggle('is-scrolled', window.scrollY > value);
    }

    updateBg();
    window.addEventListener('scroll', updateBg, {
        passive: true
    });
    window.addEventListener('resize', updateBg);

    const sections = links.map(link => document.querySelector(link.getAttribute('href'))).filter(Boolean);

    if (!sections.length) return;

    const owners = new Map(sections.map(section => [section, section.id]));

    if (hero && links.length) {
        owners.set(hero, links[0].getAttribute('href').slice(1));
        sections.unshift(hero);
    }

    const setActive = (id) => {
        links.forEach(link => {
            const isActive = link.getAttribute('href') === `#${id}`;

            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        })
    }

    const visible = new Set();

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                visible.add(entry.target)
            } else {
                visible.delete(entry.target);
            }
        });

        const current = sections.find(section => visible.has(section));

        if (current) setActive(owners.get(current));
    }, {
        rootMargin: '-45% 0px -45% 0px',
        threshold: 0
    })

    sections.forEach(section => observer.observe(section));

}
