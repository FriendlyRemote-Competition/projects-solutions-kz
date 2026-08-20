initHeader();

const MEDIA_ROOT = './assets/';

const mediaUrl = (relativePath) => {
    return MEDIA_ROOT + String(relativePath).replace(/^\/+/, '');
}

async function loadJson (relativePath) {
    const response = await fetch(mediaUrl(relativePath));

    if (!response.ok) {
        throw new Error(`Unable to load ${relativePath} (${response.status})`);
    }

    return response.json();
}


async function init() {
    const menu = initMenu();

    const [
        rooms,
        nearby,
        sampleMenu,
        altText,
        hotelCopy,
        diningCopy,
        footerCopy,
    ] = await Promise.all([
        loadJson('data/rooms.json'),
        loadJson('data/nearby.json'),
        loadJson('data/sample-menu.json'),
        loadJson('data/image-alt-text.json'),
        loadJson('content/hotel-copy.json'),
        loadJson('content/dining-copy.json'),
        loadJson('content/footer-copy.json'),
    ]);

    const applyAltText = (altText) => {
        document.querySelectorAll('[data-alt-key]').forEach((image) => {
            const description = altText[image.dataset.altKey];

            if (description) image.alt = description;
        });
    }

    applyAltText(altText);

    renderStory(hotelCopy);

    initRooms(rooms, altText, (roomId) => {});

    initFooter(footerCopy);
}

init()