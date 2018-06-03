<?php
/**
 * Created by OctaneLab.
 * Date: 13.03.2018
 */

namespace common\OctaneComponents\traits;


use Yii;
use kartik\helpers\Html;

trait UXTrait
{
    public function createNameUX($string, $type = Html::TYPE_DEFAULT)
    {
        return Html::bsLabel(Yii::t('app', $string), $type);
    }
}