<?php
    require_once ("../../../nucleo/constantes.php");   
    // Conecta a la base de datos 
    require_once ("../../../nucleo/conexion.php");
    // require_once ("../../nucleo/funciones.php"); 

    //Se toman los valores de la sesion
    @session_start();

    if (!isset($_SESSION['id'])){
        header("Location: login");
        exit(0);
    }

    if(!isset($_SESSION['tout'])) {
        $_SESSION['tout'] = time();
    }
    else  {

        if(($_SESSION['tout']+3600) < time()) {

            @session_destroy();
            header("Location: login");
            exit(0);
        }

        $_SESSION['tout'] = time();
    }


    // ************** GET **************
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $listado_estados = array(); 
        $query = "SELECT * FROM estados WHERE isDeleted = 0 ORDER BY id ASC";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())   {	
                $id = $row['id'];
                $nombre = $row['estado'];
                
                array_push($listado_estados, array(
                    'id'=>$id, 
                    'estado'=>$nombre, 
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        echo json_encode($listado_estados);
    }

?>



     