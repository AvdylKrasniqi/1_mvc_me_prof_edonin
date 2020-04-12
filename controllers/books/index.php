<?php

function get($db) {
  return view('books/list', [
    'books' => $db->query('SELECT * FROM Books')
  ]);
}
