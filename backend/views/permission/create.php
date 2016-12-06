<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Rbac */
?>
<div id="content" class="col-md-12">
  <div class="pageheader">
    <h2>
      <i class="fa fa-cog" style="line-height: 48px;padding-left: 1px;">
      </i>
      <?= Yii::t('backend', 'Create Permission') ?>
    </h2>
    <div class="breadcrumbs">
      <ol class="breadcrumb">
        <li>
          位置
        </li>
        <li>
          <?= Html::a(Html::encode(Yii::$app->name), Yii::$app->homeUrl) ?>
        </li>
        <li class="active">
          <?= Yii::t('backend', 'System Management') ?>
        </li>
        <li class="active">
          <?= Html::a(Yii::t('backend', 'Permissions'), ['index']) ?>
        </li> 
        <li class="active">
          <?= Yii::t('backend', 'Create Permission') ?>
        </li>
      </ol>
    </div>
  </div>
  <div class="main">
    <div class="row">
      <div class="col-md-6">
        <section class="tile color transparent-black">
          <div class="tile-body">
          	<?= $this->render('_form', [
                  'model' => $model,
            ]) ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>