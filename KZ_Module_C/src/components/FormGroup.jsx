/**
 * Form control for personnel settings.
 */
export const FormGroup = ({
    legend,
    options,
    value,
    onChange
}) => {
    return (
        <fieldset className={"mb-4"}>
            <legend className={"fs-6 text-uppercase text-body-secondary"}>
                {legend}
            </legend>

            <div className={'btn-group w-100'}>
                {
                    options.map((option) => (
                        <button key={option.value} type={"button"} className={`btn btn-outline-primary ${option.value === value ? 'active' : ''}`}
                        aria-pressed={option.value === value} onClick={() => onChange(option.value)}>
                            {option.label}
                        </button>
                    ))
                }
            </div>
        </fieldset>
    )
}