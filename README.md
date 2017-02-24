[![Build Status](https://travis-ci.org/clthck/cakephp-pug.svg)](https://travis-ci.org/clthck/cakephp-pug)
[![Latest Stable Version](https://poser.pugx.org/clthck/cakephp-pug/v/stable)](https://packagist.org/packages/clthck/cakephp-pug)
[![Total Downloads](https://poser.pugx.org/clthck/cakephp-pug/downloads)](https://packagist.org/packages/clthck/cakephp-pug)
[![License](https://poser.pugx.org/clthck/cakephp-pug/license)](https://packagist.org/packages/clthck/cakephp-pug)

# Pug Template Engine Plugin for CakePHP 3

Powered by [Tale Jade for PHP](https://github.com/Talesoft/tale-jade).

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar require clthck/cakephp-pug`.

If Composer is installed globally, run
```bash
composer require clthck/cakephp-pug
```

## Bootstrap

Add the following to your `config/bootstrap.php` to load the plugin.

```php
Plugin::load('PugView');
```

## Application Wide Usage

Place the following to your `AppController.php` to load the PugView class.
```php
public function initialize()
{
    parent::initialize();

    $this->viewBuilder()
        ->className('PugView.Pug')
        ->options(['pretty' => false]);
}
```

What if we need to load additional helpers for our PugView instance?
In this case, we can make AppView class inherit PugView class:
```php
...
use PugView\View\PugView;
...
class AppView extends PugView
{
	...
	public function initialize()
	{
	    $this->viewOptions([
	        'pretty' => true
	    ]);

	    parent::initialize();
	    
	    $this->loadHelper('Form', [
	        'templates' => 'form_template'
	    ]);
	}
}
```

## In Template File (.ctp.pug)

Use `$view` instead of `$this`.
```php
= $view->Flash->render()
```

## Usage Example of CakePHP JavaScript block

	- $view->Html->scriptStart(['block' => true])
	|
		$(function() {
			// Your js code goes here..
		});

	- $view->Html->scriptEnd()

If you're using Sublime Text 2/3, you need to install [cakephp-jade-tmbundle](http://github.com/clthck/cakephp-jade-tmbundle/tree/master) to make syntax highlighting work properly.

## Language Syntax Reference

Please check [jade.talesoft.codes](http://jade.talesoft.codes/) for syntax reference.
