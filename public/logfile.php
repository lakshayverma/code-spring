<?php
require_once("../includes/initialize.php");

if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>

<?php
// Clear all logs.
if(isset($_GET['clear']) && $_GET['clear'] == 'true'){
    wipe_all_logs($session->user_id);
}
?>

<?php include_layout_template('header.php'); ?>

<article class="panel panel-info">
    <hgroup class="panel-heading">
        <h2 class="text-primary">Site Logs</h2>
    </hgroup>
    
    <section class="panel-body">
        <?php echo nl2br(get_all_logs()); ?>
    </section>
    
    <footer class="panel-footer">
        <a href="logfile.php?clear=true" class="btn btn-info">Clear Logs</a>
    </footer>
    
</article>
<?php include_layout_template('footer.php'); ?>