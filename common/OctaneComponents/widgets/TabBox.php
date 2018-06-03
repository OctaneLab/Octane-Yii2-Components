<?php

namespace common\OctaneComponents\widgets;

use Yii;
use yii\base\Widget;

class TabBox extends Widget
{
    public $items;
    public $title;
    public $button;

    public function run()
    {
        return $this->render('tab-box', [
            'items' => $this->items,
            'title' => $this->title,
            'button' => $this->button
        ]);
    }
}