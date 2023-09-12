<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Методические материалы </title>
</head>
<body>
<h1> Методические материалы </h1>
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
<?php
include ("base.php");
$result=pg_query($link, 'SELECT * from "Guide" where name='."'".$_GET['name']."'");
	while ($row = pg_fetch_row($result)) {
		echo '<embed src="'.$row[2].'" width="80%" height="850px"/>';
	}
?>
</div>
</body>
</html>