/**
 * Progress Bar
 * @param percent
 * @param label
 * @returns {JSX.Element}
 * @constructor
 */
export const Progressbar = ({
    percent,
    label
}) => {
    return (
        <div
            className={"progress"}
            style={{
                height: 8
            }}
            role={"progressbar"}
            aria-label={label}
            aria-valuenow={percent}
            aria-valuemin={0}
            aria-valuemax={100}
        >
            <div className={"progress-bar"}
                 style={{
                     width: `${percent}%`
                 }}>

            </div>
        </div>
    )
}