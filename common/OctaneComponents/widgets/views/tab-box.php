<?php

use common\OctaneComponents\components\Icon;
use kartik\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $items array
 * @var $title array
 */
?>

<div class="nav-tabs-custom box box-solid">
    <div class="overlay loading-state" style="display: none"><i class="fa fa-refresh fa-spin"></i></div>
    <ul class="nav nav-tabs <?= $title ? 'pull-right' : '' ?>">
        <?php foreach ($items as $k => $item) : ?>
            <li class="<?= isset($item['active']) ? 'active' : '' ?>">
                <a href="#<?= isset($item['id']) ? $item['id'] : $items[$k]['id'] = microtime() ?>"  data-toggle="tab"
                    <?= isset($item['ajax_url']) ? 'data-ajax_url="' . $item['ajax_url'] . '"' : '' ?>
                >
                    <?= isset($item['title']) ? $item['title'] : $items[$k]['title'] = 'default tab' ?>
                </a>
            </li>
        <?php endforeach ?>
        <?php if($title): ?>
            <li class="pull-left header">
                <?= isset($title['icon']) ? $title['icon'] : '' ?>
                <?= isset($title['content']) ? $title['content'] : '' ?>
            </li>
        <?php endif; ?>
        <?php if($button): ?>
            <div class="pull-right" style="margin-top: 5px;">
                <?= $button ?>
            </div>
        <?php endif; ?>
    </ul>
    
    <div class="tab-content">
        <?php foreach ($items as $item) : ?>
        <div class="<?= isset($item['active']) ? 'active ' : '' ?>tab-pane" id="<?= $item['id'] ?>">
            <?= isset($item['content']) ? $item['content'] : 'default content' ?>
        </div>
        <?php endforeach ?>
    </div>
    <!-- /.box-body -->
</div>