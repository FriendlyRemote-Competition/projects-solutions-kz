import {book} from "../shared/lib.js";
import {Link, useNavigate} from "react-router-dom";
import {useState} from "react";
import {useData} from "../app/providers/data.provider.jsx";
import {Progressbar} from "./Progressbar.jsx";

/**
 * Header with search query and links to bookmarks and personnel settings.
 *
 * @returns {JSX.Element}
 * @constructor
 */
export const Header = () => {
    const {bookmarks, overallProgress} = useData()

    // state for save query
    const [query, setQuery] = useState('')

    const router = useNavigate();

    return (
        <header className="navbar navbar-expand-lg bg-body-tertiary">
            <div className="container">
                <Link className="navbar-brand" to="/">{book.title}</Link>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <div className="d-flex align-items-center gap-2" role="search">
                        <input className="form-control me-2" type="search" placeholder="Search..." aria-label="Search" onChange={(event) => {
                            setQuery(event.target.value)
                            router(`/search?q=${encodeURIComponent(event.target.value)}`)
                        }} />
                        <Link to={'/bookmarks'} className="btn btn-primary">Bookmarks</Link>
                        <button className="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">Aa</button>

                       <div className={'w-100'}>
                           <small className={"text-body-secondary w-100"}>
                               Overall progress: {overallProgress}%
                           </small>
                           <Progressbar percent={overallProgress} label={'Overall reading progress'} />
                       </div>
                    </div>
                </div>
            </div>
        </header>
    )
}