<html>
<head>
	<meta charset='utf-8'>
</head>
<body>

<form action="<?=$_SERVER['PHP_SELF']?>" method='POST'>
	<input type='text' name='input_title' value="<?=$_POST['input_title']?>">
	<input type='text' name='input_addr' value="<?=$_POST['input_addr']?>">

	<select name="select_genre">
		<option value=""> 전부 보기</option>
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
	<input type='submit' value='필터링'>
</form>



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

	while($row = mysqli_fetch_array($result)){
		echo "<br><br>";
		
		// 제목 클릭하면 해당 상세 페이지로 이동
		echo'<a href="http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/each.php?id=' . $row['id'] . '">';
		echo '<h2>' . $row['title'] .'</h2></a><br>';
	
		// 아트허브인 경우 이미지 클릭하면 상세 페이지 이동
		if(strpos($row['link'], 'arthub') !== false){
			echo '<a href="http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/each.php?id=' . $row['id'] . '">';
			echo '<img src="' . $row['poster_img'] . '" width="300"><br>';
			echo '</a>';
		}
		
		// 그 외에는 바로바로 꺼내쓰면 될듯합니다
		echo $row['genre'].'<br>';
		echo $row['address'].'<br>';
		echo $row['start_date'].' ~ '.$row['end_date'].'<br>';
	}

?>
</body>
</html>
