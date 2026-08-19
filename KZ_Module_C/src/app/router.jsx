import {createBrowserRouter} from "react-router-dom";
import {Layout} from "./layout.jsx";
import {LibraryPage} from "../pages/LibraryPage.jsx";
import {ReadPage} from "../pages/ReadPage.jsx";
import {NotFoundPage} from "../pages/NotFoundPage.jsx";
import {SearchPage} from "../pages/SearchPage.jsx";
import {BookmarksPage} from "../pages/BookmarksPage.jsx";

// browser routes
export const router = createBrowserRouter([
    {
        element: <Layout />,
        children: [
            {
                path: '/',
                element: <LibraryPage />
            },
            {
                path: '/read/:sectionId',
                element: <ReadPage />
            },
            {
                path: '*',
                element: <NotFoundPage />
            },
            {
                path: '/search',
                element: <SearchPage />
            },
            {
                path: '/bookmarks',
                element: <BookmarksPage />
            }
        ]
    }
])