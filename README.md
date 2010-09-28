# PHP Codesniffer standard for the Kohana Framework

This package contains a set of coding standard tests for the [kohana](http://kohanaframework.org) PHP framework.  
The original tests were written by [Matthew Turland](http://matthewturland.com), see his [github repo](http://github.com/elazar/phpcs-kohana) for more info.

These tests are meant to a guide and are may not be 100% accurate.  If you find a bug please report it on the [kohana issue tracker](http://dev.kohanaframework.org).

## Requirements

These tests require [PHP Codesniffer](http://pear.php.net/PHP_CodeSniffer)

## Installation

If you want the standard to be available system wide you can symlink them into the code sniffer dir like so:

	sudo ln -sfn `pwd`/PHP/CodeSniffer/Standards/Kohana `pear config-get php_dir`/PHP/CodeSniffer/Standards/Kohana 
	sudo ln -sfn `pwd`/test/PHP_CodeSniffer/CodeSniffer/Standards/Kohana `pear config-get test_dir`/PHP_CodeSniffer/CodeSniffer/Standards/Kohana

You can then reference the standard like so:

	phpcs --standard=Kohana

Or, if you don't want to install it system wide you can simply reference the local copy

	phpcs --standard=path/to/coding-standard/PHP/CodeSniffer/Standards/Kohana