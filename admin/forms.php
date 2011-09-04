<?php
if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
	exit;
}

include_once '../Settings/settings.php';

foreach ($_POST as $Key => $Value) {
	$_POST[$Key] = trim(htmlspecialchars($Value));
}

$Action = isset ($_POST['action']) ? intval($_POST['action']) : null;


class Template {

	public $Layout, $layoutOptions = array();

	public function __construct(){
		require_once ('../Twig/Autoloader.php');
		Twig_Autoloader::register();

		$this->Loader = new Twig_Loader_Filesystem ('../Templates');
		$this->Twig = new Twig_Environment ($this->Loader, array (
			'cache' => false,
			'debug' => true,
			'auto_reload' => true,
			'strict_variables' => false,
			)
		);

	}

	public function setLayout ($Layout){
		$this->Layout = $Layout;
	}

	public function setOptions ($Key, $Value){
		$this->layoutOptions[$Key] = $Value;
	}

	public function Output(){
		$this->Layout = empty ($this->Layout) ? 'index.html' : $this->Layout . '.twig';

		$Template = $this->Twig->loadTemplate ($this->Layout);
		$Template->display($this->layoutOptions);
	}

}

$Template = new Template;
$Template->setLayout('Forms');

switch ($Action) {
	case 1:
//course add
		$Template->setOptions('n', 1);
		$Template->Output();
		break;

	case 2:
//course edit
		break;

	case 3:
//group add
		$Template->setOptions('n', 3);
		$Template->Output();
		break;

	case 4:
//group edit
		if (isset ($_POST['gid']) && is_numeric($_POST['gid'])) {
			$gid = mysql_real_escape_string($_POST['gid']);

			$gnm = mysql_fetch_row(mysql_query("SELECT `gnm` FROM `groups` WHERE `id` = {$gid};")) or exit(mysql_error());
			$gnm = $gnm[0];

			$Template->setOptions('n', 4);
			$Template->setOptions('gn', $gnm);
			$Template->Output();
		}
		break;

	case 5:
//subject add
		$Template->setOptions('n', 5);
		$Template->Output();
		break;

	case 6:
//subject edit
		if (isset ($_POST['subject_id']) && is_numeric($_POST['subject_id'])) {
			$subject_id = mysql_real_escape_string($_POST['subject_id']);

			$row = mysql_fetch_assoc(mysql_query("SELECT `sg` FROM `subjects` WHERE `id` = {$subject_id};")) or exit (mysql_error());

			if ($row['sg']) {
				$row = mysql_fetch_assoc(mysql_query("SELECT `did`, `subject`, `type`, `lec1`, `aud1`, `bt1`, `et1`, `lec2`, `aud2`, `bt2`, `et2` FROM `subjects` WHERE `id` = {$subject_id};")) or exit(mysql_error());

				$row['type'] = explode(' ', $row['type']);
				$row['bt1'] = explode(':', $row['bt1']);
				$row['et1'] = explode(':', $row['et1']);
				$row['bt2'] = explode(':', $row['bt2']);
				$row['et2'] = explode(':', $row['et2']);

				$Template->setOptions('n', 6);
				$Template->setOptions('row', $row);
				$Template->Output();
			} else {
				$row = mysql_fetch_assoc(mysql_query("SELECT `did`, `subject`, `type`, `lec1`, `aud1`, `bt1`, `et1` FROM `subjects` WHERE `id` = {$subject_id};")) or exit(mysql_error());

				$row['type'] = explode(' ', $row['type']);
				$row['bt1'] = explode(':', $row['bt1']);
				$row['et1'] = explode(':', $row['et1']);

				$Template->setOptions('n', 7);
				$Template->setOptions('row', $row);
				$Template->Output();
			}
		}
		break;
}


/*
		switch ($Action) {
			case 'add':

				break;

			case 'edit':
				if (isset ($_POST['gid']) && is_numeric($_POST['gid'])) {
					$gid = mysql_real_escape_string($_POST['gid']);

					$gnm = mysql_fetch_row(mysql_query("SELECT `gnm` FROM `groups` WHERE `id` = {$gid};")) or exit(mysql_error());
					$gnm = $gnm[0];
				} else {
					echo '<span style="color: red;">Параметры не прошли проверку...</span>';
				}
				break;
		}
		break;

	case 'subject':

		switch ($Action) {
			case 'add':

				break;

			case 'edit':
				if (isset ($_POST['subject_id']) && is_numeric($_POST['subject_id'])) {
					$subject_id = mysql_real_escape_string($_POST['subject_id']);

					$row = mysql_fetch_assoc(mysql_query("SELECT `h` FROM `subjects` WHERE `id` = {$subject_id};")) or exit (mysql_error());

					if ($row['h']) {
						$row = mysql_fetch_assoc(mysql_query("SELECT `did`, `subject`, `type`, `lec1`, `aud1`, `bt1`, `et1`, `lec2`, `aud2`, `bt2`, `et2` FROM `subjects` WHERE `id` = {$subject_id};")) or exit(mysql_error());

						$type = explode(' ', $row['type']);
						$bt1 = explode(':', $row['bt1']);
						$et1 = explode(':', $row['et1']);
						$bt2 = explode(':', $row['bt2']);
						$et2 = explode(':', $row['et2']);
					} else {
						$row = mysql_fetch_assoc(mysql_query("SELECT `did`, `subject`, `type`, `lec1`, `aud1`, `bt1`, `et1` FROM `subjects` WHERE `id` = {$subject_id};")) or exit(mysql_error());

						$type = explode(' ', $row['type']);
						$bt1 = explode(':', $row['bt1']);
						$et1 = explode(':', $row['et1']);


					}
				} else {
					echo '<span style="color: red;">Параметры не прошли проверку...</span>';
				}
				break;
		}
*/
?>