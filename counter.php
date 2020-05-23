<?php
$files = $_SERVER['DOCUMENT_ROOT']."\scripts\count.txt";
// Если файл не сушествует, то...
if (!file_exists($files)) {
	file_put_contents($files, date('d.m.Y').":0,0%%%0,0");
}
// Если существует...
else {
	$rez = file_get_contents($files);
	$rez = explode("%%%", $rez); // В rez[0] сегодняшняя дата, просмотры и посетители за этот день, в rez[1] - за все время
	$rezall = explode(",", $rez[1]);
	$rezdata = substr($rez[0], 0, 8); // сегодняшнее число
	$rezpr = substr($rez[0], 9);
	$rezpr = explode(",", $rezpr);
	$date = date('d.m.Y');
	// echo $rezdata;
	// echo "<br>".$rezpr[0];
	// echo "<br>".$rezpr[1];
	// echo "<br>".$rezall[0];
	// echo "<br>".$rezall[1];
	if (strtotime(date('d.m.y')) == strtotime($rezdata)) { // ЭТО БЛЯТЬ ДАТА СЕРВЕРА, А НЕ КЛИЕНТА, НАДО УСВОИТЬ ЭТО
		$rezpr[0] += 1;
		if (!isset($_COOKIE['visitors'])) {
			setcookie("visitors", "yes", time() + 3600);
			$rezpr[1] += 1;
		}
		file_put_contents($files, date('d.m.y').":".$rezpr[0].",".$rezpr[1]."%%%".$rezall[0].",".$rezall[1]."");
	}
	else {
		$rezall[0] += $rezpr[0];
		$rezall[1] += $rezpr[1];
		if (!isset($_COOKIE['visitors'])) {
			setcookie("visitors", "yes", time() + 3600);
			$unique = 1;
		}
		else {
			$unique = 0;
		}
		file_put_contents($files, date('d.m.y').":1,".$unique."%%%".$rezall[0].",".$rezall[1]."");
	}
}
?>