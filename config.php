<?php
// composer 사용
include __DIR__ . '/vendor/autoload.php';
// 위경도를 날씨정보x,y값으로 변환해주는 파일
include __DIR__ . '/conGridGps.php';

// env 사용 설정
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 시간대 설정
date_default_timezone_set("Asia/Seoul");

// DB설정
require __DIR__ . '/dbset.php';
