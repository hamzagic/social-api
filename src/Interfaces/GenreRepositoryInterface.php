<?php

namespace App\Interfaces;

use App\Models\Genre;

interface GenreRepositoryInterface
{
  public function create(Genre $genre): Genre;

  public function update(Genre $genre): Genre;

  public function delete(Genre $genre): Genre;

  public function findById(int $id);

  public function findAll(): array;

  public function findByName(string $name);
}