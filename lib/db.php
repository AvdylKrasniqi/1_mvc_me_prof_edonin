<?php

class Db extends Service {
  private $mysqli;
  private $logger;

  public function __construct($config, $logger) {
    //var_dump($config);
    $this->mysqli = new mysqli(
      $config['db_host'],
      $config['db_username'],
      $config['db_password'],
      $config['db_database']
    );
    $this->logger = $logger;
  }

  public function cleanup() {
    $this->mysqli->close();
  }

  public function query($query, $types = '', $params = []) {
    $this->logger->trace("Preparing query $query");
    $stmt = $this->mysqli->prepare($query);
    if ($stmt == false) {
      $this->logger->error("Query failed.");
      throw new Exception($this->mysqli->error);
    }

    if (count($params) > 0) {
      $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result == false) {
      throw new Exception($this->mysqli->error);
    }

    $rows = [];
    while ($row = $result->fetch_assoc()) {
      array_push($rows, $row);
    }

    $result->close();
    $stmt->close();
    return $rows;
  }

  public function execute($statement, $types = '', $params = []) {
    $stmt = $this->mysqli->prepare($statement);
    if ($stmt == false) {
      throw new Exception($this->mysqli->error);
    }

    if (count($params) > 0) {
      $stmt->bind_param($types, ...$params);
    }

    $result = $stmt->execute();
    if ($result == false) {
      throw new Exception($this->mysqli->error);
    }

    $stmt->close();
  }
}
