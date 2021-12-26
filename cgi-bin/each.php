<?php
	include_once 'dbconn.php';
	$id = $_GET['id'];
    $sql = "SELECT * FROM exhibition WHERE id=".$id;
	$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
?>
<html>
<head>

<title>톺:<?php echo $row['title'];?></title>

<link rel="stylesheet" href="../style.css">
<meta name="viewport" content="width=device-width, initial scale=1.0">
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
</script>

<body>
<div class="navbar">
    <div class="navbar-logo">
	    <a href="../query.php">톺</a>
	</div>
	<form class="navbar-search" action="search.php" method='POST'>
		<div class="navbar-search-input">
			<input type='text' name='input_title' placeholder="전시 톺아보기" class='auto'>
		</div>
		<div class="navbar-search-input-addr"> 
			<input type='text' name='input_addr' placeholder="주소">
		</div>
		<div class="navbar-search-genre">
			<select name="select_genre">
				<option value=""> 모든 장르</option>
				<option value="드로잉"> 드로잉 </option>
				<option value="조각"> 조각 </option>
				<option value="디자인"> 디자인 </option>
				<option value="퍼포먼스"> 퍼포먼스 </option>
			    <option value="건축"> 건축 </option>
			    <option value="설치"> 설치 </option>
				<option value="공예"> 공예 </option>
				<option value="영화"> 영화 </option>
				<option value="회화"> 회화 </option>
				<option value="캘리그라피"> 캘리그라피 </option>
				<option value="만화"> 만화 </option>
				<option value="고미술"> 고미술 </option>
				<option value="사진"> 사진 </option>
				<option value="미디어아트"> 미디어아트 </option>
				<option value="판화"> 판화 </option>
				<option value="교육"> 교육 </option>
			</select>
		</div>
		<div class="navbar-search-submit">
			<input type="submit" value="search">
		</div>
	</form>
</div>

<div class="detail-contents">
	<div class="each">
		<?php if (strpos($row['link'], 'arthub') !== false){ ?>
		<div style="display:flex; align-items:center;">
			<div class="img-cover">
				<?php echo "<img src=".
					$row['poster_img']." class='img-cover-thumbnail'>";?>
			</div>
		</div>
		<?php } ?>
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
<div class="detail-link" onclick="location.href='<?php echo $row['link'] ?>'">
	자세히 보기!
</div>
<?php if (strpos($row['link'], 'arthub') !== false){ ?>
<iframe src=<?php echo $row['link']?>></iframe>
<?php } ?>
</body>

</html>
