<?php
// If it is going to need the database, then it is probably smart to require it before we start.
require_once(LIB_PATH.DS."database.php");

class Comment extends DatabaseObject{
    protected static $table_name = 'comment';
    protected static $db_fields = array('id', 'posted_by', 'user_type', 'project', 'comment', 'posted_on');
    public $id;
    public $posted_by;
    public $user_type;
    public $project;
    public $comment;
    public $posted_on;
    
    public static function make($posted_by, $user_type, $project, $comment){
       $cmnt = new self;
       $cmnt->posted_by = $posted_by;
       $cmnt->user_type = ($user_type == 'client') ? 'client' : 'user';
       $cmnt->project = $project;
       $cmnt->comment= $comment;
       $cmnt->posted_on = strftime("%Y-%m-%d %H:%M:%S", time());
       
       return $cmnt;
    }
    
    public static function find_for_project($project){
        return static::find_by_sql("SELECT * FROM comment where project=" . $project);
    }
    
    public function to_string(){
        $data  = "";
        
        if($this->user_type == 'client'){
            $posted_by = Client::find_by_id($this->posted_by);
        }else{
            $posted_by = User::find_by_id($this->posted_by);
        }
        
        $data .= "<li class=\"list-group-item\">"
                . "<h4>"
                . $posted_by->html_name()
                . "<p class=\"h6\">"
                . $this->posted_on
                . "</p>"
                . "</h4>"
                . "<cite>"
                . $this->comment
                . "</cite>"
                . "</li>";
        
        
        return $data;
    }
}
