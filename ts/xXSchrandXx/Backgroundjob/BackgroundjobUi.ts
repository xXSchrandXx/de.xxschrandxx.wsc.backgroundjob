import * as Ajax from "WoltLabSuite/Core/Ajax";
import { dialogFactory } from "WoltLabSuite/Core/Component/Dialog";
import { getPhrase } from "WoltLabSuite/Core/Language";
import * as UiNotification from "WoltLabSuite/Core/Ui/Notification";

class BackgroundjobExecute {
    public constructor() {
        document.querySelectorAll(".jsObjectActionObject").forEach((row: HTMLTableRowElement) => this.initRow(row));
    }

    public initRow(row: HTMLTableRowElement) {
        var executeButton = row.querySelector(".jsExecute") as HTMLButtonElement;
        if (executeButton != null) {
            executeButton.addEventListener("click", async (event: Event) => this.click("execute", event, row, executeButton));
        }

        var infoButton = row.querySelector(".jsInfo") as HTMLButtonElement;
        if (infoButton != null) {
            infoButton.addEventListener("click", async (event: Event) => this.click("info", event, row, infoButton));
        }
    }

    protected click(action: string, event: Event, row: HTMLTableRowElement, button: HTMLButtonElement): void {
        event.preventDefault();
        if (button.classList.contains("disabled")) {
            return;
        }
        button.classList.add("disabled");
        const objectID = ~~row.dataset.objectId!;

        Ajax.dboAction(action, "wcf\\data\\backgroundjob\\BackgroundjobAction")
            .objectIds([objectID])
            .dispatch()
            .then((value: unknown) => {
                switch (typeof value) {
                    case "string":
                        const dialog = dialogFactory()
                            .fromHtml(value)
                            .withoutControls();
                        dialog.show(getPhrase('wcf.acp.page.backgroundjobList.button.info.result'));
                        break;
                    default:
                        row.remove();
                        UiNotification.show();
                        break;
                }
            })
            .then(() => {
                button.classList.remove("disabled")
            }
        );
    }
}

export default BackgroundjobExecute;