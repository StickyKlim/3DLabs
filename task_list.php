<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Список заданий </title>
</head>
<body>
<h1>Нажмите на задание</h1>
<div class="main">
<?php
include ("base.php");
$module=pg_query($link, 'SELECT distinct(module) FROM "Task" where id_task>=2');
	while ($row = pg_fetch_row($module)) {
		echo '<div class="carbox"><li>'.$row[0].'</li><ul>';
		$res=pg_query($link, 'SELECT distinct(id_task), name FROM "Task" where  module='."'".$row[0]."'");
		while ($spisok = pg_fetch_row($res)) {
			echo '<li><a href="task_model.php?id='.$spisok[0].'">'.$spisok[1].'</a></li>';
		}
		echo '</ul></div>';
	}
?>
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