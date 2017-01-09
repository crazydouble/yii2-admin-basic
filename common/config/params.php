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
        'name' => '默认', // 填写你的项目名称
        /*
         * 根据需求添加／更改需要的短信类型
         */
        'signup' => [
            'smsFreeSignName' => '注册验证',  
            'smsTemplateCode' => 'SMS_6765804', 
        ],
        'update' => [
            'smsFreeSignName' => '变更验证', 
            'smsTemplateCode' => 'SMS_6765801', 
        ]
    ],
];
