<?php

function get($db, $logger) {
  return view('books/list', [
    'books' => $db->query('SELECT * FROM Books')
  ]);
}
