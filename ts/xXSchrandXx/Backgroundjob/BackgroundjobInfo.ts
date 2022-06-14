import * as Ajax from "WoltLabSuite/Core/Ajax";
import * as Language from "WoltLabSuite/Core/Language";
import UiDialog, { setTitle } from "WoltLabSuite/Core/Ui/Dialog";
import { DatabaseObjectActionResponse } from "WoltLabSuite/Core/Ajax/Data";

export class BackgroundjobInfo {
    public constructor() {
        const elements = document.getElementsByClassName("backgroundjobInfoButton");
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
                        actionName: "info",
                        className: "wcf\\data\\backgroundjob\\BackgroundjobAction",
                        objectIDs: [objectID],
                    }
                };
            },
            _ajaxSuccess: (data: DatabaseObjectActionResponse) => {
                UiDialog.open({
                    _dialogSetup: () => {
                        return {
                            id: 'backgroundjobInfoDialog',
                            source: null,
                            options: {
                                onShow: function(): void {
                                    setTitle('backgroundjobInfoDialog', Language.get('wcf.page.backgroundjobList.button.info.result'));
                                }
                            }
                        }
                    }
                }, data['returnValues'][objectID]);
            }
        });
    }
}

export default BackgroundjobInfo;