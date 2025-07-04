<?php
/**
 * Se encarga de interactuar con la base de datos con la tabla libro hay que crear una clase por cada tabla en este caso solo tenemos una tabla entonces hacemos solo una clase, (clase libro db) para hacerle consultas a la base de datos.
 */
class inscripcionclaseDBDB {

    private $db;
    private $table = 'inscripciones_clases';
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
            $inscripciones = [];
            //en cada vuelta obtengo un array asociativo con los datos de una fila y lo guardo en la variable $row
            //cuando ya no quedan filas que recorrer termina el bucle
            while($row = $resultado->fetch_assoc()){
                //al array libros le añado $row 
                $inscripciones[] = $row;
            }
            //devolvemos el resultado
            return $inscripciones;
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
/**
 * Inserta una nueva inscripción en la tabla inscripciones_clases
 * @param int $id_entrenador ID del entrenador
 * @param int $id_clase ID de la clase
 * @return bool True si se insertó correctamente, false en caso contrario
 */
/*nose si poner esto

function insertarInscripcion($id_entrenador, $id_clase) {
    global $pdo; // Asegúrate de que $pdo está definido en tu contexto

    $sql = "INSERT INTO inscripciones_clases (id_entrenador, id_clase) VALUES (:id_entrenador, :id_clase)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_entrenador', $id_entrenador);
    $stmt->bindParam(':id_clase', $id_clase);

    return $stmt->execute();
}*/

function insertarInscripcion($pdo, $id_entrenador, $id_clase) {
    $sql = "INSERT INTO inscripciones_clases (id_entrenador, id_clase) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_entrenador, $id_clase]);
}
/**
 * Obtiene todas las inscripciones de la tabla inscripciones_clases
 * @return array Array de inscripciones
 */
function obtenerInscripciones($pdo) {
    $sql = "SELECT * FROM inscripciones_clases";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Elimina una inscripción de la tabla inscripciones_clases
 * @param int $id ID de la inscripción a eliminar
 * @return bool True si se eliminó correctamente, false en caso contrario
 */
function eliminarInscripcion($pdo, $id) {
    $sql = "DELETE FROM inscripciones_clases WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id]);
}
/**
 * Actualiza una inscripción en la tabla inscripciones_clases
 * @param int $id ID de la inscripción a actualizar
 * @param int $id_entrenador Nuevo ID del entrenador
 * @param int $id_clase Nuevo ID de la clase
 * @return bool True si se actualizó correctamente, false en caso contrario
 */
function actualizarInscripcion($pdo, $id, $id_entrenador, $id_clase) {
    $sql = "UPDATE inscripciones_clases SET id_entrenador = ?, id_clase = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$id_entrenador, $id_clase, $id]);
}
/**
 * Obtiene las inscripciones de un entrenador específico
 * @param int $id_entrenador ID del entrenador
 * @return array Array de inscripciones del entrenador
 */
function obtenerInscripcionesPorEntrenador($pdo, $id_entrenador) {
    $sql = "SELECT * FROM inscripciones_clases WHERE id_entrenador = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_entrenador]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/////////////QUE ES ESTO?///////////
/**
 * Obtiene las inscripciones de una clase específica
 * @param int $id_clase ID de la clase
 * @return array Array de inscripciones de la clase
 */
function obtenerInscripcionesPorClase($pdo, $id_clase) {
    $sql = "SELECT * FROM inscripciones_clases WHERE id_clase = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_clase]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Comprueba si un entrenador está inscrito en una clase específica
 * @param int $id_entrenador ID del entrenador
 * @param int $id_clase ID de la clase
 * @return bool True si el entrenador está inscrito, false en caso contrario
 */
function estaInscrito($pdo, $id_entrenador, $id_clase) {
    $sql = "SELECT COUNT(*) FROM inscripciones_clases WHERE id_entrenador = ? AND id_clase = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_entrenador, $id_clase]);
    return $stmt->fetchColumn() > 0;}

}