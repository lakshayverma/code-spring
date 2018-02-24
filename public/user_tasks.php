<?php
require_once('../includes/initialize.php');
give_access(FALSE, TRUE);
?>
<?php include_layout_template('header.php'); ?>
<article class="panel panel-default">
    <header class="panel-heading">
        <h2 class="text-center text-uppercase">Assigned Tasks</h2>
        <p class="panel-title text-center text-lowercase">
            "<em>All the tasks that have been assigned to you will show up here. Be quick to complete those.</em>"
        </p>
    </header>
    <section class="panel-group" id="myTasks">
        <?php
        $tasks = Task::assigned_tasks($session->user_id);
        foreach ($tasks as $task):
            ?>
            <div class="panel
            <?php
            switch ($task->stage) {
                case 'Testing':
                case 'Final':
                    echo 'panel-warning';
                    break;
                case 'Done':
                    echo 'panel-success';
                    break;
                case 'Failed':
                    echo 'panel-danger';
                    break;
                default:
                    echo 'panel-default';
                    break;
            }
            ?>">

                <header class="panel-heading">
                    <span>
                        <span class="glyphicon glyphicon-briefcase"></span>
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
                    <h3 class="panel-title">
                        <?php echo $task->name; ?>
                        <a href="<?php echo "#task" . $task->id; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#myTasks">
                            <span class="btn btn-xs btn-default">
                                Details
                                <span class="caret"></span>
                            </span>
                        </a>
                    </h3>
                </header>
                <div <?php echo "id=\"task" . $task->id . "\""; ?> class="panel-collapse collapse">
                    <div class="panel-body">
                        <blockquote>
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
                                    <?php foreach ($task->stages as $stage): ?>
                                        <?php if ($stage == $task->stage): ?>
                                            <li class="navbar-text text-center">
                                                <?php echo $stage; ?>
                                            <?php else: ?>
                                            <li class="text-center">
                                                <a href="change_stage.php?obj=task&&id=<?php echo $task->id; ?>&&value=<?php echo $stage ?>&&ref=user_tasks.php">
                                                    <?php echo $stage; ?>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <a href="task_details.php?task=<?php echo $task->id; ?>" class="btn btn-default">View/Edit task</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    <footer class="panel-footer">
        <p><?php echo output_message($message); ?></p>
    </footer>
</article>

<?php include_layout_template('footer.php'); ?>