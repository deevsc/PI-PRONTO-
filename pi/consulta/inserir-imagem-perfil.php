<?php // inserção de imagem do usuário no banco (perfil)
session_start();//´para salvar o usuário que está cadastrando a imagem

$username =  trim($_PUT['user'], '"');// verifica a existência de uma pasta com o id do usuário
$folder = "../uploads/{$_SESSION['id_usuario']}/perfil/";//criação de uma pasta com o id do usuário, e dentro dela uma pasta perfil (caso já não exista)

if (!is_dir($folder))
	mkdir($folder, 0777, true);

if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $folder . $_POST['image_id'])) {//salvar a foto dentro da pasta nova. A imagem será salva com um id único criado pelo sistema
   echo "Arquivo válido e enviado com sucesso";
} else {
    echo "Falha ao enviar o arquivo \n";
}