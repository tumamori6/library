<?php

require "/home/hinata-antenna/www/hinata_antenna/admin/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "cY9FeVA2b9phQ75QJwhN7j321";
$consumerSecret = "GSphl2NMCY5CZp7ixVeAjK22ElPQySKYukMN7fVhrK16bvrUOl";
$accessToken = "1254421767285686272-DasvcKYf2hMfW7n159sfGPgatxDoop";
$accessTokenSecret = "g5ItrLx6IweBmUNsfdg9lvY3ChO71dMlyEIyJLIH3KjGs";

$twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

$postURL = 'http://hinata-antenna.info/redirect.php?url='.urlencode(substr($product_url,7,100)).'&thumnail='.$product_img.'';

$tag = substr($product_title,0,100);
$tag .= "\n#日向坂46好きな人と繋がりたい ";
$tag .= "\n#ひなあい";
$tag .= "\n#ひなあい名言Tシャツ";
$tags = str_replace("\\n",PHP_EOL,$tag);

$result = $twitter->post(
	"statuses/update",
	array("status" => "".$tags." ".$postURL."")
);

if($twitter->getLastHttpCode() == 200) {
	// ツイート成功
	debug('title:'.$product_title);
	debug('/_/_/_/_/_/_/_/_/_/_/_/_/_/_/');

}

?>
