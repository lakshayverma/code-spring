<?php
//If it is going to need database, then it's probably smart to require it before we start
require_once(LIB_PATH.DS.'database.php');
class Task extends DatabaseObject{
    protected static $table_name = "task";
    protected static $db_fields  = array('id', 'name', 'description', 'project',
                                        'assigned_to', 'stage', 'deadline'
                                        );
    public $id;
    public $name;
    public $description;
    public $project;
    public $assigned_to;
    public $stage;
    public $deadline;
    public $stages = array('Initial', 'Mid', 'Testing', 'Final', 'Done', 'Failed');
    public static function make($name, $desc, $project_id, $assigned_to){
        $task = new Task();
        $task->name = $name;
        $task->description = $desc;
        $task->project = $project_id;
        $task->assigned_to = $assigned_to;
        $task->stage = 'Initial';
        return $task;
    }
    
    public function current_stage(){
        return $this->stage;
    }

        public function validate_data(){
        $attributes = array('name', 'description', 'project', 'assigned_to');
        return $this->validate_attributes($attributes);
    }

        public static function assigned_tasks($user_id){
        $query = "SELECT * FROM " . static::$table_name
                . " WHERE assigned_to=" . $user_id. " "
                . " order by project, id";
        return static::find_by_sql($query);
    }
    
    public static function project_tasks($project_id){
        $query = "SELECT * FROM " . static::$table_name
                . " WHERE project=" . $project_id . " "
                . " order by project, id";
        return static::find_by_sql($query);
    }
    
    public function change_stage($value){
        if(!empty($value) && (array_search($value, $this->stages)) >= 0){
            $this->stage = $value;
        }else{
            $this->stage = $this->stage;
        }
    }
    
    public static function basic_tasks_for($project){
        $project_tasks = array();
        $tasks = array('System Analysis', 'System Design', 'Coding', 'Testing', 'Implementation', 'Maintainance');
        foreach ($tasks as $task){
            $project_task = static::make($task, "", $project, 4);
            $project_tasks[] = $project_task;
        }
        return $project_tasks;
    }

}
?>