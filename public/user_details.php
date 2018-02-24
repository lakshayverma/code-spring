<?php
require_once('../includes/initialize.php');
give_access(FALSE, TRUE);
?>
<?php include_layout_template('header.php'); ?>
<?php
if (isset($_GET['id']) && $user = User::find_by_id($_GET['id'])):
    ?>
    <section class="row">
        <div class="col-md-12">
            <h2 class="text-uppercase"><?php echo $user->full_name(); ?></h2>
            <h4 class="text-info">
                <?php echo $user->designation; ?>
                <small>
                    <em class="text-lowercase">
                        , <?php
                        $department = Department::find_by_id($user->department_id);
                        echo ($department) ? $department->name : "";
                        ?>
                    </em>
                </small>
            </h4>
        </div>
    </section>
    <section class="col-md-4 col-md-offset-1 col-md-push-7  panel panel-default">
        <h2 class="panel-heading">Projects</h2>
        <ul class="projects list-group">
            <?php
            $projects = Project::find_for_user($user->id);
            foreach ($projects as $project):
                ?>
                <li class="list-group-item
                <?php
                switch ($project->current_stage) {
                    case 'Test':
                        echo 'list-group-item-warning';
                        break;
                    case 'Final':
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
                    <p class="list-group-item-heading">
                        <a href="project_info.php?id=<?php echo $project->id ?>">
                            <?php echo $project->name; ?>
                        </a>
                    </p>
                    <blockquote>
                        <?php echo $project->description; ?>
                    </blockquote>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="col-md-7 col-md-pull-5 panel panel-primary">
        <h2 class="panel-heading">Tasks</h2>
        <ul class="tasks list-group">
            <?php
            $tasks = Task::assigned_tasks($user->id);
            foreach ($tasks as $task):
                ?>
                                                                <!--<li class="task <?php echo ($task->stage == 'Failed') ? 'Failed' : '' ?>">-->
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
                    <span class="list-group-item-text">
                        <em>
                            <?php
                            $parent = Project::find_by_id($task->project);
                            if ($parent) {
                                echo "<a href=\"project_info.php?id={$parent->id}\">"
                                . $parent->name
                                . "</a>";
                            }
                            ?>
                        </em>
                    </span>
                    <h3 class="list-group-item-heading"><?php echo $task->name; ?></h3>
                    <blockquote class="list-group-item-text">
                        <?php echo $task->description; ?>
                    </blockquote>
                    <?php
                    if ($task->assigned_to == $session->user_id && $session->user_type != 'client'):
                        ?>


                        <div class="navbar">
                            <span>
                                <span class="glyphicon glyphicon-pencil"></span>
                                Change Stage: 
                            </span>
                            <ul class="nav nav-justified">
                                <!--<ul class="stages">-->
                                <?php foreach ($task->stages as $stage): ?>
                                    <?php if ($stage == $task->stage): ?>
                                        <li class="navbar-text text-center">
                                            <!--<li class="stage selected">-->
                                            <?php echo $stage; ?>
                                        <?php else: ?>
                                        <li class="text-center">
                                            <!--<li class="stage">-->
                                            <a href="change_stage.php?obj=task&&id=<?php echo $task->id; ?>&&value=<?php echo $stage ?>&&ref=user_details.php?id=<?php echo $user->id; ?>">
                                                <?php echo $stage; ?>
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <a href="task_details.php?task=<?php echo $task->id; ?>" class="button small">View/Edit task</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php else: ?>
    <p>No user selected</p>
<?php endif; ?>
<?php echo output_message($message); ?>

<?php include_layout_template('footer.php'); ?>