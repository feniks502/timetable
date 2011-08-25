<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
	exit;
}


include_once '../Settings/settings.php';

foreach ($_POST as $Key => $Value) {
	$_POST[$Key] = trim(htmlspecialchars($Value));
}

$Object = isset ($_POST['object']) ? $_POST['object'] : null;
$Action = isset ($_POST['action']) ? $_POST['action'] : null;

switch ($Object) {
	case 'course':

		switch ($Action) {
			case 'add':
				if (isset ($_POST['course_name']) && ($_POST['course_name']) !== '') {
					$course_name = mysql_real_escape_string($_POST['course_name']);
					$msg_success = 'true';
					$msg_fail = '<span style="color: red;">Добавить не удалось!</span>';
					$status = true;

					start_transaction($msg_fail);
					mysql_query("INSERT INTO `courses` (
						`id`,
						`course_name`
						)
						VALUES (
						NULL, '{$course_name}'
						);") ? null : $status = false;
					mysql_query('ALTER TABLE  `courses` ORDER BY  `id`;') ? null : $status = false;

					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo '<span style="color: red;">Поле не должно быть пустым!</span>';
				}
				break;

			case 'edit':

				break;

			case 'delete':

				break;
		}
		break;

	case 'group':

		switch ($Action) {
			case 'add':
				if (isset ($_POST['course_id']) && is_numeric($_POST['course_id'])
					&&
				    isset ($_POST['group_name']) && ($_POST['group_name']) !== ''
					) {
					$course_id = mysql_real_escape_string($_POST['course_id']);
					$group_name = mysql_real_escape_string($_POST['group_name']);
					$msg_success = 'true';
					$msg_fail = '<span style="color: red;">Добавить не удалось!</span>';
					$status = true;

					start_transaction($msg_fail);
					$sort = mysql_fetch_assoc(mysql_query("SHOW TABLE STATUS LIKE 'groups';"));
					$sort = $sort['Auto_increment'];

					mysql_query("INSERT INTO `groups` (
						`id`,
						`sort`,
						`course_id`,
						`group_name`
						)
						VALUES (
						NULL, '{$sort}', '{$course_id}', '{$group_name}'
						);") ? null : $status = false;
					mysql_query('ALTER TABLE  `groups` ORDER BY  `id`;') ? null : $status = false;

					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo '<span style="color: red;">Поле не должно быть пустым!</span>';
				}
				break;

			case 'edit':
				if (isset ($_POST['group_id']) && is_numeric($_POST['group_id'])
					&&
				    isset ($_POST['group_name']) && ($_POST['group_name']) !== ''
					) {
					$group_id = mysql_real_escape_string($_POST['group_id']);
					$group_name = mysql_real_escape_string($_POST['group_name']);
					$msg_success = 'true';
					$msg_fail = '<span style="color: red;">Изменить не удалось!</span>';
					$status = true;

					start_transaction($msg_fail);
					mysql_query("UPDATE `groups` SET `group_name` = '{$group_name}' WHERE `id` = {$group_id};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo '<span style="color: red;">Поле не должно быть пустым!</span>';
				}
				break;

			case 'delete':
				if (isset ($_POST['group_id']) && is_numeric($_POST['group_id'])) {
					$group_id = mysql_real_escape_string($_POST['group_id']);
					$msg_success = 'true';
					$msg_fail = 'Ошибка!';
					$status = true;
					
					start_transaction($msg_fail);
					mysql_query("DELETE FROM `subjects` WHERE `group_id` = {$group_id};") ? null : $status = false;
					mysql_query("DELETE FROM `groups` WHERE `id` = {$group_id};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo 'Неверные параметры...';
				}
				break;

			case 'move':
				if (isset ($_POST['xid2']) && is_numeric($_POST['xid2'])
					&&
				    isset ($_POST['yid2']) && is_numeric($_POST['yid2'])
					&&
				    isset ($_POST['xid4']) && is_numeric($_POST['xid4'])
					&&
				    isset ($_POST['yid4']) && is_numeric($_POST['yid4'])
					) {
					$xid2 = mysql_real_escape_string($_POST['xid2']);
					$yid2 = mysql_real_escape_string($_POST['yid2']);
					$xid4 = mysql_real_escape_string($_POST['xid4']);
					$yid4 = mysql_real_escape_string($_POST['yid4']);
					$msg_success = 'true';
					$msg_fail = 'Ошибка!';
					$status = true;
		
					start_transaction($msg_fail);
					mysql_query("UPDATE `groups` SET `sort` = {$yid4} WHERE `id` = {$xid2};") ? null : $status = false;
					mysql_query("UPDATE `groups` SET `sort` = {$xid4} WHERE `id` = {$yid2};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo 'Неверные параметры...';
				}
		}
		break;

	case 'subject':

		switch ($Action) {
			case 'add':
				if (isset ($_POST['course_id']) && is_numeric($_POST['course_id'])
					&&
				    isset ($_POST['group_id']) && is_numeric($_POST['group_id'])
					&&
				    isset ($_POST['day_id']) && is_numeric($_POST['day_id'])
					&&
				    isset ($_POST['subject']) && $_POST['subject'] !== ''
					&&
				    isset ($_POST['type_1']) && is_numeric($_POST['type_1'])
					&&
				    isset ($_POST['type_2']) && is_numeric($_POST['type_2'])
					&&
				    isset ($_POST['lec1']) && $_POST['lec1'] !== ''
					&&
				    isset ($_POST['aud1']) && is_numeric($_POST['aud1'])
					&&
				    isset ($_POST['bt1']) && $_POST['bt1'] !== 'null'
					&&
				    isset ($_POST['et1']) && $_POST['et1'] !== 'null'
					) {
					$course_id = mysql_real_escape_string($_POST['course_id']);
					$group_id = mysql_real_escape_string($_POST['group_id']);
					$day_id = mysql_real_escape_string($_POST['day_id']);
					$subject = mysql_real_escape_string($_POST['subject']);
					$type_1 = mysql_real_escape_string($_POST['type_1']);
					$type_2 = mysql_real_escape_string($_POST['type_2']);
					$lec1 = mysql_real_escape_string($_POST['lec1']);
					$aud1 = mysql_real_escape_string($_POST['aud1']);
					$bt1 = mysql_real_escape_string($_POST['bt1']);
					$et1 = mysql_real_escape_string($_POST['et1']);
					$msg_success = 'true';
					$msg_fail = '<span style="color: red;">Добавить не удалось!</span>';
					$status = true;

					switch ($day_id) {
						case 1:
							$day = 'Понедельник';
							break;

						case 2:
							$day = 'Вторник';
							break;

						case 3:
							$day = 'Среда';
							break;

						case 4:
							$day = 'Четверг';
							break;

						case 5:
							$day = 'Пятница';
							break;

						case 6:
							$day = 'Суббота';
							break;

						case 7:
							$day = 'Воскресенье';
							break;

						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					switch ($type_1) {
						case 1:
							$type_1 = 'lecture';
							break;

						case 2:
							$type_1 = 'seminar';
							break;

						case 3: $type_1 = 'elective';
							break;

						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					switch ($type_2) {
						case 1:
							$type_2 = 'simple';
							break;
						case 2:
							$type_2 = 'odd';
							break;
						case 3:
							$type_2 = 'even';
							break;
						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					$type = $type_2 . ' ' .$type_1;

					start_transaction($msg_fail);
					$sort = mysql_fetch_assoc(mysql_query("SHOW TABLE STATUS LIKE 'subjects';"));
					$sort = $sort['Auto_increment'];

					mysql_query("INSERT INTO `subjects` (
						`id`,
						`sort`,
						`course_id`,
						`group_id`,
						`day_id`,
						`day`,
						`subject`,
						`type`,
						`lec1`,
						`aud1`,
						`bt1`,
						`et1`
						)
						VALUES (
						NULL, '{$sort}', '{$course_id}', '{$group_id}', '{$day_id}', '{$day}', '{$subject}', '{$type}', '{$lec1}', '{$aud1}', '{$bt1}', '{$et1}'
						);") ? null : $status = false;
					mysql_query("ALTER TABLE  `subjects` ORDER BY  `id`;") ? null : $status = false;

					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo '<span style="color: red;">Все параметры должны быть заданы!</span>';
				}
				break;

			case 'edit':
				if (isset ($_POST['subject_id']) && is_numeric($_POST['subject_id'])
					&&
				    isset ($_POST['day_id']) && is_numeric($_POST['day_id'])
					&&
				    isset ($_POST['subject']) && $_POST['subject'] !== ''
					&&
				    isset ($_POST['type_1']) && is_numeric($_POST['type_1'])
					&&
				    isset ($_POST['type_2']) && is_numeric($_POST['type_2'])
					&&
				    isset ($_POST['lec1']) && $_POST['lec1'] !== ''
					&&
				    isset ($_POST['aud1']) && is_numeric($_POST['aud1'])
					&&
				    isset ($_POST['bt1']) && $_POST['bt1'] !== 'null'
					&&
				    isset ($_POST['et1']) && $_POST['et1'] !== 'null'
					) {
					$subject_id = mysql_real_escape_string($_POST['subject_id']);
					$day_id = mysql_real_escape_string($_POST['day_id']);
					$subject = mysql_real_escape_string($_POST['subject']);
					$type_1 = mysql_real_escape_string($_POST['type_1']);
					$type_2 = mysql_real_escape_string($_POST['type_2']);
					$lec1 = mysql_real_escape_string($_POST['lec1']);
					$aud1 = mysql_real_escape_string($_POST['aud1']);
					$bt1 = mysql_real_escape_string($_POST['bt1']);
					$et1 = mysql_real_escape_string($_POST['et1']);
					$msg_success = 'true';
					$msg_fail = '<span style="color: red;">Добавить не удалось!</span>';
					$status = true;

					switch ($day_id) {
						case 1:
							$day = 'Понедельник';
							break;

						case 2:
							$day = 'Вторник';
							break;

						case 3:
							$day = 'Среда';
							break;

						case 4:
							$day = 'Четверг';
							break;

						case 5:
							$day = 'Пятница';
							break;

						case 6:
							$day = 'Суббота';
							break;

						case 7:
							$day = 'Воскресенье';
							break;

						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					switch ($type_1) {
						case 1:
							$type_1 = 'lecture';
							break;

						case 2:
							$type_1 = 'seminar';
							break;

						case 3:
							$type_1 = 'elective';
							break;

						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					switch ($type_2) {
						case 1:
							$type_2 = 'simple';
							break;
						case 2:
							$type_2 = 'odd';
							break;
						case 3:
							$type_2 = 'even';
							break;
						default :
							exit('<span style="color: red;">Параметры не прошли проверку...</span>');
					}

					$type = $type_2 . ' ' .$type_1;

					start_transaction($msg_fail);
					mysql_query("UPDATE `subjects` SET `day_id` =  '{$day_id}',
						`day` =  '{$day}',
						`subject` = '{$subject}',
						`type` =  '{$type}',
						`lec1` =  '{$lec1}',
						`aud1` =  '{$aud1}',
						`bt1` =  '{$bt1}',
						`et1` =  '{$et1}' WHERE `id` = {$subject_id};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo '<span style="color: red;">Все параметры должны быть заданы!</span>';
				}
				break;

			case 'delete':
				if (isset ($_POST['subject_id']) && is_numeric($_POST['subject_id'])) {
					$subject_id = mysql_real_escape_string($_POST['subject_id']);
					$msg_success = 'true';
					$msg_fail = 'Ошибка!';
					$status = true;

					start_transaction($msg_fail);
					mysql_query("DELETE FROM `subjects` WHERE `id` = {$subject_id};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo 'Неверные параметры...';
				}
				break;

			case 'move':
				if (isset ($_POST['xid3']) && is_numeric($_POST['xid3'])
					&&
				    isset ($_POST['yid3']) && is_numeric($_POST['yid3'])
					&&
				    isset ($_POST['xid4']) && is_numeric($_POST['xid4'])
					&&
				    isset ($_POST['yid4']) && is_numeric($_POST['yid4'])
					) {
					$xid3 = mysql_real_escape_string($_POST['xid3']);
					$yid3 = mysql_real_escape_string($_POST['yid3']);
					$xid4 = mysql_real_escape_string($_POST['xid4']);
					$yid4 = mysql_real_escape_string($_POST['yid4']);
					$msg_success = 'true';
					$msg_fail = 'Ошибка!';
					$status = true;
		
					start_transaction($msg_fail);
					mysql_query("UPDATE `subjects` SET `sort` = {$yid4} WHERE `id` = {$xid3};") ? null : $status = false;
					mysql_query("UPDATE `subjects` SET `sort` = {$xid4} WHERE `id` = {$yid3};") ? null : $status = false;
					$status ? commit($msg_success, $msg_fail) : rollback($msg_fail);
				} else {
					echo 'Неверные параметры...';
				}
		}
		break;
}

function start_transaction($msg_fail) {
	mysql_query('START TRANSACTION;') or exit($msg_fail . mysql_error());
}

function commit($msg_success, $msg_fail) {
	mysql_query('COMMIT;') or exit($msg_fail . mysql_error());
	echo $msg_success;
}

function rollback($msg_fail) {
	mysql_query('ROLLBACK;') or exit($msg_fail . mysql_error());
	echo $msg_fail . mysql_error();
}
?>