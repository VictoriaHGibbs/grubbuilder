<?php

class DatabaseObject
{
  static protected $database;
  static protected $table_name = "";
  static protected $db_columns = [];
  static protected $id = "";
  static public $primary_key = '';
  public $errors = [];

  static public function set_database($database)
  {
    self::$database = $database;
  }

  static public function find_by_sql($sql)
  {
    $result = self::$database->query($sql);
    if (!$result) {
      exit("Database query failed.");
    }

    // results into objects
    $object_array = [];
    while ($record = $result->fetch_assoc()) {
      $object_array[] = static::instantiate($record);
    }

    $result->free();

    return $object_array;
  }

  static public function find_all()
  {
    $sql = "SELECT * FROM " . static::$table_name;
    return static::find_by_sql($sql);
  }

  static public function find_by_id($id)
  {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

// Find by the primary key value
  static public function find_by_pk($id)
  {
    $sql = "SELECT * FROM " . static::$table_name . " ";
    $sql .= "WHERE " . static::$primary_key . "='" . self::$database->escape_string($id) . "'";
    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }

  // Get ALL rows (optionally with filters)
  public static function find_related($filters = []) {
    $table_name = static::$table_name;
    $query = "SELECT * FROM {$table_name}";
    $params = [];
    $types = "";
    $values = [];

    if (!empty($filters)) {
        $query .= " WHERE " . implode(" AND ", array_map(fn($key) => "$key = ?", array_keys($filters)));
        $params = array_values($filters);
        $types = str_repeat("s", count($params));
    }

    $stmt = static::$database->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_object(static::class)) {
        $data[] = $row;
    }
    return $data;
  }

  // Uses recipe id to pull in associated values from any table.
  public static function find_by_recipe($recipe_id) {
    return self::find_related(['recipe_id' => $recipe_id]);
  }

  // Uses user id to pull in associated values from any table.
  public static function find_by_user($user_id) {
    return self::find_related(['user_id' => $user_id]);
  }



  static protected function instantiate($record)
  {
    $object = new static;
    foreach ($record as $property => $value) {
      if (property_exists($object, $property)) {
        $object->$property = $value;
      }
    }
    return $object;
  }

  protected function validate()
  {
    $this->errors = [];

    return $this->errors;
  }

  protected function create()
  {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(', ', array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    $result = self::$database->query($sql);
    if ($result) {
      $this->id = self::$database->insert_id;
    }
    return $result;
  }

  protected function update()
  {
    $this->validate();
    if (!empty($this->errors)) {
      return false;
    }
    $attributes = $this->sanitized_attributes();
    $attribute_pairs = [];
    foreach ($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(', ', $attribute_pairs);
    $sql .= " WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

  public function save()
  {
    if (isset($this->id)) {
      return $this->update();
    } else {
      return $this->create();
    }
  }

  public function merge_attributes($args = [])
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }

  public function attributes()
  {
    $attributes = [];
    foreach (static::$db_columns as $column) {
      if ($column == 'id') {
        continue;
      }
      $attributes[$column] = $this->$column;
    }
    return $attributes;
  }

  protected function sanitized_attributes()
  {
    $sanitized = [];
    foreach ($this->attributes() as $key => $value) {
      $sanitized[$key] = self::$database->escape_string($value);
    }
    return $sanitized;
  }

  public function delete()
  {
    $sql = "DELETE FROM " . static::$table_name . " ";
    $sql .= "WHERE id='" . self::$database->escape_string($this->id) . "' ";
    $sql .= "LIMIT 1";
    $result = self::$database->query($sql);
    return $result;
  }

// -----------------------------------------------------------------------

//   public function lookup($lu_id, $lu_table) {
//     $sql = "SELECT " . $lu_table . " FROM " . $lu_table . " ";
//     $sql .=  "WHERE id='" . $lu_id . "'";
//     $obj_array = static::find_by_sql($sql);
//     return $obj_array;
//   }

// Get ONE row by primary key
// public static function find($id) {
//   $table_name = static::$table_name;
//   $primary_key = static::$primary_key;
//   $query = "SELECT * FROM {$table_name} WHERE {$primary_key} = ? LIMIT 1";
  
//   $stmt = static::$database->prepare($query);
//   $stmt->bind_param("i", $id);
//   $stmt->execute();
//   $result = $stmt->get_result();
  
//   return $result->fetch_object(static::class);
// }


}
