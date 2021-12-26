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

<body>
<div class="navbar">
    <div class="navbar-logo">
	    <a href="../index.html">톺</a>
		</div>
			<form class="navbar-search">
		<div class="navbar-search-input">
			<input type="text" id="navbar-search-input">
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
