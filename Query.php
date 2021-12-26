<html>
<head>
<meta charset="utf-8">
<title> 톺 </title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(function(){
	$(".auto").autocomplete({
		source: "cgi-bin/auto.php",
		minLength: 1
	});
});

<?php include_once 'cgi-bin/dbconn.php'; ?>
</script>
</head>

<body>
	<form action='http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/search.php' method='POST'>
		<input type='text' name='input_title' value='' class='auto'>
		<input type='text' name='input_addr' value=''>
		<input type='submit' value='검색'>
	</form>

<?php
	// 메인페이지에서 날짜 제일 가까운 전시 10개 추천
	$sql = "SELECT * FROM exhibition WHERE end_date >= now() ORDER BY end_date ASC LIMIT 10";
	
	$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
	
	$result = mysqli_query($conn, $sql);

	while($row = mysqli_fetch_array($result)){
		
		// 제목 클릭시 상세페이지 이동
		echo "<br><br>";
		echo'<a href="http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/each.php?id=' . $row['id'] . '">';
		echo '<h2>' . $row['title'] .'</h2></a><br>';

		// 이미지 클릭시 상세페이지 이동
		if(strpos($row['link'], 'arthub') !== false){
			echo '<a href="http://cspro.sogang.ac.kr/~cse20151527/cgi-bin/each.php?id=' . $row['id'] . '">';
			echo '<img src="' . $row['poster_img'] . '" width="300"><br>';
			echo '</a>';
		}

		// 그 외에는 꺼내쓰기...
		echo $row['genre'].'<br>';
		echo $row['address'].'<br>';
		echo $row['start_date'].' ~ '.$row['end_date'].'<br>';
	}
?>
</body>
</html>
