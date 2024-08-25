<?php

namespace App\Interfaces;

use App\Models\Subgenre;

interface SubgenreRepositoryInterface
{
  public function create(Subgenre $subgenre): Subgenre;

  public function update(Subgenre $subgenre): Subgenre;

  public function delete(Subgenre $subgenre): Subgenre;

  public function findById(int $id);

  public function findAll(): array;

  public function findByName(string $name);
}