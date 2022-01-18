<?php
$urls = [
	'https://aiseki-data.com/',
];

$header = @get_headers('https://aiseki-data.com/');

if(!$header || !preg_match('/^HTTP\/.+200\s/i', $header[0])){
	echo '【ERROR】ウェブページが表示されていません';
}else{
	echo 'no error';
}