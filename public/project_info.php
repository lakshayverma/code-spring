<?php
require_once('../includes/initialize.php');
give_access(FALSE);
?>

<?php
if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'Basic Waterfall') {
        $project_id = $_POST['project_id'];
        $basic_tasks = Task::basic_tasks_for($project_id);
        foreach ($basic_tasks as $basic_task) {
            $basic_task->save();
        }
        $message = 'Here you go';
        $session->message($message);
        redirect_to("project_info.php?id={$project_id}");
    } elseif ($_POST['submit'] == 'Make Task') {
        // Create a new Task in the database
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $project_id = $_POST['project_id'];
        $assigned_to = $_POST['assigned_to'];
        $task = Task::make($name, $desc, $project_id, $assigned_to);
        if ($task->validate_data()) {
            if ($task->save()) {
                redirect_to("project_info.php?id={$project_id}");
            } else {
                $session->message("Could Not <storng class='Failed'>create</strong> task.");
                redirect_to("project_info.php?id={$project_id}");
            }
        } else {
            $session->message("<strong class='Failed'>Task Creation Fields can not be <big>empty</big></strong>.");
            redirect_to("project_info.php?id={$project_id}");
        }
    } elseif ($_POST['submit'] == 'Take Ownership') {
        $project_id = $_POST['project_id'];
        $project = Project::find_by_id($project_id);
        $project->project_manager = $session->user_id;
        if ($project->save()) {
            $session->message("Taken <strong>Take Ownership</strong> of the project.");
        } else {
            $session->message("Could not <strong class='Failed'>Take Ownership</strong> of the project.");
        }
        redirect_to("project_info.php?id={$project_id}");
    } elseif ($_POST['submit'] == 'Quit') {
        $project_id = $_POST['project_id'];
        $project = Project::find_by_id($project_id);
        $project->project_manager = 4;
        $project->change_stage("Failed");
        if ($project->save()) {
            $session->message("<strong>Quit</strong> the Project.");
        } else {
            $session->message("Can not <strong class='Failed'>QUIT</strong> the project.");
        }
        redirect_to("project_info.php?id={$project_id}");
    } elseif ($_POST['submit'] == 'post comment') {
        $text = $_POST['comment_text'];
        $posted_by = $_POST['posted_by'];
        $user_type = $_POST['user_type'];
        $project_id = $_POST['project_id'];
        if (empty($text)) {
            $message = "<strong class='Failed'>"
                    . "Can not post empty comment..."
                    . "</strong>";
        } else {
            $comment = Comment::make($posted_by, $user_type, $project_id, $text);
            $message = ($comment->save()) ? '' : 'Failed to post comment';
        }
        $session->message($message);
        redirect_to("project_info.php?id={$project_id}");
    }
}
?>

<?php include_layout_template('header.php'); ?>

