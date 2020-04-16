<?php

define('TRACE', 0);
define('DEBUG', 1);
define('INFO', 2);
define('WARN', 3);
define('ERROR', 4);
define('LEVEL_MAPPING', ['TRACE', 'DEBUG', 'INFO', 'WARN', 'ERROR']);

class Logger extends Service {
  private $level;
  private $file;

  private function append($message) {
    fwrite($this->file, $message . "\n");
  }

  public function getCurrentTime(){
    return date("H:i:s");
  }

  private function logConditionally($message, $level) {
    if ($this->level > $level) {
      return;
    }

    if ($message instanceof Exception) {
      $message = $message->getMessage() . PHP_EOL . $message->getTraceAsString();
    }

    $this->append('[' . LEVEL_MAPPING[$level] . '] ' . $this->getCurrentTime() . ' ' . $message);
  }

  public function __construct($config) {
    $level = $config['log_level'] ?? INFO;
    $this->level = is_string($level) ? array_search($level, LEVEL_MAPPING) : $level;
    $this->file = fopen(ROOT . '/server.log', 'a');
  }

  public function trace($message) {
    $this->logConditionally($message, TRACE);
  }

  public function debug($message) {
    $this->logConditionally($message, DEBUG);
  }

  public function info($message) {
    $this->logConditionally($message, INFO);
  }

  public function warn($message) {
    $this->logConditionally($message, WARN);
  }

  public function error($message) {
    $this->logConditionally($message, ERROR);
  }
}
