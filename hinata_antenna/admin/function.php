<?php

require_once('/home/hinata-antenna/www/hinata_antenna/db_define.php');
require_once("/home/hinata-antenna/www/hinata_antenna/phpQuery-onefile.php");

ini_set('date.timezone','Asia/Tokyo');
ini_set('log_errors','On');
ini_set('error_log','/home/hinata-antenna/www/hinata_antenna/admin/php.log');
$debug_flg = 1;

function debug($str){
	global $debug_flg;
	if($debug_flg){
		error_log($str);
	}
}

//dbConnect
function dbConnect(){

	$dbh = new PDO(DSN,DB_USERNAME,DB_PASS);

  return $dbh;
}

//queryPost
function queryPost($dbh, $sql, $data){
  //クエリー作成
  $stmt = $dbh->prepare($sql);
	$stmt->execute($data);
  //プレースホルダに値をセットし、SQL文を実行
  if(!$stmt->execute($data)){
    return 0;
  }

  return $stmt;

}

//getProductList
function viewProductList(){

	try {

		$dbh = dbConnect();
		$sql = "SELECT * FROM product";
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


//matomesokuhou
function matomesokuhou(){


  $html = file_get_contents('http://hiraganakeyaki.blog.jp/');
  $obj = phpQuery::newDocument($html);
  $articles_title = $obj['.article-title > a'];
  $articles_url = $obj['.article-title > a'];
  $imgs = $obj['.pict'];
  $times = $obj['time'];

  foreach ($articles_title as $val) {
    $arr_title[] = pq($val)->text();
  }

  foreach ($articles_url as $val) {
    $arr_url[] = pq($val)->attr("href");
  }

  foreach ($imgs as $val) {
    $arr_img[] = pq($val)->attr("src");
  }

  foreach ($times as $val) {
    $arr_time[] = date('Y/m/d H:i:s',strtotime(pq($val)->attr("datetime")));
  }

  for ($i=0; $i < count($arr_title); $i++) {

    try {

      $dbh = dbConnect();
      $title = $arr_title[$i];
      $url = $arr_url[$i];
      $img = $arr_img[$i];
      $time = $arr_time[$i];
      $site = 'matomesokuhou';
      $sql = 'INSERT INTO content(title,url,thumnail,post_date,site)VALUES(:title,:url,:thumnail,:post_date,:site)';
      $stmt = $dbh->prepare($sql);
      $params = array(':title' => $title,':url' => $url,':thumnail' => $img,':post_date' => $time,':site' => $site);
      $stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count) {
				require_once('tweet.php');
			}

    } catch (Exception $e) {
      echo $e->getMessage();
      exit();
    }

  }

}

//matomekingdam
function matomekingdam(){
  $html = file_get_contents('http://hiragana46matome.com/');
  $obj = phpQuery::newDocument($html);
  $articles_title = $obj['.article-title'];
  $articles_url = $obj['.article > a'];
  $imgs = $obj['.article-thumb > img'];
  $times = $obj['.article-date'];

  foreach ($articles_title as $val) {
    $arr_title[] = pq($val)->text();
  }

  foreach ($articles_url as $val) {
    $arr_url[] = pq($val)->attr("href");
  }

  foreach ($imgs as $val) {
    $arr_img[] = pq($val)->attr("src");
  }

  foreach ($times as $val) {
    $arr_time[] = pq($val)->text();
  }


    for ($i=0; $i < count($arr_title); $i++) {

      try {

        $dbh = dbConnect();
        $title = $arr_title[$i];
        $url = $arr_url[$i];
        $img = $arr_img[$i];
        $time = $arr_time[$i];
        $site = 'matomekingdam';
        $sql = 'INSERT INTO content(title,url,thumnail,post_date,site)VALUES(:title,:url,:thumnail,:post_date,:site)';
        $stmt = $dbh->prepare($sql);
        $params = array(':title' => $title,':url' => $url,':thumnail' => $img,':post_date' => $time,':site' => $site);
				$stmt->execute($params);
				$count = $stmt->rowCount();
				if ($count) {
					require_once('tweet.php');
				}

      } catch (Exception $e) {
        echo $e->getMessage();
        exit();
      }

    }


}

//hinatasokuhou
function hinatasokuhou(){
  $html = file_get_contents('http://hinatasoku.blog.jp/');
  $obj = phpQuery::newDocument($html);
  $articles_title = $obj['.article-title > a'];
  $articles_url = $obj['.article-title > a'];
  $imgs = $obj['.ArticleFirstImageThumbnail > img'];
  $times = $obj['.article-header-date > time'];

  foreach ($articles_title as $val) {
    $arr_title[] = pq($val)->text();
  }

  foreach ($articles_url as $val) {
    $arr_url[] = pq($val)->attr("href");
  }

  foreach ($imgs as $val) {
    $arr_img[] = pq($val)->attr("src");
  }

  foreach ($times as $val) {
    $arr_time[] = date('Y/m/d H:i:s',strtotime(pq($val)->attr("datetime")));
  }


  for ($i=0; $i < count($arr_title); $i++) {

    try {

      $dbh = dbConnect();
      $title = $arr_title[$i];
      $url = $arr_url[$i];
      $img = $arr_img[$i];
      $time = $arr_time[$i];
      $site = 'hinatasokuhou';
      $sql = 'INSERT INTO content(title,url,thumnail,post_date,site)VALUES(:title,:url,:thumnail,:post_date,:site)';
      $stmt = $dbh->prepare($sql);
      $params = array(':title' => $title,':url' => $url,':thumnail' => $img,':post_date' => $time,':site' => $site);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count) {
				require_once('tweet.php');
			}

    } catch (Exception $e) {
      echo $e->getMessage();
      exit();
    }

  }

}


//matomemory
function matomemory(){
  $html = file_get_contents('http://46matome.net/');
  $obj = phpQuery::newDocument($html);
  $articles_title = $obj['.article-title > a'];
  $articles_url = $obj['.article-title > a'];
  $imgs = $obj['.article-header-inner > a > img'];
  $times = $obj['.article-header-date > time'];

  foreach ($articles_title as $val) {
    $arr_title[] = pq($val)->text();
  }

  foreach ($articles_url as $val) {
    $arr_url[] = pq($val)->attr("href");
  }

  foreach ($imgs as $val) {
    $arr_img[] = pq($val)->attr("src");
  }

  foreach ($times as $val) {
    $arr_time[] = date('Y/m/d H:i:s',strtotime(pq($val)->attr("datetime")));
  }


  for ($i=0; $i < count($arr_title); $i++) {

    try {

      $dbh = dbConnect();
      $title = $arr_title[$i];
      $url = $arr_url[$i];
      $img = $arr_img[$i];
      $time = $arr_time[$i];
      $site = 'matomemory';
      $sql = 'INSERT INTO content(title,url,thumnail,post_date,site)VALUES(:title,:url,:thumnail,:post_date,:site)';
      $stmt = $dbh->prepare($sql);
      $params = array(':title' => $title,':url' => $url,':thumnail' => $img,':post_date' => $time,':site' => $site);
			$stmt->execute($params);
			$count = $stmt->rowCount();
			if ($count) {
				require_once('tweet.php');
			}

    } catch (Exception $e) {
      echo $e->getMessage();
      exit();
    }

  }

}


//getContents
function getContents($site){
  switch ($site) {
    case '0':
      $content = matomesokuhou();
      break;

    case '1':
      $content = matomekingdam();
      break;

		case '2':
      $content = hinatasokuhou();
      break;

		case '3':
      $content = matomemory();
      break;

    default:
      // code...
      break;
  }

  return $content;
}


?>
