const STORAGE_KEY = 'su-hotel-last-room';
const SWAP_DURATION = 260;

const formatPrice = (price) => {
    return `From CNY ${Number(price).toLocaleString('en-US')} / night`;
}

const pad = (value) => {
    return String(value).padStart(2, '0');
}

const restoreIndex = (rooms) => {
    let stored = null;

    try {
        stored = window.localStorage.getItem(STORAGE_KEY);
    } catch (error) {
        stored = null;
    }

    const position = rooms.findIndex((room) => room.id === stored);

    return position >= 0 ? position : 0;
}

const remember = (id) => {
    try {
        window.localStorage.setItem(STORAGE_KEY, id);
    } catch (error) {
        // handle
    }
}

const initRooms = (rooms, altText, onBookRoom) => {
    const card = document.querySelector('[data-rooms-card]');
    const tabs = document.querySelector('[data-room-tabs]');

    if (!card || !tabs || !rooms.length) return;

    const section = document.querySelector('#rooms');
    const image = card.querySelector('[data-room-image]');
    const index = card.querySelector('[data-room-index]');
    const name = card.querySelector('[data-room-name]');
    const description = card.querySelector('[data-room-description]');
    const meta = card.querySelector('[data-room-meta]');
    const price = card.querySelector('[data-room-price]');
    const amenities = card.querySelector('[data-room-amenities]');
    const details = card.querySelector('[data-room-details]');
    const panel = document.querySelector('#room-amenities');
    const bookButton = card.querySelector('[data-room-book]');
    const previous = document.querySelector('[data-room-prev]');
    const next = document.querySelector('[data-room-next]');

    card.id = 'rooms-panel';
    card.setAttribute('role', 'tabpanel');

    let current = restoreIndex(rooms);
    let swapping = false;

    const buildTabs = () => {
        tabs.innerHTML = '';

        rooms.forEach((room, position) => {
            const tab = document.createElement('button');

            tab.type = 'button';
            tab.className = 'rooms__tab';
            tab.textContent = room.name;
            tab.id = `room-tab-${room.id}`;
            tab.setAttribute('role', 'tab');
            tab.setAttribute('aria-selected', 'false');
            tab.setAttribute('aria-controls', 'rooms-panel');
            tab.tabIndex = -1;

            tab.addEventListener('click', () => select(position));

            tabs.append(tab);
        });
    }

    const paint = (room) => {
        image.src = mediaUrl(room.image);
        image.alt = altText[room.image.split('/').pop()] || room.name;

        index.textContent = `${pad(current + 1)} / ${pad(rooms.length)}`;
        name.textContent = room.name;
        description.textContent = room.description;
        price.textContent = formatPrice(room.price);

        meta.innerHTML = '';

        [
            ['Space', room.size],
            ['Guests', String(room.guests)],
            ['Bed', room.bed],
        ].forEach(([label, value]) => {
            const item = document.createElement('div');
            item.className = 'rooms__meta-item';

            const term = document.createElement('dt');
            term.className = 'rooms__meta-label';
            term.textContent = label;

            const detail = document.createElement('dd');
            detail.className = 'rooms__meta-value';
            detail.textContent = value;

            item.append(term, detail);
            meta.append(item);
        });

        amenities.innerHTML = '';

        room.amenities.forEach((amenity) => {
            const item = document.createElement('li');
            item.className = 'rooms__amenity';
            item.textContent = amenity;
            amenities.append(item);
        });

        bookButton.setAttribute(
            'aria-label',
            `Book this room — ${room.name}`
        );
    }

    const markTabs = () => {
        Array.from(tabs.children).forEach((tab, position) => {
            const isActive = position === current;

            tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
            tab.tabIndex = isActive ? 0 : -1;

            if (isActive && tabs.scrollWidth > tabs.clientWidth) {
                tabs.scrollTo({
                    left: tab.offsetLeft - tabs.offsetLeft,
                    behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                });
            }
        });

        card.setAttribute('aria-labelledby', `room-tab-${rooms[current].id}`);
    }

    const select = (position, options = {}) => {
        const total = rooms.length;
        const target = ((position % total) + total) % total;

        if (target === current || swapping) return;

        const forward = options.direction
            ? options.direction > 0
            : target > current;

        current = target;
        remember(rooms[current].id);

        if (prefersReducedMotion()) {
            paint(rooms[current]);
            markTabs();
            if (options.focusTab) focusTab();
            return;
        }

        swapping = true;
        card.style.setProperty('--swap-shift', forward ? '-18px' : '18px');
        card.classList.add('is-swapping');

        window.setTimeout(() => {
            paint(rooms[current]);
            markTabs();

            card.classList.add('is-instant');
            card.style.setProperty('--swap-shift', forward ? '18px' : '-18px');
            void card.offsetWidth;
            card.classList.remove('is-instant');
            card.classList.remove('is-swapping');

            swapping = false;

            if (options.focusTab) focusTab();
        }, SWAP_DURATION);
    }

    const focusTab = () => {
        const tab = tabs.children[current];

        if (tab) tab.focus({
            preventScroll: true
        });
    }

    buildTabs();
    paint(rooms[current]);
    markTabs();
    remember(rooms[current].id);

    previous.addEventListener('click', () =>
        select(current - 1, {
            direction: -1
        })
    );

    next.addEventListener('click', () => select(current + 1, {
        direction: 1
    }));


    section.addEventListener('keydown', (event) => {
        if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;

        const target = event.target;

        if (
            target instanceof HTMLElement &&
            ['INPUT', 'SELECT', 'TEXTAREA'].includes(target.tagName)
        ) {
            return;
        }

        event.preventDefault();

        const inTablist = target instanceof HTMLElement && target.closest('[data-room-tabs]');

        select(current + (event.key === 'ArrowRight' ? 1 : -1), {
            direction: event.key === 'ArrowRight' ? 1 : -1,
            focusTab: Boolean(inTablist),
        });
    });

    details.addEventListener('click', () => {
        const expanded = details.getAttribute('aria-expanded') === 'true';

        details.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        panel.hidden = expanded;
    });

    bookButton.addEventListener('click', () => {
        if (typeof onBookRoom === 'function') {
            onBookRoom(rooms[current].id);
        }
    });
}