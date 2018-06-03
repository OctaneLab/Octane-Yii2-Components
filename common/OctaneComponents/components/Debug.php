<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents\components;

use common\OctaneComponents\OActiveRecord;
use kartik\helpers\Html;
use Yii;

class Debug
{
    /**
     * @param string $item
     * @param bool $dieAfter
     */
    public static function vars($item = '', $dieAfter = true)
    {
        echo "<pre>";
        var_dump($item);
        echo "</pre>";

        if($dieAfter){
            die();
        }
    }
}