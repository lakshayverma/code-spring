<?php

require_once('../includes/initialize.php');
give_access(FALSE, TRUE);
$user = $session->get_user_object();
?>

<?php

if (isset($_GET['obj'])) {
    $id = $_GET['id'];
    switch ($_GET['obj']) {
        case 'task':
            $obj = Task::find_by_id($id);
            break;
        case 'project':
            $obj = Project::find_by_id($id);
            break;

        default:
            $session->message("Sorry there was an error while trying to find {$_GET['obj']}. Try again later.");
            redirect_to("index.php");
            break;
    }
    if ($obj) {
        if ($obj->current_stage() == 'Failed') {
            if ($user->get_type() == 'admin') {
                $obj->change_stage($_GET['value']);
                if ($obj->save()) {
                    $session->message('Changed the stage.');
                    redirect_to($_GET['ref']);
                } else {
                    $session->message('Can not change the stage.');
                    redirect_to($_GET['ref']);
                }
            }else{
                    $session->message('Only admin can change the stage once you FAIL.');
                    redirect_to($_GET['ref']);
            }
        }else{
            $obj->change_stage($_GET['value']);
                if ($obj->save()) {
                    $session->message('Changed the stage.');
                    redirect_to($_GET['ref']);
                } else {
                    $session->message('Can not change the stage.');
                    redirect_to($_GET['ref']);
                }
        }
    } else {
        $session->message("Cannot find the object.");
        redirect_to($_GET['ref']);
    }
} else {
    $session->message("Sorry there was an error while changing the object. Try again later.");
    redirect_to("index.php");
}
?>

