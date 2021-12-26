<?php
include_once 'dbconn.php';

if (isset($_GET['term'])){
	$return_arr = array();
	$keyword = urldecode($_GET['term']);
	#제목 포함하는 것 10개
	$sql = "SELECT * FROM exhibition WHERE title LIKE '%".$keyword."%' LIMIT 10";	
	
	$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
		
	$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_array($result)){
		$return_arr[] = $row['title'];
	}
		
	echo json_encode($return_arr);
}
?>
