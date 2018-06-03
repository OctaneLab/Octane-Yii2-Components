<?php

namespace common\OctaneComponents\exceptions;

class ModelNotFoundException extends OException
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Model not found';
    }
}