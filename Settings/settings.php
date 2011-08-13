<?php
$database = array(
	'host' => 'localhost',
	'user' => 'root',
	'pass' => '123123',
	'db_name' => 'timetable'
);

$link = mysql_connect($database['host'], $database['user'], $database['pass'])
		or exit('Не удалось подключиться к серверу баз данных!' . mysql_error());
mysql_query("SET NAMES 'utf8'");
$selected_db = mysql_select_db($database['db_name'], $link)
		or exit('Не удалось подключиться к базе данных!' . mysql_error());
?>