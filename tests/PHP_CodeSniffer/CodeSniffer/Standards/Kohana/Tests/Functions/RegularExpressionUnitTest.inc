<?php
preg_match('/abc/', $str);
preg_match("/abc/", $str);
preg_replace('/(\d+) dollar/', '$1 euro', $str);
preg_replace('/(\d+) dollar/', '\\1 euro', $str);
preg_match('/^.+@.+$/D', $str);
preg_match('/^.+@.+$/', $str);
