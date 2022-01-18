<?

/*****
@return $recom_browser_flg bool
*****/
function checkRecomBrowser(){

	$ua                   = strtolower($_SERVER['HTTP_USER_AGENT']);
	$prohibit_browsers    = ['edge','trident','msie','firefox','opera','samsung'];
	$prohibit_browser_flg = false;
	$recom_browser_flg    = false;

	foreach ($prohibit_browsers as $val) {

		if (strstr($ua,$val)) {

			$prohibit_browser_flg = true;
			break;

		}

	}

	if (!$prohibit_browser_flg) {

		if (is_ios() && strstr($ua,'safari') && !strstr($ua,'crios')) {

			$recom_browser_flg = true;

		}elseif (is_android() && strstr($ua,'chrome')) {

			$recom_browser_flg = true;

		}

	}

	return $recom_browser_flg;

}

/*****
@return $is_lighthouse_flg bool
*****/

function isLighthouse(){

	$flg = false;
	$ua  = strtolower($_SERVER['HTTP_USER_AGENT']);

	if (stristr($ua,'lighthouse')) {
		$bool = true;
	}

	return $bool;

}


/*****
@return $is_ios_flg bool
*****/
function isIos(){

	$bool = false;
	$ua   = strtolower($_SERVER['HTTP_USER_AGENT']);

	if (preg_match('/iphone|ipod|ipad/', $ua)) {
		$bool = true;
	}

	return $bool;

}

/*****
@return $os_major_varsion int
*****/

function getOsMajorVersion(){

	$ver = 0;
	$ua  = $_SERVER['HTTP_USER_AGENT'];

	if (stristr($ua,'iPhone')) {

		preg_match('/iPhone OS ([0-9_]+)/', $ua, $matches);
		$ver = explode('_',$matches[1]);

	}elseif (stristr($ua,'Android')) {

		preg_match('/Android ([0-9\.]+)/', $ua, $matches);
		$ver = explode('.',$matches[1]);

	}

	return (int)$ver[0];

}


/*****
@param  $datetime timestanmp
@return $datetime str
*****/

function convertToFuzzyTime($timestanmp){

	$unix     = strtotime($timestanmp);
	$now      = time();
	$diff_sec = $now - $unix;

	if($diff_sec < 60){

		$time = $diff_sec;
		$txt  = $time."秒前";

	}elseif($diff_sec < 3600){

		$time = $diff_sec/60;
		$txt  = $time."分前";

	}elseif($diff_sec < 86400){

		$time = $diff_sec/3600;
		$txt  = $time."時間前";

	}elseif($diff_sec < 2764800){

		$time = $diff_sec/86400;
		$txt  = $time."日前";

	}else{

		$txt  = "1ヶ月以上";

	}

	return $txt;

}

/*****
@param  $datas multidimensional array $redis_key str
@return $cache_datas object

$redis = new Redis();
$redis->connect("localhost",6379);

*****/
/*
function datasCaching($datas,$redis_key,$expire=null){

	foreach($datas as $key => $data){

		foreach($data as $k => $value){
			$redis->hSet($redis_key, $key.$k,$value);
		}

	}

	if ($expire) {
		$redis->expire($redis_key, $expire);
	}

	return $redis->hGetAll($redis_key);

}

*/

/*****
@param  $cache_data hash $propatys array
@return $multi dimensional array
*****/

function getDatasFromFullCache($full_cache,$propertys){

	$loop_cnt = count($full_cache)/count($propertys);
	ksort($full_cache);

	for ($i=0; $i < $loop_cnt; $i++) {

		$data = [];

		foreach ($propertys as $val) {

			$data += [$val => $full_cache[$i.$val]];

		}

		$datas[] = $data;

	}

	return $datas;

}

/*****
@param  $array array $key_name str $order sort_order
@return $array sortedArray
*****/

function sortByKey($array,$key_name,$order){

	foreach($array as $key => $val){

		$standard_key_array[$key] = $val[$key_name];

	}

	array_multisort($standard_key_array,$order,$array);

	return $array;

}


/*
@param  array $this_week_files
@return bool
*/

function hasTodayText($this_week_files){

	$bool = false;

	foreach($this_week_files as $f){

		if (strpos($f, date('Ymd')) !== false) {
			$bool = true;
		}
	
	}

	return $bool;

}

/*
@param  string $target
@return array
*/
function getThisWeekFiles($target){

	$this_week_files = [];
	$all_files       = glob($target);

	for ($i = -6; $i <= 0; $i++) {
		$d      = new DateTime($i . ' day');
		$days[] = $d->format('Ymd');
	}

	foreach ($all_files as $file) {
		foreach ($days as $d) {
			if (strpos($file, $d) !== false) {
				$this_week_files[] = $file;
			}
		}
	}

	return $this_week_files;

}


/*
@param  array $base_datas
@param  charcode $from $to
@return array
*/
function formatFileDatas($base_datas, $from, $to){

	$formatted_datas = [];

	foreach ($base_datas as $datas) {

		$data = explode(',', $datas);
		$item = [];

		foreach ($data as $val) {
			$item[] = mb_convert_encoding($val, $from, $to);
		}

		$formatted_datas[] = $item;

	}

	return $formatted_datas;

}
