import {Link, useSearchParams} from "react-router-dom";
import {matchText, sections} from "../shared/lib.js";
import {HighlightText} from "../components/HighlightText.jsx";

/**
 * Page for show search result after input in header.
 * @returns {JSX.Element}
 * @constructor
 */
export const SearchPage = () => {
    const [searchParams] = useSearchParams();
    const query = searchParams.get('q') ? searchParams.get('q').trim() : '';

    const results = query ? sections.filter(section => section.heading.toLowerCase().includes(query.toLowerCase()) || section.content.toLowerCase().includes(query.toLowerCase())) : [];

    return (
        <div className={"container py-4"}>
            <h1 className={"h4"}>
                Search the textbook: "{query}"
            </h1>

            <p className={"text-body-secondary"}>
                {results.length} results found
            </p>

            {query && results.length === 0 && (
                <div className={"alert alert-warning"}>
                    <strong>
                        No results found.
                    </strong> Try another search query.
                </div>
            )}

            {results.length === 0 && (
                <Link to={'/'} className={"btn btn-primary"}>
                    Back To Library
                </Link>
            )}

            <div className={"list-group"}>
                {results.map((section) => (
                    <Link to={`/read/${section.id}?q=${encodeURIComponent(query)}`}
                        className={"list-group-item list-group-item-action"}
                    >
                        <h2 className={"h6 mb-1"}>
                            Chapter {section.chapterNumber} - Section {section.sectionNumber}. {section.heading}
                        </h2>

                        <p className={"small mb-1"}>
                            <HighlightText text={matchText(section.content, query)} query={query} />
                        </p>

                        <small className={"text-body-secondary"}>
                            Match found in the section text
                        </small>
                    </Link>
                ))}
            </div>
        </div>
    )
}