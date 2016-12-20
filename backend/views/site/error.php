<?php 

use yii\helpers\Html;
Yii::$app->layout = 'error'; 

?>
<div class="cont">
	<?php if (!empty($_GET['type']) && $_GET['type'] == 'permission'): ?>
		<div class="c1">
			<img src="<?= Yii::$app->request->baseUrl; ?>/assets/images/error/05.png" class="img1">
		</div>

		<h2><?= Yii::t('backend', 'Permission Error') ?></h2>
		<div class="c2">
			<a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="re"><?= Yii::t('backend', 'Back') ?></a>
			<a href="<?= Yii::$app->homeUrl ?>" class="home"><?= Yii::t('backend', 'Back Home') ?></a>
		</div>
	<?php else: ?>
		<div class="c1">
			<img src="<?= Yii::$app->request->baseUrl; ?>/assets/images/error/01.png" class="img1">
		</div>

		<h2><?= Yii::t('backend', 'Error') ?></h2>
		<div class="c2">
			<a href="<?= $_SERVER['HTTP_REFERER'] ?>" class="re"><?= Yii::t('backend', 'Back') ?></a>
			<a href="<?= Yii::$app->homeUrl ?>" class="home"><?= Yii::t('backend', 'Back Home') ?></a>
			<!--
			<a href="http://www.sj5d.com" class="home">返回首页</a>
			<a href="http://www.moke8.com" class="sr">搜索一下页面相关信息</a>
			-->
		</div>
		<div class="c3">
			提醒： 您可能输入了错误的网址，或者该网页已删除或移动
		</div>
	<?php endif; ?>
</div>