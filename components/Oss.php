<?php

namespace components;

use chonder\AliyunOSS\AliyunOSS;
use Yii;
use yii\web\UploadedFile;

class OSS {

    private $ossClient;

    public function __construct($isInternal = false)
    {
        $serverAddress = $isInternal ? Yii::$app->params['oss']['ossServerInternal'] : Yii::$app->params['oss']['ossServer'];
        $this->ossClient = AliyunOSS::boot(
            $serverAddress,
            Yii::$app->params['oss']['AccessKeyId'],
            Yii::$app->params['oss']['AccessKeySecret']
        );
    }

    public static function upload($model, $table, $field)
    {
        $instance = UploadedFile::getInstance($model, $field);
        
        if ($instance) {
            //$oss = new OSS(true); // 上传文件使用内网，免流量费
            $oss = new OSS();

            $file_name = $oss->uuid($instance->extension);
            $ossKey = $table.'/'.$field.'/'.$file_name;
            $filePath = $instance->tempName;

            $oss->ossClient->setBucket(Yii::$app->params['oss']['Bucket']);
            $oss->ossClient->uploadFile($ossKey, $filePath);

            return $file_name;
        }
        return $model->$field; 
    }

    public static function oauthUpload($filePath, $table, $field, $extension = 'jpg'){
        if ($filePath) {
            //$oss = new OSS(true); // 上传文件使用内网，免流量费
            $oss = new OSS();

            $file_name = $oss->uuid($extension);
            $ossKey = $table.'/'.$field.'/'.$file_name;

            $img = $oss->curl_file_get_contents($filePath);
            $filePath = '/tmp/'.$file_name;
            @file_put_contents($filePath, $img);

            $oss->ossClient->setBucket(Yii::$app->params['oss']['Bucket']);
            $oss->ossClient->uploadFile($ossKey, $filePath);
            @unlink('/tmp/'.$file_name);
            
            return $file_name;
        }
        return false;
    }

    public function curl_file_get_contents($url){
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        ob_start();  
        curl_exec($ch);  
        $data = ob_get_contents();  
        ob_end_clean();  
        return $data; 
    }

    /**
     * 生成uuid图片名称
     */
    public function uuid($ext)
    {
        $chars = md5(uniqid(mt_rand(), true));  
        $uuid  = substr($chars, 0, 8) . '-';  
        $uuid .= substr($chars, 8, 4) . '-';  
        $uuid .= substr($chars, 12, 4) . '-';  
        $uuid .= substr($chars, 16, 4) . '-';  
        $uuid .= substr($chars, 20, 12);

        return md5($uuid).'.'.$ext;
    }

    public static function getUrl($table, $field, $ossKey)
    {
        $oss = new OSS();
        $oss->ossClient->setBucket(Yii::$app->params['oss']['Bucket']);
        return preg_replace('/(.*)\?OSSAccessKeyId=.*/', '$1', $oss->ossClient->getUrl($table.'/'.$field.'/'.$ossKey, new \DateTime("+1 day")));
    }

    public static function delFile($table, $field, $ossKey)
    {
        $oss = new OSS();
        $oss->ossClient->setBucket(Yii::$app->params['oss']['Bucket']);
        $oss->ossClient->delFile($table.'/'.$field.'/'.$ossKey);
    }

    public static function createBucket($bucketName)
    {
        $oss = new OSS();
        return $oss->ossClient->createBucket($bucketName);
    }

    public static function getAllObjectKey($bucketName)
    {
        $oss = new OSS();
        return $oss->ossClient->getAllObjectKey($bucketName);
    }

}