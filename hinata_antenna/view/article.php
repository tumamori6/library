<?
require_once('header.html');
$article_id				 = $meta[0]['id'];
$article_url			 = $meta[0]['url'];
$article_data			 = switchGetData($article_id,$article_url);
$relation_article_data = createArticleList();
$currentPage = 'article.php?title='.$meta[0]['title'];
$relation_article_list = optimizeArticleList($relation_article_data,$currentPage);
?>

<link rel="stylesheet" href="/css/article.css">

<main class="article">


	<div class="contents">

		<h1><?=$meta[0]['title']?></h1>

		<img src="<?=$meta[0]['thumnail']?>" alt="<?=$category?>">

		<?=dispContents($article_data)?>

	</div>

	<? if($relation_article_list){ ?>

		<div class="relation-article">

			<h2>その他読まれている記事</h2>
			<ul>

				<? foreach ($relation_article_list as $val) { ?>

					<li>
						<a href="<?=$val['url']?>"><?=$val['title']?></a>
					</li>

				<? } ?>

			</ul>

		</div>

	<? } ?>


	<a href="https://px.a8.net/svt/ejp?a8mat=3BME9A+3SXPWY+CO4+15Z9V5" rel="nofollow" onclick="ga('send','event','a8','click','file', 1);">
	<img border="0" width="468" height="60" alt="" src="https://www22.a8.net/svt/bgt?aid=200919214230&amp;wid=001&amp;eno=01&amp;mid=s00000001642007051000&amp;mc=1" style="
	    width: 100%;
	"></a>
</main>


<?require_once('footer.html')?>
