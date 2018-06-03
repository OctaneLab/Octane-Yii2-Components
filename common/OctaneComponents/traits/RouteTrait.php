<?php

namespace common\OctaneComponents\traits;

use common\OctaneComponents\components\Icon;
use Yii;

trait RouteTrait
{
    /**
     * @param string $action Action name
     * @param array $params Pass params to generate more accurate Route Title
     * @return string "ControllerName > ActionTitle"
     */
    public function getRouteTitle($action, $params = [])
    {
        $controller_title = $this->getControllerTitle();
        $action_title     = $this->getActionTitle($action, $params);

        if ($controller_title AND $action_title) return $controller_title . ' > ' . $action_title;
        else if ($action_title) return $action_title;

        return Yii::t('app', 'Link');
    }

    /**
     * @return string|null Controller name
     */
    public static function getControllerTitle()
    {
        $controllerName = self::name();

        return $controllerName ? $controllerName : null;
    }

    /**
     * @param string $action Action name
     * @param array $params Pass params to generate more accurate Action Icon
     * @return string Combined Action icon and title
     */
    public static function getActionTitlePretty($action, $params = [])
    {
        $icon = '';
        if ($icon_name = self::getActionIcon($action, $params)) {
            $icon = Icon::i($icon_name) . ' ';
        }

        return $icon . self::getActionTitle($action, $params);
    }

    /**
     * @param string $action Action name
     * @param array $params Pass params to generate more accurate Action Title
     * @return string Action title
     */
    public static function getActionTitle($action, $params = [])
    {
        $actionLabels = self::labels($params);

        return (isset($actionLabels[$action]) && isset($actionLabels[$action]['title']))
            ? $actionLabels[$action]['title']
            : Yii::t('app', 'Tytuł');
    }

    /**
     * @param string $action Action name
     * @param array $params Pass params to generate more accurate Action Icon
     * @return string Action icon
     */
    public static function getActionIcon($action = '', $params = [])
    {
        if (empty($action)) {
            $controllerObject = new static(null, null);
            $action           = $controllerObject->defaultAction;
            unset($controllerObject);
        }

        $actionLabels = self::labels($params);

        return (isset($actionLabels[$action]) && isset($actionLabels[$action]['icon'])) ? $actionLabels[$action]['icon'] : Yii::t('app', 'circle-o');
    }

}