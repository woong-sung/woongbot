<?php
// 환경설정 파일불러오기
include __DIR__ . '/config.php';

$query = "select * from stock";
// $query = "show databases";
$data = mysqli_query($conn, $query);
$result = "등록된 주식은 다음과 같습니다.\n";

foreach (mysqli_fetch_assoc($data) as $i => $row) {
  $result.=$i.") 종목 이름: ".$row['name'].", "."종목 코드: ".$row['code'];
}

$json_data = [
  "result" => $result,
  "query" => $query
];

print_r(json_encode($json_data));

