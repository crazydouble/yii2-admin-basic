<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Admin;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
?>
<div id="content" class="col-md-12">
  <div class="pageheader">
    <h2>
      <i class="fa fa-cog" style="line-height: 48px;padding-left: 1px;">
      </i>
      <?= Yii::t('backend', 'View Admin') ?>
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
          <?= Html::a(Yii::t('backend', 'Admins'), ['index']) ?>
        </li> 
        <li class="active">
          <?= Yii::t('backend', 'View Admin') ?>
        </li>
      </ol>
    </div>
  </div>
  <div class="main">
    <div class="row">
      <div class="col-md-6 view_width">
        <section class="tile color transparent-black">
          <div class="tile-body">
            <p>
                <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('backend', 'Back'), ['index'], ['class' => 'btn btn-danger']) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'nickname',
                    'email:email',
                    'auth_key',
                    'password_hash',
                    'password_reset_token',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'status',
                        'value' => Admin::getValues('status',$model->status)
                    ],
                ],
            ]) ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>