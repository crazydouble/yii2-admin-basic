<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AdminLog;

/* @var $this yii\web\View */
/* @var $model backend\models\AdminLog */
?>
<div id="content" class="col-md-12">
  <div class="pageheader">
    <h2>
      <i class="fa fa-file-o" style="line-height: 48px;padding-left: 1px;">
      </i>
      <?= Yii::t('backend', 'View Log') ?>
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
          <?= Html::a(Yii::t('backend', 'AdminLogs'), ['index']) ?>
        </li> 
        <li class="active">
          <?= Yii::t('backend', 'View Log') ?>
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
               <?= Html::a(Yii::t('backend', 'Back'), ['index'], ['class' => 'btn btn-danger']) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'admins.nickname',
                    'admin_ip',
                    'admin_agent',
                    'controller',
                    'action',
                    'details:ntext',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'status',
                        'value' => AdminLog::getValues('status',$model->status)
                    ],
                ],
            ]) ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>