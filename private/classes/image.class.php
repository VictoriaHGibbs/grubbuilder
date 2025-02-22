<?php 

class Image extends DatabaseObject {

  static public $table_name = 'image';
  static public $db_columns = ['image_id', 'recipe_id', 'image_line_item', 'image_url', 'sort_order'];
  static public $primary_key = 'image_id';

  public $image_id;
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

  // Get images by recipe
  static public function find_by_recipe($recipe_id) {
    return self::find_related(['recipe_id' => $recipe_id]);
  }

  protected function validate()
  {
    $this->errors = [];

    // Subclass specific validation

    return $this->errors;
  }
}
