<?php

namespace tests;

use alexantr\ace\AceWidgetAsset;
use yii\web\AssetBundle;

class AceWidgetAssetTest extends TestCase
{
    public function testRegister()
    {
        $view = $this->mockView();

        $this->assertEmpty($view->assetBundles);

        AceWidgetAsset::register($view);

        // AceAsset, AceWidgetAsset
        $this->assertEquals(2, count($view->assetBundles));

        $this->assertArrayHasKey('alexantr\\ace\\AceWidgetAsset', $view->assetBundles);
        $this->assertTrue($view->assetBundles['alexantr\\ace\\AceWidgetAsset'] instanceof AssetBundle);

        $out = $view->renderFile('@tests/data/views/layout.php');

        $this->assertRegExp('%"/assets/[0-9a-z]+/ace.widget.js"%', $out);
    }
}
