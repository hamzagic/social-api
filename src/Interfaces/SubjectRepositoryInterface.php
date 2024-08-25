<?php

namespace App\Interfaces;

use App\Models\Subject;

interface SubjectRepositoryInterface
{
  public function create(Subject $subject): Subject;

  public function update(Subject $subject): Subject;

  public function delete(Subject $subject): Subject;

  public function findById(int $id): Subject;

  public function findAll(): array;

  public function findByName(string $name): Subject;
}