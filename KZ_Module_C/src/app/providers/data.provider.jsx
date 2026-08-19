import {createContext, useContext, useEffect, useState} from "react";
import {sections} from "../../shared/lib.js";

// context for store book data
export const DataContext = createContext()

// hook for use context
export const useData = () => useContext(DataContext)

/**
 * States and actions for context.
 */
export const DataProvider = ({
    children
}) => {
    // states for book
    const [settings, setSettings] = useState(() => {
        const value = localStorage.getItem('settings');
        return value ? JSON.parse(value) : {
            theme: 'light',
            fontSize: 18,
            lineHeight: 1.7,
            width: 720
        }
    })
    const [bookmarks, setBookmarks] = useState(() => {
        const value = localStorage.getItem('bookmarks');
        return value ? JSON.parse(value) : [];
    })
    const [visited, setVisited] = useState(() => {
        const value = localStorage.getItem('visited');
        return value ? JSON.parse(value) : [];
    })

    // persist in local storage
    useEffect(() => {
        localStorage.setItem('settings', JSON.stringify(settings))
    }, [settings])
    useEffect(() => {
        localStorage.setItem('bookmarks', JSON.stringify(bookmarks))
    }, [bookmarks])
    useEffect(() => {
        localStorage.setItem('visited', JSON.stringify(visited))
    }, [visited])

    /**
     * Retrieve chapter progress
     */
    const chapterProgress = (chapter) => {
        const read = chapter.sections.filter(section => {
            return visited.includes(section.id);
        }).length;

        return Math.round((read / chapter.sections.length) * 100);
    }

    // check bookmark for section
    const isBookmarked = (sectionId) => bookmarks.includes(sectionId);

    // change bookmark for section by id
    const toggleBookmark = (sectionId) => setBookmarks((prevValue) => {
        return isBookmarked(sectionId) ? prevValue.filter(id => id !== sectionId) : [...prevValue, sectionId]
    });


    // mark section visited
    const markVisited = (sectionId) => {
        setVisited((prevValue) => prevValue.includes(sectionId) ? prevValue : [...prevValue, sectionId]);
    }

    // calc overall progress
    const overallProgress = Math.round((visited.length / sections.length) * 100);

    // reset reading progress
    const resetProgress = () => setVisited([]);

    // check visited section or not
    const isVisited = (sectionId) => visited.includes(sectionId);

    // change setting by key and value
    const changeSetting = (key, value) => setSettings(prevVal => ({
        ...prevVal,
        [key]: value
    }))

    // change personnel settings
    useEffect(() => {
        const root = document.documentElement;
        root.dataset.bsTheme = settings.theme;

        root.style.setProperty('--reader-font-size', `${settings.fontSize}px`);
        root.style.setProperty('--reader-line-height', settings.lineHeight);
        root.style.setProperty('--reader-width', `${settings.width}px`);
    }, [settings]);

    return (
        <DataContext.Provider value={{
            settings,
            bookmarks,
            chapterProgress,
            isBookmarked,
            toggleBookmark,
            markVisited,
            overallProgress,
            resetProgress,
            isVisited,
            changeSetting
        }}>
            {children}
        </DataContext.Provider>
    )
}