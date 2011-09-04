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
				$columns[$id]['header'] = $header['cnm'];
			}
		}
	}
	foreach ($column_id as $id) {
		foreach ($rows as $row) {
			if ($row['cid'] == $id) {
				$columns[$id]['items'][] = array(
					'class' => 'simple',
					'href' => "id={$id}&id2={$row['id']}",
					'item' => $row['gnm'],
					'sort' => "id={$id}&id2={$row['id']}&id4={$row['sort']}"
				);
			}
		}
	}
} else {
	$position = 'subjects';

	$cid = mysql_real_escape_string($_GET['id']);
	$gid = mysql_real_escape_string($_GET['id2']);

	//columns generation
	$sql = "SELECT DISTINCT `did`, `day` FROM `subjects` WHERE `gid` = {$gid} ORDER BY `did`;";
	$get_columns = mysql_query($sql);

	$headers = getAssoc($get_columns);
	$column_id = undimention($headers, 'did');

	//rows generation
	$sql = "SELECT `id`, `sort`, `did`, `sg`, `subject`, `type`, `aud1`, `bt1`, `et1`, `aud2`, `bt2`, `et2` FROM `subjects` WHERE `gid` = {$gid} ORDER BY `sort`;";
	$get_rows = mysql_query($sql);

	$rows = getAssoc($get_rows);

	foreach	($column_id as $id) {
		foreach ($headers as $header) {
			if ($header['did'] == $id) {
				$columns[$id]['header'] = $header['day'];
			}
		}
	}
	foreach ($column_id as $id) {
		foreach ($rows as $row) {
			if ($row['did'] == $id) {
				$columns[$id]['items'][] = array(
					'class' => $row['type'],
					'href' => "id={$cid}&id2={$gid}&id3={$row['id']}",
					'item' => $row['subject'],
					'aud1' => $row['aud1'],
					'bt1' => $row['bt1'],
					'et1' => $row['et1'],
					'sg' => $row['sg'],
					'aud2' => $row['aud2'],
					'bt2' => $row['bt2'],
					'et2' => $row['et2'],
					'sort' => "id={$cid}&id2={$gid}&id3={$row['id']}&id4={$row['sort']}"
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