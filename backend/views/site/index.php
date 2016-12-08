<?php 

use yii\helpers\Html; 

?>
<div id="content" class="col-md-12"> 
 <div class="pageheader"> 
  <h2><i class="fa fa-tachometer"></i> <?= Yii::t('backend', 'Index') ?> </h2> 
  <div class="breadcrumbs"> 
   <ol class="breadcrumb"> 
    <li>当前位置</li> 
    <li><?= Html::a(Html::encode(Yii::$app->name), Yii::$app->homeUrl) ?></li>
    <li class="active"><?= Yii::t('backend', 'Index') ?></li> 
   </ol> 
  </div> 
 </div> 
 <div class="main"> 
  <div class="row cards"> 
   <div class="card-container col-lg-3 col-sm-6 col-sm-12"> 
    <div class="card card-redbrown hover"> 
     <div class="front"> 
      <div class="media"> 
       <span class="pull-left"> <i class="fa fa-users media-object"></i> </span> 
       <div class="media-body"> 
        <small>注册用户 - 1w</small> 
        <h2 class="media-heading animate-number" data-value="<?= $count['user']; ?>" data-animation-duration="10000"><?= $count['user']; ?></h2> 
       </div> 
      </div> 
      <div class="progress-list"> 
       <div class="details"> 
        <div class="title">
         本月计划 %
        </div> 
       </div> 
       <div class="status pull-right bg-transparent-black-1"> 
        <span class="animate-number" data-value="<?= $count['user'] / 10000 * 100; ?>" data-animation-duration="1500">0</span>% 
       </div> 
       <div class="clearfix"></div> 
       <div class="progress progress-little progress-transparent-black"> 
        <div class="progress-bar animate-progress-bar" data-percentage="<?= $count['user'] / 10000 * 100; ?>%"></div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
   <?php
   /*
   // 需根据项目修改
   <div class="card-container col-lg-3 col-sm-6 col-sm-12"> 
    <div class="card card-blue hover"> 
     <div class="front"> 
      <div class="media"> 
       <span class="pull-left"> <i class="fa fa-volume-up media-object"></i> </span> 
       <div class="media-body"> 
        <small>用户数量 - 100</small> 
        <h2 class="media-heading animate-number" data-value="<?= $count['user']; ?>" data-animation-duration="1500"><?= $count['singer']; ?></h2> 
       </div> 
      </div> 
      <div class="progress-list"> 
       <div class="details"> 
        <div class="title">
         本月计划 %
        </div> 
       </div> 
       <div class="status pull-right bg-transparent-black-1"> 
        <span class="animate-number" data-value="<?= $count['user'] / 100 * 100; ?>" data-animation-duration="1500">0</span>% 
       </div> 
       <div class="clearfix"></div> 
       <div class="progress progress-little progress-transparent-black"> 
        <div class="progress-bar animate-progress-bar" data-percentage="<?= $count['user'] / 100 * 100 ;?>%"></div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
   <div class="card-container col-lg-3 col-sm-6 col-sm-12"> 
    <div class="card card-greensea hover"> 
     <div class="front"> 
      <div class="media"> 
       <span class="pull-left"> <i class="fa fa-music media-object"></i> </span> 
       <div class="media-body"> 
        <small>用户数量 - 500</small> 
        <h2 class="media-heading animate-number" data-value="<?= $count['user']; ?>" data-animation-duration="1500"><?= $count['song']; ?></h2> 
       </div> 
      </div> 
      <div class="progress-list"> 
       <div class="details"> 
        <div class="title">
         本月计划 %
        </div> 
       </div> 
       <div class="status pull-right bg-transparent-black-1"> 
        <span class="animate-number" data-value="<?= $count['user'] / 500 * 100; ?>" data-animation-duration="1500">0</span>% 
       </div> 
       <div class="clearfix"></div> 
       <div class="progress progress-little progress-transparent-black"> 
        <div class="progress-bar animate-progress-bar" data-percentage="<?= $count['user'] / 500 * 100; ?>%"></div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
   */
   ?>
   <div class="card-container col-lg-3 col-sm-6 col-xs-12"> 
    <div class="card card-slategray hover"> 
     <div class="front"> 
      <div class="media"> 
       <span class="pull-left"> <i class="fa fa-eye media-object"></i> </span> 
       <div class="media-body"> 
        <small>访问量</small> 
        <h2 class="media-heading animate-number" data-value="0" data-animation-duration="1500">0</h2> 
       </div> 
      </div> 
      <div class="progress-list"> 
       <div class="details"> 
        <div class="title">
         本月计划 %
        </div> 
       </div> 
       <div class="status pull-right bg-transparent-black-1"> 
        <span class="animate-number" data-value="0" data-animation-duration="1500">0</span>% 
       </div> 
       <div class="clearfix"></div> 
       <div class="progress progress-little progress-transparent-black"> 
        <div class="progress-bar animate-progress-bar" data-percentage="0%"></div> 
       </div> 
      </div> 
     </div> 
    </div> 
   </div> 
  </div> 
 </div> 
</div> 