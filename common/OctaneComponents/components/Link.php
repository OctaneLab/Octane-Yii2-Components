<?php

namespace common\OctaneComponents\components;

use Yii;
use common\OctaneComponents\OController;
use kartik\helpers\Html;
use yii\helpers\Inflector;

class Link
{
    /**
     * @param $route array|string Normal Controller/Action route
     * @param array $options
     * @param bool|string $icon True - gets default action's icon, any other string means the name of specific icon.
     * @param null|string $title - Own title
     * @param string $tag Html tag name - default it's "a" tag
     * @return string Html tag
     */
    public static function to($route, $options = [], $icon = false, $title = null, $tag = 'a')
    {var_dump($route); die();
        $things = self::getRouteData($route, $title);

//      $controller   = $things['controller'];
//      $action_name  = $things['action']['name'];
        $action_title = $things['action']['title'];
        $action_icon  = $things['action']['icon'];
//      $params       = $things['params'];

        if (!$title) $title = $action_title;
        if (!isset($options['title'])) $options['title'] = $action_title;

        if ($icon) {
            if ($icon === true) $icon_name = $action_icon;
            else $icon_name = $icon;
            $title = Icon::i($icon_name) . ' ' . $title;
        }

        if ($tag == 'a') return Html::a($title, $route, $options);

        return Html::tag($tag, $title, $options);
    }

    /**
     * @param $route array|string Normal Controller/Action route
     * @param null|string $title - Own title
     * @return string Html tag
     */
    public static function breadcrumb($route, $title = null)
    {
        $things       = self::getRouteData($route, $title);
        $action_title = $things['action']['title'];
        if (!$title) $title = $action_title;

        return ['label' => $title, 'url' => $route];
    }

    /**
     * @param $route
     * @param null $title
     * @return array
     */
    public static function getRouteData($route, $title = null)
    {
        $items = explode('/', $route[0]);
        if (count($items) > 1) {
            $controller    = $items[0];
            $action        = $items[1];
            $controllerObj = self::getControllerInstance($controller);
        } else {
            $controllerObj = Yii::$app->controller;
            $controller    = $controllerObj->uniqueId;
            $action        = $items[0];
        }

        $params = [];
        if (count($route) > 1) {
            foreach ($route as $param => $value) {
                if (!is_numeric($param)) $params[$param] = $value;
            }
        }

        $action_title = $controllerObj->getActionTitle($action, $params);
        $action_icon  = $controllerObj->getActionIcon($action, $params);

        return [
            'controller' => $controllerObj,
            'action'     => ['name' => $action, 'title' => $action_title, 'icon' => $action_icon],
            'params'     => $params,
        ];
    }

    /**
     * @param $controller_name string Unique ID of controller
     * @return OController
     */
    private static function getControllerInstance($controller_name)
    {
        if (isset(Yii::$app->params['controllerInstances'])) {
            if (isset(Yii::$app->params['controllerInstances'][$controller_name])) {
                return Yii::$app->params['controllerInstances'][$controller_name];
            }
        }
        $class = self::getControllerNamespace($controller_name);

        return Yii::$app->params['controllerInstances'][$controller_name] = new $class($controller_name, null);
    }

    /**
     * @param $controller_name string Unique ID of controller
     * @return string Controller's namespace
     */
    private static function getControllerNamespace($controller_name)
    {
        return Yii::$app->controllerNamespace . '\\' . Inflector::id2camel($controller_name) . 'Controller';
    }

    /**
     * @param $controller
     * @param $method
     * @param array $params
     * @return mixed
     */
    private static function callControllerMethod($controller, $method, $params = [])
    {
        return forward_static_call_array([self::getControllerNamespace($controller), $method], $params);
    }
}