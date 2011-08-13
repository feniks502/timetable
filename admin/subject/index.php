<!DOCTYPE html>
<html>
	<head>
		<title>Добавление предмета</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../../css/admin_table.css" />
		<script type="text/javascript" src="../../js/main.js"></script>
		<script type="text/javascript" src="../../js/admin_ajax_temp.js"></script>
	</head>
	<body>

		<form name="add_subject">

			<fieldset>
				<legend>Добавить предмет</legend>

				<table cellspacing="1">
					<tr>
						<td class="key">День:</td>
						<td class="value">
							<select size="7" name="day">
								<option value="Понедельник">Понедельник</option>
								<option value="Вторник">Вторник</option>
								<option value="Среда">Среда</option>
								<option value="Четверг">Четверг</option>
								<option value="Пятница">Пятница</option>
								<option value="Суббота">Суббота</option>
								<option value="Воскресенье">Воскресенье</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Тип:</td>
						<td class="value">
							<select size="2" name="type_2">
								<option value="lecture">Лекция</option>
								<option value="seminar">Семинар</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Цикличность:</td>
						<td class="value">
							<select size="3" name="type_1">
								<option value="simple">Простая</option>
								<option value="odd">Нечетная</option>
								<option value="even">Четная</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Преподаватель:</td>
						<td class="value">
							<input type="text" size="20" maxlength="50" name="surname" value="Фамилия" onfocus="if (this.value == 'Фамилия') this.value = ''" onblur="if (this.value == '') this.value = 'Фамилия'"><br>
							<input type="text" size="20" maxlength="50" name="name" value="Имя" onfocus="if (this.value == 'Имя') this.value = ''" onblur="if (this.value == '') this.value = 'Имя'"><input style="padding: 0px 5px 0px 5px; margin-left: 5px;" type="button" name="dont_know" value="Не знаю!"><br>
							<input type="text" size="20" maxlength="50" name="patronymic" value="Отчество" onfocus="if (this.value == 'Отчество') this.value = ''" onblur="if (this.value == '') this.value = 'Отчество'"><input style="padding: 0px 5px 0px 5px; margin-left: 5px;" type="button" name="dont_know" value="Не знаю!">
						</td>
					</tr>
					<tr>
						<td class="key">Аудитория №:</td>
						<td class="value"><input type="text" size="4" maxlength="4" name="auditory"></td>
					</tr>
					<tr>
						<td class="key">Начало:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="begin_time_h"> : <input type="text" size="2" maxlength="2" name="begin_time_min">
						</td>
					</tr>
					<tr>
						<td class="key">Окончание:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="end_time_h"> : <input type="text" size="2" maxlength="2" name="end_time_min">
						</td>
					</tr>
					<tr>
						<td class="key">Предмет:</td>
						<td class="value">
							<input type="text" size="50" maxlength="50" name="subject">
							<input type="hidden" name="course_id" value="<?php echo $_GET['id_1']; ?>">
							<input type="hidden" name="group_id" value="<?php echo $_GET['id_2']; ?>">
						</td>
					</tr>
				</table>
			</fieldset>
			<input style="padding: 5px; margin-left: 10px;" type="submit" value="Добавить">
			| <button style="padding: 5px;" type="button" name="delete_all" disabled="disabled">Очистить таблицу</button>
			| <a style="color: #0b55c4;" href="<?php echo "../?id_1={$_GET['id_1']}&id_2={$_GET['id_2']}"; ?>">Назад</a>
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



