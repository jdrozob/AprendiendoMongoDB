<?php
try {
    $connection = new Mongo();
    $database = $connection->selectDB('miBlog');
    $collection = $database->selectCollection('articles');
} catch (MongoConnectionException $e) {
    die('Fallo en la conexión a la base de datos' . $e->getMessage());
}
$cursor = $collection->find();
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
                <h1>Principal</h1>
                <?php while ($cursor->hasNext()):
                        $article = $cursor->getNext();
                ?>
                <h2><?php echo $article['title']; ?> </h2>
                <p>
                    <?php echo substr($article['content'], 0, 20) . '...'; ?>
                </p>
                <a href="verArticulo.php?id = <?php echo $article['_id']; ?>">Leer M&aacute;s</a>
                <?php endwhile; ?>
            </div>
        </div>
    </body>
</html>