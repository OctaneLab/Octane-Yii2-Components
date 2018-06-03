<?php
/**
 * Created by OctaneLab.
 * Date: 11.03.2018
 */
namespace common\OctaneComponents\components;

use dmstr\web\AdminLteAsset;
use kartik\helpers\Html;
use Yii;

class Image
{
    /**
     * @param string $image Image path app/web/{$image}
     * @param array $options
     * @param boolean $adminlte Boolean decide whether to use AdminLTE path or Web path (as default)
     * @param bool $just_url
     * @return string
     */
    public static function path($image, $options = [], $adminlte = false, $just_url = false)
    {
        if (!$adminlte) {
            $url = Yii::$app->request->baseUrl . '/' . $image;
        } else {
            $url = self::getAssetPath() . '/' . $image;
        }

        if ($just_url) return $url;

        return Html::img($url, $options);
    }

    /**
     * @param string $height
     * @param string $color
     * @return string
     */
    public static function logo($height = '80px', $color = 'blue')
    {
        if (!$height) $height = '80px';

        return Html::a(self::path('images/cvcento-' . $color . '.png', [
            'alt'    => Yii::$app->name,
            'height' => $height,
        ]), ['/site']);
    }

    private static function getAssetPath()
    {
        if (isset(Yii::$app->params['assetPath'])) {
            return Yii::$app->params['assetPath'];
        } else {
            $asset = new AdminLteAsset();

            return Yii::$app->assetManager->getPublishedUrl($asset->sourcePath);
        }
    }
}