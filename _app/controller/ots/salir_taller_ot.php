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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $id=$mysqli -> real_escape_string($_POST['id']);
        
        if(!$id){
            echo 'Error: id no puede estar vacio ';
        }

        // $salida_taller = $mysqli->real_escape_string($_POST['salida_taller']);

        $query = "UPDATE ots 
                  SET salida_taller = NOW(),
                  estado = '1'
                    WHERE
                    id = $id";

        /* Prepare statement */
        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo 'Error: '.$mysqli->error;
        }
        
        // Execute statement
        $stmt->execute();
        // close statement
        $stmt->close();
    }

?>