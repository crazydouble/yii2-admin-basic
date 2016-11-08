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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // Bootstrap
        'assets/css/vendor/animate/animate.min.css',
        'assets/js/vendor/mmenu/css/jquery.mmenu.all.css',
        'assets/js/vendor/videobackground/css/jquery.videobackground.css',
        'assets/js/vendor/rickshaw/css/rickshaw.min.css',
        'assets/js/vendor/morris/css/morris.css',
        'assets/js/vendor/tabdrop/css/tabdrop.css',
        'assets/js/vendor/summernote/css/summernote.css',
        'assets/js/vendor/summernote/css/summernote-bs3.css',
        'assets/js/vendor/chosen/css/chosen.min.css',
        'assets/js/vendor/chosen/css/chosen-bootstrap.css'
    ];
    public $js = [
        'assets/js/vendor/bootstrap/bootstrap.min.js',
        'assets/js/vendor/mmenu/js/jquery.mmenu.min.js',
        'assets/js/vendor/sparkline/jquery.sparkline.min.js',
        'assets/js/vendor/nicescroll/jquery.nicescroll.min.js',
        'assets/js/vendor/animate-numbers/jquery.animateNumbers.js',
        'assets/js/vendor/videobackground/jquery.videobackground.js',
        'assets/js/vendor/blockui/jquery.blockUI.js',
        'assets/js/vendor/flot/jquery.flot.min.js',
        'assets/js/vendor/flot/jquery.flot.time.min.js',
        'assets/js/vendor/flot/jquery.flot.selection.min.js',
        'assets/js/vendor/flot/jquery.flot.animator.min.js',
        'assets/js/vendor/flot/jquery.flot.orderBars.js',
        'assets/js/vendor/easypiechart/jquery.easypiechart.min.js',
        'assets/js/vendor/rickshaw/raphael-min.js',
        'assets/js/vendor/rickshaw/d3.v2.js',
        'assets/js/vendor/rickshaw/rickshaw.min.js',
        'assets/js/vendor/morris/morris.min.js',
        'assets/js/vendor/tabdrop/bootstrap-tabdrop.min.js',
        'assets/js/vendor/summernote/summernote.min.js',
        'assets/js/vendor/chosen/chosen.jquery.min.js',
        'assets/js/minimal.min.js'
    ];
    public $depends = [
        '\backend\assets\LoginAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
