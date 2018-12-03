<?php // enviar para o banco de dados o valor recebido pela avaliação 

$base = require '../_base.php';

$base->post(function($h, $r) {
	session_start();
	if(!empty($_GET['estrela'])){
		$estrela = $_GET['estrela'];
		print_r($_SESSION);
	//Salvar no banco de dados
		$stmt = $r['pdo']->prepare("insert into avaliacao (id_usuario_avaliado, id_usuario_avaliador, valor) VALUES (:id_usuario_avaliado,:id_usuario_avaliador, :estrela)");
		$stmt->bindParam("id_usuario_avaliador", $_SESSION['id_usuario']);
		$stmt->bindParam("id_usuario_avaliado", $_GET['id_usuario']);
		$stmt->bindParam("estrela", $_GET['estrela']);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	else{
	$_SESSION['msg'] = "Necessário selecionar pelo menos 1 estrela";
	}
});

$base->get(function($h, $r) { // para obter os valores de acordo com a relação e fazer a execução da trigger 
	session_start();
	if(!isset($_GET['total_avaliacao'])) {
		$stmt = $r['pdo']->prepare("
		SELECT u.total_avaliacao, u.media_avaliacao from usuario u  
			inner join avaliacao as a
				on a.id_usuario_avaliado = u.id_usuario;
		u.total_avaliacao = (total_avaliacao + 1);
		u.media_avaliacao = (select SUM(valor) from avaliacao where a.id_usuario_avaliado = u.id_usuario)/u.total_avaliacao;

		insert into usuario (media_avaliacao, total_avaliacao) values (:media_avaliacao, :total_avaliacao) where a.id_usuario_avaliado = u.id_usuario;
	");
   	} else {
		$stmt = $r['pdo']->prepare("
			SELECT d.id_item from desejos d 
				inner join usuario as u
					on d.id_usuario = u.id_usuario
						where u.username=:username
		order by 
			titulo 
	");
   	 	$stmt->bindParam("username", $_SESSION);	
	}
	$stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
});

return $base->return();


