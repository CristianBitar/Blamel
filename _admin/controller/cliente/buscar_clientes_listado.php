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
        
        $listado_clientes = array(); 
        $query = "SELECT * FROM clientes WHERE isDeleted = 0 ORDER BY id ASC";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())   {	
                $id = $row['id'];
                $nombre = $row['nombre'];
                
                array_push($listado_clientes, array(
                    'id'=>$id, 
                    'nombre'=>$nombre, 
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        echo json_encode($listado_clientes);
    }

?>



     