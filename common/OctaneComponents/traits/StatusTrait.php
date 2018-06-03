<?php
/**
 * Created by OctaneLab.
 * Date: 13.03.2018
 */

namespace common\OctaneComponents\traits;

use Yii;
use kartik\helpers\Html;

trait StatusTrait
{

    static $STATUS_DEAD   = 0;
    static $STATUS_ALIVE  = 1;

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::$STATUS_DEAD  => Yii::t('app', 'Niektywny'),
            self::$STATUS_ALIVE => Yii::t('app', 'Aktywny'),
        ];
    }

    /**
     * @return array
     */
    public static function getStatusesUX()
    {
        return [
            self::$STATUS_DEAD  => Html::bsLabel(self::getStatuses()[self::$STATUS_DEAD],Html::TYPE_DANGER),
            self::$STATUS_ALIVE => Html::bsLabel(self::getStatuses()[self::$STATUS_ALIVE],Html::TYPE_SUCCESS)
        ];
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return self::getStatuses()[$this->status];
    }

    /**
     * @return mixed
     */
    public function getStatusUX()
    {
        return self::getStatusesUX()[$this->status];
    }
}