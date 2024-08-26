<?php

namespace App\Controllers;

use App\Repositories\SubjectRepository;
use App\Database\Connection;

class SubjectController
{
  private $subjectRepository;
  public function __construct(Connection $connection)
  {
    $this->subjectRepository = new SubjectRepository($connection);
  }

  public function create($data)
  {
    $content = json_decode($data);
    foreach ($content as $key => $value) {
      if (empty($value)) {
        http_response_code(400);
        $resp = [
          "message" => "Invalid data"
        ];
        echo json_encode($resp);
      }
    }
    $subject = $this->subjectRepository->create($content);
    if (!$subject) {
      return;
    } else {
      http_response_code(201);
      echo json_encode($subject);
    }
  }

  public function findById($data): void
  {
    $subject = $this->subjectRepository->findById($data);
    echo json_encode($subject);
  }

  public function findByName($data)
  {
    $data = json_decode($data);
    if (!empty($data) && is_string($data->name)) {
      $subject = $this->subjectRepository->findByName($data->name);
      echo json_encode($subject);
    } else {
      http_response_code(400);
      $resp = [
        "message" => "Invalid data"
      ];
      echo json_encode($resp);
    }
  }
}