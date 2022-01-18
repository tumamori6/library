<?
if(CURRENT_PAGE == 'article') $meta = getMeta();
?>

<?if($meta){?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover">
	<meta name="description" content="<?=SITE_NAME.' | '.$meta[0]['title']?>">
	<meta name="keywords" content="<?=KEYWORDS?>">
	<meta property="og:site_name" content="<?=SITE_NAME?>">
	<meta property="og:title" content="<?=SITE_NAME.' | '.$meta[0]['title']?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?=$meta[0]['url']?>">
	<meta property="og:description" content="<?=SITE_NAME?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@<?=SITE_NAME?>">
	<meta name="twitter:title" content="<?=$meta[0]['title']?>">
	<meta name="twitter:image" content="<?=$meta[0]['thumnail']?>">
	<meta name="twitter:url" content="<?=$meta[0]['url']?>">
	<meta name="twitter:discription" content="<?=SITE_NAME?>">
	<link rel="shortcut icon" href="<?=FAVICON?>">
	<link rel="apple-touch-icon" href="<?=APPLE_TOUCH_ICON?>">
	<title><?=SITE_NAME.' | '.$meta[0]['title']?></title>

<?}else {?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1,viewport-fit=cover">
	<meta name="description" content="<?=DESCRIPTION?>">
	<meta name="keywords" content="<?=KEYWORDS?>">
	<meta property="og:title" content="<?=SITE_NAME?>">
	<meta property="og:site_name" content="<?=SITE_NAME?>">
	<meta property="og:locale" content="ja_JP">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?=SITE_URL?>">
	<meta property="og:description" content="<?=DESCRIPTION?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@<?=SITE_NAME?>">
	<meta name="twitter:url" content="<?=SITE_URL?>">
	<meta name="twitter:title" content="<?=SITE_NAME?>">
	<meta name="twitter:discription" content="@<?=DESCRIPTION?>">
	<link rel="shortcut icon" href="<?=FAVICON?>">
	<link rel="apple-touch-icon" href="<?=APPLE_TOUCH_ICON?>">
	<title><?=SITE_NAME?></title>

<?}?>
