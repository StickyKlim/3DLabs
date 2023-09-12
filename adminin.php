<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Главная страница </title>
</head>
<body>
<h1> Добро пожаловать! </h1>
<div class="main">
<div class="set">
<?php
session_start();
if(!isset($_SESSION['login'])) {
    echo '<div class="pas">
	<form method="POST" action="session.php">
	<textarea name="request_login" placeholder="Login"></textarea><br>
    <input type="password" name="request_password" placeholder="Password"></textarea>
	</div>
    <div class="add_but">
	<input type="submit" name="but_1" value="Вход">
	</div>
    </form>';
}

if(isset($_SESSION['login'])) {
    echo "<a href='exit.php'>Выход</a>";
	header("location: admindo.php");
    unset($_SESSION['error']);
}

if(isset($_SESSION['error'])) {
    echo "Неверный логин или пароль!";
}
?>
</div>
</div>

<ul class="menu">
    <li><a href="index.php">Главная страница</a></li>
    <li>Методические материалы:</li>
	<ul>
<?php
include ("base.php");
$result=pg_query($link, 'select distinct(name) from "Guide"');
	while ($row = pg_fetch_row($result)) {
			echo '<li><a href="comp.php?name='.$row[0].'">'.$row[0].'</a></li>';
		}
?>
	</ul>
	<li><a href="task_list.php">Задания</a> </li>
	<li><a href="cont.php">Обратная связь</a></li>
	<li><a href="adminin.php">Администрация</a></li>
</ul>
</body>
</html>