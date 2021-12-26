<html>
<body>
<?php
	$genre_list = ["드로잉", "조각", "디자인", "퍼포먼스", "건축", "설치", "공예", "영화", "회화", "캘리그라피", "만화", "고미술", "사진", "미디어아트", "판화", "교육"];
	include_once 'dbconn.php';
?>

<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');

foreach($genre_list as $genre_unit){
	//장르명, 해당 장르 리스트 첫번째 페이지 url post로 받음
	$url = $_POST["url"];
	$url = "https://www.artbava.com/exhibit/?genre=" . $genre_unit;
	$html = file_get_html($url);

	//목록에서 상세 페이지 링크 가져와서 배열에 저장
	$arr = $html->find('div[id="exhibit-list"]', 0)->find('a');

	//동적 크롤링 시작
	while(True){
		//상세 페이지 DB 업로드
		for($i=0;$i<count($arr)-1;$i=$i+2){
		
			$d_html = file_get_html('https://artbava.com'.$arr[$i]->href);
		
			$title = $d_html->find('h2',0)->plaintext;
			$poster_img = $d_html->find('img',0)->src;
			$link = 'https://artbava.com'.$arr[$i]->href;
			$genre = urldecode((explode("genre=", $url))[1]);
			$arr1 =  $d_html->find('nav[class=nav-gallery]', 0)->find('p');
			$address = $arr1[1]->plaintext;	
			$arr2 = $d_html->find('h4');
			$venue = $arr2[0]->plaintext;
			$date = explode(' ~ ' ,$arr2[1]->plaintext);
			$date[0] = str_replace("년 ","/",$date[0]);
			$date[0] = str_replace("월 ","/",$date[0]);
			$start_date = str_replace("일", "", $date[0]);
			$date[1] = str_replace("년 ","/",$date[1]);
			$date[1] = str_replace("월 ","/",$date[1]);
			$end_date = str_replace("일", "", $date[1]);

			$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
			$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
			$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
		
			$sql = "INSERT INTO exhibition (title, poster_img, link, genre, address, venue, start_date, end_date) VALUES ('$title', '$poster_img', '$link','$genre', '$address', '$venue', '$start_date', '$end_date')";
		
			if ($conn->query($sql) == TRUE){
				echo "DB save success<br><br>";
			}
			else{
				"falied ".$sql."<br>". $conn->error;
			}
		}
	
		//현재 목록에 20개 이상 있으면 다음 페이지 서치
		if(count($arr) < 41) break;
		$html = file_get_html('https://artbava.com'.$arr[count($arr)-1]->href);
		$arr = $html->find('div[id="exhibit-list"]', 0)->find('a');
	}
}


?>

</body>
</html>
