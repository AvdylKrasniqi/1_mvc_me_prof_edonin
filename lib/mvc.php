<?php

class Request extends Service {
  public $params;
  public $assigns;

  public function __construct() {
    $this->params = $_REQUEST;
    $this->assigns = [];
  }
}

function params_factory($request) {
  return $request->params;
}

function view($name, $params = []) {
  foreach ($params as $key => $value) {
    $$key = $value;
  }

  include ROOT . "/views/$name.php";
}
