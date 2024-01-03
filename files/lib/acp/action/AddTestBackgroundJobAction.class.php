<?php

namespace wcf\acp\action;

use Laminas\Diactoros\Response\RedirectResponse;
use wcf\acp\page\BackgroundJobListPage;
use wcf\action\AbstractAction;
use wcf\system\background\BackgroundQueueHandler;
use wcf\system\background\job\TestBackgroundJob;
use wcf\system\request\LinkHandler;

final class AddTestBackgroundJobAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public $neededModules = ['ENABLE_DEVELOPER_TOOLS'];

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.configuration.package.canInstallPackage'];

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $alwaysFail = false;

        if (isset($_REQUEST['fail'])) {
            $alwaysFail = (bool) $_REQUEST['fail'];
        }

        BackgroundQueueHandler::getInstance()->enqueueIn(new TestBackgroundJob($alwaysFail), 60);

        return new RedirectResponse(LinkHandler::getInstance()->getControllerLink(BackgroundJobListPage::class, ['isACP' => true]));
    }
}
