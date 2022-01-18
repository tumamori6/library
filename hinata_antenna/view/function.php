<?php
require_once('/home/hinata-antenna/www/hinata_antenna/db_define.php');
require_once("/home/hinata-antenna/www/hinata_antenna/phpQuery-onefile.php");

ini_set('log_errors','On');
ini_set('error_log','/home/hinata-antenna/www/hinata_antenna/view/php.log');
$debug_flg = 1;

function debug($str){
	global $debug_flg;
	if($debug_flg){
		error_log($str);
	}
}


function isPC(){

	$ua = $_SERVER['HTTP_USER_AGENT'];
	$ua_list = array('iPhone','iPad','iPod','Android');

	foreach ($ua_list as $isPC) {

		if (strpos($ua,$isPC) == false) {

			return 'PC';

		}else {

			return '';

		}

	}

}

function ua_smt(){

	$ua = $_SERVER['HTTP_USER_AGENT'];
	$ua_list = array('iPhone','iPad','iPod','Android');

	foreach ($ua_list as $ua_smt) {

		if (strpos($ua, $ua_smt) !== false) return 'sp';

	}

	return 'pc';

}

function dbConnect(){

	$dbh = new PDO(DSN,DB_USERNAME,DB_PASS);

  return $dbh;
}


function queryPost($dbh, $sql, $data){

  $stmt = $dbh->prepare($sql);

  if(!$stmt->execute($data)){
    return 0;
  }

  return $stmt;

}


function viewContentList($currentMinNum = 1,$span = 20){

  try {

    $dbh = dbConnect();
		if (isset($_GET['category'])) {
			$category = $_GET['category'];
			$sql = "SELECT * FROM content where title=".$category." AND delete_flg=0 ORDER BY create_date DESC";
		}else {
			$sql = "SELECT * FROM content where delete_flg=0 ORDER BY create_date DESC";
		}


    $data = array();
    $stmt = queryPost($dbh,$sql,$data);
    $rst['total'] = $stmt->rowCount();
		$rst['total_page'] = ceil($rst['total']/$span);
		if (!$stmt) {
			return false;
		}

		$sql .= ' LIMIT '.$span.' OFFSET '.$currentMinNum;
		$data = array();
		$stmt = queryPost($dbh,$sql,$data);

		if ($stmt) {

			$rst['data'] = $stmt->fetchAll();
			return $rst;
		}else {
			return false;
		}


  } catch (Exception $e) {
    error_log('エラー発生：'.$e->getMessage());
  }

}

function getMeta(){

	try {

		$dbh = dbConnect();
		$sql = 'SELECT * FROM content WHERE title like :title AND delete_flg=0';
		$stmt = $dbh->prepare($sql);
		$article_id = '%'.$_GET['title'].'%';
		$stmt->bindParam(':title',$article_id,PDO::PARAM_STR);
		$stmt->execute();

		if (!$stmt) {
			return false;
		}else {
			$rst = $stmt->fetchAll();
			return $rst;
		}

	} catch (Exception $e) {
		error_log('エラー発生：'.$e->getMessage());
	}

}

function dispArticle($site,$article_url){

	$html = file_get_contents($article_url);
	$obj = phpQuery::newDocument($html);

	switch ($site) {
		case 'matomekingdam':
			$article_dom = $obj['.article-body'];
			break;

		case 'hinatasokuhou':
			$article_dom = $obj['.article-body-more'];
			break;

		default:
			$article_dom = $obj['.article-body-inner'];
			break;
	}


	return $article_dom;

}


