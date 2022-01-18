<?php

$csv = [
	['a','b','c','d','e'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
];

$file_name = "sample.csv";

$fp = fopen('php://output', 'w');
foreach ($csv as $line) {
	mb_convert_variables('SJIS-win', 'UTF-8', $line);
	fputcsv($fp, $line);
}
fclose($fp);

header('Content-Type: application/octet-stream');
header("Content-Disposition: attachment; filename=".$file_name."");
header('Content-Transfer-Encoding: binary');
exit;
