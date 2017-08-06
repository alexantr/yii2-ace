# Ace editor widget for Yii 2

This extension renders a [Ace Code Editor](https://ace.c9.io/) widget for [Yii framework 2.0](http://www.yiiframework.com).

[![Latest Stable Version](https://poser.pugx.org/alexantr/yii2-ace/v/stable)](https://packagist.org/packages/alexantr/yii2-ace)
[![Total Downloads](https://poser.pugx.org/alexantr/yii2-ace/downloads)](https://packagist.org/packages/alexantr/yii2-ace)
[![License](https://poser.pugx.org/alexantr/yii2-ace/license)](https://packagist.org/packages/alexantr/yii2-ace)

## Installation

Install extension through [composer](http://getcomposer.org/):

```
composer require "alexantr/yii2-ace"
```

## Usage

The following code in a view file would render a Ace widget:

```php
<?= alexantr\ace\Ace::widget(['name' => 'attributeName']) ?>
```

Configuring the [Ace options](https://github.com/ajaxorg/ace/wiki/Configuring-Ace) should be done
using the `clientOptions` attribute:

```php
<?= alexantr\ace\Ace::widget([
    'name' => 'attributeName',
    'clientOptions' => [
        'fontSize' => 14,
        'useSoftTabs' => true,
    ],
]) ?>
```

If you want to use the Ace widget in an ActiveForm, it can be done like this:

```php
<?= $form->field($model, 'attributeName')->widget(alexantr\ace\Ace::className()) ?>
```

## Using global configuration

To avoid repeating identical configuration in every widget you can set global configuration in
`Yii::$app->params`. Options from widget's `clientOptions` will be merged with this configuration. Use `presetName`
attribute for this functionality:

```php
<?= alexantr\ace\Ace::widget([
    'name' => 'attributeName',
    'presetName' => 'ace.customConfig', // will use Yii::$app->params['ace.customConfig']
]) ?>
```

## Global configuration examples

Usual array:

```php
'params' => [
    'ace.customConfig' => [
        'fontSize' => 14,
        'useSoftTabs' => true,
    ],
]
```

Callable string:

```php
'ace.customConfig' => 'app\helpers\Editor::getGlobalConfig',
```

> **Note:** Method `Editor::getGlobalConfig` must return array.

Anonymous function:

```php
'ace.customConfig' => function () {
    return [
        'fontSize' => 14,
        'minLines' => 10,
        'maxLines' => new \yii\web\JsExpression('Infinity'),
        'useSoftTabs' => true,
    ];
},
```