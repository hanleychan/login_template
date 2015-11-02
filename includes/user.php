<?php

require_once('db.php');
require_once('database_object.php');

define("MIN_PASSWORD_LENGTH", 6);
define("MAX_PASSWORD_LENGTH", 50);
define("MIN_USERNAME_LENGTH", 6);
define("MAX_USERNAME_LENGTH", 16);

class User extends DatabaseObject {
	public $id;
	public $username;
	public $password;
	protected static $table_name = "users";
	protected static $db_fields=array('id','username','password');
	
	public static function authenticate($username, $password) {
		global $database;
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$users = self::find_by_sql("SELECT * FROM users WHERE username='{$username}' LIMIT 1"); 
		if($users) {
			$user = $users[0];	
			if(password_verify($password, $user->password)) {
				return $user;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
		
	public static function validatePassword($password, $passwordConfirm) {
        if(empty($password)) {
            $errors[] = "Your password can not be blank";
        }
        if($password != $passwordConfirm) {
            $errors[] = "Your passwords do not match";
        }
        if(strlen($password) < MIN_PASSWORD_LENGTH || strlen($password) > MAX_PASSWORD_LENGTH) {
            $errors[] = "Your password must be between " . MIN_PASSWORD_LENGTH . " and " . MAX_PASSWORD_LENGTH . " characters long.";
        }

        if(isset($errors))
            return $errors;
        else
            return null;
    }

    public static function validateUsername($username) {
        if(empty($username)) {
            $errors[] = "Your username can not be blank";
        } 

        // Check if username already exists in the database
        $result = self::find_by_sql("SELECT username FROM users WHERE username='{$username}'");
        if($result) {
            $errors[] = "The chosen username already exists";
        }

        if(preg_match('/[^a-zA-Z0-9_]/', $username)) {
            $errors[] = "Username can only contain letters, numbers, and underscores";
        }

        if(strlen($username) < MIN_USERNAME_LENGTH || strlen($username) > MAX_USERNAME_LENGTH) {
            $errors[] = "Usernames must be between " . MIN_USERNAME_LENGTH . " and " . MAX_USERNAME_LENGTH . " characters long";
        }

        if(isset($errors))
            return $errors;
        else
            return null;
    }
	
}

?>
