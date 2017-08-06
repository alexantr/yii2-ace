<?php

namespace alexantr\ace;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * Ace code editor widget
 * @see https://ace.c9.io/
 */
class Ace extends InputWidget
{
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
     * @var array Ace events
     */
    public $clientEvents = [];
    /**
     * @var string param name in `Yii::$app->params` with Ace predefined config
     */
    public $presetName;
    /**
     * @var array Container options
     */
    public $containerOptions = [
        'style' => 'width:100%'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->presetName !== null) {
            $this->clientOptions = ArrayHelper::merge($this->getPresetConfig($this->presetName), $this->clientOptions);
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        // create div for editor
        $this->containerOptions['id'] = $this->options['id'] . '-ace';
        echo Html::tag('div', '', $this->containerOptions) . "\n";

        // create hidden textarea
        $this->options['style'] = 'display:none';
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options) . "\n";
        } else {
            echo Html::textarea($this->name, $this->value, $this->options) . "\n";
        }

        // register Ace plugin
        $this->registerClientScript();
    }

    /**
     * Registers Ace plugin
     */
    protected function registerClientScript()
    {
        $view = $this->getView();

        AceAsset::register($view);

        $textarea_id = $this->options['id'];
        $editor_id = $textarea_id . '-ace';

        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '{}';
        $var = uniqid('ace');

        $js = [];
        $js[] = "var $var = ace.edit('$editor_id');";
        $js[] = "$var.setTheme('ace/theme/{$this->theme}');";
        $js[] = "$var.getSession().setMode('ace/mode/{$this->mode}');";
        $js[] = "$var.getSession().setUseWrapMode(true);";
        $js[] = "$var.setValue(jQuery('#$textarea_id').val(), -1);";
        $js[] = "$var.getSession().on('change', function() { jQuery('#$textarea_id').val($var.getSession().getValue()); });";

        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $name => $handler) {
                $handler = ($handler instanceof JsExpression) ? $handler : new JsExpression($handler);
                $js[] = "$var.getSession().on('$name', $handler);";
            }
        }

        $js[] = "$var.setOptions($options);";

        $view->registerJs(implode("\n", $js));
    }

    /**
     * Get options config from preset
     * @param string $presetName
     * @return array
     */
    protected function getPresetConfig($presetName)
    {
        $config = isset(Yii::$app->params[$presetName]) ? Yii::$app->params[$presetName] : [];
        if ((is_string($config) && is_callable($config)) || $config instanceof \Closure) {
            $config = call_user_func($config);
        }
        return is_array($config) ? $config : [];
    }
}
