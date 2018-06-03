<?php

namespace common\OctaneComponents\exceptions;

use yii\base\Exception;

class OException extends Exception
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'OException';
    }
}