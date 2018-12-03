<?php

$base = require '../_base.php';
    

$base->get(function($h, $r) { //sistema de login
    session_start();

    $ret = $h->select('SELECT id_usuario,username FROM usuario WHERE username=:username AND senha=:senha');
    
    if (empty($ret)) {
        $_SESSION['username'] = null;
        $_SESSION['id_usuario'] = null;  
        return false;
    }

    $_SESSION['username'] = $ret[0]['username'];
    $_SESSION['id_usuario'] = $ret[0]['id_usuario'];
    return true;
});

    
return $base->return();