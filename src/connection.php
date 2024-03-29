<?php

require __DIR__ . "/config.php";

function getDbConnection(): PDO
{
    global $config;
    $connection = null;
    try {
        $connection = new PDO(
            "mysql:host=" . $config['host'] . "; dbname=" . $config['dbname'] . "; charset=utf8",
            $config['username'],
            $config['password']
        );
        $connection->exec("SET NAMES utf8");
    } catch (PDOException $exception) {
        die("Connection error to MySQL: " . $exception->getMessage());
    }

    return $connection;
}
