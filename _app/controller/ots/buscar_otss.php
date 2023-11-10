<?php
    // require_once ("../../../nucleo/constantes.php");   
    // // Conecta a la base de datos 
    // require_once ("../../../nucleo/conexion.php");
    // // require_once ("../../nucleo/funciones.php"); 

    // //Se toman los valores de la sesion
    // @session_start();

    // if (!isset($_SESSION['id'])){
    //     header("Location: login");
    //     exit(0);
    // }

    // if(!isset($_SESSION['tout'])) {
    //     $_SESSION['tout'] = time();
    // }
    // else  {

    //     if(($_SESSION['tout']+3600) < time()) {

    //         @session_destroy();
    //         header("Location: login");
    //         exit(0);
    //     }

    //     $_SESSION['tout'] = time();
    // }


    // ************** GET **************
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sesion_id = $_SESSION['id'];

        $listado_ots = array(); 
        $query = "SELECT ots.id, ots.nombre, ots.fecha_inicio
                    FROM ots 
                    INNER JOIN trabajadores_asignados 
                    ON ots.id = trabajadores_asignados.id_ots
                    INNER JOIN trabajadores 
                    ON trabajadores.id = trabajadores_asignados.id_trabajador
                    WHERE trabajadores.id = '$sesion_id' AND ots.isDeleted = 0 
                    ORDER BY ots.id ASC";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())   {	
                $id = $row['id'];
                $nombre = $row['nombre'];
                $fecha_inicio = $row['fecha_inicio'];

                array_push($listado_ots, array(
                    'id'=>$id, 
                    'nombre'=>$nombre, 
                    'fecha_inicio'=>$fecha_inicio, 
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        // echo json_encode($listado_ots);
    }

?>



     