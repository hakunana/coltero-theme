<?php

use humhub\libs\Html;
use yii\helpers\Url;
?>
<div class="nav pull-left nav-search">
    <?= Html::beginForm(Url::to(['//search/search/index']), 'GET'); ?>
    <div class="form-group form-group-search">
        <?= Html::textInput('keyword', '', array('placeholder' => Yii::t('base', 'Search'), 'class' => 'form-control form-search', 'id' => 'search-input-field')); ?>
        <?= Html::submitButton(Yii::t('base', 'Search'), array('class' => 'btn btn-default btn-sm form-button-search hidden')); ?>
    </div>
    <?= Html::endForm(); ?>
</div>