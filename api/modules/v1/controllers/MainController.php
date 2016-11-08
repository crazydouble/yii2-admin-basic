<?php
namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;  
use yii\filters\auth\HttpBasicAuth;  
use yii\filters\auth\HttpBearerAuth;  
use yii\filters\auth\QueryParamAuth;  
use yii\filters\RateLimiter;  

class MainController extends ActiveController
{
    public $serializer = [
         'class' => 'yii\rest\Serializer',
         'collectionEnvelope' => 'items'
    ];

    public function behaviors()
	{
	    $behaviors = parent::behaviors();
	    $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
	    /*
	    $behaviors['authenticator'] = [  
            'class' => CompositeAuth::className(),  
            'authMethods' => [  
                # 下面是三种验证access_token方式  
                //HttpBasicAuth::className(),  
                //HttpBearerAuth::className(),  
                # 这是GET参数验证的方式  
                # http://10.10.10.252:600/user/index/index?access-token=xxxxxxxxxxxxxxxxxxxx  
                QueryParamAuth::className(),  
            ],  
          
        ];
        */
	    return $behaviors;
	}

    public function actions()
	{
		$actions = parent::actions();
		// 注销系统自带的实现方法
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
    	return $actions;
	}
}