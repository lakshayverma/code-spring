</div>
<footer id="footer" class="jumbotron">
    <h4>
        <span class="glyphicon glyphicon-user"></span>
        <a href="http://lakshay.azurewebsites.net">Lakshay Verma</a>
    </h4>
    <h5>
        <span class="glyphicon glyphicon-credit-card"></span> <span><em>Enrollment Number</em> <strong>146433412</strong></span>
    </h5>
    
    <a href="about.php" class="btn btn-info btn-sm">About</a>
    <h4><span class="glyphicon glyphicon-copyright-mark"></span> <span><?php echo date("Y", time()); ?></span> </h4>
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