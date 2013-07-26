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

<?php 
/* Ejemplo de consulta en el shell de Mongo que obtiene todos los documentos de
 * una colección llamada peliculas que tienen su campo genero configurado como
 * aventura:
 * >db.peliculas.find({"genero":"aventura"})
{ "_id" : ObjectId("4db439153ec7b6fd1c9093ec"), "nombre" : "guardianes de la noche", "genero" : "aventura", "año" : 2009 }
 */

/* En PHP obtener todas las peliculas en las que genero == aventura
 * $collectionPeliculas->find(array("genero" => "aventura"));
 */

/* Obtener todas las peliculas en las que genero es comedia y año es 2011
 * $movieCollection->find(array("genero" => "comedia", "año" = 2011)); 
 */

/*Obtener todas las peliculas
 * movieCollection.>find();
 */

/* Cuando realizamos una busqueda con find, nos retorna un objeto cursor con el 
 * cual podremos iterar sobre todo el resultado de la consulta con ayuda de bucles 
 * como while.
 * $cursor = $colleccionPelicula->find(array('genero'=>'aventura'));
 * while ($cursor->hashNext()) {
 * $movie = $cursor->getNext();
 * //hacer algo con la pelicula
 * .............................
 * }
 */

/* Lo anterior con un for, el metodo count() nos retorna el numero de objetos
 * en el resultado de la consulta
 * $cursor = $colleccionPelicula->find(array('genero'=>'aventura'));
 * if ($cursor->count() === 0) {
 * foreach ($cursor as $pelicula) {
 * //hacer algo con la pelicula
 * }
 * }
 */

/* Si lo que queremos es trabajar con PHP no mas podremos usar el metodo iterator_to_array()
 * para convertir los resultados de nuestro cursor en un arreglo y despues por medio de la
 * funcion as ir trabajando con cada elemento de este array. La desventaja grande de esto es
 * que si el resultado de la consulta es muy grande, todo se tendra que cargar en memoria
 * y esto puede signifiar una disminucion en la velocidad.
 * $cursor = $colleccionPelicula->find(array('genero'=>'aventura'));
 * $array = iterator_to_array($cursor);
 * if (!empty($array)) {
 * foreach($array as $item){
 * //hacer algo con $item
 * .......................
 * }
 * }
 */

/* Ejemplo de usos de operadores condicionales en las consultas desde PHP
 * //obtener todos los items con campo 'x' mayor que 100
 * $collection->find(array("x" => array('$gt' => 100)));
 * //obtener todos los items con campo 'x' menor que 100
 * $collection->find(array("x" => array('$lt' => 100)));
 * //obtener todos los items con campo 'x' mayor o igual que 100
 * $collection->find(array("x" => array('$gte' => 100)));
 * //obtener todos los items con campo 'x' menor o igual que 100
 * $collection->find(array("x" => array('$lte' => 100)));
 * //obtener todos los items con campo 'x' entre 100 y 200
 * $collection->find(array("x" => array('$gte' => 100, '$lte' => 200)));
 * //obtener todos los items con campo 'x' distinto de 100
 * $collection->find(array("x" => array('$ne' => 100)));
 */
?>

