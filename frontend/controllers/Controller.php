<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class Controller extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            // 前台必须登录才能使用
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //指定该规则是 "允许" 还是 "拒绝"
                        'allow' => true,
                        //@ 已认证用户
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}