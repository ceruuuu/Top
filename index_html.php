<html>

<head>
<meta charset="utf-8">
<title>톺</title>

<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial scale=1.0">
<meta name="keywords" content="톺,전시톺">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
	$(function(){
		$(".auto").autocomplete({
	        source: "auto.php",
			minLength: 1
		});
	});

<?php 
include_once 'cgi-bin/dbconn.php'; 

$sql = "SELECT * FROM exhibition WHERE end_date >= now() ORDER BY end_date ASC LIMIT 10";
    
$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
				    
$result = mysqli_query($conn, $sql);
?>

</script>

</head>

<body>
<div class="index">
<div class="index-logo">
		<h1><a href="./index_html.php">톺</a></h1>
	톺다 [톱따]<br>
	(동사) 틈이 있는 곳마다 모조리 더듬어 뒤지면서 찾다
</div>
<div class="index-search">
	<div class="orange-box"></div>
	<div class="index-search-form">
	<form action='http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/search.php' method='POST'>
		<div class="pad-15">
			<input type='text' name='input_title' placeholder="전시 톺아보기"  class='auto'>
		</div>
		<div class="pad-15 search-button">
			<input type='text' name='input_addr' placeholder="주소">
			<input type='submit' value='search'>
		</div>
	</form>
		
		<?php while($row = mysqli_fetch_array($result)){ ?>
		<div class="inded-recommend">
			<div class="each" onclick="location.href='<?php echo "http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/each.php?id=".$row['id']?>'">
				<?php if(strpos($row['link'], 'arthub') !== false){ 
				echo '<div style="display:flex; align-items:center;">';
			        echo '<div class="img-cover">';
						 echo "<img src=".
							$row['poster_img']." class='img-cover-thumbnail'>";
				echo '</div>';
				echo '</div>';
				} ?>
				<div class="each-detail">
				     <span class="genre">
				            <?php echo $row['genre'];?>
				     </span>
					<div class="title">
						  <?php echo $row['title'];?><br>
					</div>
					<div class="venue">
					     <?php echo $row['venue'];?><br>
					</div>
					<div class="address">
						<?php echo $row['address'];?><br>
					</div>
																		    
					<div class="date">
						<?php echo date("Y/m/d", strtotime($row['start_date']))
						   ." - ".
						   date("Y/m/d", strtotime($row['end_date']));?><br>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
</div>
</body>

</html>
