import {Link} from "react-router-dom";

/**
 * Fallback page when page is invalid.
 * @returns {JSX.Element}
 * @constructor
 */
export const NotFoundPage = () => {
    return (
        <div className={"container py-5 text-center"}>
            <h1 className={"h4"}>
                404 - Page not found
            </h1>

            <p className={"text-body-secondary"}>
                The requested page not found.
            </p>

            <Link to={"/"} className={"btn btn-primary"}>
                Back To Library
            </Link>
        </div>
    )
}