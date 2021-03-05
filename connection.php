<?php

require "config.php";

function getConnection(): ?PDO
{
    global $config;
    $connection = null;
    try {
        $connection = new PDO("mysql:host=" . $config['host'] . "; dbname=" . $config['dbname'] . "; 
        charset=utf8", "" . $config['username'] . "", "" . $config['password'] . "");
        $connection->exec("set names utf8");
    } catch (PDOException $exception) {
       echo "Connection error to MySQL: " . $exception->getMessage();
    }

    return $connection;
}
