<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\grid\EnumColumn;
use common\models\User;
use components\Oss;
use kartik\date\DatePicker; 
use common\models\Format;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div id="content" class="col-md-12">
    <div class="pageheader"> 
        <h2><i class="fa fa-user"></i> <?= Yii::t('backend', 'Users') ?> </h2> 
        <div class="breadcrumbs"> 
            <ol class="breadcrumb"> 
                <li>当前位置</li> 
                <li>
                    <?= Html::a(Html::encode(Yii::$app->name), Yii::$app->homeUrl) ?>
                </li>  
                <li class="active">
                    <?= Yii::t('backend', 'User Management') ?>
                </li> 
                <li class="active">
                    <?= Html::a(Yii::t('backend', 'Users'), ['index']) ?>
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
                    <?= Html::a(Yii::t('backend', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'phone_number',
                            'email:email',
                            'nickname',
                            [
                                'class' => EnumColumn::className(),
                                'attribute' => 'gender',
                                'filter' => User::getValues('gender'),
                                'enum' => User::getValues('gender')
                            ],
                            [
                                'label' => '省',
                                'attribute' => 'province_name',
                                'value' => 'provinces.name',
                                
                            ],
                            [
                                'label' => '市',
                                'attribute' => 'city_name',
                                'value' => 'citys.name',
                                
                            ],
                            /*
                            [
                               'attribute' => 'avatar',
                               'format' => 'raw',
                               'value' => function($model) {
                                    return ($model->avatar) ? Html::img(
                                        Oss::getUrl('user', 'avatar', $model->avatar),
                                        [
                                            'class' => 'img-circle',
                                            'width' => 50
                                        ]
                                    ) : $model->avatar;
                                }
                            ],
                            */
                            /*
                            [
                               'attribute' => 'description',  
                               'value' => function ($model) {
                                  return Format::mb_substr($model->description);
                                }
                            ],
                            */
                            // 'open_id',
                            [
                                'class' => EnumColumn::className(),
                                'attribute' => 'source',
                                'filter' => User::getValues('source'),
                                'enum' => User::getValues('source')
                            ],
                            // 'auth_key',
                            // 'password_hash',
                            // 'password_reset_token',
                            // 'access_token',
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
                                'filter' => User::getValues('status'),
                                'enum' => User::getValues('status')
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