<!DOCTYPe html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
	<title>Обратная связь</title>
</head>
<body>
<h1> Контакты </h1>
<div class="main">
<img src="files/nsuembuild.jpg" width="50%" heigth="50%"></src>
<h2>Проблемы с web-приложением:</h2>
<h3>Климов Антон Сергеевич</h3>
<h3>Почта для фотографий: StickyKlim@gmail.com</h3>
<h3>Телефон: 8-913-999-99-99</h3>

<h2>Преподаватель дисциплины</h2>
<h3>старший преподаватель Манагаров Иван Александрович</h3>
<h3>Телефон: 8-955-999-99-99</h3>
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