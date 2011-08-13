<?php
//Copyright display mudule v2.0
//By Solodchenko Leonid © 2010
$author = 'Солодченко Леонид';
$prefix = 'Все права защищены © ';
$begin_year = 2010;
$current_year = date('Y');

$year_check = $current_year-$begin_year;

if ($year_check > 0) {
	$end_year = "-{$current_year}";
} elseif ($year_check == 0) {
	$end_year = NULL;
} else {
	$end_year = ' <span style="color: red;">Fatal ERROR:)</span>';
}

$copyright = "<strong>Timetable Engine v1.3.737.</strong><br>{$prefix}{$begin_year}{$end_year}.<br>{$author}";
?>