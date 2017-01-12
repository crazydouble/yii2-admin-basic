<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'oss' => [
    	//服务器外网地址，深圳为 http://oss-cn-shenzhen.aliyuncs.com
        'ossServer' => 'http://img-cn-beijing.aliyuncs.com',
        //服务器内网地址，深圳为 http://oss-cn-shenzhen-internal.aliyuncs.com
        'ossServerInternal' => 'http://oss-cn-beijing-internal.aliyuncs.com',
        //阿里云给的AccessKeyId
        'AccessKeyId' => '', // 填写你的AccessKeyId
        //阿里云给的AccessKeySecret
        'AccessKeySecret' => '', // 填写你的AccessKeySecret
        //创建的空间名
        'Bucket' => '' // 填写你创建的Bucket
    ],
    'alidayu' => [
        'appkey' => '', // 填写你的appkey
        'secretKey' => '', // 填写你的secretKey
        'smsFreeSignName' => '默认', //填写显示名称
        'smsTemplateCode' => 'SMS_XXXXX', //填写模版Code
    ],
];
