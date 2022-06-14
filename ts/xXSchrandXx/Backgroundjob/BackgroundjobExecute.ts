import * as Ajax from "WoltLabSuite/Core/Ajax";
import * as UiNotification from "WoltLabSuite/Core/Ui/Notification";
import * as Language from "WoltLabSuite/Core/Language";

export class BackgroundjobExecute {
    public constructor() {
        const elements = document.getElementsByClassName("backgroundjobExecuteButton");
        for (let i = 0; i < elements.length; i++) {
            const element = elements[i] as HTMLElement;
            element.addEventListener('click', (event: Event) => this._click(event));
        }
    }

    public _click(event: Event): void {
        event.preventDefault();

        var element = event['path'][3] as HTMLElement;
        var objectID = element.getAttribute('data-object-id') as string;

        Ajax.api({
            _ajaxSetup: () => {
                return {
                    data: {
                        actionName: "execute",
                        className: "wcf\\data\\backgroundjob\\BackgroundjobAction",
                        objectIDs: [objectID],
                    }
                };
            },
            _ajaxSuccess: () => {
                UiNotification.show(Language.get('wcf.global.success'), () => {
                    window.location.reload();
                });
                element.remove();
            }
        });
    }
}

export default BackgroundjobExecute;