<?php
if (isset($_GET['id']) && $project = Project::find_by_id($_GET['id'])):
    $project_manager = User::find_by_id($project->project_manager);
    ?>

    <section class="row"><?php echo output_message($session->message()); ?></section>
    <section class="panel
    <?php
    switch ($project->current_stage) {
        case 'Code':
            echo "panel-info";
            break;
        case 'Test':
            echo "panel-warning";
            break;
        case 'Final':
            echo "panel-success";
            break;
        case 'Failed':
            echo "panel-danger";
            break;
        default :
            echo "panel-default";
            break;
    }
    ?>
             ">
        <hgroup class="panel-heading">
            <h2><?php echo $project->name ?></h2>
            <h4><?php echo $project->current_stage ?></h4>
            <h6>
                Project Manager:
                <a href="user_details.php?id=<?php echo $project_manager->id; ?>">
                    <?php echo $project_manager->full_name(); ?>
                </a>
            </h6>
        </hgroup>

        <?php
        if ($project_manager->id == $session->user_id && $session->user_type == 'admin'):
            ?>
            <div class="panel-body navbar">
                <span>
                    <span class="glyphicon glyphicon-pencil"></span>
                    Change Stage:            
                </span>
                <ul class="stages nav nav-justified ">
                    <?php foreach ($project->stages as $stage): ?>
                        <?php if ($stage == $project->current_stage): ?>
                            <li class="stage navbar-text  text-center">
                                <?php echo $stage; ?>
                            <?php else: ?>
                            <li class="stage text-center">
                                <a href="change_stage.php?obj=project&&id=<?php echo $project->id; ?>&&value=<?php echo $stage ?>&&ref=project_info.php?id=<?php echo $project->id; ?>">
                                    <?php echo $stage; ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php
        endif;
        ?>
    </section>

    <div class="row"> 
        <div class="col-md-8">
            <section class="row">
                <h2 class="text-primary">Project Description:</h2>
                <blockquote>
                    <?php echo $project->description; ?>
                </blockquote>
                <?php if ($session->user_type == 'admin'):
                    ?>
                    <?php if ($project_manager->id == $session->user_id):
                        ?>

                        <form method="post" action="project_info.php" class="panel panel-warning col-md-6 col-md-offset-3">
                            <em>Can't handle the <strong>pressure</strong>? Quit now and Leave the ownership of the project to let other's try.</em>
                            <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
                            <div class="row">

                                <label class="col-md-12">
                                    <input type="submit" name="submit" value="Quit" class="btn btn-danger btn-block">
                                </label>
                            </div>
                        </form>
                    <?php elseif ($project_manager->id == 4): ?>
                        <form method="post" action="project_info.php" class="panel panel-success col-md-6 col-md-offset-3">
                            <em>Go ahead, "<strong>Take ownership</strong> of the project and start working by creating and assigning tasks to the team members."</em>
                            <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
                            <div class="row">
                                <label class="col-md-12">
                                    <input type="submit" name="submit" value="Take Ownership" class="btn btn-success btn-block">
                                </label>
                            </div>
                        </form>
                    <?php endif; ?>
                    <?php
                endif;
                ?>
            </section>

            <section class="row">
                <h2 class="text-primary">Project Tasks</h2>
                <ul class="tasks list-group">
                    <?php
                    $tasks = Task::project_tasks($project->id);
                    foreach ($tasks as $task):
                        ?>
                        <li class="list-group-item
                        <?php
                        switch ($task->stage) {
                            case 'Testing':
                            case 'Final':
                                echo 'list-group-item-warning';
                                break;
                            case 'Done':
                                echo 'list-group-item-success';
                                break;
                            case 'Failed':
                                echo 'list-group-item-danger';
                                break;
                            default:
                                echo 'list-group-item-text';
                                break;
                        }
                        ?>">
                            <h3 class="text-capitalize">
                                <?php echo $task->name; ?>
                                <small class="text-lowercase h4"><em>(<?php echo $task->stage; ?>)</em></small>
                            </h3>
                            <span>
                                <small>Assigned to:</small>
                                <a href="user_details.php?id=<?php echo $task->assigned_to ?>">
                                    <em><?php echo User::find_by_id($task->assigned_to)->full_name(); ?></em>
                                </a>
                            </span>
                            <blockquote>
                                <?php echo $task->description; ?>
                            </blockquote>
                            <small><a href="task_details.php?task=<?php echo $task->id; ?>">View/Edit task</a></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>

        <aside id="comments" class="col-md-3 col-md-offset-1 panel panel-info">
            <?php if ($comments = Comment::find_for_project($project->id)): ?>

                <h5 class="panel-heading">Requests and Comments:</h5>
                <ul class="panel-body list-group list-unstyled">
                    <?php
                    foreach ($comments as $cmnt):
                        ?>
                        <?php echo $cmnt->to_string(); ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form method="post" class="panel panel-default">
                <h6 class="panel-heading">Make Request or Post Comment</h6>
                <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
                <input type="hidden" name="posted_by" value="<?php echo $session->get_user_object()->id; ?>">
                <input type="hidden" name="user_type" value="<?php echo $session->user_type; ?>">
                <div class="panel-body">

                    <textarea name="comment_text" class="form-control" placeholder="type here..."></textarea>
                    <label class="col-md-12">
                        <input type="submit" name="submit" value="post comment" class="btn btn-block btn-default">
                    </label>
                </div>
            </form>
        </aside>
    </div>

    <?php
    if ($project_manager->id == $session->user_id && $session->user_type == 'admin'):
        if ($tasks == NULL):
            ?>
            <form method="post" action="project_info.php" class="col-md-6 col-md-offset-3 panel panel-success">
                <h3 class="panel-heading">
                    <span class="glyphicon glyphicon-tasks"></span>
                    Add Basic Tasks into the Project
                </h3>
                <div class="panel-body">
                    <blockquote class="text-primary">
                        The project seems to be new, Jumpstart the Project by adding a few tasks into the project structure right away.
                    </blockquote>
                    <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <input class="btn btn-success btn-block" type="submit" name="submit" value="Basic Waterfall">
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>
        <form method="post" action="project_info.php" class="col-md-6 col-md-offset-3 panel panel-primary">
            <h3 class="panel-heading">
                <span class="glyphicon glyphicon-tasks"></span>
                Create New Task
            </h3>
            <div class="panel-body">
                <div class="form-group">
                    <label>
                        <span>
                            <span class="glyphicon glyphicon-edit"></span>
                            Task Name
                        </span>
                        <input type="text" name="name" value="" placeholder="Task Name" class="form-control">
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <span>
                            <span class="glyphicon glyphicon-align-right"></span>
                            Description
                        </span>
                        <textarea name="description" placeholder="Task Description" class="form-control" cols="66" rows="4"></textarea>
                    </label>
                </div>
                <input type="hidden" name="project_id" value="<?php echo $project->id; ?>">
                <div class="form-group">
                    <label>
                        <span>
                            <span class="glyphicon glyphicon-user"></span>
                            Assign To
                        </span>
                        <select name="assigned_to" class="form-control">
                            <?php
                            $users = User::find_all();
                            foreach ($users as $user):
                                ?>
                                <option value="<?php echo $user->id ?>"><?php echo $user->full_name() . " || " . $user->designation . ', ' . $user->department_name(); ?></option>            
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="row">
                    <label class="col-md-12">
                        <input type="submit" name="submit" value="Make Task" class="btn btn-block btn-primary">
                    </label>

                </div>
            </div>
        </form>
        <?php
    endif;
    ?>



<?php else: ?>
    <p>Sorry No Project was selected.</p>
<?php endif; ?>
<?php echo output_message($message); ?>

<?php include_layout_template('footer.php'); ?>