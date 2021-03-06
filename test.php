<?php
defined('DB_SERVER')    ? null : define("DB_SERVER", "mysql.hostinger.in");
defined('DB_USER')      ? null : define("DB_USER", "u859499344_mcs44");
defined('DB_PASS')      ? null : define("DB_PASS", "146433412");
defined('DB_NAME')      ? null : define("DB_NAME", "u859499344_ignou");


class MySQLDatabase{
    private $connection;
    public function __construct(){
        $this->open_connection();
    }
    
    // Connection functions
    public function open_connection(){
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if(mysqli_connect_errno()){
            die("Database connection failed: " .
                mysqli_connect_error() .
                " (" . mysqli_connect_errno() . ")"
               );
        }
    }
    public function close_connection(){
        if(isset($this->connection)){
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
    
    // Database query functions
    public function query($sql){
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result, $sql);
        return $result;
    }
    private function confirm_query($result,$sql=""){
        if(!$result){
            die("<p>Database query <big>{$sql}</big> failed.</p>");
        }
    }
    public function escape_value($string){
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }
    
    // Database neutral functions
    public function fetch_array($result_set){
        return mysqli_fetch_array($result_set);
    }
    public function num_rows($result_set){
        return mysqli_num_rows($result_set);
    }
    public function insert_id(){
        // get the last id inserted over the current database connection
        return mysqli_insert_id($this->connection);
    }
    public function affected_rows(){
        return mysqli_affected_rows($this->connection);
    }
}

echo 'LAKSHAY';

$database = new MySQLDatabase();
$db =& $database;
?>