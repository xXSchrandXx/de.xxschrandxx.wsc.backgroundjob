<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObject;
use wcf\system\background\BackgroundQueueHandler;

class Backgroundjob extends DatabaseObject
{
    /**
     * @inheritDoc
     */
    protected static $databaseTableName = 'background_job';

    /**
     * @inheritDoc
     */
    protected static $databaseTableIndexName = 'jobID';

    /*
     * ObjectIdDatabaseTableColumn $jobID
     * MEDIUMBLOB $job
     * ENUM('ready', 'processing') $status
     * time INT(10) $time
     */

     public function execute()
     {
        $unserializedJob = null;
        try {
            $unserializedJob = \unserialize($this->job);
            if ($unserializedJob) {
                BackgroundQueueHandler::getInstance()->performJob($unserializedJob, true);
            }
        } catch (\Throwable $e) {
            \wcf\functions\exception\logThrowable($e);
        } finally {
            $editor = new BackgroundjobEditor($this);
            $editor->delete();
            
        }
     }

}
