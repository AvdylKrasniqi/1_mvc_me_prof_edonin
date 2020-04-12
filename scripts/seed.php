<?php
require(__DIR__ . '/../prepend.php');

function run($db) {
  $statement = file_get_contents(__DIR__ . '/schema.sql');
  $db->execute($statement);
}

di_instantiate('run');
