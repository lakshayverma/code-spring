<?php
require_once('../includes/initialize.php');
give_access(FALSE, TRUE);
?>
<?php include_layout_template('header.php'); ?>
<section class="row">
    <h2 class="text-center">Assigned Tasks</h2>
    <ul class="list-group col-md-8 col-md-offset-2">
        <?php
        $tasks = Task::assigned_tasks($session->user_id);
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
                <span>
                    <span class="glyphicon glyphicon-link"></span>
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
                <h3><?php echo $task->name; ?></h3>
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
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php echo output_message($message); ?>

<?php include_layout_template('footer.php'); ?>