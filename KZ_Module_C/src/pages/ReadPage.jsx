import {Link, useParams, useSearchParams} from "react-router-dom";
import {useData} from "../app/providers/data.provider.jsx";
import {chapters, sections} from "../shared/lib.js";
import {useEffect} from "react";
import {Progressbar} from "../components/Progressbar.jsx";
import {HighlightText} from "../components/HighlightText.jsx";
import {Image} from "../components/Image.jsx";

/**
 * Page for reading chapter with sections.
 * @returns {JSX.Element}
 * @constructor
 */
export const ReadPage = () => {
    const {sectionId} = useParams();

    const [searchParams] = useSearchParams()

    const query = searchParams.get('q') || '';

    const {isBookmarked, toggleBookmark, markVisited, chapterProgress, isVisited} = useData();

    const section = sections.find(section => section.id === sectionId);

    useEffect(() => {
        if (section) markVisited(section.id);

        window.scrollTo(0, 0);
    }, [sectionId]);

    if (!section) {
        return (
            <div className={"py-5 text-center container"}>
                <h1 className={"h4"}>
                    Section not found
                </h1>

                <Link to={"/"} className={"btn btn-primary"}>
                    Back To Library
                </Link>
            </div>
        )
    }

    const chapter = chapters.find(chapter => chapter.id === section.chapterId);
    const index = sections.findIndex((item) => item.id === section.id);
    const prev = sections[index - 1];
    const next = sections[index + 1];

    return (
        <div className={"container py-4"}>
            <nav className={"d-flex align-items-center gap-3 mb-1"} aria-label={"Reading position"}>
                <Link to={"/"}
                      className={"btn btn-secondary"}>
                    Library
                </Link>

                <strong className={"text-center w-100"}>
                    Chapter {section.chapterNumber} - Section {section.sectionNumber} of {section.sectionsCount}
                </strong>
            </nav>

            <div className={"ms-auto d-flex flex-column gap-2"} style={{
                minWidth: 160
            }}>
                <small className={"text-body-secondary text-end"}>
                    Chapter progress: {chapterProgress(chapter)}%
                </small>

                <Progressbar
                    percent={chapterProgress(chapter)}
                    label={"Chapter reading progress"}
                />
            </div>

            <div className={"row g-4 mt-4"}>
                <nav className={"col-12 col-md-4 col-lg-3"} aria-label={"Table of contents"}>
                    <h2 className={"fs-6 text-uppercase text-body-secondary"}>
                        table of contents
                    </h2>

                    <ol className={"list-unstyled"}>
                        {chapter.sections.map((item, index) => (
                            <li key={item.id}>
                                <Link to={`/read/${item.id}`} aria-current={item.id === section.id ? 'page' : undefined}
                                className={`d-flex gap-2 px-2 py-1 rounded text-decoration-none ${item.id === section.id ? 'bg-primary text-white' : ''}`}>
                                    <span>
                                        {index + 1}.
                                    </span>
                                    <span>
                                        {item.heading} {isVisited(item.id) && '- Completed'}
                                    </span>
                                </Link>
                            </li>
                        ))}
                    </ol>
                </nav>

                <article className={"col reader"} style={{
                    maxWidth: 'var(--reader-width)'
                }}>
                    <h1>
                        {section.heading}
                    </h1>

                    <button className={"bookmark-star btn btn-primary"} type={"button"} aria-pressed={isBookmarked(section.id)}
                            aria-label={isBookmarked(section.id) ? 'Remove bookmark' : 'Add bookmark'}
                            title={isBookmarked(section.id) ? 'Remove bookmark' : 'Add bookmark'}
                            onClick={() => toggleBookmark(section.id)}>
                        {isBookmarked(section.id) ? 'Unbookmark' : 'Bookmark'}
                    </button>

                    <div className={"paragraph d-flex gap-2"}>
                        <p>
                            <HighlightText text={section.content} query={query} />
                        </p>
                    </div>

                    {section.image && (
                        <Image src={section.image} alt={section.imageAlt} />
                    )}

                    <p className={"d-flex flex-wrap gap-2"}>
                        {section.keyTerms.map(term => (
                            <span key={term} className={"badge text-bg-light border"}>
                                {term}
                            </span>
                        ))}
                    </p>
                </article>
            </div>

            <nav className={"d-flex justify-content-between mt-4"}
                 aria-label={"Section navigation"}>
                {prev ? (
                    <Link to={`/read/${prev.id}`}
                          className={"btn btn-primary"}>
                        Previous section
                    </Link>
                ) : (
                    <span></span>
                )}

                {next && (
                    <Link to={`/read/${next.id}`}
                          className={"btn btn-primary"}>
                        Next section
                    </Link>
                )}
            </nav>
        </div>
    )
}