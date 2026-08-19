import {useData} from "../app/providers/data.provider.jsx";
import {book, chapters, minimizeText} from "../shared/lib.js";
import {Link} from "react-router-dom";
import {Progressbar} from "../components/Progressbar.jsx";

/**
 * Book chapters.
 * @returns {JSX.Element}
 * @constructor
 */
export const LibraryPage = () => {
    const {chapterProgress} = useData()

    return (
        <div className={"container py-4"}>
            <h1 className={"h3"}>
                {book.title}
            </h1>

            <p>
                {book.subtitle} - {book.author}, {book.edition}
            </p>

            <div className={"list-group"}>
                {chapters.map((chapter) => {
                    const percent = chapterProgress(chapter);

                    return (
                        <Link to={`/read/${chapter.sections[0].id}`}
                            key={chapter.id}
                              className={"list-group-item list-group-item-action py-3"}
                        >
                            <div className={"d-flex justify-content-between gap-3 mb-2"}>
                                <h2 className={"h5"}>
                                    Chapter {chapter.number}. {chapter.title}
                                </h2>

                                <span className={`badge align-self-start ${percent === 100 ? 'text-bg-success' : percent > 0 ? 'text-bg-warning' : 'text-bg-secondary'}`}>
                                    {percent === 100 ? 'Completed' : percent > 0 ? `${percent}% read` : 'Not started'}
                                </span>
                            </div>

                            <Progressbar
                                percent={percent}
                                label={`Progress of chapter ${chapter.number}`}
                            />

                            <p className={"small text-body-secondary mb-2"}>
                                {minimizeText(chapter.sections[0].content, 120)} - {chapter.sections.length} sections
                            </p>
                        </Link>
                    )
                })}
            </div>
        </div>
    )
}