<?php
$envFile = file_get_contents(dirname(__DIR__) . '/env.json');
$env = json_decode($envFile, false);

// Variables
$hostDB = $env->HOST;
$nombreDB = $env->DB;
$usuarioDB = $env->USR;
$passDB = $env->PASS;

$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$pdo = new PDO($hostPDO, $usuarioDB, $passDB);
