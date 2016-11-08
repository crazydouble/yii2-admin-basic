<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
}