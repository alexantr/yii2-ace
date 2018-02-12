<?php

namespace alexantr\ace;

use yii\web\AssetBundle;

class WidgetAsset extends AssetBundle
{
    public $sourcePath = '@alexantr/ace/assets';
    public $js = [
        'widget.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
