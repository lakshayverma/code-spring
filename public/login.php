<?php
require_once("../includes/initialize.php");

if ($session->is_logged_in()) {
    redirect_to("projects.php");
}

// Remember to always give form's submit tag a name="submit" attribute!
if (isset($_POST['submit']) && $_POST['submit'] != 'Create Client') { // Form was submitted.
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($_POST['submit'] == 'User') {
        // check USER table to see if username/password exist.
        $user_type = 'User';
        $found_user = User::authenticate($username, $password);
    }
    if ($_POST['submit'] == 'Client') {
        // check CLIENT table to see if username/password exist.
        $user_type = 'Client';
        $found_user = Client::authenticate($username, $password);
    }
    if ($found_user) {
        $session->login($found_user);
        log_action("{$user_type}: " . $username, "logged in.");
        redirect_to("projects.php");
    } else {
        // username/password combo was not found in the database.
        $message = "Username/Password combination incorrect.";
        log_action("Login: {$user_type}: " . $username, $message);
    }
} elseif (isset($_POST['submit']) && $_POST['submit'] == 'Create Client') {
    $name = $_POST['client_name'];
    $company = $_POST['company'];

    $location = $_POST['location'];
    $email = $_POST['mail'];
    $mobile = $_POST['mobile'];

    $username = $_POST['username'];
    $password = $_POST['password'];

    $client = Client::make($name, $company, $location, $email, $mobile, $username, $password);


    if ($client->validate_data()) {
        if ($client->save()) {
            $session->message("User: {$client->username} has been created.");
        } else {
            $session->message("Could Not create Client.");
        }
    } else {
        $session->message("The data you provided was incorrect.");
    }
    redirect_to("login.php");
} else { // Form has not been submitted.
    $username = "";
    $password = "";
}
?>
<?php include_layout_template('header.php'); ?>
<div class="row">
    
    <div class="h4 text-warning">
        <?php echo output_message($message); ?>
    </div>

    <form method="post" action="login.php" class="col-md-5 col-md-offset-1 panel panel-primary">
        <h3 class="panel-heading">Create New User</h3>
        <div class="row">
            <label class="col-md-12">
                <span>Name</span>
                <input required type="text" name="client_name" value="" placeholder="Client Name" class="form-control">
            </label>
        </div>
        <div class="row">
            <label class="col-md-6">
                <span>Company</span>
                <input required type="text" name="company" value="" placeholder="Company Name" class="form-control">
            </label>
            <label class="col-md-6">
                <span>City</span>
                <input required type="text" name="location" value="" placeholder="Client City" class="form-control">
            </label>
        </div>
        <div class="row">
            <label class="col-md-6">
                <span>Email</span>
                <input required type="email" name="mail" value="" placeholder="nomail@example.com" class="form-control">
            </label>
            <label class="col-md-6">
                <span>Contact No</span>
                <input required type="tel" name="mobile" value="" placeholder="+xx-xxx-xxx-xxx-x" class="form-control">
            </label>
        </div>
        <div class="row">
            <label class="col-md-6">
                <span>User Name</span>
                <input required type="text" name="username" value="" placeholder="User Name" class="form-control">
            </label>
            <label class="col-md-6">
                <span>Password</span>
                <input required type="password" name="password" value="" placeholder="Password" class="form-control">
            </label>
        </div>
        <div class="row">
            <label class="col-md-6"><input type="submit" name="submit" value="Create Client" class="btn btn-block btn-success"></label>
            <label class="col-md-6"><input type="reset" class="btn btn-block btn-danger"></label>
        </div>
    </form>

    <form method="post" action="login.php" class="col-md-5 col-md-offset-1 panel panel-success">
        <h2 class="panel-heading">Login to website</h2>
        <div class="panel-body">
            <div class="row">
                <label class="col-md-12">
                    User Name: <input type="text" name="username" maxlength="30" value="<?php htmlentities($username); ?>" class="form-control" />
                </label>
            </div>
            <div class="row">
                <label class="col-md-12">
                    Password: <input type="password" name="password" maxlength="30" value="<?php htmlentities($password); ?>" class="form-control">
                </label>
            </div>
            <div class="row">
                <label class="col-md-6"><input type="submit" name="submit" value="User" class="btn btn-block btn-primary"></label>
                <label class="col-md-6"><input type="submit" name="submit" value="Client" class="btn btn-block btn-success"></label>
            </div>
        </div>
    </form>
</div>
<?php include_layout_template('footer.php'); ?>