<?php // função da tela inicial em que estão presentes apenas obras nacionais

$base = require '../_base.php';

$base->get(function($h, $r) {
	if(!isset($_GET['id_item'])) {
		$stmt = $r['pdo']->prepare("
		SELECT 
			id_item, foto_item, titulo, subtitulo, valor, genero, descricao, id_usuario 
		FROM 
			item
		WHERE 
			genero like 'literatura brasileira' 
		order by 
			titulo 
		limit 5
	");
   	} else {
		$stmt = $r['pdo']->prepare("
			SELECT 
				id_item, foto_item, titulo, subtitulo, valor, genero, descricao, id_usuario
			FROM 
				item
			WHERE 
				id_item = :id_item
	");
   	 	$stmt->bindParam("id", $_GET["id_item"]);	
	}
	$stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
});

return $base->return();