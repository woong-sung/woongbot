<?php
// 환경설정 파일불러오기
include __DIR__ . '/config.php';

$query = "select * from stock";
// $query = "show databases";
$data = mysqli_query($conn, $query);
$result = [];
while ($row = mysqli_fetch_assoc($data)) {
  $result[] = $row;
}

print_r(json_encode($result));

