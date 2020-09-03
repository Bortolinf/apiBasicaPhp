<?php
header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Content-type: application/json; charset=utf-8");


echo json_encode($array, JSON_UNESCAPED_UNICODE);

exit;




?>