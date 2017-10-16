<?php
	require "db.php";
	$user=R::findOne('users','latin = ? AND password = ?',array($_POST['login'],$_POST['password']));
	if(isset($user->latin)){
		$_SESSION['name']=$user->name;
		$_SESSION['level']=$user->level;
		$_SESSION['latin']=$user->latin;
		$_SESSION['photo']=$user->photo;
        header("Location: /tablesoutput.php");
	}
	else{
        header("Location: /loginpage.php");
	}
	// echo "false";
?>