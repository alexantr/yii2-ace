<?php

namespace alexantr\ace;

use yii\web\AssetBundle;

class AceAsset extends AssetBundle
{
    const CDN_BASE_PATH = 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8';

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js',
    ];
}
