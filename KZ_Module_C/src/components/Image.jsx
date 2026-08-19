import {useState} from "react";

/**
 * Show image with fallback.
 * @param src
 * @param alt
 * @returns {JSX.Element}
 * @constructor
 */
export const Image = ({
    src,
    alt
}) => {
    const [isFailed, setIsFailed] = useState(false);

    if (isFailed)
    {
        return (
            <div className={"border rounded bg-body-tertiary text-body-secondary text-center p-5 my-4"}>
                Image is not available
            </div>
        )

    }

    return (
        <img
            className={"img-fluid rounded my-4"}
            src={`/${src}`}
            alt={alt}
            onError={() => setIsFailed(true)}
            />
    )
}