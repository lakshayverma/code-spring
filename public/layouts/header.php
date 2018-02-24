<?php
require_once('../includes/initialize.php');
global $session;
?>
<!doctype html>
<html>
    <head>
        <title><?php echo SITE_TITLE; ?></title>
        <!--<link href="stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />-->
        <link href="styles/css/bootstrap.min.css" type="text/css" rel="stylesheet">


        <!--<link href="styles/css/theme.min.css" type="text/css" rel="stylesheet">-->
    </head>
    <body class="container">
        <header class="row">
            <?php
            if (isset($session->user_id) && $user = $session->get_user_object()):
                ?>
                <nav class="navbar">
                    <ul class="nav nav-tabs">
                        <li class="navbar-link">
                            <a href="projects.php">
                                <span class="glyphicon glyphicon-folder-open"></span>
                                Projects
                            </a>
                        </li>
                        <?php if ($user->get_type() != 'client'): ?>
                            <li class="navbar-link">
                                <a href="user_tasks.php">
                                    <span class="glyphicon glyphicon-tasks"></span>
                                    Tasks
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="dropdown navbar-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Click for More">
                                <?php echo $user->full_name(); ?> 
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($user->get_type() == 'admin'): ?>
                                    <li>
                                        <a href="users.php">
                                            <span class="glyphicon glyphicon-star"></span>
                                            Users
                                        </a>
                                    </li>
                                    <li>
                                        <a href="clients.php">
                                            <span class="glyphicon glyphicon-heart"></span>
                                            Clients
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logfile.php">
                                            <span class="glyphicon glyphicon-file"></span>
                                            Site Logs
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($user->get_type() != 'client'): ?>
                                    <li>
                                        <a href="edit_user.php" title="Logout">
                                            <span class="glyphicon glyphicon-edit"></span>
                                            Change Password
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="edit_client.php" title="Logout">
                                            <span class="glyphicon glyphicon-edit"></span>
                                            Edit Profile
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="logout.php" title="Logout">
                                        <span class="glyphicon glyphicon-log-out"></span>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
            <a href="index.php" title="Home" class="btn btn-block">
                <hgroup class="jumbotron">
                    <h1><?php echo SITE_TITLE; ?></h1>
                    <h3><?php echo SITE_MOTO; ?></h3>
                </hgroup>
            </a>
        </header>
        <div id="main" class="row">