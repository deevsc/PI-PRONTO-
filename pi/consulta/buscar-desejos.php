<?php // para exibir na lista de desejos so usuário 

$base = require '../_base.php';

$base->get(function($h, $r) {
	session_start();
	if(!isset($_GET['id_desejo'])) {
		$stmt = $r['pdo']->prepare("
		SELECT d.id_item from desejos d 
			inner join usuario as u
				on d.id_usuario = u.id_usuario
		order by 
			id_item
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