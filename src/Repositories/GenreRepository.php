<?php

namespace App\Repositories;

use App\Models\Genre;
use App\Repositories\SubjectRepository;
use App\Interfaces\BasicRepositoryInterface;
use App\Database\Connection;
use PDO;
use PDOException;

class GenreRepository implements BasicRepositoryInterface
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
        echo '{"message": "Genre already exists"}';
        return;
      }
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
    $subject = new SubjectRepository($this->connection);
    $result =$subject->findById($data);
    if(!empty($result)) {
      try {
        $data->name = strtolower($data->name);
        $statement = $this->pdo->prepare('INSERT INTO genre (name, description, subject_id) VALUES (:name, :description, :subject_id)');
        $statement->bindParam(':name', $data->name, PDO::PARAM_STR);
        $statement->bindParam(':description', $data->description, PDO::PARAM_STR);
        $statement->bindParam(':subject_id', $result['id'], PDO::PARAM_INT);
        $statement->execute();
        $subject = $statement->fetch(PDO::FETCH_ASSOC);
        return $subject;
      } catch(PDOException $e) {
        echo $e->getMessage();
      }
    } else {
      http_response_code(400);
      echo '{"message": "Invalid genre"}';
      return;
    }
  }

  public function update($data)
  {
    $statement = $this->pdo->prepare('UPDATE subject SET name = :name WHERE id = :id');
    $statement->execute();

  }

  public function delete($data)
  {
    $statement = $this->pdo->prepare('DELETE FROM subject WHERE id = :id');
    $statement->execute();
   
  }

  public function findById(int $id): Genre
  {
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE id = :id');
    $statement->execute();
    $genre = $statement->fetchObject(Genre::class);
    return $genre;
  }

  public function findAll(): array
  {
    $statement = $this->pdo->query('SELECT * FROM subject');
    $genres = $statement->fetchAll(PDO::FETCH_CLASS, Genre::class);
    return $genres;
  }

  public function findByName(string $name)
  {
    $name = strtolower($name);
    $statement = $this->pdo->prepare('SELECT * FROM genre WHERE name = :name');
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    $genre = $statement->fetch(PDO::FETCH_ASSOC);
    return $genre;
  }
}
  