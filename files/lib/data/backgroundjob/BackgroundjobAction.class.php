<?php

namespace wcf\data\backgroundjob;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\SystemException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;

/**
 * @property BackgroundjobEditor[] $objects
 * @method   BackgroundjobEditor[] getObjects()
 * @method   BackgroundjobEditor   getSingleObject()
 */
class BackgroundjobAction extends AbstractDatabaseObjectAction
{
    /**
     * @inheritDoc
     */
    protected $permissionsCreate = ['admin.configuration.package.canInstallPackage'];

    /**
     * @inheritDoc
     */
    protected $permissionsDelete = ['admin.configuration.package.canInstallPackage'];

    /**
     * @inheritDoc
     */
    protected $permissionsUpdate = ['admin.configuration.package.canInstallPackage'];

    /**
     * @inheritDoc
     */
    protected $requireACP = ['create', 'delete', 'update', 'execute', 'info'];

    /**
     * list of permissions required to execute objects
     * @var string[]
     */
    protected $permissionsExecute = ['admin.configuration.package.canInstallPackage'];

    /**
     * list of permissions required to see information of objects
     * @var string[]
     */
    protected $permissionsInfo = ['admin.configuration.package.canInstallPackage'];

    public function validateExecute()
    {
        // validate permissions
        if (\is_array($this->permissionsExecute) && !empty($this->permissionsExecute)) {
            WCF::getSession()->checkPermissions($this->permissionsExecute);
        } else {
            throw new PermissionDeniedException();
        }

        if (count($this->getObjectIDs()) != 1) {
            throw new UserInputException('objectIDs');
        }
    }

    public function execute()
    {
        try {
            $result = $this->getSingleObject()->getDecoratedObject()->execute();
            $this->getSingleObject()->delete();

            return $result;
        } catch (\Throwable $e) {
            \wcf\functions\exception\logThrowable($e);
            return WCF::getTPL()->fetch('__backgroundJobError', 'wcf', [
                'e' => $e
            ]);
        }
    }

    public function validateInfo()
    {
        // validate permissions
        if (\is_array($this->permissionsInfo) && !empty($this->permissionsInfo)) {
            WCF::getSession()->checkPermissions($this->permissionsInfo);
        } else {
            throw new PermissionDeniedException();
        }

        if (count($this->getObjectIDs()) != 1) {
            throw new UserInputException('objectIDs');
        }
    }

    public function info()
    {
        return WCF::getTPL()->fetch('__backgroungJobInfo', 'wcf', [
            'object' => $this->getSingleObject()->getDecoratedObject()
        ]);
     }
}
