<?php

function get($logger) {
  $logger->info("Someone visited the home page.");
  return view('home');
}
