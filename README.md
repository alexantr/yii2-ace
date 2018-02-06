# Ace editor widget for Yii 2

This extension renders a [Ace Code Editor](https://ace.c9.io/) widget for [Yii framework 2.0](http://www.yiiframework.com).

[![Latest Stable Version](https://img.shields.io/packagist/v/alexantr/yii2-ace.svg)](https://packagist.org/packages/alexantr/yii2-ace)
[![Total Downloads](https://img.shields.io/packagist/dt/alexantr/yii2-ace.svg)](https://packagist.org/packages/alexantr/yii2-ace)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/alexantr/yii2-ace/master/LICENSE)
[![Build Status](https://travis-ci.org/alexantr/yii2-ace.svg?branch=master)](https://travis-ci.org/alexantr/yii2-ace)

## Installation

Install extension through [composer](http://getcomposer.org/):

```
composer require alexantr/yii2-ace
```

> **Note:** The extension loads editor code from [CDN](https://cdnjs.com/libraries/ace/).

## Usage

The following code in a view file would render an Ace widget:

```php
<?= alexantr\ace\Ace::widget(['name' => 'attributeName']) ?>
```

If you want to use the Ace widget in an ActiveForm, it can be done like this:

```php
<?= $form->field($model, 'attributeName')->widget(alexantr\ace\Ace::className()) ?>
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

Setting [themes](https://github.com/ajaxorg/ace/tree/master/lib/ace/theme) and programming language mode:

```php
<?= alexantr\ace\Ace::widget([
    'name' => 'attributeName',
    'mode' => 'javascript',
    'theme' => 'twilight',
]) ?>
```

Default mode is "html" and theme is "chrome".

## Using global configuration (presets)

To avoid repeating identical configuration in every widget you can set global configuration in
`@app/config/ace.php`. Options from widget's `clientOptions` will be merged with this configuration.

You can change default path with `presetPath` attribute:

```php
<?= alexantr\ace\Ace::widget([
    'name' => 'attributeName',
    'presetPath' => '@backend/config/my-ace-config.php',
]) ?>
```

Preset file example:

```php
<?php
return [
    'fontSize' => 14,
    'minLines' => 10,
    'maxLines' => new \yii\web\JsExpression('Infinity'),
    'useSoftTabs' => true,
];
```
