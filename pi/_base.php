<?php

$pdo = require('_database.php');

class Helper {
    private $pdo;
    
    function __construct($pdo, $body, $query) {
        $this->pdo = $pdo;
        $this->body = $body;
        $this->query = $query;
    }

    function select($sql) { 
        try {
            $sth = $this->pdo->prepare($sql);
            $sth->execute($this->query);
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch(Exception $e) {
            return 'ERRO MORTAL: ' . $e->getMessage();
        }
    }
}

class Rest {
    private $pdo;
    private $function = [];


    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function get($fn) { 
        $this->function['GET'] = $fn;
        return $this;
    }
    
    function post($fn) {
        $this->function['POST'] = $fn;
        return $this;
    }
    
    function put($fn) { 
        $this->function['PUT'] = $fn;
        return $this;
    }

    function update($fn) {
        $this->function['UPDATE'] = $fn; 
        return $this;
    }
    
    function delete($fn) {
        $this->function['DELETE'] = $fn;
        return $this;
    }
    
    function return() {
        $body = json_decode(file_get_contents('php://input'), true);
        echo json_encode( 
            $this->function[ $_SERVER['REQUEST_METHOD'] ](
                new Helper($this->pdo, $body, $_GET),

                [
                    "pdo" => $this->pdo,
                    "body" => $body,
                    "query" => $_GET,
                ]
            )
        );
    } 
}

return new Rest($pdo);