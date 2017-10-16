<?php
	require "db.php";
	$tr = [
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d",
        "Е"=>"e","Ё"=>"yo","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"c","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
        " "=> "", "."=> "", "/"=> "_",
        "A"=>"a","B"=>"b","C"=>"c","D"=>"d",
        "E"=>"e","F"=>"f","G"=>"g","H"=>"h",
        "I"=>"i","J"=>"j","K"=>"k","L"=>"l",
        "M"=>"m","N"=>"n","O"=>"o","P"=>"p",
        "Q"=>"q","R"=>"r","S"=>"s","T"=>"t",
        "U"=>"u","V"=>"v","W"=>"w","X"=>"x",
        "Y"=>"y","Z"=>"z"
    ];
	$latin = $_POST['name'];
    $latin = strtr($latin,$tr);
    $latin = preg_replace('/[^A-Za-z0-9_\-]/', '', $latin);

	$user=R::dispense('users');
	$user->name=$_POST['name'];
	$user->level='2138197fcbcsad987s';
	$user->latin=$latin;
	$user->balance=$_POST['balance'];
	$user->totalprice=0;
	$user->photo='images/img.jpg';
	$user->password=$_POST['password'];
	R::store($user);
    header("Location: /aboutusers.php");
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