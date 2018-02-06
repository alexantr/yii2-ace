<?php

namespace tests;

use alexantr\ace\AceAsset;
use yii\web\AssetBundle;

class AceAssetTest extends TestCase
{
    public function testRegister()
    {
        $view = $this->mockView();

        $this->assertEmpty($view->assetBundles);

        AceAsset::register($view);

        // only AceAsset
        $this->assertEquals(1, count($view->assetBundles));

        $this->assertArrayHasKey('alexantr\\ace\\AceAsset', $view->assetBundles);
        $this->assertTrue($view->assetBundles['alexantr\\ace\\AceAsset'] instanceof AssetBundle);

        $out = $view->renderFile('@tests/data/views/layout.php');

        $this->assertRegExp('%"https://cdnjs.cloudflare.com/ajax/libs/ace/[0-9\.]+/ace.js"%', $out);
    }
}
