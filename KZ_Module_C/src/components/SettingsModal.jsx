import {useData} from "../app/providers/data.provider.jsx";
import {FormGroup} from "./FormGroup.jsx";

const FONT_SIZES = [
    {
        label: 'A-',
        value: 16
    },
    {
        label: 'A',
        value: 18,
    },
    {
        label: 'A+',
        value: 22
    }
]

const THEMES = [
    {
        label: 'Light',
        value: 'light'
    },
    {
        label: 'Dark',
        value: 'dark'
    }
]

const LINE_HEIGHTS = [
    {
        label: 'Compact',
        value: 1.4
    },
    {
        label: 'Normal',
        value: 1.7
    },
    {
        label: 'Wide',
        value: 2.1
    }
]

const WIDTHS = [
    {
        label: 'Basic',
        value: 560
    },
    {
        label: 'Medium',
        value: 720
    },
    {
        label: 'Full',
        value: 960
    },
]

/**
 * Settings Offcanvas with personnel settings.
 * @returns {JSX.Element}
 * @constructor
 */
export const SettingsModal = () => {
    const { resetProgress, settings, changeSetting } = useData()

    return (

        <div className="offcanvas offcanvas-end" tabIndex="-1" id="offcanvasExample"
             aria-labelledby="offcanvasExampleLabel">
            <div className="offcanvas-header">
                <h5 className="offcanvas-title" id="offcanvasExampleLabel">Reading settings</h5>
                <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div className="offcanvas-body">
                <FormGroup legend={"Font Size"} options={FONT_SIZES} value={settings.fontSize} onChange={(value) => changeSetting('fontSize', value)} />

                <FormGroup legend={'Colour Theme'} options={THEMES} value={settings.theme} onChange={(value) => changeSetting('theme', value)} />

                <FormGroup legend={'Line Spacing'} options={LINE_HEIGHTS} value={settings.lineHeight} onChange={(value) => changeSetting('lineHeight', value)} />

                <FormGroup legend={'Text Width'} options={WIDTHS} value={settings.width} onChange={(value) => changeSetting('width', value)} />

                <button className={"btn btn-danger w-100"} onClick={resetProgress}>
                    Reset reading process
                </button>
            </div>
        </div>
    )
}