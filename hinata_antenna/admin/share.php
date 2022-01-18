<?php
require_once('function.php');

$html = file_get_contents('https://hinatata.shopselect.net/');
$obj = phpQuery::newDocument($html);
$product_title = $obj['.item_meta > .title'];
$product_price = $obj['.item_meta > .price'];
$product_img = $obj['.image_container > img'];
$product_url = $obj['.product_list > a'];

foreach ($product_url as $val) {
	$arr_id[] = substr(pq($val)->attr("href"),-8,8);
}

foreach ($product_title as $val) {
	$arr_title[] = pq($val)->text();
}

foreach ($product_price as $val) {
	$arr_price[] = pq($val)->text();
}

foreach ($product_img as $val) {
	$arr_img[] = pq($val)->attr("src");
}

foreach ($product_url as $val) {
	$arr_url[] = pq($val)->attr("href");
}


for ($i=0; $i < count($arr_title); $i++) {

	try {

		$product_id = $arr_id[$i];
		$product_title = $arr_title[$i];
		$product_price = $arr_price[$i];
		$product_img = $arr_img[$i];
		$product_url = $arr_url[$i];

		$dbh = dbConnect();
		$sql = <<<SQL
		INSERT INTO product(product_id,product_title,product_price,product_img,product_url)
		VALUES(:product_id,:product_title,:product_price,:product_img,:product_url)
		SQL;
		$data = array(':product_id'=>$product_id,':product_title'=>$product_title,':product_price'=>$product_price,':product_img'=>$product_img,':product_url'=>$product_url);
		$stmt = $dbh->prepare($sql);
		$stmt->execute($data);

		//productツイート
		$count = $stmt->rowCount();
		if ($count) {
			require_once('share_tweet.php');
		}else {
			require_once('product_delete.php');
		}

	} catch (Exception $e) {
		echo $e->getMessage();
		exit();
	}


}

//cron_reg

?>
