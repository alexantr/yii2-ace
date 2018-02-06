<?php

namespace alexantr\ace;

use yii\web\AssetBundle;

/**
 * Class AceWidgetAsset
 * @package alexantr\ace
 */
class AceWidgetAsset extends AssetBundle
{
    public $sourcePath = '@alexantr/ace/assets';
    public $js = [
        'ace.widget.js',
    ];
    public $depends = [
        'alexantr\ace\AceAsset',
    ];
}