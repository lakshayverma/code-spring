</div>
<footer id="footer" class="jumbotron">
    <h4>
        <span class="glyphicon glyphicon-user"></span>
        Lakshay Verma
    </h4>
    <h5>
        <span class="glyphicon glyphicon-credit-card"></span> <strong>Enrollment Number</strong> <em>146433412</em>
    </h5>
    <nav class="">
        <ul class="nav nav-stacked">
            <li class="navbar-link">
                <a href="index.php">
                    About This Project
                </a>
            </li>
            <li class="navbar-link">
                <a href="index.php">
                    About US
                </a>
            </li>
        </ul>
    </nav>
    
    <h4><span class="glyphicon glyphicon-copyright-mark"></span> <?php echo date("Y", time()); ?> </h4>
</footer>

<script type="text/javascript" src="styles/js/jquery-2.1.3.js"></script>
<script type="text/javascript" src="styles/js/bootstrap.min.js"></script>

</body>
</html>
<?php
if (isset($database)) {
    $database->close_connection();
}
?>