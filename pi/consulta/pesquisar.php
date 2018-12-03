<?php // função de pesquisar da página inicial

$base = require '../_base.php';

$base->post(function($h, $r) {
	
	$stmt = $r['pdo']->prepare('select * from item where titulo like :objeto LIMIT 10');
    $stmt->execute([
    	":objeto" => "%" . $_GET["objeto"] . "%"
    ]);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}); 

return $base->return();

