<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\grid\EnumColumn;
use backend\models\Admin;
use kartik\date\DatePicker; 
use common\models\Format;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div id="content" class="col-md-12">
    <div class="pageheader"> 
        <h2><i class="fa fa-cog"></i> <?= Yii::t('backend', 'Admins') ?> </h2> 
        <div class="breadcrumbs"> 
            <ol class="breadcrumb"> 
                <li>当前位置</li>
                <li>
                    <?= Html::a(Html::encode(Yii::$app->name), Yii::$app->homeUrl) ?>
                </li>
                <li class="active">
                  <?= Yii::t('backend', 'System Management') ?>
                </li>
                <li class="active">
                    <?= Html::a(Yii::t('backend', 'Admins'), ['index']) ?>
                </li>
            </ol>
        </div> 
    </div> 
    <div class="main">
        <div class="row">
          <div class="col-md-12">
            <section class="tile color transparent-black">
              <div class="tile-body color transparent-black rounded-corners">
                <p>
                    <?= Html::a(Yii::t('backend', 'Create Admin'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            [
                                'attribute' => 'role',
                                'value' => function ($model) {
                                    $auth = Yii::$app->authManager;
                                    $role = $auth->getRolesByUser($model->id);
                                    return $role[key($role)]->description;
                                },
                            ],
                            'username',
                            'nickname',
                            'email:email',
                            // 'auth_key',
                            // 'password_hash',
                            // 'password_reset_token',
                            [
                                'attribute' => 'created_at',
                                'value' => function ($model) {
                                    return date('Y-m-d H:i:s', $model->created_at);
                                },
                                'filter' => DatePicker::widget([ 
                                    'name' => Format::getModelName($searchModel->className()).'[created_at]', 
                                    'type' => DatePicker::TYPE_BUTTON,
                                    'pluginOptions' => [ 
                                        'autoclose' => true, 
                                        'format' => 'yyyy-mm-dd', 
                                        'todayHighlight' => true, 
                                    ] 
                                ]),
                            ],
                            [
                                'attribute' => 'updated_at',
                                'value' => function ($model) {
                                    return date('Y-m-d H:i:s', $model->updated_at);
                                },
                                'filter' => DatePicker::widget([ 
                                    'name' => Format::getModelName($searchModel->className()).'[updated_at]', 
                                    'type' => DatePicker::TYPE_BUTTON,
                                    'pluginOptions' => [ 
                                        'autoclose' => true, 
                                        'format' => 'yyyy-mm-dd', 
                                        'todayHighlight' => true, 
                                    ] 
                                ]),
                            ],
                            [
                                'class' => EnumColumn::className(),
                                'attribute' => 'status',
                                'filter' => Admin::getValues('status'),
                                'enum' => Admin::getValues('status'),
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
              </div>
            </section>
          </div>
        </div> 
    </div>
</div>