<?php
    session_start();
	if (isset($_POST['login'])) {
		$login = $_POST['login']; 
			if ($login == '') { 
			unset($login);} 
			}
    if (isset($_POST['password'])){
		$password=$_POST['password']; 
		if ($password =='') { 
			unset($password);} 
			}
	if (empty($login) or empty($password)) {
		exit ("Введите логин или праоль");
    }
    include ("base.php"); 
	$result = pg_query($link, 'SELECT * FROM "Users" WHERE login='."'".$login."'");
    $myrow = pg_fetch_array($result);
    if (empty($myrow['password'])) {
		exit ("Введённый вами login или пароль неверный.");
	}
    else {
		if ($myrow['password']==$password) {
			$_SESSION['login']=$myrow['login']; 
			$_SESSION['id']=$myrow['id'];
			header('Location: ../admindo.php');
    }
		else {
			exit ("Введённый вами login или пароль неверный.");
		}
    }
?>