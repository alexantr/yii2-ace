<?php

namespace tests;

use alexantr\ace\Ace;
use tests\data\models\Post;
use Yii;

class AceTest extends TestCase
{
    public function testRenderWithModel()
    {
        $view = $this->mockView();

        $out = Ace::widget([
            'view' => $view,
            'model' => new Post(),
            'attribute' => 'message',
        ]);
        $expected = '<div id="post-message-ace" style="width:100%"></div>';
        $expected .= "\n";
        $expected .= '<textarea id="post-message" name="Post[message]" style="display:none"></textarea>';

        $this->assertEqualsWithoutLE($expected, $out);
    }

    public function testRenderWithNameAndValue()
    {
        $view = $this->mockView();

        $out = Ace::widget([
            'view' => $view,
            'id' => 'test',
            'name' => 'test-editor-name',
            'value' => 'test-editor-value',
        ]);
        $expected = '<div id="test-ace" style="width:100%"></div>';
        $expected .= "\n";
        $expected .= '<textarea id="test" name="test-editor-name" style="display:none">test-editor-value</textarea>';

        $this->assertEqualsWithoutLE($expected, $out);
    }

    public function testWidgetConfig()
    {
        $view = $this->mockView();

        $widget = Ace::widget([
            'view' => $view,
            'model' => new Post(),
            'attribute' => 'message',
            'mode' => 'javascript',
            'theme' => 'twilight',
            'clientOptions' => [
                'fontSize' => 14,
                'useSoftTabs' => true,
            ],
        ]);

        $out = $view->renderFile('@tests/data/views/layout.php', [
            'content' => $widget,
        ]);

        $expected = 'alexantr.aceWidget.register(\'post-message-ace\', \'post-message\', \'javascript\', \'twilight\', {"fontSize":14,"useSoftTabs":true});';
        $this->assertContains($expected, $out);
    }

    public function testDefaultPresetPathWithOverride()
    {
        Yii::setAlias('@app/config', __DIR__ . '/data/config');

        $view = $this->mockView();

        $widget = Ace::widget([
            'view' => $view,
            'model' => new Post(),
            'attribute' => 'message',
            'clientOptions' => [
                'useSoftTabs' => false,
            ],
        ]);

        $out = $view->renderFile('@tests/data/views/layout.php', [
            'content' => $widget,
        ]);

        $expected = '{"fontSize":14,"minLines":10,"maxLines":Infinity,"useSoftTabs":false}';
        $this->assertContains($expected, $out);
    }

    public function testCustomPresetPath()
    {
        if (isset(Yii::$aliases['@app/config'])) {
            unset(Yii::$aliases['@app/config']);
        }

        $view = $this->mockView();

        $widget = Ace::widget([
            'view' => $view,
            'model' => new Post(),
            'attribute' => 'message',
            'presetPath' => '@app/data/config/other.php',
        ]);

        $out = $view->renderFile('@tests/data/views/layout.php', [
            'content' => $widget,
        ]);

        $expected = '{"minLines":1,"maxLines":20}';
        $this->assertContains($expected, $out);
    }
}
