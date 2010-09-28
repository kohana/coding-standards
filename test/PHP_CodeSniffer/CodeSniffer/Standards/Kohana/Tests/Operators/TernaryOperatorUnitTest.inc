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
