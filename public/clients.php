<?php
require_once('../includes/initialize.php');
give_access(TRUE);
?>
<?php include_layout_template('header.php'); ?>

<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'Create Client') {
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
            
        } else {
            $session->message("Could Not create Client.");
            redirect_to("clients.php");
        }
    } else {
        $session->message("Fields can not be empty.");
        redirect_to("clients.php");
    }
}
?>
<section class="panel panel-info col-md-5">
    <h2 class="panel-heading">All Clients.</h2>
    <ul class="panel-body list-group">
        <?php
        $clients = Client::find_all();
        if ($clients):
            foreach ($clients as $client):
                ?>
                <li class="list-group-item list-unstyled">
                    <h4 class="list-group-item-heading">
                        <span class="glyphicon glyphicon-user"></span>
                            <!--<a href="client_details.php?id=<?php echo $client->id; ?>">-->
                        <?php echo $client->name; ?>
                        <!--</a>-->
                    </h4>
                    <em>
                        <?php echo $client->company . ", " . $client->location; ?>
                    </em>
                    <p class="text-justify">
                        <a href="mailto:<?php echo $client->email; ?>" class="btn btn-info">
                            <span class="glyphicon glyphicon-envelope"></span>
                            Contact
                        </a>

                        <strong>
                            <span class="glyphicon glyphicon-phone"></span>
                            <?php echo $client->mobile; ?>
                        </strong>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php else: ?>
    <p>Currently no user is in the database</p>
<?php endif; ?>
<?php echo output_message($session->message()); ?>
<form method="post" action="clients.php" class="col-md-6 col-md-offset-1 panel panel-primary">
    <h3 class="panel-heading">Make New Client</h3>
    <div class="form-group row">
        <label class="col-md-12">
            <span>Name</span>
            <input type="text" name="client_name" value="" placeholder="Client Name" class="form-control">
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
            <span>Company</span>
            <input type="text" name="company" value="" placeholder="Company Name" class="form-control">
        </label>
        <label class="col-md-6">
            <span>City</span>
            <input type="text" name="location" value="" placeholder="Client City" class="form-control">
        </label>
    </div>
    <div class="form-group row">
        <label class="col-md-6">
            <span>Email</span>
            <input type="email" name="mail" value="" placeholder="nomail@example.com" class="form-control">
        </label>
        <label class="col-md-6">
            <span>Contact No</span>
            <input type="tel" name="mobile" value="" placeholder="+xx-xxx-xxx-xxx-x" class="form-control">
        </label>
    </div>
    <div class="form-group row">
        <label class="col-md-4 col-md-offset-4"><input type="submit" name="submit" value="Create Client" class="btn btn-block btn-success"></label>
    </div>

</form>
<?php include_layout_template('footer.php'); ?>