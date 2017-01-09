<?php

namespace components;

use Yii;

class Alidayu {

	private $topClient;

    public function __construct()
    {
        $this->topClient = new \TopClient;
        $this->topClient->appkey = Yii::$app->params['alidayu']['appkey'];
        $this->topClient->secretKey = Yii::$app->params['alidayu']['secretKey'];
    }

    public function sendPhoneVerifyCode($phone_number, $type = 'signup')
    {
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $code = $this->verify_code();
        $name = Yii::$app->params['alidayu']['name'];
        $req->setExtend($code);
        $req->setSmsType("normal");
        $req->setSmsFreeSignName(Yii::$app->params['alidayu'][$type]['smsFreeSignName']);
        $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$name\"}");
        $req->setRecNum($phone_number);
        $req->setSmsTemplateCode(Yii::$app->params['alidayu'][$type]['smsTemplateCode']);
        $resp = $this->topClient->execute($req);
        return (isset($resp->result->success) && $resp->result->success == true) ? $code : false;
    }

    public function phoneVerifyCode($model, $page = 1, $size = 50)
    {
        $req = new \AlibabaAliqinFcSmsNumQueryRequest;
        $req->setRecNum($model->phone_number);
        $req->setQueryDate(date('Ymd'));
        $req->setCurrentPage($page);
        $req->setPageSize($size);
        $resp = $this->topClient->execute($req);
        $obj = $resp->values;
        if($obj){
            foreach ($obj->fc_partner_sms_detail_dto as $value) {
                if($value->extend == $model->phone_verify_code && $value->sms_status == 3){
                    $second = floor(strtotime(date('Y-m-d H:i:s')) - strtotime($value->sms_receiver_time));
                    if($second <= 300){
                        return true;
                    }
                }
            }
        }
        return false;
    }
 
    public function verify_code($length = 4) 
    {  
        return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);  
    }

}