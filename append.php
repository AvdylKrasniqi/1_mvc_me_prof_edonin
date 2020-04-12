<?php

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST'
    && isset($_POST['@method'])
    && in_array($_POST['@method'], ['put', 'patch', 'delete'])) {
  $method = $_POST['@method'];
}

$handler = strtolower($method);

if (function_exists($handler)) {
  try {
    return di_instantiate($handler);
  } catch (Exception $e) {
    return view('error', [
      'code' => 500
    ]);
  }
}

return view('error', [
  'code' => 404
]);
