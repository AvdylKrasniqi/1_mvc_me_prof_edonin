<?php

define('ROOT', __DIR__);

require_once(ROOT . '/di.php');

foreach (glob(ROOT . '/lib/*.php') as $filename) {
  include_once($filename);
}

foreach (get_declared_classes() as $class) {
  if (!is_subclass_of($class, 'Service')) {
    continue;
  }

  $name = lcfirst(str_replace(' ', '', ucwords(preg_replace('/[^a-zA-Z0-9\x7f-\xff]++/', ' ', $class))));
  if (!di_is_registered($name)) {
    di_register($name, $class);
  }
}
