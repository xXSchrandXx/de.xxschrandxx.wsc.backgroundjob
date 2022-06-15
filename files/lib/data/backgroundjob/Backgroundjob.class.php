<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObject;
use wcf\system\background\BackgroundQueueHandler;
use wcf\system\background\job\AbstractBackgroundJob;

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

     /**
      * Gets unserialize backgroundjob
      * @return ?AbstractBackgroundJob
      */
     public function getUnserialized()
     {
        $unserializedJob = null;
        try {
            $unserializedJob = \unserialize($this->job);
        } catch (\Throwable $e) {
            \wcf\functions\exception\logThrowable($e);
        }
        return $unserializedJob;
     }

     /**
      * Executes the job and deletes on success.
      */
     public function execute()
     {
        try {
            $unserializedJob = $this->getUnserialized();
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
