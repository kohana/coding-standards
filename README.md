# PHP Codesniffer standard for the Kohana Framework

This package contains a set of coding standard tests for the [kohana](http://kohanaframework.org) PHP framework.  
The original tests were written by [Matthew Turland](http://matthewturland.com), see his [github repo](http://github.com/elazar/phpcs-kohana) for more info.

These tests are meant to be a guide and may not be 100% accurate.  If you find a bug please report it on the [kohana issue tracker](http://dev.kohanaframework.org).

## Requirements

These tests require [PHP Codesniffer](http://pear.php.net/PHP_CodeSniffer)

## Installation - PEAR (recommended)

Standard PEAR install:

	sudo pear channel-discover pear.kohanaframework.org
	sudo pear install kohana/PHP_CodeSniffer_Standards_Kohana

## Installation - Composer

Add the package to the development dependencies in your project's composer.json

    {
        "require-dev": {
            "kohana/coding-standards": "*",
        }
    }

Run `composer --dev update` to update your composer.lock file and install the package. The sniffs will be installed in
`vendor/kohana/coding-standards` in your project root directory.

## Installation - If you intened to make changes to the sniff's

If you want the standard to be available system wide you can symlink them into the code sniffer dir like so:

	git clone https://github.com/kohana/coding-standards.git kohana-coding-standards
	cd kohana-coding-standards
	sudo ln -sfn `pwd`/PHP/CodeSniffer/Standards/Kohana `pear config-get php_dir`/PHP/CodeSniffer/Standards/Kohana 
	sudo ln -sfn `pwd`/test/PHP_CodeSniffer/CodeSniffer/Standards/Kohana `pear config-get test_dir`/PHP_CodeSniffer/CodeSniffer/Standards/Kohana

## Running

You can reference the standard like so:

	phpcs --standard=Kohana system/classes/kohana

Or, if you don't want to install it system wide you can simply reference the local copy

	phpcs --standard=path/to/coding-standard/PHP/CodeSniffer/Standards/Kohana system/classes/kohana

If you installed with composer, reference the standard from your vendor directory:

    phpcs --standard=vendor/kohana/coding-standards/PHP/CodeSniffer/Standards/Kohana

## Customising your project standard

It is also possible to extend the rules in use for your project, or to include some but not all of the Kohana standards
(for example, if you are working on something that is not intended as a kohana module). You do this by adding a
`coding_standard.xml` to your project root which specifies which rules to include and customises any variables. See the
[PHP_CodeSniffer docs](https://pear.php.net/manual/en/package.php.php-codesniffer.annotated-ruleset.php) for more
details.

## Testing

Like all things code related, sniffs need to be tested!  To run the tests they need to be in the codesniffer dir 
(i.e. you should run the above commands to symlink the sniffs / tests in) and you need to 
[patch phpcs' AllSniffs.php](http://pear.php.net/bugs/bug.php?id=17902&edit=12&patch=fix-cant-run-symlinked-tests.patch&revision=latest)

Then just run the tests like so:

	phpunit --bootstrap=`pear config-get php_dir`/PHP/CodeSniffer.php `pear config-get test_dir`/PHP_CodeSniffer/CodeSniffer/Standards/AllSniffs.php

### Known issues

* There are some problems with expressions in ternary operators

Please report any new issues to the K3 bug tracker and file it under "PHPCS Coding Standards"
