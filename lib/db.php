<?php

class Db extends Service {
  private $mysqli;

  public function __construct($config) {
    $this->mysqli = new mysqli(
      $config['db_host'],
      $config['db_username'],
      $config['db_password'],
      $config['db_database']
    );
  }

  public function query($query, $types = '', $params = []) {
		$stmt = $this->mysqli->prepare($query);
		if ($stmt == false) {
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
