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
        'AccessKeyId' => 'cUKNS5vHWVIQIRHv',
        //阿里云给的AccessKeySecret
        'AccessKeySecret' => 'N2iN4dsKJnpZlO4lgNfll505TD77jI',
        //创建的空间名
        'Bucket' => 'raoshezhe' // 需根据项目修改
    ],
    'alidayu' => [
        'appkey' => '23339662',
        'secretKey' => 'c14330ff4060f164cf6e356042496e84',
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
