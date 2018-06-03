<?php

namespace common\OctaneComponents;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OModel extends Model
{
    /**
     * Creates and populates a set of models. (Marta mod)
     *
     * @param string $modelClass
     * @param array $post
     * @param array $multipleModels
     * @return array
     */
    public static function createMultiple($modelClass, $post = null, $multipleModels = null)
    {
        if (is_null($post)) {
            $model    = new $modelClass;
            $formName = $model->formName();
            $post     = Yii::$app->request->post($formName);
        }
        $models   = [];
        $flag     = false;

        if ($multipleModels !== null && is_array($multipleModels) && !empty($multipleModels)) {
            $keys = array_keys(ArrayHelper::map($multipleModels, 'id', 'id'));
            $multipleModels = array_combine($keys, $multipleModels);
            $flag = true;
        }

        if ($post && is_array($post)) {
            foreach ($post as $i => $item) {
                if ($flag) {
                    if (isset($item['id']) && !empty($item['id']) && isset($multipleModels[$item['id']])) {
                        $models[] = $multipleModels[$item['id']];
                    } else {
                        $models[] = new $modelClass;
                    }
                } else {
                    $models[] = new $modelClass;
                }
            }
        }
        unset($model, $formName, $post);
        return $models;
    }
}