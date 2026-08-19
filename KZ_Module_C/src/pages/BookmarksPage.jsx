import {useData} from "../app/providers/data.provider.jsx";
import {minimizeText, sections} from "../shared/lib.js";
import {Link} from "react-router-dom";

/**
 * Page with saved bookmarks.
 * @returns {JSX.Element}
 * @constructor
 */
export const BookmarksPage = () => {
    const {bookmarks, toggleBookmark} = useData()

    return (
        <div className={"container py-4"}>
            <h1 className={"h4 mb-4"}>
                My bookmarks ({bookmarks.length})
            </h1>

            {bookmarks.length === 0 && (
                <div className={"alert alert-info"}>
                    <strong>
                        You don't have any bookmarks yet.
                    </strong> Open section and click "Bookmark" button and back to here again.
                </div>
            )}

            <div className={"list-group"}>
                {bookmarks.map(sectionId => {
                    const section = sections.find(s => s.id === sectionId);
                    if (!section) return null;

                    return (
                        <div key={section.id} className={"list-group-item d-flex flex-wrap justify-content-between gap-3"}>
                            <div>
                                <h2 className={"h6 mb-1"}>
                                    Chapter {section.chapterNumber} - Section {section.sectionNumber}. {section.heading}
                                </h2>

                                <p className={"small text-body-secondary mb-0"}>
                                    "{minimizeText(section.content, 120)}"
                                </p>
                            </div>

                            <div className={"d-flex align-items-start gap-2"}>
                                <Link to={`/read/${section.id}`} className={"btn btn-primary"}>
                                    Go to
                                </Link>

                                <button className={"btn btn-danger"} type={"button"}
                                    onClick={() => toggleBookmark(section.id)}
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    )
                })}
            </div>
        </div>
    )
}