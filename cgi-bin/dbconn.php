<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$hostname = "localhost";
$username = "cse20151527";
$password = "cse20151527";
$dbname = "db_cse20151527";

$conn = new mysqli($hostname, $username, $password, $dbname)
	or die("DB Connection Failed");
?>

