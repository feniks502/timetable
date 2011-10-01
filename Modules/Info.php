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
			$info = mysql_fetch_assoc(mysql_query("SELECT `sg` FROM `subjects` WHERE `id` = {$subject_id};"));
			
			if ($info['sg']) {

				$info = mysql_fetch_assoc(mysql_query("SELECT `lec1`, `aud1`, `bt1`, `et1`, `lec2`, `aud2`, `bt2`, `et2`, `hwk` FROM `subjects` WHERE `id`={$subject_id};"));

				echo "<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Преподаватель:</strong> {$info['lec1']} // {$info['lec2']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Аудитория №:</strong> {$info['aud1']} // {$info['aud2']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Начало:</strong> {$info['bt1']} // {$info['bt2']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Окончание:</strong> {$info['et1']} // {$info['et2']}</div>
				<span style=\"color: #f00;\">Домашнее задание:</span><br>
				<textarea style=\"height: 280px; width: 100%; margin-bottom: 5px;\">{$info['hwk']}</textarea>
				<div>
				<input style=\"padding: 5px; display: none; cursor: pointer;\" type=\"submit\" value=\"Сохранить\">
				<div id=\"response\" style=\"float: right;\"></div>
				</div>";

			} else {

				$info = mysql_fetch_assoc(mysql_query("SELECT `lec1`, `aud1`, `bt1`, `et1`, `hwk` FROM `subjects` WHERE `id`={$subject_id};"));

				echo "<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Преподаватель:</strong> {$info['lec1']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Аудитория №:</strong> {$info['aud1']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Начало:</strong> {$info['bt1']}</div>
				<div style=\"border-bottom: #777 dashed 1px; margin-bottom: 10px;\"><strong>Окончание:</strong> {$info['et1']}</div>
				<span style=\"color: #f00;\">Домашнее задание:</span><br>
				<textarea style=\"height: 280px; width: 100%; margin-bottom: 5px;\">{$info['hwk']}</textarea>
				<div>
				<input style=\"padding: 5px; display: none; cursor: pointer;\" type=\"submit\" value=\"Сохранить\">
				<div id=\"response\" style=\"float: right;\"></div>
				</div>";
			}

			break;

		case 'add_hw':
			$hwk = mysql_real_escape_string($_POST['hwk']);
			$msg_success = 'true';
			$msg_fail = '<span style="color: red;">Ошибка!</span>';
			$status = true;
			
			start_transaction($msg_fail);
			mysql_query("UPDATE `subjects` SET `hwk` = '{$hwk}' WHERE `id` ={$subject_id};") ? null : $status = false;

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