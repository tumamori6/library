<?
require(dirname(__FILE__) . '/recommendClass.php');

$recommend = new recommendClass();


$ratings = [
	[
		'user_id' => 1,
		'item_id' => [1, 3, 5],
	],
	[
		'user_id' => 2,
		'item_id' => [2, 4, 5],
	],
	[
		'user_id' => 3,
		'item_id' => [2, 3, 4, 7],
	],
	[
		'user_id' => 4,
		'item_id' => [3],
	],
	[
		'user_id' => 5,
		'item_id' => [4, 6, 7],
	],
];

$all_item_ids = [1, 2, 3, 4, 5, 6, 7];

// make rating
foreach ($ratings as $rating) {
	foreach ($rating['item_id'] as $item_id) {
		$recommend->setRating($rating['user_id'], $item_id);
	}
}

// calclation of jaccard
$recommend->calcJaccard($all_item_ids);

// get recommended items of item_id:1
print_r($recommend->getItems(1));
