<?php

if ($foo == $bar)
	return $foo;

if ($foo == $bar)
	continue;

if ($foo == $bar)
	break;

if ($foo == $bar)
	throw new Exception('You screwed up!');

if ($baz == $bun)
	$baz = $bar + 2;

if ($foo == $bar) {
    echo 'False positive!';
}

if ($foo == $bar)
    exit 'Bye!';
