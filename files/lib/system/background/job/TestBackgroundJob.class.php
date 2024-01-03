<?php

namespace wcf\system\background\job;

class TestBackgroundJob extends AbstractBackgroundJob
{
    private $alwaysFail;

    public function __construct(bool $alwaysFail = false) {
        $this->alwaysFail = $alwaysFail;
    }

    /**
     * @inheritDoc
     */
    public function perform()
    {
        if ($this->alwaysFail) {
            throw new \Exception("This will always happen, delete this job.");
        }
    }
}
