# sy/container

Dependency injection container

## Installation

Install the latest version with

```bash
$ composer require sy/container
```

## Basic Usage

```php
<?php

use Sy\Container;

$container = new Container();

// Set an entry
$container->foo = function() {
	return 'hello';
};

// Get an entry
$var = $container->foo;

// Check an entry
if (isset($container->foo))
```