function regArticleData($article_id,$article_url){

	$html = file_get_contents($article_url);
	$obj = phpQuery::newDocument($html);
	$come_head = $obj['.t_h'];
	$come_body = $obj['.t_b'];

	foreach ($come_head as $val) {

		$arr['id'][]	 = mt_rand();
		$arr['head'][] = strpos(pq($val)->html(),'＠まとめきんぐだむ') ? str_replace('＠まとめきんぐだむ','',pq($val)->html()) : pq($val)->html();

	}

	foreach ($come_body as $val) {

		$arr['body'][] = pq($val)->html();

	}

	for ($i=0; $i < count($arr['head']); $i++) {

		try {

			$dbh						 = dbConnect();
			$article_id			 = $article_id;
			$article_url		 = $article_url;
			$come_num				 = $i;
			$come_id				 = $arr['id'][$i];
			$come_head			 = $arr['head'][$i];
			$come_body			 = $arr['body'][$i];
			$sql = <<<SQL
			INSERT INTO article(article_id,article_url,come_num,come_id,come_head,come_body)
			VALUES(:article_id,:article_url,:come_num,:come_id,:come_head,:come_body)
			SQL;
			$data = array(
				':article_id' => $article_id,
				':article_url' => $article_url,
				':come_num' => $come_num,
				':come_id' => $come_id,
				':come_head' => $come_head,
				':come_body' => $come_body
			);

			$stmt = queryPost($dbh,$sql,$data);

			if (!$stmt) {
				debug('Success');
			}else {
				debug('Failed');
			}

		} catch (Exception $e) {
			echo $e->getMessage();
			exit();
		}

	}

}

function getArticleData($article_id){

	try {

		$dbh = dbConnect();
		$sql = 'SELECT * FROM article WHERE article_id='.$article_id.' AND delete_flg=0 ORDER BY come_num DESC';
		$data = array();
		$stmt = queryPost($dbh,$sql,$data);

		if (!$stmt) {
			return false;
		}else {
			$rst = $stmt->fetchAll();
			return $rst;
		}

	} catch (Exception $e) {
		error_log('エラー発生：'.$e->getMessage());
	}

}

function dispArticleData($article_url){

		$html = file_get_contents($article_url);
		$obj = phpQuery::newDocument($html);
		$come_head = $obj['.t_h'];
		$come_body = $obj['.t_b'];

		foreach ($come_head as $val) {

			$arr['head'][] = strpos(pq($val)->html(),'＠まとめきんぐだむ') ? str_replace('＠まとめきんぐだむ','',pq($val)->html()) : pq($val)->html();

		}

		foreach ($come_body as $val) {

			$arr['body'][] = pq($val)->html();

		}

	return $arr;

}

function switchGetData($article_id,$article_url){

	if (getArticleData($article_id)) {

		$article_data = getArticleData($article_id);

	}else {

		regArticleData($article_id,$article_url);
		$article_data = dispArticleData($article_url);

	}

	return $article_data;

}

function dispContents($article_data){

	if ($article_data['head']) {

		for ($i=0;$i<=count($article_data['head']);$i++) {

			$obj_come = phpQuery::newDocument($article_data['head'][$i]);

			if (!strpos(pq($obj_come)->html(),'日向速報')) {

				echo $article_data['head'][$i].'<br>';
				echo '<p>'.$article_data['body'][$i].'<p><br>';

			}

		}

	}else {

		foreach ($article_data as $val) {

			$obj_come = phpQuery::newDocument($val['come_head']);

			if (!strpos(pq($obj_come)->html(),'日向速報')) {

				echo $val['come_head'].'<br>';
				echo '<p>'.$val['come_body'].'<p><br>';

			}

		}

	}

}

function createArticleList(){

	try {

		$dbh = dbConnect();
		$sql = "SELECT * FROM content";
		$data = array();
		$stmt = queryPost($dbh,$sql,$data);

		if (!$stmt) {
			return false;
		}else {
			$rst = $stmt->fetchAll();
			return $rst;
		}

	} catch (Exception $e) {
		error_log('エラー発生：'.$e->getMessage());
	}

}

function optimizeArticleList($data_list,$article_url){

	foreach ($data_list as $key => $val) {

		if ($article_url == $val['url']) continue;

		$arr[$key]['title']	 = $val['title'];
		$arr[$key]['url']		 = 'article.php?title='.$val['title'];

	}

	shuffle($arr);
	array_splice($arr,5);

	return $arr;

}


?>
