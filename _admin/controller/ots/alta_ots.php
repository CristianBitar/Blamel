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
        $fecha_inicio=$mysqli -> real_escape_string($_POST['fecha_inicio']);
        $fecha_fin=$mysqli -> real_escape_string($_POST['fecha_fin']);
        $cliente = $mysqli->real_escape_string($_POST['cliente']);
        $estado = $mysqli->real_escape_string($_POST['estado']);
        $direccion = $mysqli->real_escape_string($_POST['direccion']);
        $telefono = $mysqli->real_escape_string($_POST['telefono']);
        $contacto=$mysqli -> real_escape_string($_POST['contacto']);
        $materiales = $mysqli->real_escape_string($_POST['materiales']);
        $incidencia = $mysqli->real_escape_string($_POST['incidencia']);

        $query = "INSERT INTO ots (
        id, 
        nombre, 
        fecha_inicio, 
        fecha_fin,
        cliente, 
        estado,
        direccion, 
        telefono, 
        contacto, 
        materiales, 
        incidencia, 
        fecha_alta) VALUES 
                    (NULL,
                    '$nombre',
                    '$fecha_inicio',
                    '$fecha_fin',
                    '$cliente', 
                    '$estado',
                    '$direccion', 
                    '$telefono', 
                    '$contacto',
                    '$materiales',
                    '$incidencia',
                    NOW());";

        /* Prepare statement */
        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo 'Error: '.$mysqli->error;
        }

        // Execute statement
        $stmt->execute();

        $id_ots = $mysqli->insert_id;

        echo json_encode($id_ots); 
        
        // close statement
        $stmt->close();
    }

?>