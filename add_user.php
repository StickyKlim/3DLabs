<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Добавление данных </title>
</head>
<body>
<h1> Добавить Администратора </h1>

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


<div class="main">
<form action="add_user.php" method="GET">
	<h3>Таблица: Модель</h3>
	<textarea name="login" id="login" placeholder="Логин"></textarea><br>
	<textarea name="pass" id="pass" placeholder="Пароль"></textarea><br>
	<div class="add_but">
	<input type="submit" name="add" value="Добавить"><br>
	</div>
</form>
<?php
error_reporting(E_ERROR);
include ("base.php");
$id_res=pg_query($link, 'SELECT max(id) from "User"');
if(($_GET['login']!='')&($_GET['pass']!='')){
	while ($id_row = pg_fetch_row($id_res)) {
		global $id_max;
		$id_max=$id_row[0]+1;
	}
	if(isset($_GET['add'])){
		$model=pg_query($link, 'INSERT INTO "User" VALUES ('.$id_max.",'".$_GET['login']."','".$_GET['pass']."');");
	}
}
else {
	echo 'Вы не заполнили данные в таблице';
}
?>
</div>
</body>
</html>