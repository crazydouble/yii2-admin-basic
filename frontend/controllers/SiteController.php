<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'auth', 'send-phone-verify-code', 'reset-password', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    /**
     * 显示首页
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 注册用户
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'site';
        $model = new User(['scenario' => 'alidayu']);
        if ($model->load(Yii::$app->request->post())) {
            if($user = $model->signup()){
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } 
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Oauth 成功回调
     * @param QqAuth|WeiboAuth $client
     * @see http://wiki.connect.qq.com/get_user_info
     * @see http://stuff.cebe.cc/yii2docs/yii-authclient-authaction.html
     */
    public function successCallback($client) {
        // qq | sina | weixin
        $id = $client->getId(); 
        // basic info
        //$attributes = $client->getUserAttributes(); 
        //user openid
        $openid = $client->getOpenid(); 
        // user extend info
        $userInfo = $client->getUserInfo(); 
        $user = User::findByOpenId($openid);
        if ($user) {
            if ($user->status = User::STATUS_ACTIVE) {
                if(Yii::$app->user->login($user)){
                    return $this->goHome();
                }
            }
        }else{
            $model = new User(['scenario' => 'oauth']);
            if ($user = $model->oauthSignup($id, $openid, $userInfo)) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } 
        }
        return $this->redirect(['login']); 
    }

    /**
     * 发送手机验证码
     */
    public function actionSendPhoneVerifyCode($phone_number, $code, $type = 'signup'){
        $c = new \TopClient();
        $c->appkey = Yii::$app->params['alidayu']['appkey'];
        $c->secretKey = Yii::$app->params['alidayu']['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend($code);
        $req->setSmsType("normal");
        $req->setSmsFreeSignName(Yii::$app->params['alidayu'][$type]['smsFreeSignName']);
        $req->setSmsParam("{\"code\":\"$code\",\"product\":\"饶舌者Rappers\"}");
        $req->setRecNum($phone_number);
        $req->setSmsTemplateCode(Yii::$app->params['alidayu'][$type]['smsTemplateCode']);
        $c->execute($req);
    }
    
    /**
     * 登录用户
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout = 'site';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 注销当前用户
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(false);

        return $this->goHome();
    }
}