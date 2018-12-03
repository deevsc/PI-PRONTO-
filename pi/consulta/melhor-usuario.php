<?php // busca os 5 usuários com melhor avaliação 

$base = require '../_base.php';

$base->get(function($h, $r) {
	 return $h->select('
		SELECT 
			id_usuario, nome, username, telefone, email, media_avaliacao, total_avaliacao, foto_perfil, foto_capa 
		FROM 
			usuario 
		WHERE 
			media_avaliacao is not null 
		order by 
			media_avaliacao 
		desc limit 5
	');
}); 

return $base->return();
