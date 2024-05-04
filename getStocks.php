<?php
// 환경설정 파일불러오기
include __DIR__ . '/config.php';

$query = "select * from stock";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

echo $row;

