<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="contl">
    <?php $form = ActiveForm::begin(); ?>
    <ul class="w-user w-user-2">
      <li class="w0">
        <div class="inpt">
          <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'class'=>'txt', 'placeholder'=>'手机号'])->label(false) ?> 
        </div>
      </li>
      <li class="w0">
        <div class="inpt">
          <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'class'=>'txt', 'placeholder'=>'请输入密码'])->label(false) ?>
        </div>
      </li>
      <li class="w0 w2">
        <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class'=>'w-btn w-btn-0']) ?>
      </li>
      <li class="w0 w3 f-cb">
        <span class="chkbox" style="font-size:12px;">
          <span class="c j-ok">
            <input id="c0" type="checkbox">
          </span>
          <a class="ztag" tabindex="3" href="javascript:void(0);">
            <?= Yii::t('frontend', 'Remember Me') ?>
          </a>
        </span>
        <!--
        <?= Html::a(Yii::t('frontend', 'Reset Password'), Yii::$app->urlManager->createUrl(['site/reset-password']), ['class' => 'fgt']) ?>
        -->
      </li>
    </ul>
  <?php ActiveForm::end(); ?>
</div>