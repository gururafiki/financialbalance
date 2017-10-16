<?php
	require "db.php";
	$user=R::findOne('users','latin = ? AND password = ?',array($_POST['login'],$_POST['password']));
	if(isset($user->latin)){
		$_SESSION['name']=$user->name;
		$_SESSION['level']=$user->level;
		$_SESSION['latin']=$user->latin;
		$_SESSION['photo']='images/img.jpg';
		$user->password=$_POST['newpass'];
		R::store($user);
        header("Location: /tablesoutput.php");
	}
	else{
        header("Location: /loginpage.php");
	}
		// $user = R::dispense('base');
		// $user->login = $_POST['login'];
		// $user->mail = $_POST['mail'];
		// $user->password = $_POST['password'];
		// $user->datebirth = $_POST['date'];
		// $user->datereg = date("d.m.Y (H:i:s)", time());
		// $user->ip = getenv("REMOTE_ADDR");
		// $user->browserinfo = getenv("HTTP_USER_AGENT");
		// $user->port = getenv("REMOTE_PORT");
		// $user->typecon =  $_SERVER['HTTP_CONNECTION'];
		// $user->host = gethostbyaddr(getenv("REMOTE_ADDR"));
		// $user->refer = @$_SERVER['HTTP_REFERER'];
		// R::store($user);
?>