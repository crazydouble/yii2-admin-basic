<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Rbac;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Rbac */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rbac-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'permission')->widget(
        Select2::classname(), 
        [
            'data' => Rbac::getPermissionList(),
            'options' => [
                'multiple' => true,
                'placeholder' => Yii::t('common', 'Prompt')
            ]
        ]);
    ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php
    /*
    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

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
