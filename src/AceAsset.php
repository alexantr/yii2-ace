<?php

namespace alexantr\ace;

use yii\web\AssetBundle;

/**
 * Class AceAsset
 * @package alexantr\ace
 */
class AceAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.0/ace.js',
    ];
}
