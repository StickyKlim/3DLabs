<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Администрация </title>
</head>
<body>
<h1> Страница администрирования </h1>
<div class="main">
<div class="admin">
<h3><?php
session_start();
if(isset($_SESSION['login'])) {
    echo "<a> Ваш логин:". $_SESSION['login']."</b><br><br>";
    echo "<a href='exit.php'>Выход</a>";
    unset($_SESSION['error']);
}
?></h3></div>
<div class="but">
<form action="add_model.php">
<input type="submit" name="button" value="Добавить модель">
</form>

<form action="add_user.php">
<input type="submit" name="button" value="Добавить Админа">
</form>
</div>
<br><br><br><br> <?php
include ("base.php");
$brand=pg_query($link, 'SELECT distinct(module) FROM "Task"');
	while ($row = pg_fetch_row($brand)) {
		echo '<div class="carbox"><li>'.$row[0].'</li><ul>';
		$res=pg_query($link, 'SELECT distinct(id_task), name FROM "Task" where module='."'".$row[0]."'");
		while ($spisok = pg_fetch_row($res)) {
			echo '<li><a href="task_admin.php?id='.$spisok[0].'">'.$spisok[1].'</a></li>';
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