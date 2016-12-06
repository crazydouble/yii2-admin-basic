<?php 

use backend\assets\AppAsset; 
use yii\helpers\Html; 
AppAsset::register($this); 

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
  
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="<?= Yii::$app->charset ?>" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
      div.required label:after {
          content: " *";
          color: red;
      }
    </style>
  </head>
  
  <body class="bg-3">
    <?php $this->beginBody() ?>
    <!-- 预加载 -->
    <div class="mask">
      <div id="loader">
      </div>
    </div>
    <!--/预加载 -->
    <div id="wrap">
      <div class="row">
        <!-- 固定导航 -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top" role="navigation" id="navbar">
          <!-- Logo -->
          <div class="navbar-header col-md-2">
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
              <strong>
                <?= Html::encode(Yii::$app->name) ?>
              </strong>
            </a>
            <div class="sidebar-collapse">
              <?= Html::a('<i class="fa fa-bars"></i>', 'javascript:void(0);') ?>
            </div>
          </div>
          <!-- /Logo -->
          <div class="navbar-collapse">
            <!-- 页面刷新 -->
            <ul class="nav navbar-nav refresh">
              <li class="divided">
                <?= Html::a(
                  '<i class="fa fa-refresh"></i>',
                  'javascript:void(0);',
                  ['class' => 'page-refresh']
                ) ?>
              </li>
            </ul>
            <!-- /页面刷新 -->
            <!-- 搜索 -->
            <?php
            /*
            <div class="search" id="main-search">
              <i class="fa fa-search">
              </i>
              <input type="text" placeholder="搜索您需要的内容..." />
            </div>
            */
            ?>
            <!-- /搜索 -->
            <!-- 快捷操作 -->
            <ul class="nav navbar-nav quick-actions">
                <li class="dropdown divided user" id="current-user">
                  <div class="profile-photo">
                    <img src="<?= Yii::$app->request->baseUrl; ?>/assets/images/profile-photo.jpg" alt="" />
                  </div>
                  <?= Html::a(
                    Yii::$app->user->identity->nickname.'<i class="fa fa-caret-down"></i>',
                    'javascript:void(0);',
                    ['class' => 'dropdown-toggle options', 'data-toggle' => 'dropdown']
                  ) ?>
                  <ul class="dropdown-menu arrow settings">
                    <li>
                      <h3>
                        背景:
                      </h3>
                      <ul id="color-schemes">
                        <li><a href="javascript:void(0);" class="bg-1"></a></li>
                        <li><a href="javascript:void(0);" class="bg-2"></a></li>
                        <li><a href="javascript:void(0);" class="bg-3"></a></li>
                        <li><a href="javascript:void(0);" class="bg-4"></a></li>
                        <li><a href="javascript:void(0);" class="bg-5"></a></li>
                        <li><a href="javascript:void(0);" class="bg-6"></a></li>
                      </ul>
                      <!--
                      <div class="form-group videobg-check">
                        <label class="col-xs-8 control-label">
                          保存 背景
                        </label>
                        <div class="col-xs-4 control-label">
                          <div class="onoffswitch greensea small">
                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                            id="videobg-check" />
                            <label class="onoffswitch-label" for="videobg-check">
                              <span class="onoffswitch-inner">
                              </span>
                              <span class="onoffswitch-switch">
                              </span>
                            </label>
                          </div>
                        </div>
                      </div>
                      -->
                    </li>
                    <li class="divider">
                    </li>
                    <?php
                    /*
                    <li>
                      <?= Html::a('<i class="fa fa-user"></i> 个人资料', 'javascript:void(0);') ?>
                    </li>
                    <li>
                      <?= Html::a('<i class="fa fa-calendar"></i> 日历', 'javascript:void(0);') ?>
                    </li>
                    <li>
                      <?= Html::a(
                        '<i class="fa fa-envelope"></i> 通知
                        <span class="badge badge-red" id="user-inbox">
                          3
                        </span>', 'javascript:void(0);'
                      ) ?>
                    </li>
                    <li class="divider">
                    </li>
                    */
                    ?>
                    <li>
                      <?= Html::a('<i class="fa fa-power-off"></i>'.Yii::t('backend', 'Logout'),Yii::$app->urlManager->createUrl(['site/logout'])) ?>
                    </li>
                  </ul>
                </li>
                <?php
                /*
                <li>
                  <?= Html::a('<i class="fa fa-comments"></i>', '#mmenu') ?>
                </li>
                */
                ?>
            </ul>
            <!-- /快捷操作 -->
            <!-- 侧边栏 -->
            <ul class="nav navbar-nav side-nav" id="sidebar">
              <li class="collapsed-content">
                <ul>
                  <li class="search"></li>
                </ul>
              </li>
              <li class="navigation" id="navigation">
                <?= Html::a(
                  '导航栏 <i class="fa fa-angle-up"></i>',
                  'javascript:void(0);',
                  ['class' => 'sidebar-toggle', 'data-toggle' => '#navigation']
                )?>
                <ul class="menu">
                  <li class="active">
                    <?= Html::a(
                      '<i class="fa fa-tachometer"></i> '.Yii::t('backend', 'Index')/*.'<span class="badge badge-red">1</span>'*/,
                      Yii::$app->homeUrl
                    ) ?>
                  </li>
                  <li class="dropdown">
                    <?= Html::a(
                      '<i class="fa fa-user"></i> '.Yii::t('backend', 'User Management').'<b class="fa fa-plus dropdown-plus"></b>',
                      'javascript:void(0);',
                      ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']
                    ) ?>
                    <ul class="dropdown-menu">
                      <li>
                        <?= Html::a(
                          '<i class="fa fa-caret-right"></i> '.Yii::t('backend', 'Users'),
                          Yii::$app->urlManager->createUrl(['user'])
                        ) ?>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <?= Html::a(
                      '<i class="fa fa-cog"></i> '.Yii::t('backend', 'System Management').'<b class="fa fa-plus dropdown-plus"></b>',
                      'javascript:void(0);',
                      ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']
                    ) ?>
                    <ul class="dropdown-menu">
                      <li>
                        <?= Html::a(
                          '<i class="fa fa-caret-right"></i> '.Yii::t('backend', 'Admins'),
                          Yii::$app->urlManager->createUrl(['admin'])
                        ) ?>
                      </li>
                      <li>
                        <?= Html::a(
                          '<i class="fa fa-caret-right"></i> '.Yii::t('backend', 'Permissions'),
                          Yii::$app->urlManager->createUrl(['permission'])
                        ) ?>
                      </li>
                      <li>
                        <?= Html::a(
                          '<i class="fa fa-caret-right"></i> '.Yii::t('backend', 'Roles'),
                          Yii::$app->urlManager->createUrl(['role'])
                        ) ?>
                      </li>
                      <li>
                        <?= Html::a(
                          '<i class="fa fa-caret-right"></i> '.Yii::t('backend', 'Logs'),
                          Yii::$app->urlManager->createUrl(['log'])
                        ) ?>
                      </li>
                    </ul>
                  </li>
                  <?php
                  /*
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-desktop">
                      </i>
                      Example Pages
                      <b class="fa fa-plus dropdown-plus">
                      </b>
                      <span class="label label-greensea">
                        mails
                      </span>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a href="mail.html">
                          <i class="fa fa-caret-right">
                          </i>
                          Vertical Mail
                          <span class="badge badge-red">
                            5
                          </span>
                        </a>
                      </li>
                      <li>
                        <a href="mail-horizontal.html">
                          <i class="fa fa-caret-right">
                          </i>
                          Horizontal Mail
                          <span class="label label-greensea">
                            mails
                          </span>
                        </a>
                      </li>
                    </ul>
                  </li>
                  
                  */
                  ?>
                </ul>
              </li>
              <?php
              /*
              <li class="summary" id="order-summary">
                <a href="javascript:void(0);" class="sidebar-toggle underline" data-toggle="#order-summary">
                  Orders Summary
                  <i class="fa fa-angle-up">
                  </i>
                </a>
                <div class="media">
                  <a class="pull-right" href="javascript:void(0);">
                    <span id="sales-chart">
                    </span>
                  </a>
                  <div class="media-body">
                    This week sales
                    <h3 class="media-heading">
                      26, 149
                    </h3>
                  </div>
                </div>
                <div class="media">
                  <a class="pull-right" href="javascript:void(0);">
                    <span id="balance-chart">
                    </span>
                  </a>
                  <div class="media-body">
                    This week balance
                    <h3 class="media-heading">
                      318, 651
                    </h3>
                  </div>
                </div>
              </li>
              <li class="settings" id="general-settings">
                <a href="javascript:void(0);" class="sidebar-toggle underline" data-toggle="#general-settings">
                  General Settings
                  <i class="fa fa-angle-up">
                  </i>
                </a>
                <div class="form-group">
                  <label class="col-xs-8 control-label">
                    Switch ON
                  </label>
                  <div class="col-xs-4 control-label">
                    <div class="onoffswitch greensea">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                      id="switch-on" checked="" />
                      <label class="onoffswitch-label" for="switch-on">
                        <span class="onoffswitch-inner">
                        </span>
                        <span class="onoffswitch-switch">
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-8 control-label">
                    Switch OFF
                  </label>
                  <div class="col-xs-4 control-label">
                    <div class="onoffswitch greensea">
                      <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                      id="switch-off" />
                      <label class="onoffswitch-label" for="switch-off">
                        <span class="onoffswitch-inner">
                        </span>
                        <span class="onoffswitch-switch">
                        </span>
                      </label>
                    </div>
                  </div>
                </div>
              </li>
              */
              ?>
            </ul>
            <!-- /侧边栏 -->
          </div>
        </div>
        <!-- /固定导航-->
        <!-- 页面主内容 -->
        <?= $content ?>
        <!-- /页面主内容 -->
        <?php
        /*
        <div id="mmenu" class="right-panel">
          <!-- 右侧导航选项卡 -->
          <ul class="nav nav-tabs nav-justified">
            <li class="active">
              <a href="#mmenu-users" data-toggle="tab">
                <i class="fa fa-users">
                </i>
              </a>
            </li>
            <li class="">
              <a href="#mmenu-history" data-toggle="tab">
                <i class="fa fa-clock-o">
                </i>
              </a>
            </li>
            <li class="">
              <a href="#mmenu-friends" data-toggle="tab">
                <i class="fa fa-heart">
                </i>
              </a>
            </li>
            <li class="">
              <a href="#mmenu-settings" data-toggle="tab">
                <i class="fa fa-gear">
                </i>
              </a>
            </li>
          </ul>
          <!-- /右侧导航选项卡 -->
          <!-- 选项卡窗格 -->
          <div class="tab-content">
            <div class="tab-pane active" id="mmenu-users">
              <h5>
                <strong>
                  在线用户
                </strong>
              </h5>
              <ul class="users-list">
                <li class="online">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/ici-avatar.jpg" alt="" />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Ing. Imrich
                        <strong>
                          Kamarel
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Ulaanbaatar, Mongolia
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="online">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/arnold-avatar.jpg" alt=""
                      />
                    </a>
                    <span class="badge badge-red unread">
                      3
                    </span>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Arnold
                        <strong>
                          Karlsberg
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Bratislava, Slovakia
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="busy">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/random-avatar2.jpg" alt=""
                      />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Jesse
                        <strong>
                          Phoenix
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Berlin, Germany
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
              <h5>
                <strong>
                  离线用户
                </strong>
              </h5>
              <ul class="users-list">
                <li class="offline">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/random-avatar4.jpg" alt=""
                      />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Dell
                        <strong>
                          MacApple
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Paris, France
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane" id="mmenu-history">
              <h5>
                <strong>
                  聊天记录
                </strong>
              </h5>
              <ul class="history-list">
                <li class="online">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/ici-avatar.jpg" alt="" />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Ing. Imrich
                        <strong>
                          Kamarel
                        </strong>
                      </h6>
                      <small>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="busy">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/arnold-avatar.jpg" alt=""
                      />
                    </a>
                    <span class="badge badge-red unread">
                      3
                    </span>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Arnold
                        <strong>
                          Karlsberg
                        </strong>
                      </h6>
                      <small>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                        dolore eu fugiat nulla pariatur
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="offline">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/peter-avatar.jpg" alt=""
                      />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Peter
                        <strong>
                          Kay
                        </strong>
                      </h6>
                      <small>
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                        deserunt mollit
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane" id="mmenu-friends">
              <h5>
                <strong>
                  好友列表
                </strong>
              </h5>
              <ul class="favourite-list">
                <li class="online">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/arnold-avatar.jpg" alt=""
                      />
                    </a>
                    <span class="badge badge-red unread">
                      3
                    </span>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Arnold
                        <strong>
                          Karlsberg
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Bratislava, Slovakia
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="offline">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/random-avatar8.jpg" alt=""
                      />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Anna
                        <strong>
                          Opichia
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Budapest, Hungary
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="busy">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/random-avatar1.jpg" alt=""
                      />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Lucius
                        <strong>
                          Cashmere
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Wien, Austria
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
                <li class="online">
                  <div class="media">
                    <a class="pull-left profile-photo" href="javascript:void(0);">
                      <img class="media-object" src="<?= Yii::$app->request->baseUrl; ?>/assets/images/ici-avatar.jpg" alt="" />
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading">
                        Ing. Imrich
                        <strong>
                          Kamarel
                        </strong>
                      </h6>
                      <small>
                        <i class="fa fa-map-marker">
                        </i>
                        Ulaanbaatar, Mongolia
                      </small>
                      <span class="badge badge-outline status">
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="tab-pane pane-settings" id="mmenu-settings">
              <h5>
                <strong>
                  聊天设置
                </strong>
              </h5>
              <ul class="settings">
                <li>
                  <div class="form-group">
                    <label class="col-xs-8 control-label">
                      显示离线用户
                    </label>
                    <div class="col-xs-4 control-label">
                      <div class="onoffswitch greensea">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                        id="show-offline" checked="" />
                        <label class="onoffswitch-label" for="show-offline">
                          <span class="onoffswitch-inner">
                          </span>
                          <span class="onoffswitch-switch">
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form-group">
                    <label class="col-xs-8 control-label">
                      显示全名
                    </label>
                    <div class="col-xs-4 control-label">
                      <div class="onoffswitch greensea">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                        id="show-fullname" />
                        <label class="onoffswitch-label" for="show-fullname">
                          <span class="onoffswitch-inner">
                          </span>
                          <span class="onoffswitch-switch">
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form-group">
                    <label class="col-xs-8 control-label">
                      启用历史纪录
                    </label>
                    <div class="col-xs-4 control-label">
                      <div class="onoffswitch greensea">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                        id="show-history" checked="" />
                        <label class="onoffswitch-label" for="show-history">
                          <span class="onoffswitch-inner">
                          </span>
                          <span class="onoffswitch-switch">
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form-group">
                    <label class="col-xs-8 control-label">
                      显示位置
                    </label>
                    <div class="col-xs-4 control-label">
                      <div class="onoffswitch greensea">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                        id="show-location" checked="" />
                        <label class="onoffswitch-label" for="show-location">
                          <span class="onoffswitch-inner">
                          </span>
                          <span class="onoffswitch-switch">
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="form-group">
                    <label class="col-xs-8 control-label">
                      通知
                    </label>
                    <div class="col-xs-4 control-label">
                      <div class="onoffswitch greensea">
                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"
                        id="show-notifications" />
                        <label class="onoffswitch-label" for="show-notifications">
                          <span class="onoffswitch-inner">
                          </span>
                          <span class="onoffswitch-switch">
                          </span>
                        </label>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <!-- tab-pane -->
          </div>
          <!-- /选项卡窗格 -->
        </div>
        */
        ?>
      </div>
    </div>
    <section class="videocontent" id="video">
    </section>
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>