<?php
if (isset($_GET['url'])) {
header('Location:http://'.$_GET['url'].'');
}
 ?>
<html>
	<head>
	 <meta charset="utf-8">
	 <meta name="twitter:card" content="summary_large_image">
	 <meta name="twitter:site" content="@日向坂46アンテナ">
	 <meta name="twitter:url" content="http://<?=$_GET['url']?>">
	 <meta name="twitter:title" content="http://<?=substr($_GET['url'],0,100)?>">
	 <meta name="twitter:description" content="日向坂アンテナ">
	 <meta name="twitter:image" content="<?=$_GET['thumnail']?>">
	 <title></title>

		<!-- Global site tag (gtag.js) - Google Analytics -->
	 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-146473273-3"></script>
	 <script>
		 window.dataLayer = window.dataLayer || [];
		 function gtag(){dataLayer.push(arguments);}
		 gtag('js', new Date());

		 gtag('config', 'UA-146473273-3');
	 </script>
	</head>
<body>

</body>
 </html>
