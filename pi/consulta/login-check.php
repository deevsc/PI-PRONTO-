<?php

$base = require '../_base.php';
    
$base->get(function($h, $r) { //verifica se o usuário está logado (função presente em quase todas as páginas)
    session_start();
    if ( isset($_SESSION['username'])&& !empty($_SESSION['username']) )
        return $_SESSION['username'];
    else
        return false;
});

    
return $base->return();