<?php

namespace App\Repositories;

use App\Models\Subject;
use App\Interfaces\SubjectRepositoryInterface;
use PDO;
use App\Database\Connection;

class SubjectRepository implements SubjectRepositoryInterface
{
  private PDO $pdo;
  private $connection;
  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
    $this->pdo = $this->connection->connect();
  }

  public function create(Subject $subject): Subject
  {
    $statement = $this->pdo->prepare('INSERT INTO subject (name) VALUES (:name)');
    $statement->execute([
      'name' => $subject->getName()
    ]);
    $subject->setId($this->pdo->lastInsertId());
    return $subject;
  }

  public function update(Subject $subject): Subject
  {
    $statement = $this->pdo->prepare('UPDATE subject SET name = :name WHERE id = :id');
    $statement->execute([
      'name' => $subject->getName(),
      'id' => $subject->getId()
    ]);
    return $subject;
  }

  public function delete(Subject $subject): Subject
  {
    $statement = $this->pdo->prepare('DELETE FROM subject WHERE id = :id');
    $statement->execute([
      'id' => $subject->getId()
    ]);
    return $subject;
  }

  public function findById(int $id): Subject
  {
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE id = :id');
    $statement->execute([
      'id' => $id
    ]);
    $subject = $statement->fetchObject(Subject::class);
    return $subject;
  }

  public function findAll(): array
  {
    $statement = $this->pdo->query('SELECT * FROM subject');
    $subjects = $statement->fetchAll(PDO::FETCH_CLASS, Subject::class);
    return $subjects;
  }

  public function findByName(string $name): Subject
  {
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE name = :name');
    $statement->execute([
      'name' => $name
    ]);
    $subject = $statement->fetchObject(Subject::class);
    return $subject;
  }

}
  