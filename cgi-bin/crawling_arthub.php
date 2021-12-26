<?php

include('simplehtmldom_1_9_1/simple_html_dom.php');

$hostname = "localhost";
$username = "cse20151527";
$password = "cse20151527";
$dbname = "db_cse20151527";

$connect = new mysqli($hostname, $username, $password, $dbname)
	or die("DB Connection Failed");

$genre_transform = array(
"Drawing" => "드로잉",
"Sculpture" => "조각",
"Design" => "디자인",
"Performance" => "퍼포먼스",
"Ceramic" => "공예",
"Video" => "영화",
"Painting" => "회화",
"Photography" => "사진",
"MediaArt" => "미디어아트");


$year = date("Y");
$month = date("m");
//echo $year ."/". $month;

$url = "https://www.arthub.co.kr/sub01/board033_list.htm?k_date=$year&k_month=$month";
//echo '<a href="'.$url.'">crawling</a><br>';

$html = file_get_html($url);

$tables = $html->find("table");
$view_arr = array(); //각 전시 id

if($tables){
	foreach($tables[4]->find('tr') as $row){
		$link = $row->find('a');
		foreach($link as $l){
			$href = $l->href;
			//echo $href.'<br>';
			$split_href = explode("=", $href);//str split
			if($split_href[0] == "board03_view.htm?No"){
				//echo '<br>'.$split_href[1].'<br>';
				$view_arr[] = $split_href[1];
			}
		}
	}
}


$view_arr = array_unique($view_arr);
$success_count = 0;
//echo json_encode($view_arr);

$each_url = "https://www.arthub.co.kr/sub01/board03_view.htm?No=";
$main_url = "https://www.arthub.co.kr/";
//각 주소마다 방문해서 db insert
foreach($view_arr as $board_No){
	//echo $board_No.'<br><br>';
	$link = $each_url.$board_No;
	//각 전시 내용
	$html = file_get_html($link);
	
	//정보 영역
	$area = $html->find('table',7);

	//title & genre
	$split_title = explode(":",$html->find('.sub01_view_title',0)->plaintext);
	$title = $split_title[0];
	$genre = str_replace(' ', '', $split_title[2]);//str trim
	$split_genre = explode("&",$genre);
	$genre = $split_genre[0];
	$genre = array_key_exists($genre, $genre_transform)? 
					$genre_transform[$genre]
					: "기타";
	echo $title.'/'.$genre.'<br>';
	
	//poster_img
	$tmp = $area->find('img',0)->src;
	$tmp2 = substr($tmp, 0, 3);//delete '../' from src
	$poster_img = $main_url.substr($tmp, 3);
	//echo '<img src='.$poster_img.'><br>';
	
	$sub_area = $area->find('table',0)->find('tr');
	foreach($sub_area as $tr){
		$td_name = $tr->find('td')[0]->plaintext;
		$td_text = $tr->find('td')[2]->plaintext;
		//echo $td_name.'<br><b>'.$td_text.'</b><br>';
		if($td_name == "전시일정 "){
			$split_td_text = explode(" ", $td_text);
			$start_date = $split_td_text[0];
			$end_date = $split_td_text[3];
			//echo $start_date.'<br>'.$end_date.'<br>';
		}else if($td_name == "전시장소 "){
			$td_text = str_replace("&nbsp;","|",$td_text);
			$split_td_text = explode("|", $td_text);
			$venue = $split_td_text[0];
			//echo $venue.'<br>';
		}else if($td_name == "주소 "){
			$address = rtrim($td_text);
			//echo $address.'<br>';
		}/*else if($td_name == "홈페이지 "){
			$link = str_replace(' ', '', $td_text);
			//echo $link.'<br>';
		}*/
	}
	
	$qry = "SET character_set_connection = 'utf8'"; $result= $connect->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $connect->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $connect->query( $qry );

	$sql = "INSERT INTO exhibition (title, poster_img, link, genre, address, venue, start_date, end_date)
	VALUES ('$title', '$poster_img', '$link', '$genre', '$address', '$venue', '$start_date', '$end_date')";
	
	if($connect->query($sql)){
		//echo "DB insert success<br><br>";
		$success_count += 1;
	}

	//break;//for debugging
}

$fname = './forDebug.txt';
$logData = date("Y-m-d H:i:s")." : arthub : ".$success_count." db_updated";

$file = fopen($fname, "a+") or die("Unable to open file!");
fwrite($file, $logData.PHP_EOL);
fclose($file);
echo $logData;

$connect->close();
?>
