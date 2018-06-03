<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents\components;

use common\OctaneComponents\OActiveRecord;
use kartik\helpers\Html;
use Yii;

class Icon
{
    /**
    * @param string $icon_name
    * @param array $options
    * @param string $prefix
    * @return string
    */
   public static function i($icon_name, $options = [], $prefix = 'fa fa-')
   {
      return Html::icon($icon_name, $options, $prefix, 'i');
   }

    /**
    * @param string $icon_name
    * @param array $options
    * @param string $prefix
    * @return string
    */
   public static function span($icon_name, $options = [], $prefix = 'fa fa-')
   {
      return Html::icon($icon_name, $options, $prefix, 'span');
   }

    /**
     * @param HXActiveRecord $model
     * @param string $field_name
     * @param array $options
     * @param string $prefix
     * @param string $tag
     * @return string
     */
    public static function forField($model, $field_name, $options = [], $prefix = 'fa fa-', $tag = 'i')
    {
        $icon_name = $model->getAttributeIcon($field_name);

        return Html::icon($icon_name, $options, $prefix, $tag);
    }

    /**
     * @param array $options
     * @param string $prefix
     * @param string $tag
     * @return string
     */
    public static function forRequestedAction($options = [], $prefix = 'fa fa-', $tag = 'i')
    {
        $icon_name = Yii::$app->controller->getActionIcon(Yii::$app->requestedAction->id);

        return Html::icon($icon_name, $options, $prefix, $tag);
    }
}