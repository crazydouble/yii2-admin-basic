<?php

use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

LoginAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
    	.help-block{
    		float:right;
    		margin-top:-27px;
    		margin-right:5px;
    	}
    </style>
</head>

<body class="bg-3">
    <?php $this->beginBody() ?>
    <div class="container">
		<div id="wrap">
			<div class="row">
				<div id="content" class="col-md-12 full-page login">
					<div class="inside-block">
						<img src="<?= Yii::$app->request->baseUrl; ?>/assets/images/logo-big.png" alt class="logo">
						<h1><strong><?= Html::encode(Yii::$app->name) ?></strong></h1>
						<?php $form = ActiveForm::begin([
							'fieldConfig' => [
								'template' => "{input}{error}"
							]
						]); ?>
						<section>
							<div class="input-group">
							  <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class'=>'form-control','placeholder'=>'请输入管理员账号']) ?>
							  <div class="input-group-addon"><i class="fa fa-user"></i></div>
							</div>
							<div class="input-group">
							  <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'请输入密码']) ?>
							  <div class="input-group-addon"><i class="fa fa-key"></i></div>
							</div>
						</section>
						<section class="controls">
							<div class="checkbox check-transparent">
								<?= $form->field($model,'rememberMe')->checkbox([
			                        'id' => 'remember',
			                        'template' => "{input}{label}"
			                    ])?>
							</div>
							<?= Html::a(Yii::t('backend', 'Forgot Password'), 'javascript:void(0);') ?>
						</section>
						<section class="log-in">
							<?= Html::submitButton(Yii::t('backend', 'Login'), ['class' => 'btn btn-greensea']) ?>
							<span>or</span>
							<?= Html::a(Yii::t('backend', 'Contact Admin'), 'mailto:'.Yii::$app->params['adminEmail'], ['class' => 'btn btn-slategray']) ?>
						</section>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>