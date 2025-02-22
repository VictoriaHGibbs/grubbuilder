<?php

class User extends DatabaseObject
{

    static public $table_name = 'user';
    static public $db_columns = ['id', 'username', 'profile_image_url', 'f_name', 'l_name', 'email_address', 'password_hash', 'joined_at', 'role_id', 'active'];
    
    public $id;
    public $username;
    public $profile_image_url;
    public $f_name;
    public $l_name;
    public $email_address;
    protected $password_hash;
    public $joined_at;
    public $role_id;
    public $active;
    public $password;
    public $confirm_password;
    protected $password_required = true;



    public function __construct($args = [])
    {
        $this->username = $args['username'] ?? '';
        $this->profile_image_url = $args['profile_image_url'] ?? NULL;
        $this->f_name = $args['f_name'] ?? '';
        $this->l_name = $args['l_name'] ?? '';
        $this->email_address = $args['email_address'] ?? '';
        $this->password_hash = $args['password_hash'] ?? '';
        $this->joined_at = $args['joined_at'] ?? date('Y-m-d H:i:s');
        $this->role_id = $args['role_id'] ?? 1;
        $this->active = $args['active'] ?? 1;
        $this->password = $args['password'] ?? '';
        $this->confirm_password = $args['confirm_password'] ?? '';
    }

    // Retrieve username from a $id
    static public function get_username_by_id($id)
    {
        $user = self::find_by_id($id);
        return $user ? $user->username : null;
    }

    // Active display
    public function active_display() {
      if ($this->active == 1) {
        echo 'Active';
      } else {
        echo 'Deactivated';
      }
    }

    // Hash password before storing
    protected function set_hashed_password()
    {
        $this->password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Verify password
    public function verify_password($password)
    {
        return password_verify($password, $this->password_hash);
    }

    protected function create() {
      $this->set_hashed_password();
      return parent::create();
    }

    protected function update() {
      if($this->password != '') {
        $this->set_hashed_password();
        // validate password
      } else {
        // password not being updated, skip hashing and validation
        $this->password_required = false;
      }
      return parent::update();
    }

    protected function validate() {
      $this->errors = [];

      if(is_blank($this->username)) {
        $this->errors[] = "Username cannot be blank.";
      } elseif (!has_length($this->username, array('min' => 5, 'max' => 20))) {
        $this->errors[] = "Username must be between 5 and 20 characters.";
      } elseif (!has_unique_username($this->username, $this->id ?? 0)) {
        $this->errors[] = "Username not allowed. Try another.";
      }
  
      if(is_blank($this->f_name)) {
        $this->errors[] = "First name cannot be blank.";
      } elseif (!has_length($this->f_name, array('min' => 2, 'max' => 50))) {
        $this->errors[] = "First name must be between 2 and 50 characters.";
      }
  
      if(is_blank($this->l_name)) {
        $this->errors[] = "Last name cannot be blank.";
      } elseif (!has_length($this->l_name, array('min' => 2, 'max' => 50))) {
        $this->errors[] = "Last name must be between 2 and 50 characters.";
      }
  
      if(is_blank($this->email_address)) {
        $this->errors[] = "Email cannot be blank.";
      } elseif (!has_length($this->email_address, array('max' => 100))) {
        $this->errors[] = "Email must be less than 100 characters.";
      } elseif (!has_valid_email_format($this->email_address)) {
        $this->errors[] = "Email must be a valid format.";
      }
  
      if($this->password_required) {
        if(is_blank($this->password)) {
          $this->errors[] = "Password cannot be blank.";
        } elseif (!has_length($this->password, array('min' => 12))) {
          $this->errors[] = "Password must contain 12 or more characters";
        } elseif (!preg_match('/[A-Z]/', $this->password)) {
          $this->errors[] = "Password must contain at least 1 uppercase letter";
        } elseif (!preg_match('/[a-z]/', $this->password)) {
          $this->errors[] = "Password must contain at least 1 lowercase letter";
        } elseif (!preg_match('/[0-9]/', $this->password)) {
          $this->errors[] = "Password must contain at least 1 number";
        } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
          $this->errors[] = "Password must contain at least 1 symbol";
        }
  
        if(is_blank($this->confirm_password)) {
          $this->errors[] = "Confirm password cannot be blank.";
        } elseif ($this->password !== $this->confirm_password) {
          $this->errors[] = "Password and confirm password must match.";
        }
      }
  
      return $this->errors;
    }

    static public function find_by_username($username) {
      $sql = "SELECT * FROM " . static::$table_name . " ";
      $sql .= "WHERE username='" . self::$database->escape_string($username) . "'";
      $obj_array = static::find_by_sql($sql);
      if(!empty($obj_array)) {
        return array_shift($obj_array);
      } else {
        return false;
      }
    }

    // Check if a username exists
    //   static public function username_exists($username) {
    //     $sql = "SELECT COUNT(*) FROM " . static::$table_name . " WHERE username = ?";
    //     $stmt = self::$database->prepare($sql);
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();
    //     $stmt->bind_result($count);
    //     $stmt->fetch();
    //     return $count > 0;
    //   }

}
