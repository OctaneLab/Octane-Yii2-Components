<?php

use common\OctaneComponents\components\Icon;

/**
 * @var $this \yii\web\View
 * @var $box string
 * @var $options array
 * @var $data array
 */
?>

<!-- Messages: style can be found in dropdown.less-->
<li class="dropdown <?= $box ?>-menu">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <?= Icon::i($options['icon']) ?>
      <span class="label label-<?= $options['badgeColor'] ?>"><?= $data['badge'] ?></span>
   </a>

   <ul class="dropdown-menu">
      <li class="header"><?= $data['header'] ?></li>
      <li>
         <?= $this->render('nav-box/_' . $box, compact('box', 'data', 'options')) ?>
      </li>
      <li class="footer"><a href="<?= $data['footerUrl'] ?>"><?= $data['footer'] ?></a></li>
   </ul>
</li>