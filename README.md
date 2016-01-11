# Jade Template Engine Plugin for CakePHP 3

Powered by [Tale Jade for PHP](https://github.com/Talesoft/tale-jade).

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar require clthck/cakephp-jade`.

If Composer is installed globally, run
```bash
composer require clthck/cakephp-jade
```

## Bootstrap

Add the following to your `config/bootstrap.php` to load the plugin.

```php
Plugin::load('clthck/JadeView');
```

## Application Wide Usage

Place the following to your `AppController.php` to load the JadeView class.
```php
public function initialize()
{
    parent::initialize();

    $this->viewBuilder()
        ->className('clthck/JadeView.Jade')
        ->options(['pretty' => true]);
}
```

What if we need to load additional helpers for our JadeView instance?
In this case, we can make AppView class inherit JadeView class:
```php
...
use clthck\JadeView\View\JadeView;
...
class AppView extends JadeView
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

## In Template File (.ctp.jade)

Use `$view` instead of `$this`.
```php
= $view->Flash->render()
```

## Usage Example of CakePHP javascript block

	- $view->Html->scriptStart(['block' => true])
	|
		$(function() {
			// Your js code goes here..
		});

	- $view->Html->scriptEnd()

If you're using Sublime Text 2/3, you need to install [cakephp-jade-tmbundle](http://github.com/clthck/cakephp-jade-tmbundle/tree/master) to make syntax highlighting work properly.

## Language Syntax Reference

Please check [jade.talesoft.io](http://jade.talesoft.io/) for syntax reference.
