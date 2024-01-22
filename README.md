Yii2 JSON Attribute Behavior
============================
This behavior automatically generates a UUID for the given attribute on create.

![CI Workflow](https://github.com/eluhr/yii2-uuid-attribute-behavior/actions/workflows/ci.yml/badge.svg)

Installation
------------

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```
composer require --prefer-dist eluhr/yii2-uuid-attribute-behavior "*"
```

or add

```
"eluhr/yii2-uuid-attribute-behavior": "*"
```

to the `require` section of your `composer.json` file.

Usage
-----

In a `yii\base\Model` or a derivation thereof, the behavior can be used as follows:

```php
public function behaviors(): array
{
    $behaviors = parent::behaviors();
    $behaviors['uuid-attribute'] = [
        'class' => eluhr\uuidAttributeBehavior\UuidAttributeBehavior::class
    ];
    return $behaviors;
}
```

By using this behavior it does not matter if the attribute is a string or an array. 
The behavior will always ensure, that the attribute is an array before saving the data to the database and yii will handle the rest.

This behavior supports [i18n](https://www.yiiframework.com/doc/guide/2.0/en/tutorial-i18n). By adding the `uuid-attribute-validator` category in your config you can overwrite the default error messages.

Testing
-------

After installing dependencies via composer you can run the tests with:

```bash
make test
```
