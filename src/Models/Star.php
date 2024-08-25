<?php

namespace App\Models;

class Star
{
  private $id;
  private $subject_id;
  private $genre_id;
  private $subgenre_id;
  private $title_id;
  private $name;
  private $description;

  public function __construct($id, $subject_id, $genre_id, $subgenre_id, $title_id, $name, $description = null)
  {
    $this->id = $id;
    $this->subject_id = $subject_id;
    $this->genre_id = $genre_id;
    $this->subgenre_id = $subgenre_id;
    $this->title_id = $title_id;
    $this->name = $name;
    $this->description = $description;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getSubjectId()
  {
    return $this->subject_id;
  }

  public function getGenreId()
  {
    return $this->genre_id;
  }

  public function getSubgenreId()
  {
    return $this->subgenre_id;
  }

  public function getTitleId()
  {
    return $this->title_id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setSubjectId($subject_id)
  {
    $this->subject_id = $subject_id;
  }

  public function setGenreId($genre_id)
  {
    $this->genre_id = $genre_id;
  }

  public function setSubgenreId($subgenre_id)
  {
    $this->subgenre_id = $subgenre_id;
  }

  public function setTitleId($title_id)
  {
    $this->title_id = $title_id;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }
}