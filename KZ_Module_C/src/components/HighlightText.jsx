/**
 * Hightlight text in section.
 */
export const HighlightText = ({
    text,
    query
}) => {
    if (!query) return text;

    const safeQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const parts = text.split(new RegExp(`(${safeQuery})`, 'gi'));

    return parts.map((part, index) => {
        return part.toLowerCase() === query.toLowerCase() ? (
            <mark key={index}>
                {part}
            </mark>
        ) : part;
    })
}