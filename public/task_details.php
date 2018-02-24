<?php
require_once('../includes/initialize.php');
give_access(FALSE, FALSE);

// update task values if the FORM was posted.
if (isset($_POST['submit']) && $_POST['submit'] == "update task") {
    $task = Task::find_by_id($_POST['task_id']);
    $task->name = (isset($_POST['task_name'])) ? $_POST['task_name'] : $task->name;
    $task->description = (isset($_POST['task_desc'])) ? $_POST['task_desc'] : $task->description ;
    $task->assigned_to = (isset($_POST['assigned_to'])) ? $_POST['assigned_to'] : $task->assigned_to;
    $task->change_stage($_POST['stage']);
    $message = ($task->save()) ? "Task Altered Successfully" : "Task Modification Failed";
    $session->message($message);
    redirect_to('task_details.php?task=' . $task->id);
}
?>
<?php include_layout_template('header.php'); ?>
<?php
$task_id = 0;
if (isset($_GET['task'])) {
    $task_id = $_GET['task'];
}
echo output_message($session->message());
?>
<?php if (($task_id > 0) && ($task = Task::find_by_id($task_id))): ?>
    <section id="task" class="panel panel-default">
        <?php
        if ($session->user_type == 'client') {
            $user = Client::find_by_id($session->user_id);
        } else {
            $user = User::find_by_id($session->user_id);
        }
        $project = Project::find_by_id($task->project);
        $project_manager = User::find_by_id($project->project_manager);
        ?>

        <header class="panel-heading">
            <h1>
                <?php echo $task->name; ?>
                <small><em>(<?php echo $task->stage; ?>)</em></small>
            </h1>
            <a href="project_info.php?id=<?php echo $project->id; ?>">
                <?php echo $project->name; ?>
            </a>
            <a href="user_details.php?id=<?php echo $project_manager->id ?>">
                <span class="glyphicon glyphicon-user"></span>
                <?php echo $project_manager->full_name(); ?>
            </a>
        </header>
        <blockquote class="panel-body">
            <p><?php echo $task->description ?></p>
            <span>
                <small>Assigned to:</small>
                <a href="user_details.php?id=<?php echo $task->assigned_to ?>">
                    <em><?php echo User::find_by_id($task->assigned_to)->full_name(); ?></em>
                </a>
            </span>
        </blockquote>
        <?php
        if ($task->assigned_to == $session->user_id && $session->user_type != 'client'):
            ?>


            <div class="navbar navbar-default">
                <span>
                    <span class="glyphicon glyphicon-pencil"></span>
                    Change Stage: 
                </span>
                <ul class="nav nav-justified">
                    <?php foreach ($task->stages as $stage): ?>
                        <?php if ($stage == $task->stage): ?>
                            <li class="navbar-text text-center">
                            <?php else: ?>
                            <li class="text-center">
                                <a href="change_stage.php?obj=task&&id=<?php echo $task->id; ?>&&value=<?php echo $stage ?>&&ref=task_details.php?task=<?php echo $task->id; ?>">
                                <?php endif; ?>
                                <?php echo $stage; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </section>
    <?php if (($task->assigned_to == $user->id && $user->get_type() != 'client') || (($user->get_type() == 'admin') && ($project_manager->id == $user->id))): ?>
        <form method="post" action="task_details.php" class="panel panel-default col-md-6 col-md-offset-3">
            <h3 class="panel-heading">
                <span class="glyphicon glyphicon-pencil"></span>
                Alter Task
            </h3>
            <input type="hidden" name="task_id" value="<?php echo $task->id; ?>">
            <div class="form-group">
                <label>
                    <span>
                        Name
                    </span>
                    <input type="text" name="task_name" value="<?php echo $task->name; ?>" readonly class="form-control">
                </label>                
            </div>
            <div class="form-group">
                <label>
                    <span>
                        <span class="glyphicon glyphicon-align-right"></span>
                        Description
                    </span> 
                    <textarea name="task_desc" class="form-control" cols="66" rows="7"><?php echo $task->description; ?></textarea>
                </label>
            </div>
            <div class="form-group">
                <label>
                    <span>
                        <span class="glyphicon glyphicon-user"></span>
                        Assign To
                    </span>
                    <select class="form-control" name="assigned_to" <?php
                    if ($project_manager->id != $user->id) {
                        echo 'disabled';
                    }
                    ?> >
                                <?php
                                $users = User::find_all();
                                foreach ($users as $usr):
                                    if ($usr->id == $task->assigned_to):
                                        ?>
                                <option selected value="<?php echo $usr->id ?>">
                                    <?php echo $usr->full_name() . " || " . $usr->designation . ', ' . $usr->department_name(); ?>
                                </option>
                            <?php else: ?>
                                <option value="<?php echo $usr->id ?>"><?php echo $usr->full_name() . " || " . $usr->designation . ', ' . $usr->department_name(); ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <span>
                        <span class="glyphicon glyphicon-stats"></span>
                        Stage:
                    </span>
                    <select name="stage" class="form-control" <?php echo ($user->id != $project_manager->id) ? 'disabled' : '';?>>
                                <?php foreach ($task->stages as $stage): ?>
                            <option value="<?php echo $stage; ?>" <?php echo ($stage == $task->current_stage()) ? 'selected' : ''; ?>  >
                                <?php echo $stage; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="row">
                <label class="col-md-12">
                    <input type="submit" name="submit" value="update task" class="btn btn-block btn-primary">
                </label>
            </div>
        </form>
    <?php endif; ?>

<?php else: ?>
    <section>
        <h1><em>Sorry,</em> the <strong>Task</strong> was not found.</h1>
    </section>
<?php endif; ?>
<?php include_layout_template('footer.php'); ?>