<?php
// If it is going to need the database, then it is probably smart to require it before we start.
require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject{
    // this class is used for the database table named users.
    protected static $table_name = "user";
    protected static $db_fields = array('id', 'first_name', 'last_name', 'username', 'password', 'department_id', 'designation');
    public $id;
    public $first_name;
    public $last_name;
    public $username;
    public $password;
    public $department_id;
    public $designation;
    public static function make($first_name, $last_name,
                       $username, $password,
                       $department_id, $designaiton
                      ){
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->username = $username;
        $user->password = $password;
        $user->department_id = $department_id;
        $user->designation = $designaiton;
        
        return $user;
    }
    public function validate_data(){
        $attributes = array('username', 'password',
                            'first_name', 'last_name'
                            );
        return $this->validate_attributes($attributes);
    }
    
    public function get_type(){
        switch ($this->designation){
            case 'Head':
            case 'Lead':
                return 'admin';
            default :
                return 'user';
        }
        return 'user';
    }

    public static function authenticate($username="", $password=""){
        global $database;
        
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        
        $sql  = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";
        
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name . " " . $this->last_name;
        }else{
            return "";
        }
    }
    public function html_name(){
        return "<a href=\"user_details.php?id={$this->id}\">" . $this->full_name() . "</a>";
    }
    public function department_name(){
        global $database;
        $sql = "SELECT name FROM department "
            . "WHERE id={$this->department_id} "
            . "LIMIT 1";
        $result = $database->query($sql);
        $row = $database->fetch_array($result);
        return array_shift($row);
    }
    
}
?>