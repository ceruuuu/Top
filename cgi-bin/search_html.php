<?php
	include_once 'dbconn.php';

    // 장르, 제목, 주소 쿼리문에 넣고
	$select_genre = ''; 
	if(!empty($_POST['select_genre'])){
		$select_genre = urldecode($_POST['select_genre']);  
	}   
	$input_title = urldecode($_POST['input_title']);
	$input_addr = urldecode($_POST['input_addr']);
	$sql = "SELECT * FROM exhibition WHERE (end_date >= now()) and (genre LIKE '%".$select_genre."%')" . " and (title LIKE '%".$input_title."%')" . "and (address LIKE '%".$input_addr."%') ORDER BY end_date ASC";
	$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );

	// 검색 결과 리스트 가져옴
	$result = mysqli_query($conn, $sql);
?>
<html>
<head>

<title>톺</title>

<link rel="stylesheet" href="../style.css">
<meta name="viewport" content="width=device-width, initial scale=1.0">

</head>


<body>
<div class="navbar">
	<div class="navbar-logo">
		<a href="../index.html">톺</a>
	</div>
	<form class="navbar-search" action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
		<div class="navbar-search-input">
			<input type='text' name='input_title' placeholder="전시 톺아보기" value="<?=$_POST['input_title']?>">	
		</div>
		<div class="navbar-search-input-addr">
			<input type='text' name='input_addr' placeholder="주소" value="<?=$_POST['input_addr']?>">
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

<div class="remain">
<div class="contents">
<div class="contents-result">
	<?php while($row = mysqli_fetch_array($result)){ ?>
	<div class="each" onclick="location.href='<?php echo "http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/detail_html.php?id=".$row['id'] ?>'">
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
	<?php } ?>
</div>
<div class="contents-recent">

</div>
</div>
</div>
</body>
</html>
