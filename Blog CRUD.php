<?php
/*
 * En este archivo se creara un blog el cual implementara una conexion con MongoDB y se realizaran operaciones CRUD
 */
$action = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Guardar')) ? 'save_article' : 'show_form';
switch ($action) {
    case 'save_article':
        try {
            $connection = new Mongo();
            $database = $connection->selectDB('miBlog');
            $collection = $database->selectCollection('articles');
            /* Código alternativo de selección base de datos colección:
             * $connection = new Mongo();
             * $collection = $conection->miBlog->articles;
             */
            $article = array();    
            $article['title'] = $_POST['title'];
            $article['content'] = $_POST['content'];
            $article['saved_at'] = new MongoDate();
            $collection->insert($article);
            echo "Operación de inserción completada";
        } catch (MongoConnectionException $e) {
            die("No se ha podido conectar a la base de datos " . $e->getMessage());
        } catch (MongoException $e) {
            die("No se han podido insertar los datos " . $e->getMessage());
        }
        /* Código alternativo si queremos que el método insert espere respuesta de MongoDB.
         * MongoDB por defecto es asincrono con el metodo insert, por lo tanto éste último
         * no va a esperar una respuesta del insert que se hace directamente en MongoDB, sino 
         * que va a seguir con la siguiente linea de codigo. El safe => True garantiza que 
         * se realice primero el insert y luego se siga con el codigo:
         * try {
         * $status = $collection->insert($article, array('safe' => True));
         * echo "Operación de inserción completada";
         * } catch (MongoCursorException $e) {
         * die("Insert ha fallado " . $e->getMessage());
         * }
         */
        
        /* Cuándo hacemos un insert 'safe' podemos utilizar un parámetro timeout opcional
         * que nos retorna tambien el tiempo en el que se realiza el insert:
         * try {
         * $collection->insert($article, array('safe' => True, 'timeout' => True));
         * } catch (MongoCursorException $e) {
         * die("EL tiempo de espera para Insert ha finalizado " . $e->getMessage());
         * }
         */
        
        /* Podemos añadir un _id personalizado con un insert. Este código no es pensado en el blog,
         * es un ejemplo de un _id personalizado. El _id se crea usando la funcion hash de timestamp.
         * En estos casos no se asegura la unicidad del _id, por lo tanto si se quiere asegurar esto
         * debemos hacer safe => True obligatoriamente para que éste nos asegure el insert:
         * $username = 'Juan';
         * try {
         * $document = array('_id' => hash('sha1', $username.time()),
         * 'user' => $username, 'visited' => 'homepage.php');
         * $collection->insert($document, array(safe => True));
         * } catch (MongoCursorException $e) {
         * die('Failed to insert '. $e->getMessage());
         * }
         */
        break;
    case 'show form':
    default :
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transtional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <link rel="stylesheet" href="style.css"/>
        <title>Mi Blog</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Nueva entrada</h1>
                <?php if ($action === 'show_form'): ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <h3>Art&Iacute;culo</h3>
                    <p>
                        <input type="text" name="title" id="title"></input>
                    </p>
                    <h3>Contenido</h3>
                    <textarea name="content" rows="20"></textarea>
                    <p>
                        <input type="submit" name="btn_submit" value="Guardar"/>
                    </p>
                </form>
                <?php else: ?>
                <p>
                    Art&Iacute;culo guardado. _id:<?php echo $article['_id']; ?>
                    <a href="Blog CRUD.php"> &iquest;Escribir otro?</a>
                </p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>

