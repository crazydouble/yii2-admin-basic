<?php
use frontend\assets\LoginAsset;
use yii\helpers\Html;
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?= Html::encode(Yii::$app->name) ?>"/>
    <meta name="description" content="<?= Html::encode(Yii::$app->name) ?>"/>
    <!--
    // 需根据项目修改
    <meta property="qc:admins" content="147316564662173052056375" />
    <meta property="wb:webmaster" content="2188bc7148e1e3c0" />
    -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>

<body class="p-body6">
    <?php $this->beginBody() ?>
        <div class="m-stwrap1" style="visibility: visible; opacity: 1;">
        <div class="logo">
          <h1 class="f1">
            <?= Html::encode(Yii::$app->name) ?>
          </h1>
        </div>
        <div class="m-region">
          <div class="m-userlnks f-cb" action="<?= Yii::$app->controller->action->id ?>">
          	<?= Html::a(Html::encode(Yii::t('frontend', 'Sign Up')),['signup'],['class' => 'signup']) ?>
          	<?= Html::a(Html::encode(Yii::t('frontend', 'Login')), ['login'],['class' => 'login']) ?>
          	<?= Html::a(Html::encode(Yii::t('frontend', 'Down App')), 'javascript:void(0);', ['class' => 'dwdapp']) ?>
          </div>
          <div class="m-forms">
            <div class="m-reg">
              <div class="cont f-cb">
                <?= $content ?>
                <div class="contr">
                  <div class="others">
                    <span class="sepln">
                    </span>
                    <span class="septxt">
                      或
                    </span>
                    <ul class="w-user w-user-3" id="otherLogin1">
                      <li class="w1 sina">
                      	<?= Html::a(Html::encode(Yii::t('common', 'Weibo')), ['auth', 'authclient' => 'weibo'], ['class' => 'w-btn3']) ?>
                      </li>
                      <li class="w1 qq">
                      	<?= Html::a(Html::encode(Yii::t('common', 'Qq')), ['auth', 'authclient' => 'qq'], ['class' => 'w-btn3 w-btn3-1']) ?>
                      </li>
                      <li class="w1 weixin">
                      	<?= Html::a(Html::encode(Yii::t('common', 'Weixin')), ['auth', 'authclient' => 'weixin'], ['class' => 'w-btn3 w-btn3-4']) ?>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php $this->endBody() ?>
    <script type="text/javascript">
      $("."+$('.m-userlnks').attr('action')).addClass('crt');
    </script>
</body>
</html>
<?php $this->endPage() ?>