<?php
$envFile = file_get_contents(__DIR__ . '/env.json');
$env = json_decode($envFile, false);

// Variables
$hostDB = $env->HOST;
$nombreDB = $env->DB;
$usuarioDB = $env->USR;
$passDB = $env->PASS;

$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;charset=utf8mb4";
$pdo = new PDO($hostPDO, $usuarioDB, $passDB);
