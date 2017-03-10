<?php
/* @var $space \humhub\modules\space\models\Space */

use yii\helpers\Html;

?>
<li role="presentation" class="<?= ($isCurrentSpace) ? 'active' : '' ?>" data-space-chooser-item <?= $data ?> data-space-guid="<?= $space->guid; ?>">
    <a href="<?= $space->getUrl(); ?>">
        <div class="media">
            <div class="media-left">
                <!-- Show space image -->
                <?= \humhub\modules\space\widgets\Image::widget([
                    'space' => $space,
                    'width' => 24,
                    'htmlOptions' => [
                        'class' => 'pull-left',
                        'style' => 'border: 2px solid ' . $space->color . ';',
                    ]
                ]); ?>
            </div>
            <div class="media-body">
                <?= Html::encode(\humhub\libs\Helpers::trimText($space->name, 18)); ?>
                <div data-message-count="<?= $updateCount; ?>"  style="display:none;" class="badge badge-space bounceIn animated messageCount pull-right"><?= $updateCount; ?></div>
            </div>
        </div>
    </a>
</li>
