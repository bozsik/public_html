
<?php
$sql = "SELECT * FROM categories";
$query = mysqli_query($con,$sql);
while($data=mysqli_fetch_assoc($query)){
	echo "<h1>".$data['category_name']."</h1>";
	$sqlart = "SELECT * FROM articles WHERE category_id = '".$data['category_id']."'";
	$queryart = mysqli_query($con,$sqlart);
	while($dataart=mysqli_fetch_assoc($queryart)){
		echo '<div class="card"><img src="prods/'.$dataart['article_img'].'" alt="'.$dataart['article_name'].'" width="250" />
		<p>'.$dataart['article_name'].'</p></div>';
	}
	echo '<hr style="clear:both;" />';
}
?>
