import data from './data.json'

// states from json
export const book = data.book;
export const chapters = data.chapters;

// mapping sections
export const sections = chapters.flatMap((chapter) => {
    return chapter.sections.map((section, index) => ({
        ...section,
        chapterId: chapter.id,
        chapterNumber: chapter.number,
        chapterTitle: chapter.title,
        sectionNumber: index + 1,
        sectionsCount: chapter.sections.length
    }))
})

// minimize text to format "asdfadfasfd..."
export const minimizeText = (text, length = 160) => {
    return text.length > length ? `${text.slice(0, length)}...` : text;
}

// check matching text with query
export const matchText = (text, query) => {
    const position = text.toLowerCase().indexOf(query.toLowerCase());

    if (position < 0) return minimizeText(text);

    const start = Math.max(0, position - 60);

    return (start > 0 ? '...' : '') + minimizeText(text.slice(start), 200);
}