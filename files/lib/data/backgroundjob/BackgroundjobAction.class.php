<?php

namespace wcf\data\backgroundjob;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\SystemException;
use wcf\system\WCF;

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

    public function validateExecute()
    {
        // validate permissions
        if (\is_array($this->permissionsExecute) && !empty($this->permissionsExecute)) {
            WCF::getSession()->checkPermissions($this->permissionsExecute);
        } else {
            throw new PermissionDeniedException();
        }
    }

    public function execute()
    {
        foreach ($this->getObjectIDs() as $jobID) {
            try {
                $job = new Backgroundjob($jobID);
                $job->execute();
            } catch (SystemException $e) {
                \wcf\functions\exception\logThrowable($e);
            }
        }
    }

    /**
     * list of permissions required to execute objects
     * @var string[]
     */
    protected $permissionsInfo = ['admin.configuration.package.canInstallPackage'];

    public function validateInfo()
    {
        // validate permissions
        if (\is_array($this->permissionsInfo) && !empty($this->permissionsInfo)) {
            WCF::getSession()->checkPermissions($this->permissionsInfo);
        } else {
            throw new PermissionDeniedException();
        }
    }

    public function info()
    {
        $infos = [];
        foreach ($this->getObjectIDs() as $jobID) {
            try {
                $job = new Backgroundjob($jobID);
                $infos[$jobID] = var_export($job->getUnserialized());
            } catch (SystemException $e) {
                \wcf\functions\exception\logThrowable($e);
            }
        }
        return $infos;
    }
}
