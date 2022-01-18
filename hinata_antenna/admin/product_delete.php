<?php
require_once('function.php');


$product_list = viewProductList();

$rand_product_id = $product_list[rand(0,count($product_list))]['id'];


try {

	$product_list = viewProductList();
	$dbh = dbConnect();
	$sql = "DELETE FROM product WHERE id = :id";
	$data = array(':id'=>$rand_product_id);
	$stmt = queryPost($dbh,$sql,$data);

} catch (Exception $e) {
	error_log('エラー発生：'.$e->getMessage());
}

?>
