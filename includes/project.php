<?php

// If it is going to need the database, then it is probably smart to require it before we start.
require_once(LIB_PATH . DS . "database.php");

class Project extends DatabaseObject {

    protected static $table_name = 'project';
    protected static $db_fields = array('id', 'name', 'description',
        'client_id', 'start_date',
        'deadline', 'project_manager',
        'current_stage'
    );
    public $id;
    public $name;
    public $description;
    public $client_id;
    public $start_date;
    public $deadline;
    public $project_manager;
    public $current_stage;
    public $stages = array('Initial', 'Design', 'Code', 'Test', 'Final', 'Failed');

    public static function make($name, $desc, $client, $start, $end) {
        $project = new Project();
        $project->name = $name;
        $project->description = $desc;
        $project->client_id = $client;
        $project->start_date = $start;
        $project->deadline = $end;
        $project->project_manager = 4;
        $project->current_stage = 'Initial';
        return $project;
    }

    public static function find_for_client($client_id) {
        $query = "SELECT * FROM " . static::$table_name
                . " WHERE client_id=" . $client_id;
        return self::find_by_sql($query);
    }

    public static function find_for_user($user_id) {
        $query = "select * from " . static::$table_name
                . " where "
                . "project_manager = {$user_id} "
                . "or "
                . "id in "
                . "(select project from task"
                . " where assigned_to = {$user_id})";
        return static::find_by_sql($query);
    }

    public static function find_open() {
        $query = "select * from project where project_manager = 4";
        return static::find_by_sql($query);
    }

    public function validate_data() {
        $attributes = array('name', 'description', 'client_id',
            'start_date', 'deadline', 'project_manager'
        );
        return $this->validate_attributes($attributes);
    }

    public function change_stage($value) {
        if (!empty($value) && (array_search($value, $this->stages)) >= 0) {
            $this->current_stage = $value;
        }
    }

    public function current_stage() {
        return $this->current_stage;
    }

}

?>