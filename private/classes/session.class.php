<?php

class Session
{
  private $user_id;
  public $username;
  private $last_login;
  public $role_id;

  public const MAX_LOGIN_AGE = 60 * 60 * 24; // 1 day in seconds

  public function __construct()
  {
    session_start();
    $this->check_stored_login();
  }

  public function login($user)
  {
    if ($user) {
      // prevent session fixation attacks
      session_regenerate_id();
      $this->user_id = $_SESSION['user_id'] = $user->user_id;
      $this->username = $_SESSION['username'] = $user->username;
      $this->last_login = $_SESSION['last_login'] = time();
      $this->role_id = $_SESSION['role_id'] = $user->role_id;
    }
    return true;
  }

  public function is_logged_in()
  {
    // return isset($this->user_id);
    return isset($this->user_id) && $this->last_login_is_recent();
  }

  public function is_admin_logged_in()
  {
    return $this->is_logged_in() && ($this->role_id == '2' || $this->role_id == '3');
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['last_login']);
    unset($_SESSION['role_id']);
    unset($this->user_id);
    unset($this->username);
    unset($this->last_login);
    unset($this->role_id);
    return true;
  }

  private function check_stored_login()
  {
    if (isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->username = $_SESSION['username'];
      $this->last_login = $_SESSION['last_login'];
      $this->role_id = $_SESSION['role_id'];
    }
  }

  private function last_login_is_recent()
  {
    if (!isset($this->last_login)) {
      return false;
    } elseif (($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }

  public function message($msg = "")
  {
    if (!empty($msg)) {
      // Then this is a "set" message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      // Then this is a "get" message
      return $_SESSION['message'] ?? '';
    }
  }

  public function clear_message()
  {
    unset($_SESSION['message']);
  }
}
