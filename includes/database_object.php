<?php
//If it is going to need database, then it's probably smart to require it before we start
require_once(LIB_PATH.DS.'database.php');
class DatabaseObject{
    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();                // NOTE solution to problem #1
        while ($row = $database->fetch_array($result_set)) {
          $object_array[] = static::instantiate($row);      // NOTE using static:: instead of self:: for late static binding.
        }
        return $object_array;
  }
    public static function find_all(){
        return self::find_by_sql("SELECT * FROM " . static::$table_name);
    }
    public static function find_by_id($id=0){
        global $database;
        $id = $database->escape_value($id);
        $result_array = self::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id = {$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }
    
    
    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }
    
    private static function instantiate($record){
        $object = new static;
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }
        return $object;
    }
    private function has_attribute($attribute){
        $object_vars = $this->attributes();
        return array_key_exists($attribute, $object_vars); // all we need to confirm is the key exists irrespective of the value.
    }
    
    public function attributes(){
        $attributes = array();
        foreach(static::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }
    protected function sanitized_attributes(){
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // NOTE: does not alter the actual value of each attribute
        
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }
    public function validate_attributes($attributes=array()){
        foreach($attributes as $attribute){
            $attr = trim($this->$attribute);
            if($this->has_attribute($attribute) && empty($attr)){
                return false;
            }
        }
        return true;
    }
    public function show_attributes($attributes=array()){
        $string = "<ul>";
        foreach($attributes as $attribute){
                $string .= "<strong>{$attribute}</strong> {$this->$attribute}";
            if($this->has_attribute($attribute) && empty($this->$attribute)){
                $string .= "<strong>{$attribute}</strong> {$this->$attribute}";
            }
        }
        $string .= "</ul>";
        return $string;
    }
    // CRUD Functions
    public function save(){
        // A new record won't have an id yet.
        return isset($this->id) ? $this->update() : $this->create();
    }
    
    public function create(){
        global $database;
        $attributes = $this->sanitized_attributes();
        $sql  = "INSERT INTO " . static::$table_name . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        }else{
            return false;
        }
    }
    public function update(){
        global $database;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql  = "UPDATE " . static::$table_name . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=" . $database->escape_value($this->id);
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete(){
        global $database;
        $sql  = "DELETE FROM " . static::$table_name . " ";
        $sql .= "WHERE id=" . $database->escape_value($this->id) . " ";
        $sql .= "LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
}
?>