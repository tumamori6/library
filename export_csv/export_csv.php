<?php

$csv = [
	['a','b','c','d','e'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
	['1','2','3','4','5'],
];

$stream = fopen('php://temp', 'w');
foreach ($csv as $line) {
	fputcsv($stream, $line);
}
rewind($stream); // ポインタを戻す
$content = stream_get_contents($stream);
fclose($stream);
file_put_contents('export.csv', $content);
