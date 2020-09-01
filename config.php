<?php

$db_host = 'localhost';
$db_name = 'devsnotes';
$db_user = 'root';
$db_pas = '';

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host.";charset=utf8", $db_user, $db_pas);

$array = [
    'error' => '',
    'result' => []
];


?>