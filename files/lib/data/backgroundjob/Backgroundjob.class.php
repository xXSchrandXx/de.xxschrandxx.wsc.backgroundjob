<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObject;
use wcf\system\background\BackgroundQueueHandler;
use wcf\system\background\job\AbstractBackgroundJob;
use wcf\util\JSON;
use wcf\util\StringUtil;

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
     * Gets the AbstractBackgroundJob`s data
     * @return array
     */
    public function getObjectVars()
    {
        $arr = get_object_vars($this->getUnserialized());
        foreach ($arr as $key => $value) {
            // Check key
            if ($key == '__PHP_Incomplete_Class_Name') {
                $arr['Name'] = $arr[$key];
                unset($arr[$key]);
            } else if (preg_replace('/[[:^print:]]/', '', $key) == 'wcf\system\background\job\AbstractBackgroundJobfailures') {
                $arr['failures'] = $arr[$key];
                unset($arr[$key]);
            }
            // Check value
            if ($value === null) {
                $arr[$key] = 'null';
            } else if (is_array($value)) {
                $arr[$key] = JSON::encode($value);
            }
        }
        return $arr;
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
