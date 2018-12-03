<?php // para buscar um usuário pesquisado 

$base = require '../_base.php';

$base->get(function($h, $r) {
	if(!isset($_GET['id_usuario'])) {
		$stmt = $r['pdo']->prepare('SELECT id_usuario, nome, username, telefone, email, bio, media_avaliacao, total_avaliacao, foto_perfil, foto_capa FROM usuario');
   	} else {
		$stmt = $r['pdo']->prepare('SELECT id_usuario, nome, username, telefone, email, bio, media_avaliacao, total_avaliacao, foto_perfil, foto_capa FROM usuario WHERE id_usuario=:id');
   	 	$stmt->bindParam("id", $_GET["id_usuario"]);
    	
	}$stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
});

return $base->return();