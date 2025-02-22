<?php

class Direction extends DatabaseObject {

  static public $table_name = 'direction';
  static public $db_columns = ['direction_id', 'recipe_id', 'direction_line_item', 'direction_text', 'sort_order'];
  static public $primary_key = 'direction_id';
  
  public $direction_id;
  public $recipe_id;
  public $direction_line_item;
  public $direction_text;
  public $sort_order;

  // public function __construct($args = []) {
  //   $this->direction_id = $args['direction_id'] ?? '';
  //   $this->recipe_id = $args['recipe_id'] ?? '';
  //   $this->direction_line_item = $args['direction_line_item'] ?? '';
  //   $this->direction_text = $args['direction_text'] ?? '';
  //   $this->sort_order = $args['sort_order'] ?? '';
  // }

  // Fetch all directions for a specific recipe
  public static function find_by_recipe($recipe_id) {
    return self::find_related(['recipe_id' => $recipe_id]);
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
