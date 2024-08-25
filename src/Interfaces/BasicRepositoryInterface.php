<?php

namespace App\Interfaces;

interface BasicRepositoryInterface
{
  public function create(mixed $data);

  public function update(mixed $data);

  public function delete(int $id);

  public function findById(int $id);

  public function findAll(): array;

  public function findByName(string $name);
}