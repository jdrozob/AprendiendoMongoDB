<?php
$id = $_GET['id'];
try {
    $connection = new Mongo();
    $database = $connection->selectDB('miBlog');
    $collection = $database->selectCollection('articles');
} catch (MongoConnectionException $e) {
    die('Fallo en la conexión a la base de datos' . $e->getMessage());
}
$article = $collection->findOne(array('_id' => new MongoId($id)));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transtional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <link rel="stylesheet" href="style.css"/>
        <title>Blog</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Mi post completo</h1>
                <h2><?php echo $article['tittle']; ?></h2>
                <p><?php echo $article['content']; ?></p>
            </div>
        </div>
    </body>
</html>
