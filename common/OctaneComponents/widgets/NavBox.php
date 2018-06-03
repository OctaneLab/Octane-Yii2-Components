<?php

namespace common\OctaneComponents\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class NavBox extends Widget
{
    public $box;
    public $options;
    public $data;

    public function init()
    {
        parent::init();

        switch ($this->box) {
            case 'messages':
                $this->options = ['icon' => 'envelope-o', 'badgeColor' => 'success'];
                $this->data    = [
                    'header'    => Yii::t('app', 'Masz {number} nieodczytanych wiadomości', ['number' => 0]),
                    'badge'     => 0,
                    'footer'    => Yii::t('app', 'Zobacz wszystkie wiadomości'),
                    'footerUrl' => '#',
                ];
                break;
            case 'notifications':
                $this->options = ['icon' => 'bell-o', 'badgeColor' => 'warning'];
                $this->data    = [
                    'header'    => Yii::t('app', 'Masz {number} powiadomień', ['number' => 0]),
                    'badge'     => 0,
                    'footer'    => Yii::t('app', 'Zobacz wszystkie powiadomienia'),
                    'footerUrl' => '#',
                ];
                break;

            default:
                $this->options = ['icon' => 'circle-o', 'badgeColor' => 'default'];
                $this->data    = [
                    'header'    => Yii::t('app', 'NAGŁÓWEK'),
                    'badge'     => 'X',
                    'footer'    => Yii::t('app', 'STOPKA'),
                    'footerUrl' => '#',
                ];
                break;
        }
    }

    public function run()
    {
        return $this->render('nav-box', [
            'box'     => $this->box,
            'options' => $this->options,
            'data'    => $this->data,
        ]);
    }
}