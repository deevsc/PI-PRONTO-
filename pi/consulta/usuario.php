<?php

$base = require '../_base.php';
    
//
//
//

$base->get(function($h, $r) {
    session_start();
    $stmt = $r['pdo']->prepare('SELECT id_usuario,nome, username, telefone, email, bio, media_avaliacao, total_avaliacao, foto_perfil, foto_capa FROM usuario WHERE username=:username');
    $stmt->bindParam('username', $_SESSION['username']);
    $stmt->execute();
    $ret = json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    die($ret);
});

//
//
//

$base->put(function($h, $r){//atualizar
    session_start();
    try {
        $md = $r['pdo']->prepare("UPDATE usuario SET nome = :nome, email = :email, telefone = :telefone, bio = :bio , foto_perfil = :foto_perfil WHERE username = :username");
        $r['body']['username'] = $_SESSION['username'];
        $md->execute($r['body']);
        $count = $md->rowCount();
        return [
            'user' => $_SESSION['id_usuario'],
            'image_id' => $r['body']['foto_perfil']
        ];
        if($count == 0) 
            return "Nenhuma linha foi alterada";
        return "Dados atualizados ;)";
    } catch(Exception $err) {
        return 'Erro: ' .  $err->getMessage();
    }
});

//
//
//

$base->post(function($h, $r){//cadastrar
    try {
        session_start();
        $md = $r['pdo']->prepare("INSERT INTO usuario(nome, email, telefone, username, senha, bio, foto_perfil) VALUES (:nome, :email, :telefone, :username, :senha, :bio, :foto_perfil)");
        $md->bindParam(":nome", $nome);


        $md->execute($r['body']);    
        return "Dados cadastrados ;)";
    }catch(Exception $err) {
        return 'Erro: ' .  $err->getMessage();
    }
});
        
//
//
//

$base->delete(function($h, $r){
    try {
        $md = $r['pdo']->prepare("DELETE FROM usuario WHERE id = :id");
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