<?php

namespace App\Interfaces;

use App\Models\Title;

interface TitleRepositoryInterface
{
  public function create(Title $title): Title;

  public function update(Title $title): Title;

  public function delete(Title $title): Title;

  public function findById(int $id);

  public function findAll(): array;

  public function findByName(string $name);
}