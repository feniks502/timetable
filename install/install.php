<?php
$options_dir = '../Settings';
$options_file = '../Settings/settings.php';

echo '<span style="color: green;">Поиск каталога настроек...</span><br><br>';

if (!is_dir($options_dir)) {
	echo '<span style="color: red;">Каталог настроек не найден!</span><br><br>';
	echo '<span style="color: green;">Попытка создания...</span><br><br>';
	if (!mkdir($options_dir, 0700)) {
		echo '<span style="color: red;">Не удалось создать каталог настроек!</span><br><br>';
		exit('<span style="color: red; font-size: 24px">Выход!</span>');
	}
	echo '<span style="color: green;">Каталог настроек успешно создан.</span><br><br>';
	echo '<span style="color: green;">Поиск файла конфигурации...</span><br><br>';
} else {
	echo '<span style="color: green;">Каталог настроек найден.</span><br><br>';
	echo '<span style="color: green;">Поиск файла конфигурации...</span><br><br>';
}

if (!is_file($options_file)) {
	echo '<span style="color: red;">Файл конфигурации не найден!</span><br><br>';
	echo '<span style="color: green;">Попытка создания...</span><br><br>';
	if (!fopen($options_file, 'w')) {
		echo '<span style="color: red;">Не удалось создать файл конфигурации!<span><br><br>';
		exit('<span style="color: red; font-size: 24px">Выход!</span>');
	} else {
		echo '<span style="color: green;">Файл конфигурации успешно создан.</span><br><br>';
		echo '<span style="color: green;">Установка прав доступа...</span><br><br>';
		if (!chmod($options_file, 0600)) {
			echo '<span style="color: red;">Не удалось установить права доступа!</span><br><br>';
		} else {
			echo '<span style="color: green;">Права доступа успешно установлены.</span><br><br>';
		}
	}
} else {
	echo '<span style="color: green;">Файл конфигурации найден.</span><br><br>';
}

echo '<span style="color: green;">Подключение к серверу баз данных...</span><br><br>';

if (!$link = mysql_connect($_POST['host_name'], $_POST['user_name'], $_POST['user_password'])) {
	echo '<span style="color: red;">Не удалось подключиться!</span><br><br>';
	exit('<span style="color: red; font-size: 24px">Выход!</span>');
} else {
	echo '<span style="color: green;">Подключение успешно.<br><br></span>';
}

echo '<span style="color: green;">Поиск базы данных...</span><br><br>';

if (!mysql_select_db($_POST['db_name'], $link)) {
	echo '<span style="color: red;">Не удалось найти базу данных!</span><br><br>';
	echo '<span style="color: green;">Попытка создания...</span><br><br>';
	$sql = "CREATE DATABASE `{$_POST['db_name']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";

	if (!mysql_query($sql)) {
		echo '<span style="color: red;">Не удалось создать базу данных!</span><br><br>';
		exit('<span style="color: red; font-size: 24px">Выход!</span>');
	} else {
		echo '<span style="color: green;">Создание таблиц (1 из 3)...</span><br><br>';
		$sql = "CREATE TABLE `{$_POST['db_name']}`.`courses` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`course_name` VARCHAR( 50 ) NOT NULL
			) ENGINE = INNODB;";
		mysql_query($sql) or exit('<span style="color: red;">Ошибка: хранилище курсов не создано!</span><br><br><span style="color: red; font-size: 24px">Выход!</span>');

		echo '<span style="color: green;">Создание таблиц (2 из 3)...</span><br><br>';
		$sql = "CREATE TABLE `{$_POST['db_name']}`.`groups` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`sort` INT UNSIGNED NOT NULL ,
			`course_id` INT UNSIGNED NOT NULL ,
			`group_name` VARCHAR( 50 ) NOT NULL
			) ENGINE = INNODB;";
		mysql_query($sql) or exit('<span style="color: red;">Ошибка: хранилище групп не создано!</span><br><br><span style="color: red; font-size: 24px">Выход!</span>');

		echo '<span style="color: green;">Создание таблиц (3 из 3)...</span><br><br>';
                $sql = "CREATE TABLE  `{$_POST['db_name']}`.`subjects` (
			`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`sort` INT UNSIGNED NOT NULL ,
			`course_id` INT UNSIGNED NOT NULL ,
			`group_id` INT UNSIGNED NOT NULL ,
			`day_id` TINYINT( 1 ) UNSIGNED NOT NULL ,
			`day` VARCHAR( 12 ) NOT NULL ,
			`subject` VARCHAR( 100 ) NOT NULL ,
			`type` VARCHAR( 16 ) NOT NULL ,
			`lecturer` VARCHAR( 100 ) NOT NULL ,
			`auditory` INT( 4 ) UNSIGNED NOT NULL ,
			`begin_time` VARCHAR( 5 ) NOT NULL ,
			`end_time` VARCHAR( 5 ) NOT NULL ,
			`home_work` TEXT NOT NULL
			) ENGINE = INNODB;";
                mysql_query($sql) or exit('<span style="color: red;">Ошибка: хранилище предметов не создано!</span><br><br><span style="color: red; font-size: 24px">Выход!</span>');

		echo '<span style="color: green;">База данных успешно создана.</span><br><br>';
		echo '<span style="color: green;">Подключение к базе данных...</span><br><br>';

		if (!mysql_select_db($_POST['db_name'])) {
			echo '<span style="color: red;">Не удалось подключиться!</span><br><br>';
			exit('<span style="color: red; font-size: 24px">Выход!</span>');
		} else {
			echo '<span style="color: green;">Подлючение прошло успешно.</span><br><br>';
		}
	}
} else {
	echo '<span style="color: green;">База данных найдена.</span><br><br>';
	echo '<span style="color: green;">Подключение к базе данных...</span><br><br>';
	echo '<span style="color: green;">Подлючение прошло успешно.</span><br><br>';
}

$db_settings = "<?php
\$database = array(
	'host' => '{$_POST['host_name']}',
	'user' => '{$_POST['user_name']}',
	'pass' => '{$_POST['user_password']}',
	'db_name' => '{$_POST['db_name']}'
);

\$link = mysql_connect(\$database['host'], \$database['user'], \$database['pass'])
		or exit('Не удалось подключиться к серверу баз данных!' . mysql_error());
mysql_query(\"SET NAMES 'utf8'\");
\$selected_db = mysql_select_db(\$database['db_name'], \$link)
		or exit('Не удалось подключиться к базе данных!' . mysql_error());
?>";

echo '<span style="color: green;">Запись в файл конфигурации...</span><br><br>';

if(!file_put_contents($options_file, $db_settings)) {
	echo '<span style="color: red;">Ошибка записи!</span><br><br>';
	exit('<span style="color: red; font-size: 24px">Выход!</span>');
} else {
	echo '<span style="color: green;">Запись прошла успешно.</span><br><br>';
}

echo '<span style="color: green; font-size: 24px;">Установка прошла успешно!</span>';
?>
