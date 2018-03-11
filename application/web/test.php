<?php


    try {
        $dsn = 'mysql:host=mysql;dbname=flaconi;charset=utf8;port=3306';
        $pdo = new PDO($dsn, 'dev', 'devpassword');
        var_dump($pdo);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

die('sadasd');