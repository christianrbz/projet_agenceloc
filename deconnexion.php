<?php 

require_once "inc/init.php";

unset($_SESSION['membre']);
header ("location:index.php");
exit;