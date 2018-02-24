<?php
//If it is going to need database, then it's probably smart to require it before we start
require_once(LIB_PATH.DS.'database.php');
class Department extends DatabaseObject{
    protected static $table_name = "department";
    protected static $db_fields  = array('id', 'name', 'description', 'head');
    public $id;
    public $name;
    public $description;
    public $head;
}
?>