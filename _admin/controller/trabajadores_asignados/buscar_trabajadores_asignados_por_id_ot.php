<?php
    header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
?>

<?php
    require_once ("../../../nucleo/constantes.php");   
    // Conecta a la base de datos 
    require_once ("../../../nucleo/conexion.php");
    // require_once ("../../nucleo/funciones.php"); 

    //Se toman los valores de la sesion
    @session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: login");
        exit(0);
    }

    if (!isset($_SESSION['tout'])) {
        $_SESSION['tout'] = time();
    } else {

        if (($_SESSION['tout'] + 3600) < time()) {

            @session_destroy();
            header("Location: login");
            exit(0);
        }

        $_SESSION['tout'] = time();
    }
    
    // ************** POST **************
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id=$mysqli -> real_escape_string($_GET['id']);
        
        if(!$id){
            echo 'Error: id no puede estar vacio ';
        }

        $listado_trabajadores = array(); 
        $query = "SELECT DISTINCT trabajadores_asignados.id AS asignacion_id, trabajadores.id, trabajadores.nombre, trabajadores.primer_apellido
                FROM trabajadores
                JOIN trabajadores_asignados ON trabajadores.id = trabajadores_asignados.id_trabajador
                JOIN ots ON trabajadores_asignados.id_ots = ots.id
                WHERE ots.id = '$id' AND trabajadores.isDeleted = 0 AND trabajadores_asignados.isDeleted = 0";
        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())  {
                $asignacion_id = $row['asignacion_id'];
                $id = $row['id'];
                $nombre = $row['nombre'];
                $primer_apellido = $row['primer_apellido'];
                
                array_push($listado_trabajadores, array(
                    'asignacion_id'=>$asignacion_id, 
                    'id'=>$id, 
                    'nombre'=>$nombre, 
                    'primer_apellido'=>$primer_apellido, 
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        echo json_encode($listado_trabajadores);
    }

?>