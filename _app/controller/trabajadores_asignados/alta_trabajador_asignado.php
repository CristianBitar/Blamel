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
        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $id_trabajador=$mysqli -> real_escape_string($_POST['id_trabajador']);
        $id_ots = $mysqli->real_escape_string($_POST['id_ots']);


        $query = "INSERT INTO trabajadores_asignados (
        id, 
        id_trabajador, 
        id_ots,
        fecha_alta) VALUES 
                    (NULL,
                    '$id_trabajador',
                    '$id_ots', 
                    NOW());";

        /* Prepare statement */
        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo 'Error: '.$mysqli->error;
        }

        // Execute statement
        $stmt->execute();

        // $id_ots = $mysqli->insert_id;

        // echo json_encode($id_ots); 
        
        // close statement
        $stmt->close();
    }

?>