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
class IeAsset extends AssetBundle
{
    public $js = [
    	'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js',
    	'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'
    ];
    public $jsOptions = ['condition' => 'lte IE9'];
}
