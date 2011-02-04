<?php
$foo = ($bar == $foo) ? $foo : $bar;
$foo = $bar ? $foo : $bar;
$foo = ($bar == $foo) ? ($foo) : ($bar);
$foo = ($bar > 5) ? ($bar + $foo) : strlen($bar);
$foo = $bar > 5 ? $bar + $foo : strlen($bar);
$foo = ($bar == $foo)
    ? $foo
    : $bar;
$foo = $bar ? -1 : $bar;
$foo = $bar ? (string) $foobar : $bar;
$foo = $bar ? ($baz ? $baz : FALSE) : $foobar;
$foo = $bar ? array() : $baz;
$foo = $bar ? new MyClass : FALSE;
$foo = ($bar = NULL) ? $foo : $bar;
$foo = new DateTimeZone($bar ? $bar : date_default_timezone_get());
$foo = new DateTime($bar, new DateTimeZone($baz ? $baz : date_default_timezone_get()));
$foo = $bar['a'][0] ? $baz->foo : FALSE;
echo MyClass::$property ? MyClass::CONSTANT : MyClass::method();
return isset($this->$key) ? $this->$key : NULL;
array('a' => $foo ? $bar : $baz);
array('a', 'b' => $foo ? $bar : $baz);
$foo = Auth::instance()->logged_in() ? 'yay' : 'nay';
$foo = TRUE ? Auth::instance()->username() : Auth::instance()->user()->guest;
$var = Auth::instance()->logged_in()
	? Auth::instance()->get_user()->profile->default_language
	: $lol;
