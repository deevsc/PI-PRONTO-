<?php

$base = require '../_base.php';
    
//
//
//

$base->get(function($helper, $raw) {
    return isset($raw['query']['id'])
        ? $helper->select('SELECT * FROM exemplo WHERE id=:id')[0] ?? 'não foi encontrado'
        : $helper->select('SELECT * FROM exemplo');
});

//
//
//

$base->post(function($h){

});

//
//
//

$base->put(function($h){

});
        

//
//
//

$base->delete(function($h){

});

//
//
//
    
return $base->return();