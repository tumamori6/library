<?php

require "/home/hinata-antenna/www/hinata_antenna/admin/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "cY9FeVA2b9phQ75QJwhN7j321";
$consumerSecret = "GSphl2NMCY5CZp7ixVeAjK22ElPQySKYukMN7fVhrK16bvrUOl";
$accessToken = "1254421767285686272-DasvcKYf2hMfW7n159sfGPgatxDoop";
$accessTokenSecret = "g5ItrLx6IweBmUNsfdg9lvY3ChO71dMlyEIyJLIH3KjGs";

$connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

if ($connection) {
	$tweets = $connection->get("search/tweets", [
		"q" => '"#日向坂46好きな人と繋がりたい" -filter:links',
		"lang" => "ja",
		"count" => 2,
		"result_type" => "recent"
	]);
}

//すでにフォロー済みのアカウントを配列に
$friends_data = $connection->get("friends/ids");
$friends_encode = json_decode(json_encode($friends_data),true);
$friends_array = $friends_encode['ids'];

//ヒットしたアカウントをを配列に
$tweets_encode = json_decode(json_encode($tweets),true);
for ($i=0; $i < count($tweets_encode['statuses']) ; $i++) {
	$tweets_array[] = $tweets_encode['statuses'][$i]['user']['id'];
}

for ($i=0; $i < count($tweets_array); $i++) {
	if (!in_array($tweets_array[$i],$friends_array)) {
		$connection->post("friendships/create", ["user_id" => $tweets_array[$i]]);
		sleep(5);
		$connection->post("mutes/users/create", ["user_id" => $tweets_array[$i]]);
		sleep(5);
	}
	sleep(5);
}
//todo database記録,apiリクエスト減らす,日時からリム処理

?>

<pre>
	<?print_r($friends_array);?>
	<?print_r($tweets_array);?>
</pre>
