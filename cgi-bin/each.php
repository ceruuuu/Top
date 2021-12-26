<?php
	include_once 'dbconn.php';

	$id = $_GET['id'];
	$sql = "SELECT * FROM exhibition WHERE id=".$id;
	$qry = "SET character_set_connection = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_results = 'utf8'"; $result= $conn->query( $qry );
	$qry = "SET character_set_client = 'utf8'"; $result= $conn->query( $qry );
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);


	//row에 다 저장돼있슴니다
	echo $row['title'].'<br>';
	echo $row['start_date'] . ' ~ ' . $row['end_date'];

?>
