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
Usage of Tag class. [Online demo.](http://adilab.net/projects/demo/html.php)

```php
require('vendor/autoload.php');

use Adi\Html\Tag;

$p = new Tag('p', 'Hello world');
$p->addStyle('color: #ff0000')->addStyle('background-color', '#ccc');
echo $p->render();
```
Usage of complex HTML structure. [Online demo.](http://adilab.net/projects/demo/html.php)

```php
require('vendor/autoload.php');

use Adi\Html\Div;
use Adi\Html\Strong;

echo Div::create(Strong::create('Hello world'))->setStyle('color: #ff0000');
```
Usage of Table class. [Online demo.](http://adilab.net/projects/demo/table.php)
```php
require('vendor/autoload.php');
use Adi\Html\Table\Table;
use Adi\Html\Table\Tr;
use Adi\Html\Table\Td;

$data = array(
    array('aaa', 'bbb', Td::create('ccc')->addClass('ccc')),
    array('ddd', 'eee', 'fff'),
    Tr::create(array('ggg', 'hhh', 'iii'))->addClass('selected'),
);

echo Table::create($data);
```

Usage of Table class - named columns. [Online demo.](http://adilab.net/projects/demo/table.php#named-columns)
```php
require('vendor/autoload.php');
use Adi\Html\Table\Table;
use Adi\Html\Table\Th;
use Adi\Html\Table\Tr;
use Adi\Html\Table\Column;
use Adi\Html\Table\Td;

$data = array(
    array('A' => 'aaa', 'B' => 'bbb', 'C' => 'ccc'),
    array('A' => 'ddd', 'B' => 'eee', 'C' => 'fff'),
    array('A' => 'ggg', 'B' => 'hhh', 'C' => Td::create('iii')->setId('i')),
);

$table = new Table($data);
$table->setColumn('B', Column::create()->addStyle('color', '#ff0000'));
$table->setHeader('B', '[B]');
$table->setHeader('C', Th::create('[C]')->addStyle('color', '#0000ff'));
echo $table;
```

Documentation
----------

[API documentacion](http://adilab.net/projects/api/namespace-Adi.Html.html)