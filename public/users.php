<?php
require_once('../includes/initialize.php');
give_access(TRUE);
?>
<?php include_layout_template('header.php'); ?>

<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'Make User') {
    $name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $department_id = $_POST['department_id'];
    $designaiton = $_POST['designation'];

    $user = User::make($name, $last_name, $username, $password, $department_id, $designaiton
    );
    if ($user->validate_data()) {
        if ($user->save()) {
            
        } else {
            $session->message("Could Not create user.");
            redirect_to("users.php");
        }
    } else {
        $session->message("Fields can not be empty.");
        redirect_to("users.php");
    }
}
?>
<section class="col-md-4 panel panel-primary">
    <h3 class="panel-heading">All the users.</h3>
    <ul class="panel-body list-group">
        <?php
        $users = User::find_all();
        if ($users):
            foreach ($users as $user):
                ?>
                <li class="list-group-item">
                    <p class="btn btn-link">
                        <span class="glyphicon glyphicon-user"></span>
                        <a href="user_details.php?id=<?php echo $user->id; ?>">
                            <?php echo $user->full_name(); ?>
                            <small class="info">(<?php echo $user->designation; ?>)</small>
                        </a>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php else: ?>
    <p>Currently no user is in the database</p>
<?php endif; ?>
<?php echo output_message($session->message()); ?>
<form method="post" action="users.php" class="col-md-7 col-md-offset-1 panel panel-info">
    <h3 class="panel-heading">
        <span class="glyphicon glyphicon-user"></span>
        <strong class="panel-title">Create New User</strong>
    </h3>
    <div class="form-group row">
        <label class="col-md-6">
            <span>First Name</span>
            <input type="text" name="first_name" value="" placeholder="First Name" class="form-control">
        </label>
        <label class="col-md-6">
            <span>Last Name</span>
            <input type="text" name="last_name" value="" placeholder="Last Name" class="form-control">
        </label>
    </div>
    <div class="form-group row">
        <label class="col-md-6">
            <span>User Name</span>
            <input type="text" name="username" value="" placeholder="User Name" class="form-control">
        </label>
        <label class="col-md-6">
            <span>Password</span>
            <input type="password" name="password" value="" placeholder="Password" class="form-control">
        </label>
    </div>
    <div class="form-group row">
        <label class="col-md-6">
            <span>Department</span>
            <select name="department_id" class="form-control">
                <?php
                $departments = Department::find_all();
                foreach ($departments as $department):
                    ?>
                    <option value="<?php echo $department->id; ?>">
                        <?php echo $department->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="col-md-6">
            <span>Designation</span>
            <select name="designation" class="form-control">
                <option value="Head">Head</option>
                <option value="Lead">Lead</option>
                <option value="Senior">Senior</option>
                <option value="Junior">Junior</option>
            </select>
        </label>
    </div>
    <div class="row">
        <label class="col-md-12">
            <input class="btn btn-block btn-info" type="submit" name="submit" value="Make User">
        </label>
    </div>
</form>
<?php include_layout_template('footer.php'); ?>