<?php
try {
    $connection = new Mongo();
    $database = $connection->selectDB('miBlog');
    $collection = $database->selectCollection('articles');
} catch (MongoConnectionException $e) {
    die('Fallo en la conexión a la base de datos' . $e->getMessage());
}
?>
