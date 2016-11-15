<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="contl">
  <?php $form = ActiveForm::begin(); ?>
    <ul class="w-user w-user-1">
        <li class="w0">
            <div class="inpt">
              <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'class'=>'txt', 'placeholder'=>'请输入您的手机号'])->label(false) ?>
            </div>
        </li>
        <li class="w0">
            <div class="inpt">
                <input id="btnSendCode" type="button" value='获取验证码' onClick="sendMessage()" />
                <?= $form->field($model, 'phone_verify_code')->textInput(['maxlength' => true, 'class'=>'txt', 'placeholder'=>'请输入验证码'])->label(false) ?>
            </div>
        </li>
        <li class="w0">
            <div class="inpt">
            <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'class'=>'txt', 'placeholder'=>'设置密码'])->label(false) ?>
            </div>
        </li>
        <li class="w0 w2">
            <?php echo Html::submitButton(Yii::t('frontend', 'Sign Up'), ['class'=>'w-btn w-btn-0']) ?>
        </li>
    </ul>
  <?php ActiveForm::end(); ?>
</div>
<script>
    var InterValObj; //timer变量，控制时间
    var count = 30; //间隔函数，1秒执行
    var curCount; //当前剩余秒数
    var code = ''; //验证码
    var codeLength = 6;//验证码长度
    function sendMessage() {
      curCount = count;
      var phone_number = $('#user-phone_number').val(); //获取手机号
      //判断手机是否符合规范
      if (phone_number.match(/^1[3|4|5|7|8]\d{9}/)) { 
        //产生验证码
        for (var i = 0; i < codeLength; i++) {
          code += parseInt(Math.random() * 9).toString();
        }
        //设置button效果，开始计时
        $('#btnSendCode').attr('disabled', 'true');
        $('#btnSendCode').val( + curCount + '秒再获取');
        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
        //向后台发送处理数据
        url = "<?= Yii::$app->urlManager->createUrl(['site/send-phone-verify-code']) ?>";
        $.get(url,{phone_number:phone_number,code:code});
      }
    }
    //timer处理函数
    function SetRemainTime() {
      if (curCount == 0) {                
        window.clearInterval(InterValObj);//停止计时器
        $('#btnSendCode').removeAttr('disabled');//启用按钮
        $('#btnSendCode').val("重新发送");
        code = ''; //清除验证码。如果不清除，过时间后，输入收到的验证码依然有效    
      }
      else {
        curCount--;
        $('#btnSendCode').val( + curCount + '秒再获取');
      }
    }
    
</script>