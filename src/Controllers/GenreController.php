<?php

namespace App\Controllers;

use App\Repositories\GenreRepository;
use App\Database\Connection;

class GenreController
{
  private $genreRepository;
  public function __construct(Connection $connection)
  {
    $this->genreRepository = new GenreRepository($connection);
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
    $genre = $this->genreRepository->create($content);
    if (!$genre) {
      return;
    } else {
      http_response_code(201);
      echo json_encode($genre);
    }
  }
}