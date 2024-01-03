<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObject;
use wcf\system\background\BackgroundQueueHandler;
use wcf\system\background\job\AbstractBackgroundJob;
use wcf\util\JSON;

/**
 * @property-read int $jobID
 * @property-read string $job
 * @property-read string $status can be 'ready' or 'processing'
 * @property-read int $time
 */
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

    /**
     * Unserializec job
     * @var ?AbstractBackgroundJob
     */
    private $unserializedJob = null;

    /**
     * Gets unserialize backgroundjob
     * @return ?AbstractBackgroundJob
     */
    public function getUnserialized()
    {
        if ($this->unserializedJob === null) {
            try {
                $this->unserializedJob = \unserialize($this->job);
            } catch (\Throwable $e) {
                \wcf\functions\exception\logThrowable($e);
            }
        }
        return $this->unserializedJob;
    }

    /**
     * Returns the name of the class
     * @return string
     */
    public function getClass()
    {
        return get_class($this->getUnserialized());
    }

    /**
     * Gets the AbstractBackgroundJob`s data
     * @return array
     */
    public function getObjectVars()
    {
        $arr = (array) $this->getUnserialized();
        foreach ($arr as $key => $value) {
            // Check key
            if (preg_replace('/[[:^print:]]/', '', $key) == 'wcf\system\background\job\AbstractBackgroundJobfailures') {
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
        $unserializedJob = $this->getUnserialized();
        if ($unserializedJob) {
            BackgroundQueueHandler::getInstance()->performJob($unserializedJob, true);
        }
    }
}
