<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900',
        'theme/global_assets/css/icons/icomoon/styles.min.css',
        'theme/assets/css/bootstrap.min.css',
        'theme/assets/css/bootstrap_limitless.min.css',
        'theme/assets/css/layout.min.css',
        'theme/assets/css/components.min.css',
        'theme/assets/css/colors.min.css',
    ];
    public $js = [
        ///core js files
        'theme/global_assets/js/main/jquery.min.js',
        'theme/global_assets/js/main/bootstrap.bundle.min.js',
        'theme/global_assets/js/plugins/loaders/blockui.min.js',
        ///End core JS files

        'theme/global_assets/js/plugins/visualization/d3/d3.min.js',
        'theme/global_assets/js/plugins/visualization/d3/d3_tooltip.js',
        'theme/global_assets/js/plugins/forms/wizards/steps.min.js',
        'theme/global_assets/js/plugins/forms/styling/switchery.min.js',
        'theme/global_assets/js/plugins/ui/moment/moment.min.js',

        ///date picker js files
        'theme/global_assets/js/plugins/pickers/daterangepicker.js',
        'theme/global_assets/js/plugins/pickers/anytime.min.js',
        'theme/global_assets/js/plugins/pickers/pickadate/picker.js',
        'theme/global_assets/js/plugins/pickers/pickadate/picker.date.js',
        'theme/global_assets/js/plugins/pickers/pickadate/picker.time.js',
        'theme/global_assets/js/plugins/pickers/pickadate/legacy.js',
        'theme/global_assets/js/plugins/notifications/jgrowl.min.js',
        /// end date picker js files

        'theme/global_assets/js/plugins/forms/selects/select2.min.js',
        'theme/global_assets/js/plugins/forms/validation/validate.min.js',
        'theme/global_assets/js/plugins/tables/datatables/datatables.min.js',
        'theme/global_assets/js/plugins/extensions/cookie.js',
        'theme/assets/js/app.js',
        'theme/global_assets/js/demo_pages/form_select2.js',
        'theme/global_assets/js/demo_pages/form_wizard.js',
        'theme/global_assets/js/demo_pages/picker_date.js',
        'theme/global_assets/js/demo_pages/datatables_advanced.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
