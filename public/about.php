<?php require_once('../includes/initialize.php'); ?>
<?php include_layout_template('header.php'); ?>

<article class="panel panel-info">
    <h3 class="panel-heading">
        About The Project
    </h3>
    <section class="panel-body">
        <h2 class="header">Definition:</h2>
        <p>
            The project at hand is for a software company that follows <em>Standard Waterfall</em> model for the development of all of its Projects. Each step of a project is referred to as a <strong>Task</strong> and every task is assigned to one of the employees by the <em>Project Manager</em>. Each task contains details regarding what needs to be done to complete the task. The employee to whom task has been assigned can <em>change stage</em> of the task in order to <strong>notify</strong> others about the progress. This way everyone knows actual status of the project. Similar to the task, a project also goes through various stages before it is Finalized. But only the Project manager can change the stage of a Project.
        </p>
        <p>
            A project is <em>requested</em> by one of the Clients of the company and has the Super User(dummy account with all the privileges who no one is allowed to access) as the Manager of the said project. An employee with user account and designation of either a Lead or a Head can ask for the <em>Ownership</em> of the project with Super User as the Acting Manager and become the project manager of the project.
        </p>
        <ul>
            <li>When user signs into the Portal s/he will be presented with the <em>list of the Projects</em> they are a part of along with the projects with no actual manager and option to request a new Project as well.</li>
            <li>A separate tab for Tasks is available to the employee accounts to get streamlined view of a list containing the tasks that have been assigned to them</li>
            <li>The list contains all the necessary details about each task to help the user complete it.</li>
            <li>The user can also change stage of the task from this very page without going else where in the site.</li>
        </ul>
    </section>
    <section class="panel-body">
        <h2 class="header">Benefits</h2>
        <p>
            The major Goal of making this website is to digitize the whole process of making projects and its Life Cycle management and on the same time making the data accessible even on the remote locations as the project is a Website meaning it will be hosted on a web server and with a URL that points to it. Eg: http://google.co.in, http://www.facebook.com/lk7253, http://be.net/lakshayverma and more. If we are able to achieve the desired Goals on time the website will help easing the project management steps and to keep track of every team member who has been assigned a task.
        </p>
    </section>

</article>

<?php include_layout_template('footer.php'); ?>