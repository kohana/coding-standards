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
$foo = new DateTimeZone($bar ? $bar : date_default_timezone_get());
$foo = new DateTime($bar, new DateTimeZone($baz ? $baz : date_default_timezone_get()));
$foo = $bar['a'][0] ? $baz->foo : FALSE;
echo MyClass::$property ? MyClass::CONSTANT : MyClass::method();
return isset($this->$key) ? $this->$key : NULL;
