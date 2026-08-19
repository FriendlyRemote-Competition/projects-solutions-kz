import {Outlet} from "react-router-dom";
import {DataProvider} from "./providers/data.provider.jsx";
import {book} from "../shared/lib.js";
import {Header} from "../components/Header.jsx";
import {SettingsModal} from "../components/SettingsModal.jsx";

/**
 * Main Layout.
 *
 * @returns {JSX.Element}
 * @constructor
 */
export const Layout = () => {
    return (
        <DataProvider>
            <div className={"d-flex flex-column vh-100"}>
                <Header />

                <main id={"main"}>
                    <Outlet />
                </main>

                <footer className={"border-top py-3"} style={{
                    marginTop: 'auto'
                }}>
                    <div className={"container text-body-secondary"}>
                        {book.title} - ${book.edition}
                    </div>
                </footer>

                <SettingsModal />
            </div>
        </DataProvider>
    )
}