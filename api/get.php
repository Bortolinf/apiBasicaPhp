<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'get') {
        $id = filter_input(INPUT_GET, 'id');

        if($id) {
            $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0) {
                $item = $sql->fetch(PDO::FETCH_ASSOC);
                    $array['result'][] = [
                        'id' => $item['id'],
                        'title' => $item['title'],
                        'body' => $item['body']
                    ];
            } else {                
                $array['error'] = 'Id nao Encontrado';
            }
        } else {
            $array['error'] = 'Id nao Enviado: '.$id;
        }
} else {
    $array['error'] = 'Método não permitido (apenas GET)';
}



require('../return.php');

?>