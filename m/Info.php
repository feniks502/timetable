<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
	exit;
}

include_once '../Settings/settings.php';

foreach ($_POST as $Key => $Value) {
	$_POST[$Key] = trim(htmlspecialchars($Value));
}

$Action = isset ($_POST['action']) ? $_POST['action'] : null;

if (isset ($_POST['subject_id'])) {

	$subject_id = mysql_real_escape_string($_POST['subject_id']);

	switch ($Action) {
		case 'load':
			$info = mysql_fetch_assoc(mysql_query("SELECT `lecturer`, `auditory`, `begin_time`, `end_time`, `home_work` FROM `subjects` WHERE `id`={$subject_id};"));

			echo "<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Преподаватель:</strong> {$info['lecturer']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Аудитория №:</strong> {$info['auditory']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Начало:</strong> {$info['begin_time']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Окончание:</strong> {$info['end_time']}</div>
				<span style=\"color: #f00;\">Домашнее задание:</span><br>
				<textarea style=\"height: 280px; width: 100%; margin-bottom: 5px;\">{$info['home_work']}</textarea>
				<div>
				<input style=\"padding: 5px;\" type=\"submit\" value=\"Сохранить\">
				<input style=\"padding: 5px;\" type=\"button\" value=\"Закрыть\">
				<div id=\"response\"></div>
				</div>";

			break;

		case 'add_hw':
			$home_work = mysql_real_escape_string($_POST['home_work']);
			$msg_success = 'true';
			$msg_fail = '<span style="color: red;">Ошибка!</span>';
			$status = true;
			
			start_transaction($msg_fail);
			mysql_query("UPDATE `subjects` SET `home_work` = '{$home_work}' WHERE `id` ={$subject_id};") ? null : $status = false;

			$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
			break;
	}		
}

function start_transaction($msg_fail) {
	mysql_query('START TRANSACTION;') or exit($msg_fail . mysql_error());
}

function commit($msg_success, $msg_fail) {
	mysql_query('COMMIT;') or exit($msg_fail . misq_error());
	echo $msg_success;
}

function rollback($msg_fail) {
	mysql_query('ROLLBACK') or exit($msg_fail . mysql_error());
	echo $msg_fail . mysql_error();
}
?>