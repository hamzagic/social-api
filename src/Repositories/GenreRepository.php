<?php

namespace App\Repositories;

use App\Models\Genre;
use App\Interfaces\GenreRepositoryInterface;
use PDO;
use App\Database\Connection;

class GenreRepository implements GenreRepositoryInterface
{
  private PDO $pdo;
  private $connection;
  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
    $this->pdo = $this->connection->connect();
  }

  public function create(Genre $genre): Genre
  {
    $statement = $this->pdo->prepare('INSERT INTO subject (name) VALUES (:name)');
    $statement->execute([
      'name' => $genre->getName()
    ]);
    $genre->setId($this->pdo->lastInsertId());
    return $genre;
  }

  public function update(Genre $genre): Genre
  {
    $statement = $this->pdo->prepare('UPDATE subject SET name = :name WHERE id = :id');
    $statement->execute([
      'name' => $genre->getName(),
      'id' => $genre->getId()
    ]);
    return $$genre;
  }

  public function delete(Genre $genre): Genre
  {
    $statement = $this->pdo->prepare('DELETE FROM subject WHERE id = :id');
    $statement->execute([
      'id' => $genre->getId()
    ]);
    return $genre;
  }

  public function findById(int $id): Genre
  {
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE id = :id');
    $statement->execute([
      'id' => $id
    ]);
    $genre = $statement->fetchObject(Genre::class);
    return $genre;
  }

  public function findAll(): array
  {
    $statement = $this->pdo->query('SELECT * FROM subject');
    $genres = $statement->fetchAll(PDO::FETCH_CLASS, Genre::class);
    return $genres;
  }

  public function findByName(string $name): Genre
  {
    $statement = $this->pdo->prepare('SELECT * FROM subject WHERE name = :name');
    $statement->execute([
      'name' => $name
    ]);
    $genre = $statement->fetchObject(Genre::class);
    return $genre;
  }
}
  