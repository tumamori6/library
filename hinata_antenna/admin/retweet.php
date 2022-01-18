<?php
require 'function.php';
require "/home/hinata-antenna/www/hinata_antenna/admin/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "cY9FeVA2b9phQ75QJwhN7j321";
$consumerSecret = "GSphl2NMCY5CZp7ixVeAjK22ElPQySKYukMN7fVhrK16bvrUOl";
$accessToken = "1254421767285686272-DasvcKYf2hMfW7n159sfGPgatxDoop";
$accessTokenSecret = "g5ItrLx6IweBmUNsfdg9lvY3ChO71dMlyEIyJLIH3KjGs";

$twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

//getTimeline
$statues = $twitter->get('statuses/user_timeline',['screen_name' => 'Ngizaka_matome']);

//stdClass to Array
$statues = json_decode(json_encode($statues), true);

foreach ($statues as $key => $val) {

	$tweet_ids[] = $val['id'];

}

//retweet
$res = $twitter->post('statuses/retweet/'.$tweet_ids[0].'');

 if ($twitter->getLastHttpCode() === 200) {
 	debug('retweet Success');
 } else {
 	debug('retweet Error'. $res->errors[0]->message);
 }
?>
