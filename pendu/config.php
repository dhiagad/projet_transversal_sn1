<?php
session_start();
try{
    $dbh = new PDO ('mysql:host=localhost;dbname=pendu;charset=utf8', 'root', '');
}catch (PDOException $e) {
    die($e->getMessage());
}
?>