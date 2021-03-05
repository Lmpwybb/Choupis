<?php

function getConnection(): ?PDO
{
  $connection = null;
  try {
        $connection = new PDO("mysql:host=?; dbname=?; charset=utf8", "?", "?");
        $connection->exec("set names utf8");
    } catch (PDOException $exception) {
           echo "Connection error to MySQL: " . $exception->getMessage();
    }
        
    return $connection;
}
