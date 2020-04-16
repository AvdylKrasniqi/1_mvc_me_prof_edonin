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
    $logger = di_resolve('logger');
    $logger->error($e);
    die();
  } finally {
    di_cleanup();
  }
}

return view('error', [
  'code' => 404
]);
