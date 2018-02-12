<?php

namespace tests;

use alexantr\ace\WidgetAsset;
use yii\web\AssetBundle;

class WidgetAssetTest extends TestCase
{
    public function testRegister()
    {
        $view = $this->mockView();

        $this->assertEmpty($view->assetBundles);

        WidgetAsset::register($view);

        // JqueryAsset, WidgetAsset
        $this->assertEquals(2, count($view->assetBundles));

        $this->assertArrayHasKey('alexantr\\ace\\WidgetAsset', $view->assetBundles);
        $this->assertTrue($view->assetBundles['alexantr\\ace\\WidgetAsset'] instanceof AssetBundle);

        $out = $view->renderFile('@tests/data/views/layout.php');

        $this->assertRegExp('%"/assets/[0-9a-z]+/widget.js"%', $out);
    }
}
