<?php


return new PDO(
    'pgsql:host=localhost;port=5432;dbname=bloop', 'postgres', 'elefante', 
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);