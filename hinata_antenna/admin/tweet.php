<?php

require "/home/hinata-antenna/www/hinata_antenna/admin/twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$consumerKey = "cY9FeVA2b9phQ75QJwhN7j321";
$consumerSecret = "GSphl2NMCY5CZp7ixVeAjK22ElPQySKYukMN7fVhrK16bvrUOl";
$accessToken = "1254421767285686272-DasvcKYf2hMfW7n159sfGPgatxDoop";
$accessTokenSecret = "g5ItrLx6IweBmUNsfdg9lvY3ChO71dMlyEIyJLIH3KjGs";

$twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

//$postURL = 'http://hinata-antenna.info/redirect.php?url='.urlencode(substr($url,7,100)).'&thumnail='.$img.'';

$postURL = 'https://hinata-antenna.info/article.php?title='.urlencode($title);

$tag = $title;
$tag .= "\n#日向坂46";
$tag .= "\n#おひさまと繋がりたい";
$tag .= "\n#日向坂46好きな人と繋がりたい ";
$tags = str_replace("\\n",PHP_EOL,$tag);

$result = $twitter->post(
	"statuses/update",
	array("status" => "".$tags." ".$postURL."")
);

if($twitter->getLastHttpCode() == 200) {
	// ツイート成功
	debug('PostURL:'.strlen($postURL));
	debug('title:'.mb_strlen($title));
	debug('url:'.strlen($url));
	debug('img:'.strlen($img));
	debug('/_/_/_/_/_/_/_/_/_/_/_/_/_/_/');

}

?>
