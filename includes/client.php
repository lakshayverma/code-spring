<?php

//If it is going to need database, then it's probably smart to require it before we start
require_once(LIB_PATH . DS . 'database.php');

class Client extends DatabaseObject {

    protected static $table_name = "client";
    protected static $db_fields = array('id', 'name', 'company', 'location',
        'email', 'mobile', 'username', 'password'
    );
    public $id;
    public $name;
    public $company;
    public $location;
    public $email;
    public $mobile;
    public $username;
    public $password;

    public function validate_data() {
        $attributes = array('username', 'password',
            'company', 'name'
        );
        return $this->validate_attributes($attributes) && is_numeric($this->mobile);
    }

    public static function authenticate($username = "", $password = "") {
        global $database;

        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function full_name() {
        return $this->name;
    }
    
    public function get_type(){
        return 'client';
    }
    
    public function html_name(){
        return "<strong> ". $this->full_name() . "</strong>";
    }

    public static function make($name, $company, $location, $email, $mobile, $username, $password) {
        $client = new self;

        $client->name = $name;
        $client->company = $company;
        $client->location = $location;
        $client->email = $email;
        $client->mobile = $mobile;
        $client->username = $username;
        $client->password = $password;

        return $client;
    }

}

?>