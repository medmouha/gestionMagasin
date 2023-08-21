<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=magasin_php","root","");
} catch (\PDOException $e) {
    $e->getMessage();
}

?>