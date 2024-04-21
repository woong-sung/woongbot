<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/conGridGps.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

date_default_timezone_set("Asia/Seoul");

// 좌표 검색 시작
$naver_key = $_ENV["NAVER_API_KEY"];
$naver_secrete = $_ENV["NAVER_API_SECRET"];

$headers = [
  "X-NCP-APIGW-API-KEY-ID:" . $naver_key,
  "X-NCP-APIGW-API-KEY:" . $naver_secrete,
  "Content-Type:application/json",
];

$search = $_GET['q'];
// $search = urlencode("계산동");

$geocoding_url = "https://naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode?query=" . $search;
$request = curl_init();
curl_setopt($request, CURLOPT_URL, $geocoding_url);
curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
curl_setopt($request, CURLOPT_HTTPGET, true);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($request);
$data = json_decode($result, true);

// print_r($data); 
$place =  $data["addresses"][0]["roadAddress"];
// echo $place;

// 날씨 검색 시작
$date = date("Ymd");
$time = date("H" . "00");
$num_of_rows = 10;
$weather_key = $_ENV["WEATHER_API_KEY"];

$ConvGridGps = new ConvGridGps();
$lat = $data["addresses"][0]["y"];
$lng = $data["addresses"][0]["x"];
$gpsToGridData = $ConvGridGps->gpsToGRID($lat, $lng);
$nx = $gpsToGridData['x'];
$ny = $gpsToGridData['y'];
// print_r($lat.", ".$lng);
// echo "\n";
// print_r($nx.", ".$ny);
$weather_url = "http://apis.data.go.kr/1360000/VilageFcstInfoService_2.0/getUltraSrtNcst?ServiceKey=" . $weather_key . "&numOfRows=" . $num_of_rows . "&base_date=" . $date . "&base_time=" . $time . "&nx=" . $nx . "&ny=" . $ny . "&dataType=JSON";
// echo $weather_url;
$request = curl_init();
curl_setopt($request, CURLOPT_URL, $weather_url);
curl_setopt($request, CURLOPT_HTTPGET, true);
curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($request);
// echo $result;
$data_arr = json_decode($result, true)["response"]["body"]["items"]["item"];

$temperature = "";
foreach ($data_arr as $data) {
  $category = $data["category"];
  if ($category == "T1H") {
    $temperature = $data["obsrValue"];
  }
}
foreach ($data_arr as $data) {
  if ($data['category'] == "T1H") {
    $temp = $data['obsrValue'];
  }
}
if ($temp == "") {
  $result = "error";
} else {
  $result = "success";
}
$json_data = [
  "result" => $result,
  "temp" => $temp,
  "date" => $date,
  "time" => $time,
  "place" => $place
];

echo json_encode($json_data);
