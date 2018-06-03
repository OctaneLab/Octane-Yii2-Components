<?php

namespace common\OctaneComponents;

use kartik\helpers\Html;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

use common\OctaneComponents\traits\RouteTrait;
use common\OctaneComponents\exceptions\ModelNotFoundException;
use common\OctaneComponents\interfaces\RoutingInterface;

/**
 * OctaneLab's Controller is the layer between used controller and Yii's one
 */
abstract class OController extends Controller implements RoutingInterface
{
    use RouteTrait;
    
    public function goBack( $status = null)
    {
        if ($status == 'error') {
            $this->setMessage('Coś poszło nie tak... Spróbuj ponownie później.', 'error');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function setMessage( string $msg, string $type = 'success' )
    {
        return Yii::$app->getSession()->addFlash( $type, Yii::t('app', $msg) );
    }
    
    public function checkUploadedFiles($model, array $attributes)
    {
        $flag = [];
        foreach ($attributes as $attribute) {
            $flag[$attribute] = UploadedFile::getInstance($model, $attribute);
        }
        
        return $flag;
    }
    
    /**
     * @inheritdoc
     */
    public function runAction($id, $params = [])
    {
        try {
            return parent::runAction($id, $params);
        } catch (ModelNotFoundException $e) {
            Yii::$app->session->addFlash('warning', $e->getMessage());
            
            return $this->redirect([$this->id . '/' . $this->defaultAction]);
        }
    }

    //TODO: Array ze zmiennymi w t()
    public function getSuccessMessage($type, $model)
    {
        switch($type){
            case "saved" :
                $anchor = Html::a("Tutaj",['index']);
                $msg = "Zapisano {$model::modelName()} '{$model->name}'' o ID({$model->id}). Wróć do listy: {$anchor}";
                break;
            default:
                $msg = "Ok";
        }

        return Yii::t('app', $msg);
    }
}
