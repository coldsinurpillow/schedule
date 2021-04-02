<?php
class Classroom extends Table {
  public $classroom_id = 0;
  public $name = "";
  public $active = 1;

  public function validate() {
    if(!(empty($this->name))) {
      return true;
    } else {
      return false;
    }
  }
} 