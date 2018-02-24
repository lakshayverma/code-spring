<?php
require_once('../includes/initialize.php');
give_access(FALSE, TRUE);
if (isset($session->user_id)) {
    $user = $session->get_user_object();
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
    $id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $new_password1 = $_POST['new_password1'];
    $new_password2 = $_POST['new_password2'];
    $message = "";

    $user_object = User::find_by_id($id);
    if ($id == $user->id) {
        $user_object->first_name = $first_name;
        $user_object->last_name = $last_name;
        
        if ($user_object->password === $password) {
            if (!empty($new_password1) && !empty($new_password2)) {
                if ($new_password1 == $new_password2) {
                    $user_object->password = $new_password1;
                } else {
                    $message = "New Passwords does not match, ";
                }
            }
            if ($user_object->update()) {
                $message .= " Profile Updated.";
            } else {
                $message .= " Failed to Update";
            }
        } else {
            $message = "Please input correct password before you proceed";
        }

        $session->message($message);
        redirect_to("edit_user.php");
    }
}
?>
<?php include_layout_template('header.php'); ?>
<p class="message text-info">
    <?php echo output_message($session->message()); ?>
</p>
<form method="post" action="edit_user.php" class="col-md-8 col-md-offset-2 panel panel-default">

    <h3 class="panel-heading">Edit Profile</h3>
    <div class="row">
        <label class="col-md-6">
            <span>First  Name</span>
            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
            <input required type="text" name="first_name" value="<?php echo $user->first_name; ?>" placeholder="First Name" class="form-control">
        </label>
        <label class="col-md-6">
            <span>Last Name</span>
            <input required type="text" name="last_name" value="<?php echo $user->last_name; ?>" placeholder="Last Name" class="form-control">
        </label>
    </div>

    <div class="row">
        <label class="col-md-6">
            <span>User Name</span>
            <input type="text" name="username" value="<?php echo $user->username; ?>" placeholder="User Name" class="form-control" readonly>
        </label>
        <label class="col-md-6">
            <span>Password</span>
            <input required type="password" name="password" value="" placeholder="Password" class="form-control">
        </label>
        <label class="col-md-6 col-md-offset-6">
            <span>New Password</span>
            <input type="password" name="new_password1" value="" placeholder="New Password" class="form-control">
            <input type="password" name="new_password2" value="" placeholder="Re-enter New Password" class="form-control">
        </label>
    </div>

    <div class="row">
        <div class="col-md-offset-2 col-md-4">
            <input type="submit" class="btn btn-block btn-success" name="submit" value="Update">
        </div>
        <div class="col-md-4">
            <input type="reset" class="btn btn-block btn-danger">
        </div>
    </div>
</form>

<?php include_layout_template('footer.php'); ?>