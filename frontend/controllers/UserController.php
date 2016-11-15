<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Html;
use common\models\User;
use frontend\models\ResetPasswordForm;
use common\models\City;
use common\models\Query;
use components\Oss;

class UserController extends Controller
{
	public function actionProfile($message = null)
    {
        $uid = Yii::$app->user->identity->id;
        $model = User::findOne($uid);
        $reset = new ResetPasswordForm();
        $result = [
            'model' => $model,
            'reset' => $reset,
            'message' => $message
        ];
        
        return $this->render('profile', $result);
    }
    // 修改个人资料
    public function actionUpdate()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        if ($model->source == User::SOURCE_PHONE) {
            $model->setScenario('update');
        }else{
            $model->setScenario('oauth');
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $message = '用户资料修改成功';
        }else{
            $message = Query::concatErrors($model);
        }

        return $this->redirect([
            'profile', 
            'message' => $message
        ]);
    }

    // 修改头像
    public function actionUpdateAvatar()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $message = '头像修改成功';
        }else{
            $message = Query::concatErrors($model);
        }

        return $this->redirect([
            'profile', 
            'message' => $message
        ]);
    }

    // 修改密码
    public function actionUpdatePassword()
    {
        $model = new ResetPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword()) {
            $message = '密码修改成功';
        }else{
            $message = Query::concatErrors($model);
        }

        return $this->redirect([
            'profile', 
            'message' => $message
        ]);
    }

    // 绑定手机
    public function actionBindPhone()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $model->setScenario('alidayu');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $message = '绑定手机已更改';
        }else{
            $message = Query::concatErrors($model);
        }

        return $this->redirect([
            'profile', 
            'message' => $message
        ]);
    }
    // 绑定邮箱
    public function actionBindEmail()
    {
        $model = User::findOne(Yii::$app->user->identity->id);
        $model->setScenario('bind');
        $model->email = $_POST['User']['email'];
        if($model->validate()){
            $message = $this->sendEmail($_POST['User']['email']);
        }else{
            $message = Query::concatErrors($model);
        }
        return $this->redirect(['profile', 'message' => $message]);
    }

    // 发送验证Email 需根据项目修改
    public function sendEmail($email)
    {
        $model = new User();
        $user = $model->findOne(Yii::$app->user->identity->id);
        $code = md5("rsz".$user->id.$email.$user->password_hash);
        $body = [
            'logo' => Oss::getUrl('other', 'user', 'email_logo.png'),
            'hostInfo' => Yii::$app->request->hostInfo,
            'backUrl' => Yii::$app->urlManager->createUrl(['user/bind-email-back', 'email' => $email, 'code' => $code]),
            'time' => date("Y-m-d")
        ];

        $mail= Yii::$app->mailer->compose();   
        $mail->setTo($email);  
        $mail->setSubject("饶舌者Rappers--邮箱变更验证");  
        $mail->setHtmlBody(
            "<div id='mailContentContainer' class='qmbox qm_con_body_content'>
                <style>.qmbox html{word-wrap:break-word;} .qmbox body{font-size:14px;font-family:arial,verdana,sans-serif;line-height:1.666;padding:8px 10px;margin:0;} .qmbox pre { white-space: pre-wrap; white-space: -moz-pre-wrap;white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word;}</style>
                <div style='width:660px;overflow:hidden;border:1px solid #e2e2e4;border-width:0 1px 1px;text-align:left;word-wrap:break-word;word-break:break-all;color:#444;font:normal 13px/20px arial;background:#fff;'>
                  <div style='width:660px;overflow:hidden;border-bottom:1px solid #bdbdbe;'>
                    <div style='height:75px;overflow:hidden;border:1px solid #464c51;background:#353b3f;'>
                      <a href='{$body['hostInfo']}' target='_blank' style='display:block;width:143px;height:65px;margin:5px 0 0 25px;overflow:hidden;text-indent:-2000px;background:url({$body['logo']})no-repeat;'>
                        饶舌者Rappers
                      </a>
                    </div>
                    <div style='padding:24px 28px;'>
                      <div style='margin:0 0 18px;'>
                        您好，
                        <a href='mailto:$email' target='_blank'>
                          $email
                        </a>
                      </div>
                      <div style='margin:0 0 18px;'>
                        饶舌者Rappers 致力于“分享高品质的中文说唱音乐”，旨在为“分享音乐、追求音乐品质、崇尚自由空间”，打造一个自由的说唱音乐爱好者家园！
                      </div>
                      <div style='margin:0 0 18px;'>
                        请点击下方链接完成邮箱绑定：
                        <br>
                        <a href='{$body['hostInfo']}{$body['backUrl']}' target='_blank'>
                          {$body['hostInfo']}{$body['backUrl']}
                        </a>
                        <br>
                        如果以上链接无法点击，请把上面网页地址复制到浏览器地址栏中打开
                      </div>
                      <div style='margin:40px 0 15px;'>
                        <div>
                          <a style='text-decoration:none;color:#444;' href='{$body['hostInfo']}' target='_blank'>
                            饶舌者Rappers，分享音乐、专注说唱
                          </a>
                        </div>
                        <div>
                          <span style='border-bottom:1px dashed #ccc;' t='5' times=''>
                            {$body['time']}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>"
        );
        if($mail->send()){
            return "<a href='http://".$this->getEmailUrl($email)."' target='_blank'>邮件已发送,请登陆邮箱查收</a>";
        }
    }
    // 获取邮件激活跳转地址
    public function getEmailUrl($email)
    {
        $ext = explode('@', $email)[1];
        $mail = [
            "qq.com" => "mail.qq.com",
            "vip.qq.com" => "mail.qq.com",
            "sina.com" => "mail.sina.com.cn",
            "sina.cn" => "mail.sina.com.cn",
            "vip.sina.com" => "mail.sina.com.cn",
            "163.com" => "mail.163.com",
            "gmail.com" => "gmail.google.com",
            "hotmail.com" => "hotmail.msn.com",
            "sohu.com" => "mail.sohu.com",
            "126.com" => "mail.126.com",
            "139.com" => "mail.10086.cn",
            "21cn.cn" => "mail.21cn.com",
            "189.cn" => "mail.189.cn"
        ];
        if(!empty($mail[$ext])){
            return $mail[$ext];
        }
    }

    // 邮箱绑定 需根据项目修改
    public function actionBindEmailBack($email, $code)
    {
        $model = new User();
        $user = $model->findOne(Yii::$app->user->identity->id);
        if(md5("rsz".$user->id.$email.$user->password_hash) == $code){
            $user->email = $email;
            if($user->save()){
                return $this->redirect(['profile', 'message' => '邮箱绑定成功']);
            }
        }
    }

    // 获取省份对应城市
    public function actionGetCity($pid)
    {
        $model = City::getCityList($pid);
        foreach($model as $id => $name)
        {
            echo Html::tag('option',Html::encode($name),['value' => $id]);
        }
    }
}