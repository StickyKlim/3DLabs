<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title> Добавление данных </title>
</head>
<body>
<h1> Добавить модель </h1>

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
<div class="set">
<form action="add_model.php" method="GET">
	<div class="table1">
	<h3>Таблица: Задание</h3>
	<textarea name="name" id="name" placeholder="Название"></textarea><br>
	<textarea name="descript" id="descript" rows=20 placeholder="Описание"></textarea><br>
	<textarea name="module" id="module" placeholder="Модуль"></textarea><br><br><br>
	
	<h3>Таблица: Файлы</h3>

	<textarea name="scheme" id="scheme" placeholder="Чертеж">/files/scheme/</textarea><br>
	<textarea name="pdf" id="pdf" placeholder="Лабораторная">/files/pdf/</textarea><br>
	
	<h3>Таблица: Настройки</h3>
	<textarea name="3d_mod" id="name" placeholder="model_name/scene.gltf">/models/</textarea><br>
	<textarea name="x_size" id="x_size" placeholder="Размер Х"></textarea><br>
	<textarea name="y_size" id="y_size" placeholder="Размер Y"></textarea><br>
	<textarea name="z_size" id="z_size" placeholder="Размер Z"></textarea><br><br><br>
	</div>
	<div class="but">
	<input type="submit" name="add" value="Добавить"><br>
	</div>
</form>
<?php
include ("base.php");
	$id_res=pg_query($link, 'Select max(id_task) from "Task"');
	while ($id_row = pg_fetch_row($id_res)) {
		global $id_max;
		$id_max=$id_row[0]+1;
	}
	$id_res=pg_query($link, 'Select max(id_files) from "TaskFiles"');
	while ($id_row = pg_fetch_row($id_res)) {
		global $id_files;
		$id_files=$id_row[0]+1;
	}
    if(isset($_GET['add'])){
		$model=pg_query($link, 'INSERT INTO "Task" VALUES ('.$id_max.",'".$_GET['name']."','".$_GET['descript']."','".$_GET['module']."');");
		$comp=pg_query($link, 'INSERT INTO "TaskFiles" VALUES ('.$id_max.",'".$_GET['scheme']."','".$_GET['pdf']."','".$id_files."');");
		$set=pg_query($link, 'INSERT INTO "Settings" VALUES ('.$id_max.",'".$_GET['3d_mod']."',".$_GET['x_size'].",".$_GET['y_size'].",".$_GET['z_size'].");");
	}
?>
</div>
</div>

</body>
</html>