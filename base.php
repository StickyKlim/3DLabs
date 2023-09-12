<?php
$link = pg_connect("hostaddr=127.0.0.1 port=5432 dbname=db3d user=postgres password=123");
if (!$link) {
	echo "Нет подключения к базе данных";
};
?>