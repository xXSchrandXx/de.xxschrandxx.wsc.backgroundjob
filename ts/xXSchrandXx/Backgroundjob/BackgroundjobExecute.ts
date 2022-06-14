import { DatabaseObjectActionResponse } from "WoltLabSuite/Core/Ajax/Data";
import * as Ajax from "WoltLabSuite/Core/Ajax";
import * as UiDialog from "WoltLabSuite/Core/Ui/Dialog";
import * as Language from "WoltLabSuite/Core/Language";
import { setTitle } from "WoltLabSuite/Core/Ui/Dialog";

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
            _ajaxSuccess: (data: DatabaseObjectActionResponse) => {
                UiDialog.open({
                    _dialogSetup: () => {
                        return {
                            id: 'BackgroundjobExecuteDialog',
                            source: null,
                            options: {
                                onShow: function(): void {
                                    setTitle('BackgroundjobExecuteDialog', Language.get('wcf.page.backgroundjobList.button.execute.result'));
                                }
                            }
                        }
                    }
                }, JSON.stringify(data['returnValues'][objectID]));
            }
        });
    }
}

export default BackgroundjobExecute;