<?php
include('header.html');

$currentPageNum = (!empty($_GET['p'])) ? $_GET['p'] : 1;
$listSpan = 20;
$currentMinNum = (($currentPageNum-1)*$listSpan);
$dbContentData = viewContentList($currentMinNum);
$lastPage = ceil($dbContentData['total']/$listSpan);
if ($currentPageNum == $lastPage) {
    $dispNum = $dbContentData['total'];
} else {
    $dispNum = $currentMinNum + $listSpan;
}

?>

<main>

	<ul>

		<?foreach ($dbContentData['data'] as $key => $val) {?>

			<?$content_id = $val['title'];?>

			<a href="./article.php?title=<?=$content_id?>">
				<li class="item">
					<img src="<?=$val['thumnail']?>" alt="<?=$content_id?>">
					<p><?=$val['title']?>
					</p>
					<span><?=date('n/j H時', strtotime($val['create_date']))?></span>
				</li>
			</a>

		<?}?>

	</ul>


	<div class="pagination">
		<ul class="pagination-list">
			<?php
				$pageColNum = 5;
				$totalPageNum = $dbContentData['total_page'];

				if ($currentPageNum == $totalPageNum && $totalPageNum >= $pageColNum) {

					$minPageNum = $currentPageNum - 4;
					$maxPageNum = $currentPageNum;

				} elseif ($currentPageNum == ($totalPageNum-1) && $totalPageNum >= $pageColNum) {

					$minPageNum = $currentPageNum - 3;
					$maxPageNum = $currentPageNum + 1;

				} elseif ($currentPageNum == 2 && $totalPageNum >= $pageColNum) {

					$minPageNum = $currentPageNum - 1;
					$maxPageNum = $currentPageNum + 3;

				} elseif ($currentPageNum == 1 && $totalPageNum >= $pageColNum) {

					$minPageNum = $currentPageNum;
					$maxPageNum = 5;

				} elseif ($totalPageNum < $pageColNum) {

					$minPageNum = 1;
					$maxPageNum = $totalPageNum;

				} else {

					$minPageNum = $currentPageNum - 2;
					$maxPageNum = $currentPageNum + 2;

				}
			?>

			<?php if ($currentPageNum != 1): ?>

			<li class="list-item"><a href="?p=1">&lt;</a></li>

			<?php endif; ?>

			<?php for ($i = $minPageNum; $i <= $maxPageNum; $i++):?>

			<li class="list-item <?if ($currentPageNum == $i) {
				echo 'active';
			} ?>"><a href="?p=<?=$i?>"><?=$i?></a></li>

			<?php endfor;?>

			<?php if ($currentPageNum != $maxPageNum): ?>

			<li class="list-item"><a href="?p=<?=$maxPageNum?>">&gt;</a></li>

			<?php endif; ?>

		</ul>
	</div>

</main>

<?include('footer.html');?>
