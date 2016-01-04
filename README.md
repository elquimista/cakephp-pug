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

	Plugin::load('clthck/JadePHP', ['bootstrap' => true]);

