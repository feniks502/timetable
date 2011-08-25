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
				echo '<form name="add_course">
			<fieldset>
				<legend>Добавить курс</legend>
				<table cellspasing="1">
					<tr>
						<td class="key">Имя курса:</td>
						<td class="value"><input type="text" name="course_name"></td>
					</tr>
				</table>
			</fieldset>
			<div style="margin-left: 10px; margin-right: 10px;">
				<input style="padding: 5px;" type="submit" value="Добавить">
				| <a style="color: #0b55c4;" href="./">Назад</a>
				<div id="response" style="float: right;"></div>
			</div>
		</form>';
				break;

			case 'edit':

				break;
		}
		break;

	case 'group':

		switch ($Action) {
			case 'add':
				echo '<form name="add_group">
			<fieldset>
				<legend>Добавить группу</legend>
				<table cellspasing="1">
					<tr>
						<td class="key">Имя группы:</td>
						<td class="value">
							<input type="text" name="group_name">
						</td>
					</tr>
				</table>
			</fieldset>
			<div style="margin-left: 10px; margin-right: 10px;">
				<input style="padding: 5px;" type="submit" value="Добавить">
				| <a style="color: #0b55c4;" href="./">Назад</a>
				<div id="response" style="float: right;"></div>
			</div>
		</form>';
				break;

			case 'edit':
				if (isset ($_POST['group_id']) && is_numeric($_POST['group_id'])) {
					$group_id = mysql_real_escape_string($_POST['group_id']);

					$group_name = mysql_fetch_row(mysql_query("SELECT `group_name` FROM `groups` WHERE `id` = {$group_id};")) or exit(mysql_error());
					$group_name = $group_name[0];

					echo '<form name="edit_group">
			<fieldset>
				<legend>Добавить группу</legend>
				<table cellspasing="1">
					<tr>
						<td class="key">Имя группы:</td>
						<td class="value">
							<input type="text" name="group_name" value="';
					echo $group_name;
					echo '">
						</td>
					</tr>
				</table>
			</fieldset>
			<div style="margin-left: 10px; margin-right: 10px;">
				<input style="padding: 5px;" type="submit" value="Изменить">
				| <a style="color: #0b55c4;" href="./">Назад</a>
				<div id="response" style="float: right;"></div>
			</div>
		</form>';
				} else {
					echo '<span style="color: red;">Параметры не прошли проверку...</span>';
				}
				break;
		}
		break;

	case 'subject':

		switch ($Action) {
			case 'add':
				echo '<form name="add_subject">

			<fieldset>
				<legend>Добавить предмет</legend>

				<table cellspacing="1">
					<tr>
						<td class="key">День:</td>
						<td class="value">
							<select size="7" name="day">
								<option value="1">Понедельник</option>
								<option value="2">Вторник</option>
								<option value="3">Среда</option>
								<option value="4">Четверг</option>
								<option value="5">Пятница</option>
								<option value="6">Суббота</option>
								<option value="7">Воскресенье</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Тип:</td>
						<td class="value">
							<select size="2" name="type_1">
								<option value="1">Лекция</option>
								<option value="2">Семинар</option>
								<option value="3">Факультатив</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Цикличность:</td>
						<td class="value">
							<select size="3" name="type_2">
								<option value="1">Простая</option>
								<option value="2">Нечетная</option>
								<option value="3">Четная</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">По подгруппам:</td>
						<td class="value">
							<input type="checkbox" name="sg">
						</td>
					</tr>
					<tr>
						<td class="key">Преподаватель:</td>
						<td class="value">
							<input type="text" size="50" maxlength="50" name="lec1"><br><div class="h">
							<input type="text" size="50" maxlength="50" name="lec2"></div>
						</td>
					</tr>
					<tr>
						<td class="key">Аудитория №:</td>
						<td class="value">
							<input type="text" size="4" maxlength="4" name="aud1"><br><div class="h">
							<input type="text" size="4" maxlength="4" name="aud2"></div>
						</td>
					</tr>
					<tr>
						<td class="key">Начало:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="bth1"> : <input type="text" size="2" maxlength="2" name="btm1"><br><div class="h">
							<input type="text" size="2" maxlength="2" name="bth2"> : <input type="text" size="2" maxlength="2" name="btm2"></div>
						</td>
					</tr>
					<tr>
						<td class="key">Окончание:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="eth1"> : <input type="text" size="2" maxlength="2" name="etm1"><br><div class="h">
							<input type="text" size="2" maxlength="2" name="eth2"> : <input type="text" size="2" maxlength="2" name="etm2"></div>
						</td>
					</tr>
					<tr>
						<td class="key">Предмет:</td>
						<td class="value">
							<input type="text" size="50" maxlength="50" name="subject">
						</td>
					</tr>
				</table>
			</fieldset>
			<div style="margin-left: 10px; margin-right: 10px;">
				<input style="padding: 5px;" type="submit" value="Добавить">
				| <a style="color: #0b55c4;" href="#" onclick="window.location.reload()">Назад</a>
				<div id="response" style="float: right;"></div>
			</div>
		</form>';
				break;

			case 'edit':
				if (isset ($_POST['subject_id']) && is_numeric($_POST['subject_id'])) {
					$subject_id = mysql_real_escape_string($_POST['subject_id']);

					$row = mysql_fetch_assoc(mysql_query("SELECT `day_id`, `subject`, `type`, `lec1`, `aud1`, `bt1`, `et1` FROM `subjects` WHERE `id` = {$subject_id};")) or exit(mysql_error());

					$type = explode(' ', $row['type']);
					$bt1 = explode(':', $row['bt1']);
					$et1 = explode(':', $row['et1']);

					echo '<form name="edit_subject">

			<fieldset>
				<legend>Добавить предмет</legend>

				<table cellspacing="1">
					<tr>
						<td class="key">День:</td>
						<td class="value">
							<select size="7" name="day">
								<option value="1"';
					if ($row['day_id'] == 1) { echo 'selected'; }
					echo '>Понедельник</option>
								<option value="2"';
					if ($row['day_id'] == 2 ) { echo 'selected'; }
					echo '>Вторник</option>
								<option value="3"';
					if ($row['day_id'] == 3) { echo 'selected'; }
					echo '>Среда</option>
								<option value="4"';
					if ($row['day_id'] == 4) { echo 'selected'; }
					echo '>Четверг</option>
								<option value="5"';
					if ($row['day_id'] == 5) { echo 'selected'; }
					echo '>Пятница</option>
								<option value="6"';
					if ($row['day_id'] == 6) { echo 'selected'; }
					echo '>Суббота</option>
								<option value="7"';
					if ($row['day_id'] == 7) { echo 'selected'; }
					echo'>Воскресенье</option>
							</select>;
						</td>
					</tr>
					<tr>
						<td class="key">Тип:</td>
						<td class="value">
							<select size="2" name="type_1">
								<option value="1"';
					if ($type[1] == 'lecture') { echo 'selected'; }
					echo '>Лекция</option>
								<option value="2"';
					if ($type[1] == 'seminar') { echo 'selected'; }
					echo '>Семинар</option>
								<option value="3"';
					if ($type[1] == 'elective') { echo 'selected'; }
					echo '>Факультатив</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Цикличность:</td>
						<td class="value">
							<select size="3" name="type_2">
								<option value="1"';
					if ($type[0] == 'simple') { echo 'selected'; }
					echo '>Простая</option>
								<option value="2"';
					if ($type[0] == 'odd') { echo 'selected'; }
					echo '>Нечетная</option>
								<option value="3"';
					if ($type[0] == 'even') { echo 'selected'; }
					echo '>Четная</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="key">Преподаватель:</td>
						<td class="value">
							<input type="text" size="50" maxlength="50" name="lec1" value="';
					echo $row['lec1'];
					echo '"><br>
						</td>
					</tr>
					<tr>
						<td class="key">Аудитория №:</td>
						<td class="value"><input type="text" size="4" maxlength="4" name="aud1" value="';
					echo $row['aud1'];
					echo '"></td>
					</tr>
					<tr>
						<td class="key">Начало:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="bth11" value="';
					echo $bt1[0];
					echo '"> : <input type="text" size="2" maxlength="2" name="btm1" value="';
					echo $bt1[1];
					echo '">
						</td>
					</tr>
					<tr>
						<td class="key">Окончание:</td>
						<td class="value">
							<input type="text" size="2" maxlength="2" name="eth1" value="';
					echo $et1[0];
					echo '"> : <input type="text" size="2" maxlength="2" name="eth1" value="';
					echo $et1[1];
					echo '">
						</td>
					</tr>
					<tr>
						<td class="key">Предмет:</td>
						<td class="value">
							<input type="text" size="50" maxlength="50" name="subject" value="';
					echo $row['subject'];
					echo '">
						</td>
					</tr>
				</table>
			</fieldset>
			<div style="margin-left: 10px; margin-right: 10px;">
				<input style="padding: 5px;" type="submit" value="Изменить">
				| <a style="color: #0b55c4;" href="#" onclick="window.location.reload()">Назад</a>
				<div id="response" style="float: right;"></div>
			</div>
		</form>';
				}
				break;
		}
		break;
}
?>