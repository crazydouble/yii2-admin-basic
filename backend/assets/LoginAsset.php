<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // Bootstrap
        'assets/css/vendor/bootstrap/bootstrap.min.css',
        'assets/css/font-awesome.css',
        'assets/css/vendor/bootstrap-checkbox.css',
        'assets/css/minimal.css'
    ];

    public $depends = [
        '\backend\assets\IeAsset'
    ];
}
