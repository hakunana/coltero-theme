<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\space\widgets\SpaceChooserItem;
\humhub\modules\space\assets\SpaceChooserAsset::register($this);

$noSpaceView = '<div class="no-space"><i class="fa fa-dot-circle-o"></i><br>' . Yii::t('SpaceModule.widgets_views_spaceChooser', 'My spaces') . '<b class="caret"></b></div>';

$this->registerJsConfig('space.chooser', [
    'noSpace' => $noSpaceView,
    'remoteSearchUrl' => Url::to(['/enterprise/spacetype/browse/search-json']),
    'text' => [
        'info.remoteAtLeastInput' => Yii::t('SpaceModule.widgets_views_spaceChooser', 'To search for other spaces, type at least {count} characters.', ['count' => 2]),
        'info.emptyOwnResult' => Yii::t('SpaceModule.widgets_views_spaceChooser', 'No member or following spaces found.'),
        'info.emptyResult' => Yii::t('SpaceModule.widgets_views_spaceChooser', 'No result found for the given filter.'),
    ],
]);

$colors = ['fc4a64', '77e88e', 'ad8bd4', '40b1d0', 'ff987e', '8c91a9'];
?>

<script>
    humhub.module('enterprise.ui', function (module, require, $) {
        var event = require('event');

        event.on('humhub:modules.space.chooser:beforeInit', function (evt, spaceChooser) {
            var SpaceChooser = spaceChooser.SpaceChooser;
            
            SpaceChooser.prototype.init = function () {
                this.$menu = $('#space-menu-dropdown');
                this.$chooser = $('#space-menu-remote-search');
                this.$search = $('#space-menu-search');
                this.$remoteSearch = $('#space-menu-remote-search');

                this.initEvents();
                this.initSpaceSearch();
            };
            
            SpaceChooser.prototype.setSpace = function (space) {
                this.getItems().removeClass('active');
                this.findItem(space).addClass('active');
                this.setSpaceMessageCount(space, 0);
            };
            
            SpaceChooser.prototype.setNoSpace = function() {
                this.getItems().removeClass('active');
            };
            
            SpaceChooser.prototype.getFirstItem = function () {
                return this.$.add(this.$remoteSearch).find('[data-space-chooser-item]:visible').first();
            };
        });
    });
</script>

<ul class="nav nav-pills nav-stacked nav-space-chooser" id="space-menu-dropdown">

    <li class="search">
        <form action="" class="dropdown-controls">
            <input type="text" id="space-menu-search"
                   class="form-control form-search"
                   autocomplete="off"
                   placeholder="<?php echo Yii::t('SpaceModule.widgets_views_spaceChooser', 'Filter'); ?>">

            <div class="search-reset" id="space-search-reset"><i class="fa fa-times-circle"></i></div>
        </form>
    </li>

    <?php foreach ($typeMembershipMap as $entry) : ?>
        <li class="title"><?= Html::encode($entry['spaceType']->title); ?>
            <?php if (in_array($entry['spaceType'], $createSpaceTypes)) : ?>
                <span class="title-link">
                    <a href="#" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/enterprise/spacetype/create-space/create', 'type_id' => $entry['spaceType']->id]) ?>">
                        <i class="fa fa-plus-square"></i>
                    </a>
                </span>
            <?php endif; ?>
        <li>
            <ul class="space-entries">
                <?php foreach ($entry['memberships'] as $membership): ?>
                    <?= SpaceChooserItem::widget(['space' => $membership->space, 'updateCount' => $membership->countNewItems(), 'isMember' => true]); ?>
                <?php endforeach; ?>
            </ul>
        </li>

    <?php endforeach; ?>
</ul>
<ul id="space-chooser-result" class="nav nav-pills nav-stacked nav-space-chooser space-entries">
    
</ul>
<ul class="nav nav-pills nav-stacked nav-space-chooser space-entries">
    <li id="space-menu-remote-search"></li>
</ul>
