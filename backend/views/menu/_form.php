<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Menu;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .icon {margin: -10px 0px 15px 0px; height: 60px; background: rgba(0, 0, 0, 0.3); border-radius: 5px;}
    .icon h1 {display:inline;padding: 0px 5px 0px 5px;position: relative;margin-left: 5px;}
    .icon h1 i {margin-top:15px;}
    .icon .active {border: 2px solid #70d445;}
    .disabled { pointer-events: none; background:rgba(255, 255, 255, 0.3);}
    .flag {
      display: none;
      background: url(<?= Yii::$app->request->baseUrl; ?>'/assets/images/pay_check_status.png') no-repeat;
      width: 23px;
      height: 23px;
      position: absolute;
      top: 0px;
      right: 0px;
      overflow: hidden;
    }
</style>
<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->widget(
        Select2::classname(), 
        [  
            'data' => $model->getMenuList(), 
            'options' => [
                'onchange' => 'display()',
                'placeholder' => Yii::t('common', 'Prompt')
            ]
        ]);
    ?>
    <?= $form->field($model, 'route')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
    
    <?= $form->field($model, 'icon')->hiddenInput(['maxlength' => true]) ?>
    <div class="icon">
        <h1><i class="fa fa-tachometer"></i><span class="flag"></span></h1>
        <h1><i class="fa fa-user"></i><span class="flag"></span></h1>
        <h1><i class="fa fa-cog"></i><span class="flag"></span></h1>
    </div>
    
    <?= $form->field($model, 'priority')->textInput() ?>

    <?php
    /*
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

<script>
    function display(){
        parent = $("#menu-parent").find('option:selected').val();
        if(parent == 0){
            $("#menu-route").attr('disabled', 'disabled');
            $(".icon").removeClass('disabled');
        }else{
            $("#menu-route").removeAttr('disabled');
            $(".icon").addClass('disabled');   
        }
    }

  <?php $this->beginBlock('js_end') ?> 
    display();
    icon = $("#menu-icon").val();
    if(icon){
        $('.' + icon).next().show();
    }
    
    //选择图标
    $('.icon > h1').click(function(){
      $('h1').removeClass('active');
      $('.flag').hide();

      $(this).addClass('active');
      $(this).children('.flag').show();
      var arr = $(this).children('.fa').attr('class').split(' ');

      $('#menu-icon').val(arr[1]);
    });
  <?php $this->endBlock() ?>
</script>