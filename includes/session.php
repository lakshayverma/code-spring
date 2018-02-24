<?php
/*
A class to work with SESSIONs
In our case, primarily to manage logging users in and out

Keep in mind when working with sessions that it is generally inadvisable to store DB-related objects in sessions.
*/
class Session{
    private $logged_in = false;
    public $user_id;
    public $user_type;
    public $message;
    function __construct(){
        session_start();
        $this->check_message();
        $this->check_login();
        if($this->logged_in){
            // TODO actions to take right away if user is logged in
        }else{
            // TODO actions to take right away if user is not logged in
        }
    }
    
    public function is_logged_in(){
        return $this->logged_in;
    }
    
    public function is_admin(){
        return ($this->user_type == 'admin') ? TRUE : FALSE;
    }
    
    public function login($user){
        // database should find user based on username/password
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->user_type = $_SESSION['user_type'] = ($user->designation) ? $user->get_type() : 'client';
            $this->logged_in = true;
        }
    }
    
    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        unset($_SESSION['user_type']);
        unset($this->user_type);
        $this->logged_in = false;
    }
    
    private function check_login(){
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])){
            $this->user_id = $_SESSION['user_id'];
            $this->user_type = $_SESSION['user_type'];
            $this->logged_in = true;
        }else{
            unset($this->user_id);
            unset($this->user_type);
            $this->logged_in = false;
        }
    }
    
    private function check_message(){
        // Is there a message stored in the session?
        if(isset($_SESSION['message'])){
            // Add it as an attribute and erase the stored version
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        }else{
            $this->message = "";
        }
    }
    public function message($msg=""){
        if(!empty($msg)){
            // then this is "set message"
            // make sure you understand why $this->message = $msg would not work
            $_SESSION['message'] = $msg;
        }else{
            // then this is 'get message'
            return $this->message;
        }
    }
    
    public function get_user_object(){
        $user = false;
        
        if($this->user_type == 'client'){
            $user = Client::find_by_id($this->user_id);
        }
        else{
            $user = User::find_by_id($this->user_id);
        }
        return $user;
    }
}

$session = new Session();
$message = $session->message();

?>