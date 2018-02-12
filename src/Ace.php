<?php

namespace alexantr\ace;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Ace code editor input widget
 * @link https://ace.c9.io/
 */
class Ace extends InputWidget
{
    /**
     * @var string Ace CDN base URL
     */
    public static $cdnBaseUrl = 'https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.1/';

    /**
     * @var string Ace mode
     */
    public $mode = 'html';
    /**
     * @var string Ace theme
     */
    public $theme = 'chrome';
    /**
     * @var array Ace options
     * @see https://github.com/ajaxorg/ace/wiki/Configuring-Ace
     */
    public $clientOptions = [];
    /**
     * @var string Path to preset with Ace options
     */
    public $presetPath = '@app/config/ace.php';
    /**
     * @var array Container options
     */
    public $containerOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->clientOptions = ArrayHelper::merge($this->getPresetConfig(), $this->clientOptions);
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->options['id'] . '-ace';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerPlugin();
        return $this->renderContent();
    }

    /**
     * Renders tags
     * @return string
     */
    protected function renderContent()
    {
        // create container for editor
        $content = Html::tag('div', '', $this->containerOptions) . "\n";

        // create hidden textarea
        $this->options['style'] = 'display:none';
        if ($this->hasModel()) {
            $content .= Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $content .= Html::textarea($this->name, $this->value, $this->options);
        }

        return $content;
    }

    /**
     * Registers Ace plugin
     */
    protected function registerPlugin()
    {
        $view = $this->getView();
        WidgetAsset::register($view);

        $cdnBaseUrl = self::$cdnBaseUrl;
        $textareaId = $this->options['id'];
        $editorId = $this->containerOptions['id'];
        $encodedOptions = !empty($this->clientOptions) ? Json::htmlEncode($this->clientOptions) : '{}';

        $view->registerJs("alexantr.aceWidget.setBaseUrl('$cdnBaseUrl');", View::POS_END);
        $view->registerJs("alexantr.aceWidget.register('$editorId', '$textareaId', '{$this->mode}', '{$this->theme}', $encodedOptions);", View::POS_END);
    }

    /**
     * Get options config from preset
     * @return array
     */
    protected function getPresetConfig()
    {
        if (!empty($this->presetPath)) {
            $presetPath = Yii::getAlias($this->presetPath);
            if (is_file($presetPath)) {
                $config = include $presetPath;
                return is_array($config) ? $config : [];
            }
        }
        return [];
    }
}
