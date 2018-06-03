<?php

namespace common\OctaneComponents\widgets;

use kartik\grid\GridView;
use Yii;

class OGridView extends GridView
{
    /** @var string|array Sort action */
    public $sortableAction = null;
    
    public static function saveSelectedRowsToSession($session_name, $data = [])
    {
        $data   = (isset($data) AND !empty($data)) ? $data : Yii::$app->request->post();
        $params = self::getSelectedRowsFromSession($session_name);
        
        foreach ($data['selected_ids'] as $id) {
            $isset = isset($params[$id]);
            if ($data['checked'] == 'true') {
                if (!$isset) $params[$id] = $id;
            } else {
                if ($isset) unset($params[$id]);
            }
        }
        
        Yii::$app->session->set('_grid-view-' . $session_name, $params);
        
        return self::getSelectedRowsFromSession($session_name);
    }
    
    public static function getSelectedRowsFromSession($session_name)
    {
        $session = Yii::$app->session->get('_grid-view-' . $session_name);
        if(!$session) $session = [];
        return $session;
    }
    
    public static function clearSelectedRowsSession($session_name)
    {
        Yii::$app->session->remove('_grid-view-' . $session_name);
    }
}