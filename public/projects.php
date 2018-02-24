<?php
require_once('../includes/initialize.php');
give_access(FALSE);
?>
<?php include_layout_template('header.php'); ?>

<?php echo output_message($session->message()); ?>
<?php
if (isset($_POST['submit']) && $_POST['submit'] == 'Create Project') {
    // Create a new project in the database
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $client = $_POST['client_id'];
    $start = $_POST['start_date'];
    $end = $_POST['deadline'];
    $project = Project::make($name, $desc, $client, $start, $end);

    if ($project->validate_data()) {
        if ($project->save()) {
            redirect_to("projects.php");
        } else {
            $session->message("Could Not create the project.");
            redirect_to("projects.php");
        }
    } else {
        $session->message("Fields can not be empty.");
        redirect_to("projects.php");
    }
}
?>
<?php
if ($session->user_type == 'client') {
    $projects = Project::find_for_client($session->user_id);
} else {
    if ($session->user_id == 4) {
        $projects = Project::find_all();
    } else {
        $projects = Project::find_for_user($session->user_id);
    }
}
?>
<section class="panel panel-primary <?php echo ($session->user_type == 'client')? 'col-md-4 col-md-push-8' : 'col-md-7 col-md-offset-1 col-md-push-4'; ?>">
    <h2 class="panel-heading">Projects</h2>
    <ul class="projects list-group">
        <?php
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
                <h3 class="panel-heading">
                    <a href="project_info.php?id=<?php echo $project->id ?>">
                        <?php echo $project->name; ?>
                    </a>
                </h3>
                <p class="panel-body">
                    <?php if ($session->user_type != 'client'): ?>
                        <strong>Role:</strong>
                        <?php
                        if ($session->user_id == $project->project_manager) {
                            if ($session->user_id == 4) {
                                echo 'Super Manager';
                            } else {
                                echo 'Manager';
                            }
                        } elseif ($session->user_id == 4) {
                            echo 'Super User';
                        } else {
                            echo 'Team Member';
                        }
                        ?>
                    <?php endif; ?>

                    <strong>Project Status:</strong> <em><?php echo $project->current_stage; ?></em>
                </p>

            </li>
        <?php endforeach; ?>
    </ul>
</section>
<?php
if (!($session->user_type == 'client')):
    $open_projects = Project::find_open();
    if ($open_projects):
        ?>
        <section class="panel panel-warning col-md-4 col-md-pull-8">
            <h4 class="panel-heading">Project's with no manager</h4>
            <ul class="projects panel-body list-group">
                <?php
                foreach ($open_projects as $project):
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
                        <strong class="panel-body">
                            <a href="project_info.php?id=<?php echo $project->id ?>">
                                <?php echo $project->name; ?>
                                <small><em>(<?php echo $project->current_stage; ?>)</em></small>
                            </a>
                        </strong>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php
    endif;
endif;
?>
<form method="post" action="projects.php" class="panel panel-default <?php echo ($session->user_type == 'client') ? 'col-md-7 col-md-pull-4' : 'col-md-12'; ?>">
    <h3 class="panel-heading">
        <span class="glyphicon glyphicon-blackboard"></span>
        Create a new Project
    </h3>
    <div class="form-group">
        <label>
            <span>
                <span class="glyphicon glyphicon-info-sign"></span>
                Project Name
            </span>
            <input type="text" name="name" value="" placeholder="Project Name" class="form-control">
        </label>
    </div>
    <div class="form-group">
        <label>
            <span>
                <span class="glyphicon glyphicon-align-right"></span>
                Project Description
            </span>
            <textarea name="description" placeholder="Project Description" cols="66" rows="7" class="form-control"></textarea>
        </label>
    </div>
    <div class="form-group">
        <label>
            <span>
                <span class="glyphicon glyphicon-calendar"></span>
                Start Date
            </span>
            <input type="date" name="start_date" value="" class="form-control">
        </label>
        <label>
            <span>
                <span class="glyphicon glyphicon-calendar"></span>
                Deadline
            </span>
            <input type="date" name="deadline" value="" class="form-control">
        </label>
    </div>
    <input type="hidden" name="client_id" value="<?php echo ($session->user_type == 'client') ? $session->user_id : '1' ?>">
    <div class="row">
        <label class="col-md-12">
            <input type="submit" name="submit" value="Create Project" class="btn btn-block btn-success">
        </label>
    </div>
</form>

<?php echo output_message($message); ?>

<?php include_layout_template('footer.php'); ?>