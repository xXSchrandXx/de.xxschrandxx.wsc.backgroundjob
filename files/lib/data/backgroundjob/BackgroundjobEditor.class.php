<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObjectEditor;

class BackgroundjobEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = Backgroundjob::class;
}
