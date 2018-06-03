<?php

namespace common\OctaneComponents\widgets;


use common\OctaneComponents\components\Icon;
use kartik\helpers\Html;
use Yii;

class Editable extends \kartik\editable\Editable
{
    public $formClass = '\kartik\form\ActiveForm';

    public $buttonsTemplate = '{submit}';

    public $submitButton = ['class' => 'btn btn-primary btn-flat', 'style' => 'margin: 0'];

    protected function initInlineOptions()
    {
        $title                = Yii::t('kveditable', 'Close');
        $this->inlineSettings = array_replace_recursive([
            'templateBefore' => self::INLINE_BEFORE_1,
            'templateAfter'  => self::INLINE_AFTER_1,
            'options'        => ['class' => 'hxs-editable'],
            'closeButton'    => Html::button(Icon::i('times'), [
                'title' => $title,
                'class' => 'kv-editable-close close pull-right',
                'style' => 'margin-left: 3px'
            ]),
        ], $this->inlineSettings);
        Html::addCssClass($this->contentOptions, 'kv-editable-inline');
        Html::addCssStyle($this->contentOptions, 'display:none');
    }
}
