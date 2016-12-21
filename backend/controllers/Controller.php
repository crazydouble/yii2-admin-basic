<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Menu;

class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            // 后台必须登录才能使用
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        // 指定该规则是 "允许" 还是 "拒绝"
                        'allow' => true,
                        // @ 已认证用户
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        parent::actions();
        $this->authCan();
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function authCan()
    {
        $action = Yii::$app->controller->id;
        $route = Yii::$app->controller->module->requestedRoute;
        if(!Yii::$app->user->identity->id || $route == 'site/logout' || $route == 'site/error'){
            return;
        }

        if(!Yii::$app->user->can($action)){
            //首页没有权限
            if($action == 'site'){
                $this->redirect([$this->getRedirectUrl()]);
                Yii::$app->end();
            }else{
                $this->redirect(['site/error', 'type' => 'permission']);
                Yii::$app->end();
            }
        }

        $end = explode('/', $route);
        $filter = ['create', 'view', 'update', 'delete'];
        if(in_array(end($end), $filter)){
            if(!Yii::$app->user->can($route)){
                $this->redirect(['site/error', 'type' => 'permission']);
                Yii::$app->end();
            }
        }
    }

    public function getRedirectUrl()
    {
        foreach (Menu::menuList()as $value) {
            foreach (Menu::menuList($value->id) as $v) {
                if(Yii::$app->user->can($v->route)){
                    return $v->route."/index";
                }
            }
        }
        return false;
    }
}