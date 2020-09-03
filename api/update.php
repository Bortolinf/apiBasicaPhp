<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put') {
    // metodo para pegar dados de uma requisição PUT
    parse_str(file_get_contents('php://input'), $input);
    $id = $input['id'] ?? null;
    $title = $input['title'] ?? null;
    $body = $input['body'] ?? null;
    // limpeza dos campos
    $id = filter_var($id);
    $title = filter_var($title);
    $body = filter_var($body);

    if($title && $body && $id) {
        // verificar se ja existe
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->Execute();
        if($sql->rowCount() === 0) {
            $array['error'] = 'Id não encontrada';
        } else {
            $sql = $pdo->prepare("UPDATE notes SET 
                                title = :title, 
                                body = :body
                                WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':body', $body);
            if($sql->execute()) {
                $array['result'] = [
                    'id' => $id,
                    'title' => $title,
                    'body' => $body
                ];
            } else {
                $error = '';
                foreach ($sql->errorInfo() as $name => $value) { 
                    $error .= "$name: $value,";
                } 
                $array['error'] = 'Erro na execução do SQL: '.$error;
            }
        }

    } else {
        $array['error'] = 'Dados não enviados: ';
    }

} else {
    $array['error'] = 'Método não permitido (apenas PUT)';
}


require('../return.php');

?>