<?php

class Direction extends DatabaseObject {

  static public $table_name = 'direction';
  static public $db_columns = ['id', 'recipe_id', 'direction_line_item', 'direction_text', 'sort_order'];

  
  public $id;
  public $recipe_id;
  public $direction_line_item;
  public $direction_text;
  public $sort_order;

  public function __construct($args = []) {
    $this->recipe_id = $args['recipe_id'] ?? '';
    $this->direction_line_item = $args['direction_line_item'] ?? '';
    $this->direction_text = $args['direction_text'] ?? '';
    $this->sort_order = $args['sort_order'] ?? $this->direction_line_item;
  }

  protected function validate()
  {
    $this->errors = [];

    if (empty($this->direction_text)) {
      $this->errors[] = "Direction text cannot be empty.";
    }
    
    return $this->errors;
  }
}
