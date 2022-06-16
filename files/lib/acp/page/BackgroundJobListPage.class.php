<?php

namespace wcf\acp\page;

use wcf\data\backgroundjob\BackgroundjobList;
use wcf\page\MultipleLinkPage;

class BackgroundJobListPage extends MultipleLinkPage
{
    /**
     * @inheritDoc
     */
    public $objectListClassName = BackgroundjobList::class;

    /**
     * @inheritDoc
     */
    public $sortField = 'jobID';

    /**
     * @inheritDoc
     */
    public $sortOrder = 'ASC';

    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.devtools.backgroundjob';

    /**
     * @inheritDoc
     */
    public $neededModules = ['ENABLE_DEVELOPER_TOOLS'];

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.configuration.package.canInstallPackage'];
}
