<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Interfaces\SubjectRepositoryInterface;
use App\Interfaces\BasicRepositoryInterface;
use PDO;
use App\Database\Connection;
use PDOException;

class SubjectRepository implements BasicRepositoryInterface
{
  private PDO $pdo;
  private $connection;
  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
    $this->pdo = $this->connection->connect();
  }

  public function create($data)
  {
    try {
      $exists = $this->findByName(strtolower($data->name));
      if($exists) {
        http_response_code(400);
        echo '{"message": "Subject already exists"}';
        return;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
    try {
      $data->name = strtolower($data->name);
      $subject = new Subject();
      $statement = $this->pdo->prepare('INSERT INTO subject (name, description) VALUES (:name, :description)');
      $statement->bindParam(':name', $data->name, PDO::PARAM_STR);
      $statement->bindParam(':description', $data->description, PDO::PARAM_STR);
      $statement->execute();
      return $subject;

    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function update($data): Subject
  {
    $statement = $this->pdo->prepare('UPDATE subject SET name = :name WHERE id = :id');
    $statement->bindParam(':name', $data['name'], PDO::PARAM_STR);
    $statement->bindParam(':id', $data['id'], PDO::PARAM_INT);
    $statement->execute();
    return $this->findById($data['id']);
  }

  public function delete($data): Subject
  {
    $statement = $this->pdo->prepare('DELETE FROM subject WHERE id = :id');
    $statement->bindParam(':id', $data['id'], PDO::PARAM_INT);
    $statement->execute();
    return $this->findById($data['id']);
  }

  public function findById($data)
  {
    try {
      if(is_string($data)) {
        $data = json_decode($data);
      }
      $statement = $this->pdo->prepare('SELECT * FROM subject WHERE id = :id');
      $statement->bindParam(':id', $data->id, PDO::PARAM_INT);
      $statement->execute();
      $subject = $statement->fetch(PDO::FETCH_ASSOC);
      return $subject;

    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function findAll(): array
  {
    $statement = $this->pdo->query('SELECT * FROM subject');
    $subjects = $statement->fetchAll(PDO::FETCH_CLASS, Subject::class);
    return $subjects;
  }

  public function findByName(string $name)
  {
    $name = strtolower($name);
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE name = :name');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    $subject = $statement->fetch(PDO::FETCH_ASSOC);
    return $subject;
  }
}
  