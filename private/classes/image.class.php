<?php 

class Image extends DatabaseObject {

  static public $table_name = 'image';
  static public $db_columns = ['id', 'recipe_id', 'image_line_item', 'image_url', 'sort_order'];

  public $id;
  public $recipe_id;
  public $image_line_item;
  public $image_url;
  public $sort_order;

  public function __construct($args = []) {
    $this->recipe_id = $args['recipe_id'] ?? '';
    $this->image_line_item = $args['image_line_item'] ?? '';
    $this->image_url = $args['image_url'] ?? '';
    $this->sort_order = $args['sort_order'] ?? 0;
  }

  protected function validate()
  {
    $this->errors = [];

    // Subclass specific validation

    return $this->errors;
  }
}
