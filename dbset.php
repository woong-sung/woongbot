<?php

$host = "43.203.80.100";
$username = "test";
$password = $_ENV["DB_PASSWORD"];
$datebase = "woongbot";

$conn = mysqli_connect($host,$username,$password,$datebase);

if (!$conn) {
  die("MYSQL 연결 실패: " . mysqli_connect_error());
}

