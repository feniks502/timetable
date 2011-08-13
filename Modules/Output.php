<?php
if (!isset ($_GET['id'], $_GET['id2'])) {
	$position = 'courses';

	//columns generation
	$sql = "SELECT * FROM `courses`;";
	$get_columns = mysql_query($sql);

	$headers = getAssoc($get_columns);
	$column_id = undimention($headers, 'id');

	//rows generation
	$sql = "SELECT * FROM `groups` ORDER BY `sort`;";
	$get_rows = mysql_query($sql);

	$rows = getAssoc($get_rows);

	foreach	($column_id as $id) {
		foreach ($headers as $header) {
			if ($header['id'] == $id) {
				$columns[$id]['header'] = $header['course_name'];
			}
		}
	}
	foreach ($column_id as $id) {
		foreach ($rows as $row) {
			if ($row['course_id'] == $id) {
				$columns[$id]['items'][] = array(
					'class' => 'simple',
					'href' => "id={$id}&id2={$row['id']}",
					'item' => $row['group_name'],
					'sort' => "id={$id}&id2={$row['id']}&id4={$row['sort']}"
				);
			}
		}
	}
} else {
	$position = 'subjects';

	$course_id = mysql_real_escape_string($_GET['id']);
	$group_id = mysql_real_escape_string($_GET['id2']);

	//columns generation
	$sql = "SELECT DISTINCT `day_id`, `day` FROM `subjects` WHERE `group_id` = {$group_id} ORDER BY `day_id`;";
	$get_columns = mysql_query($sql);

	$headers = getAssoc($get_columns);
	$column_id = undimention($headers, 'day_id');

	//rows generation
	$sql = "SELECT `id`, `sort`, `day_id`, `subject`, `type`, `auditory`, `begin_time`, `end_time` FROM `subjects` WHERE `group_id` = {$group_id} ORDER BY `sort`;";
	$get_rows = mysql_query($sql);

	$rows = getAssoc($get_rows);

	foreach	($column_id as $id) {
		foreach ($headers as $header) {
			if ($header['day_id'] == $id) {
				$columns[$id]['header'] = $header['day'];
			}
		}
	}
	foreach ($column_id as $id) {
		foreach ($rows as $row) {
			if ($row['day_id'] == $id) {
				$columns[$id]['items'][] = array(
					'class' => $row['type'],
					'href' => "id={$course_id}&id2={$group_id}&id3={$row['id']}",
					'item' => $row['subject'],
					'auditory' => $row['auditory'],
					'begin' => $row['begin_time'],
					'end' => $row['end_time'],
					'sort' => "id={$course_id}&id2={$group_id}&id3={$row['id']}&id4={$row['sort']}"
				);
			}
		}
	}
}


function getAssoc($result) {
	while ($row = mysql_fetch_assoc($result)) {
		$new_array[] = $row;
	}
	return $new_array;
}

function undimention($multi_array, $key) {
	foreach ($multi_array as $value) {
		$new_array[] = $value[$key];
	}
	return $new_array;
}
?>