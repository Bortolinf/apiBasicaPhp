<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);
//$_SERVER['HTTP_X_REQUESTED_WITH'];

if($method === 'post') {

    $title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');

    if($title && $body) {
        $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:title, :body)");
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->execute();

        $id = $pdo->lastInsertId();
        $array['result'] = [
            'id' => $id,
            'title' => $title,
            'body' => $body
        ];

    } else {
        $headers = '';
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers .= '   ';
                $headers .= str_replace(' ', '', str_replace('_', ' ', strtolower(substr($key, 5))));
                $headers .= ':';
                $headers .= $value;
            }
        }

        $array['error'] = 'Dados nao enviados: '.$headers;

    }

} else {
    $array['error'] = 'Método não permitido (apenas POST)';
}



require('../return.php');

?>