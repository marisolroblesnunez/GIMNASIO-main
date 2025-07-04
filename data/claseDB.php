<?php
// DATA/claseDB.php
// Funciones para consultar la base de datos relacionadas con clases
/**
 * Se encarga de interactuar con la base de datos con la tabla libro hay que crear una clase por cada tabla en este caso solo tenemos una tabla entonces hacemos solo una clase, (clase libro db) para hacerle consultas a la base de datos.
 */
class claseDB {

    private $db;
    private $table = 'clases';
    //recibe una conexión ($database) a una base de datos y la mete en $db
    public function __construct($database){
        $this->db = $database->getConexion();
    }

    //extrae todos los datos de la tabla $table
    public  function getAll(){
        //construye la consulta
        $sql = "SELECT * FROM {$this->table}";

        //realiza la consulta con la función query()
        $resultado = $this->db->query($sql);

        //comprueba si hay respuesta ($resultado) y si la respuesta viene con datos
        if($resultado && $resultado->num_rows > 0){
            //crea un array para guardar los datos
            $clases = [];
            //en cada vuelta obtengo un array asociativo con los datos de una fila y lo guardo en la variable $row
            //cuando ya no quedan filas que recorrer termina el bucle
            while($row = $resultado->fetch_assoc()){
                //al array libros le añado $row 
                $clases[] = $row;
            }
            //devolvemos el resultado
            return $clases;
        }else{
            //no hay datos, devolvemos un array vacío
            return [];
        }
        
    }

    public function getById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if($stmt){
            //añado un parámetro a la consulta
            //este va en el lugar de la ? en la variable $sql
            //"i" es para asegurarnos de que el parámetro es un número entero
            $stmt->bind_param("i", $id);
            //ejecuta la consulta
            $stmt->execute();
            //lee el resultado de la consulta
            $result = $stmt->get_result();

            //comprueba si en el resultado hay datos o está vacío
            if($result->num_rows > 0){
                //devuelve un array asociativo con los datos
                return $result->fetch_assoc();
            }
            //cierra 
            $stmt->close();
        }
        //algo falló
        return null;
    }


    
   /////////////////ESTO NO SE SI PONERLO AQUI?????
    // Devuelve un array asociativo con los datos de la clase o null si no se encuentra
    // Parámetros:
    // - $nombre: el nombre de la clase a buscar
    // Retorna:
    // - Un array asociativo con los datos de la clase si se encuentra, o null si no se encuentra
    // Ejemplo de uso:
    // $database = new Database();
    // $ClaseDB = new claseDB($database);
    //  $clase = $claseDB->getByName('Yoga');
    // if ($clase) {
    //  echo "Clase encontrada: " . $clase['nombre'];
    //  } else {
    //      echo "Clase no encontrada.";
    // }


 // Obtiene una clase por su nombre

    function getByName($nombre) {
        $sql = "SELECT * FROM {$this->table} WHERE nombre = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_assoc();
            }
            $stmt->close();
        }
        return null;
    }

function insertarClase($pdo, $nombre, $descripcion, $dia_semana, $hora, $duracion_minutos, $cupo_maximo) {
    $sql = "INSERT INTO clases (nombre, descripcion, dia_semana, hora, duracion_minutos, cupo_maximo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $descripcion, $dia_semana, $hora, $duracion_minutos, $cupo_maximo]);
}
function actualizarClase($pdo, $id, $nombre, $descripcion, $dia_semana, $hora, $duracion_minutos, $cupo_maximo) {
    $sql = "UPDATE clases SET nombre = ?, descripcion = ?, dia_semana = ?, hora = ?, duracion_minutos = ?, cupo_maximo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nombre, $descripcion, $dia_semana, $hora, $duracion_minutos, $cupo_maximo, $id]);
}
function eliminarClase($pdo, $id) {
    $sql = "DELETE FROM clases WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}
}