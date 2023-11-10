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
        $id=$mysqli -> real_escape_string($_GET['id']);

        $listado_clientes = array(); 
        $query = "SELECT gastos_ot.id, gastos_ot.gasto, gastos_ot.id_ot , gastos_ot.importe
                FROM gastos_ot 
                INNER JOIN ots 
                ON gastos_ot.id_ot = ots.id
                WHERE ots.id = '$id' AND gastos_ot.isDeleted = 0 
                ORDER BY gastos_ot.id ASC";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())   {	
                $id = $row['id'];
                $gasto = $row['gasto'];
                $importe = $row['importe'];
                
                array_push($listado_clientes, array(
                    'id'=>$id, 
                    'gasto'=>$gasto,
                    'importe'=>$importe, 
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        echo json_encode($listado_clientes);
    }

?>



     