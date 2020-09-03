<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete') {
    // metodo para pegar dados de uma requisição PUT
    parse_str(file_get_contents('php://input'), $input);
    $id = $input['id'] ?? null;
    // limpeza dos campos
    $id = filter_var($id);

    if($id) {
        // verificar se ja existe
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->Execute();
        if($sql->rowCount() === 0) {
            $array['error'] = 'Id não encontrada';
        } else {
            $sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
            $sql->bindValue(':id', $id);
            if($sql->execute()) {
                $array['result'] = ['ok'];
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
    $array['error'] = 'Método não permitido (apenas DELETE)';
}


require('../return.php');

?>