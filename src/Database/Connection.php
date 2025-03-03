<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
  /**
   * @var PDO
   */
  // test purposes only - will not work since it is localhost stuff
  private $pdo; 
  private $host = 'localhost';
  private $username = 'postgres';
  private $password = 'docker';
  private $dbname = 'social';
  private $port = '5432';

  public function connect()
  {
    try {
      $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
      $this->pdo = new PDO($dsn, $this->username, $this->password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "connected";
      return $this->pdo;
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

}
