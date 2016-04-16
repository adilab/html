Adi HTML Tools for PHP
========================

Adi HTML Tools for PHP is a set of class for prepare HTML code directly in PHP. The set content class for work with basic HTML tags, and to create HTML table code taking data from an array.

Installing
----------

Preferred way to install is with [Composer](https://getcomposer.org/).

Install this library using composer:

```console
$ composer require adilab/html
```

Usage:
-------------
Usage of Tag class
```php
require('vendor/autoload.php');

use Adi\Html\Tag;

$p = new Tag('p', 'Hello world');
$p->addStyle('color: #ff0000')->addStyle('background-color', '#ccc');
echo $p->render();
```
Usage of complex HTML structure

```php
require('vendor/autoload.php');

use Adi\Html\Div;
use Adi\Html\Strong;

echo Div::create(Strong::create('Hello world'))->setStyle('color: #ff0000');
```
