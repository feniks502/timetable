<!DOCTYPE html>
<html>
	<head>
		<title>Добавление курса</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../../css/admin_table.css" />
		<script type="text/javascript" src="../../js/main.js"></script>
		<script type="text/javascript" src="../../js/admin_ajax_temp.js"></script>
	</head>
	<body>

		<form name="add_course">
			<fieldset>
				<legend>Добавить курс</legend>
				<table cellspasing="1">
					<tr>
						<td class="key">Имя курса:</td>
						<td class="value"><input type="text" name="course_name"></td>
					</tr>
				</table>
			</fieldset>
			<input style="padding: 5px; margin-left: 10px;" type="submit" value="Добавить">
			| <button style="padding: 5px;" type="button" name="delete_all" disabled="disabled">Очистить таблицу</button>
			| <a style="color: #0b55c4;" href="../">Назад</a>
		</form>
		<div id="response" style="margin: 10px 0px 10px 10px;"></div>

		<div id="footer">
<?php
include_once '../../Modules/Copyright.php';

echo $copyright;
?>
		</div>
	</body>
</html>