<?php
require_once('../includes/initialize.php');
give_access(FALSE, FALSE);
if (isset($session->user_id)) {
    $user = $session->get_user_object();
}

if (isset($_POST['submit']) && $_POST['submit'] == 'Update') {
    $id = $_POST['user_id'];
    $name = $_POST['name'];

    $password = $_POST['password'];
    $new_password1 = $_POST['new_password1'];
    $new_password2 = $_POST['new_password2'];

    $company = $_POST['company'];
    $location = $_POST['location'];

    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    $message = "";

    $user_object = Client::find_by_id($id);
    if ($id == $user->id) {
        $user_object->name = $name;
        $user_object->company = $company;
        $user_object->location = $location;
        $user_object->email = $email;
        $user_object->mobile = $mobile;

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
        redirect_to("edit_client.php");
    }
}
?>
<?php include_layout_template('header.php'); ?>
<p class="message text-info">
    <?php echo output_message($session->message()); ?>
</p>
<form method="post" action="edit_client.php" class="col-md-8 col-md-offset-2 panel panel-default">

    <h3 class="panel-heading">Edit Profile</h3>
    <div class="row">
        <label class="col-md-6">
            <span>Name</span>
            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
            <input required type="text" name="name" value="<?php echo $user->name; ?>" placeholder="First Name" class="form-control">
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
        <label class="col-md-6">
            <span>
                Company
            </span>
            <input required type="text" name="company" class="form-control" value="<?php echo $user->company; ?>">
        </label>
        <label class="col-md-6">
            <span>
                <span class="glyphicon glyphicon-home"></span>
                Location
            </span>
            <textarea required name="location" placeholder="Your Home Address" class="form-control"><?php echo $user->location; ?></textarea>
        </label>
    </div>
    <div class="row">
        <label class="col-md-6">
            <span>
                <span class="glyphicon glyphicon-envelope"></span>
                Email
            </span>
            <input required type="email" name="email" value="<?php echo $user->email; ?>" placeholder="nomail@example.com" class="form-control">
        </label>
        <label class="col-md-6">
            <span>
                <span class="glyphicon glyphicon-phone"></span>
                Contact No
            </span>
            <input required type="tel" name="mobile" value="<?php echo $user->mobile; ?>" placeholder="+xx-xxx-xxx-xxx-x" class="form-control">
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