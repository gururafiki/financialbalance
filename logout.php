<?php
	require "db.php";
	$_SESSION['name']=null;
	$_SESSION['level']=null;
    header("Location: /loginpage.php");
?>