<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use common\models\City;
use components\Oss;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
?>
<div id="content" class="col-md-12">
  <div class="pageheader">
    <h2>
      <i class="fa fa-user" style="line-height: 48px;padding-left: 1px;">
      </i>
      <?= Yii::t('backend', 'View User') ?>
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
          <?= Yii::t('backend', 'User Management') ?>
        </li>
        <li class="active">
          <?= Html::a(Yii::t('backend', 'Users'), ['index']) ?>
        </li> 
        <li class="active">
          <?= Yii::t('backend', 'View User') ?>
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
                    'phone_number',
                    'email:email',
                    'nickname',
                    [
                        'attribute' => 'gender',
                        'value' => User::getValues('gender',$model->gender)
                    ],
                    [
                        'label' => '省',
                        'attribute' => 'provinces.name'
                    ],
                    [
                        'label' => '市',
                        'attribute' => 'citys.name'
                    ],
                    [
                        'attribute' => 'avatar',
                        'format' => 'raw',
                        'value' => ($model->avatar) ? Html::img(
                            Oss::getUrl('user', 'avatar', $model->avatar),
                            [
                              'width' => 200,
                              'height' => 200
                            ]
                        ) : $model->avatar, 
                    ],
                    'description:ntext',
                    'open_id',
                    [
                        'attribute' => 'source',
                        'value' => User::getValues('source',$model->source)
                    ],
                    'auth_key',
                    'password_hash',
                    'password_reset_token',
                    'access_token',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'status',
                        'value' => User::getValues('status',$model->status)
                    ],
                ],
            ]) ?>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>