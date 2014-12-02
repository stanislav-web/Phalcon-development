# Pretty Exceptions

![Pretty-Exceptions](http://www.phalconphp.com/img/pretty.jpg)

[Phalcon](http://phalconphp.com) is a web framework delivered as a C extension providing high
performance and lower resource consumption.

Pretty Exceptions is an utility to show exceptions/errors/warnings/notices using a nicely visualization.

This utility is not intended to be used in a production stage.

This utility catches uncatched exceptions, remember to remove any try/catch that avoid the utility can work.

The code in this repository is written in PHP.

## Automatic Usage

The easiest way to use this utility is include its 'loader':

```php
require '/path/to/pretty-exceptions/loader.php';
```

## Manual include

Or you could include the utility manually or via an autoloader:

```php

//Requiring the file
require '/path/to/pretty-exceptions/Library.php';

//Or using an autoloader
$loader = new Phalcon\Loader();

$loader->registerNamespaces(array(
        'Phalcon\\Utils' => '/path/to/pretty-exceptions/Library/Phalcon/Utils/'
));

$loader->register();

```

## Usage

Listen for exceptions:

```php

set_exception_handler(function($e)
{
	$p = new \Phalcon\Utils\PrettyExceptions();
	return $p->handle($e);
});

```

Listen for user errors/warnings/notices:

```php

set_error_handler(function($errorCode, $errorMessage, $errorFile, $errorLine)
{
	$p = new \Phalcon\Utils\PrettyExceptions();
	return $p->handleError($errorCode, $errorMessage, $errorFile, $errorLine);
});

```

## Options

The following is the way to configure the utility:

```php

$p = new \Phalcon\Utils\PrettyExceptions();

//Change the base uri for static resources
$p->setBaseUri('/');

//Set if the backtrace must be shown
$p->showBacktrace(true);

//Set whether if open the user files and show its code
$p->showFiles(true);

//Set whether show the complete file or just the relevant fragment
$p->showFileFragment(true);

/**
 * Set whether show human readable dump of current Phalcon application instance
 *  Can optionally pass a Phalcon application instance as a prameter in the
 *  constructor, or as the last parameter of PrettyExceptions::handle() and
 *  PrettyExceptions::handleError()
 */
$p->showApplicationDump(true);

//Change the CSS theme (default, night or minimalist)
$p->setTheme('default');

//Handle the error/exception
//...

```

## Live Demo

A live demo is available [here](http://test.phalconphp.com/exception.html) and [here](http://test.phalconphp.com/exception2.html)
