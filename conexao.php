<?php

$host = 'localhost';
$db   = 'cloud';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("falha na conexão do banco de dados");
}

