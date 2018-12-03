<?php

$base = require '../_base.php';
    
//
//
//

$base->get(function($h, $r) { // pesquisar 
    $stmt = $r['pdo']->prepare('SELECT id_item, titulo, subtitulo, autor, editora, genero, descricao, valor, id_usuario, foto_item FROM item WHERE id_item=:id');
    $stmt->bindParam('id',$_GET['id_item'] );
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
});

//
//
//

$base->post(function($h, $r){//atualizar (fiz trocado mas funciona)
    try {
        $md = $r['pdo']->prepare("UPDATE item SET titulo = :titulo, subtitulo = :subtitulo, autor = :autor, editora = :editora, genero = :genero, descricao = :descricao, valor = :valor WHERE id_item = :id");
        $md->execute($r['body']);
        $count = $md->rowCount();
        if($count == 0) 
            return "Nenhuma linha foi alterada";
        return "Dados atualizados ;)";
    }catch(Exception $err) {
        return 'Erro: ' .  $err->getMessage();
    }
});

//
//
//

$base->put(function($h, $r){//cadastrar (trocado também)
    try {
        session_start();
        $r['body']['foto'] = uniqid();
        $r['body']['id_usuario'] = $_SESSION['id_usuario'];
        $md = $r['pdo']->prepare("INSERT INTO item(titulo, subtitulo, autor, editora, genero, descricao, valor, foto_item, id_usuario) VALUES (:titulo, :subtitulo, :autor, :editora, :genero, :descricao, :valor, :foto, :id_usuario)");
        $md->execute($r['body']); 
        return [ //aqui é pra inserção da imagem, um esquema diferente do que para os outros tipos de dados
            'user' => $_SESSION['username'],
            'image_id' => $r['body']['foto']
        ];
    }catch(Exception $err) {
        return 'Erro: ' .  $err->getMessage();
    }
});
        
//
//
//

$base->delete(function($h, $r){ //apagar
    try {
        $md = $r['pdo']->prepare("DELETE FROM item WHERE id_item = :id");
        $md->execute($r['query']);
        $count = $md->rowCount();
        if($count == 0) 
            return "Isso não existe"; 
        return "deu bom";
    }catch(Exception $err){
        return "Não funcionou: " . $err->getMessage();
    }
});

//
//
//
    
return $base->return();