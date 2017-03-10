<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $this->pageTitle; ?></title>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?php $this->head() ?>
        <?= $this->render('head'); ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="wrapper">

            <div id="sidebar-wrapper">
                <?php echo \humhub\widgets\SiteLogo::widget(); ?><br>
                <?php echo \humhub\widgets\TopMenu::widget(); ?>
                <div id="hide-sidebar">
                    <a href="#menu-toggle" class="menu-toggle"
                       class="dropdown-toggle"><i class="fa fa-times"></i></a>
                </div>
                <?php echo \humhub\modules\enterprise\modules\spacetype\widgets\Chooser::widget(); ?>
            </div>

            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-md">

                            <div id="topbar-first" class="topbar">
                                <div id="rp-nav" class="nav pull-left">
                                    <ul class="nav pull-left navigation-bars">

                                        <li class="dropdown">
                                            <a href="#menu-toggle" class="menu-toggle"
                                               class="dropdown-toggle">
                                                <i class="fa fa-bars"></i></a>
                                        </li>
                                    </ul>
                                    <div class="menu-seperator"></div>
                                </div>
                                <?= \humhub\modules\enterprise\widgets\SearchWidget::widget(); ?>
                                <div class="topbar-actions pull-right">

                                    <ul class="nav pull-left" id="search-menu-nav">
                                        <?php echo \humhub\widgets\TopMenuRightStack::widget(); ?>
                                    </ul>

                                    <div class="menu-seperator"></div>
                                    <div class="notifications">
                                        <?=
                                        \humhub\widgets\NotificationArea::widget(['widgets' => [
                                                [\humhub\modules\notification\widgets\Overview::className(), [], ['sortOrder' => 10]],
                                        ]]);
                                        ?>
                                    </div>

                                    <div class="menu-seperator"></div>

                                    <?= \humhub\modules\user\widgets\AccountTopMenu::widget(['showUserName' => false]); ?>
                                </div>
                            </div>

                            <div class="content">
                                <?= $content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Menu Toggle Script -->
        <script type="text/javascript">

            var mq = window.matchMedia("(max-width: 768px)");

            if (mq.matches) {
                var navHeight = $('.space-nav:first').height();
                if (navHeight > 38) {
                    var dif = navHeight - 38;
                    $('.space-layout-container').animate({'margin-top': '+=' + dif}, 0);
                }
            }

            $(".menu-toggle").click(function (e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");

                if ($('#wrapper').css('padding-left') == "250px") {
                    $('#rp-nav').css('display', 'block');
                    $('#topbar-first').css('padding-left', '0');

                    if (mq.matches) {
                        $('#topbar-first div').removeClass('hidden');
                        $('.space-nav .nav').removeClass('hidden');
                        $('#rsp-backdrop').remove();
                    }

                } else {
                    $('#rp-nav').css('display', 'none');
                    $('#topbar-first').css('padding-left', '250px');

                    if (mq.matches) {
                        $('#topbar-first div').addClass('hidden');
                        $('.space-nav .nav').addClass('hidden');

                        $('#page-content-wrapper').append('<div id="rsp-backdrop" class="modal-backdrop in" style="z-index: 940;"></div>');
                    }
                }
            });
        </script>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>