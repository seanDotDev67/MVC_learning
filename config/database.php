<?php

    $host = '127.0.0.1';
    $port = '3307';
    $db = 'mvc_student_db';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    try{
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
    catch(PDOException $e){
        die("Error: " . $e->getMessage());
    }
    return $pdo;
?>