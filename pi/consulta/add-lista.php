<?php // adicionar a uma lista de desejos 

$base = require '../_base.php'; //conexão com a base 

$base->post(function($h, $r) {
	session_start(); // é pra pegar o usuário que está logado e adicionar à lista de desejos dele 
	print_r($_GET); // isso é só pra testar kk 
	try{
		$stmt = $r['pdo']->prepare("insert into desejos (id_item, id_usuario) values (:id_item,:id_usuario)");
		$stmt->bindParam("id_usuario", $_SESSION['id_usuario']);
		$stmt->bindParam("id_item", $_GET['id_item']);
		$stmt->execute();
	}catch(Exception $err) {
        return 'Erro: ' .  $err->getMessage();
	}
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
});

return $base->return();