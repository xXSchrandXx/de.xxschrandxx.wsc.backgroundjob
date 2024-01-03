<?php

namespace wcf\data\backgroundjob;

use wcf\data\DatabaseObjectEditor;

/**
 * @property Backgroundjob $object
 * @method   Backgroundjob getDecoratedObject()
 * @mixin    Backgroundjob
 */
class BackgroundjobEditor extends DatabaseObjectEditor
{
    /**
     * @inheritDoc
     */
    protected static $baseClass = Backgroundjob::class;
}
