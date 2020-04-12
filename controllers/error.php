<?php

function get($params) {
  return view('error', [
    'code' => $params['code'] ?? 500
  ]);
}
