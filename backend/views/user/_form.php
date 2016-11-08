<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\City;
use kartik\select2\Select2;
use components\Oss;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->radioList(User::getValues('gender')) ?>

    <?= $form->field($model, 'province')->widget(
        Select2::classname(), 
        [  
            'data' => City::getCityList(0), 
            'options' => [
                'placeholder' => Yii::t('common', 'Prompt'),
                'onchange' => 'getCity()'
            ]
        ]);
    ?>

    <?= $form->field($model, 'city')->widget(
        Select2::classname(), 
        [  
            'data' => City::getCityList($model->province), 
            'options' => [
                'placeholder' => Yii::t('common', 'Prompt')
            ],
        ]);
    ?>

    <?= $form->field($model, 'avatar')->fileInput() ?>
    
    <?=
        ($model->avatar) ? Html::img(
            Oss::getUrl('user', 'avatar', $model->avatar),
            [
              'width' => 100,
              'height' => 100,
              'style'=> 'margin-bottom:10px;',
            ]
        ) : $model->avatar
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php
    /*
    <?= $form->field($model, 'open_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'source')->textInput() ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>
    */
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    function getCity(){
        pid = $('#user-province').find('option:selected').val();
        url = "<?= Yii::$app->urlManager->createUrl(['user/get-city']) ?>";
        if(pid){
            $.get(url,{pid:pid},function(data){
                $('#user-city').html(data);
                city = $('#user-city > option:eq(0)').html();
                $('#select2-user-city-container').attr('title', city);
                $('#select2-user-city-container').html(city);
            });
        }
    }
</script>