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
        
        if(!$id){
            echo 'Error: id no puede estar vacio ';
        }

        $query = "SELECT * FROM clientes WHERE isDeleted = 0 AND id = '$id'";
        $result = $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode($row);
        }else{
            echo 'Producto no encontrado';
        }

        /* free result set */
        $result->free();
    }

?>



     