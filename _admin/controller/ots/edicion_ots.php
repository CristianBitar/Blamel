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

        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $fecha_inicio=$mysqli -> real_escape_string($_POST['fecha_inicio']);
        $fecha_fin=$mysqli -> real_escape_string($_POST['fecha_fin']);
        $cliente = $mysqli->real_escape_string($_POST['cliente']);
        $direccion = $mysqli->real_escape_string($_POST['direccion']);
        $telefono = $mysqli->real_escape_string($_POST['telefono']);
        $contacto=$mysqli -> real_escape_string($_POST['contacto']);
        $materiales = $mysqli->real_escape_string($_POST['materiales']);
        $notas = $mysqli->real_escape_string($_POST['notas']);
        $salida_taller = $mysqli->real_escape_string($_POST['salida_taller']);
        $inicio_trabajo = $mysqli->real_escape_string($_POST['inicio_trabajo']);
        $parada = $mysqli->real_escape_string($_POST['parada']);
        $continuar = $mysqli->real_escape_string($_POST['continuar']);
        $finalizar_trabajo = $mysqli->real_escape_string($_POST['finalizar_trabajo']);

        $query = "UPDATE ots 
                  SET nombre = '$nombre', 
                  fecha_inicio = '$fecha_inicio',
                  fecha_fin = '$fecha_fin',
                  cliente = '$cliente', 
                  direccion = '$direccion',
                  telefono = '$telefono', 
                  contacto = '$contacto',
                  materiales = '$materiales',
                  notas = '$notas',
                  salida_taller = '$salida_taller',
                  inicio_trabajo = '$inicio_trabajo',
                  parada = '$parada',
                  continuar = '$continuar',
                  finalizar_trabajo = '$finalizar_trabajo'
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