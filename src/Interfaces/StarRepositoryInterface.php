<?php

namespace App\Interfaces;

use App\Models\Star;

interface StarRepositoryInterface
{
  public function create(Star $star): Star;

  public function update(Star $star): Star;

  public function delete(Star $star): Star;

  public function findById(int $id);

  public function findAll(): array;

  public function findByName(string $name);
}