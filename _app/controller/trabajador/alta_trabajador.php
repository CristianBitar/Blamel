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

    $CARPETA_UPLOAD="../uploads/perfil/";

    // ************** POST **************
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $primer_apellido=$mysqli -> real_escape_string($_POST['primer_apellido']);
        $segundo_apellido = $mysqli->real_escape_string($_POST['segundo_apellido']);
        $sexo = $mysqli->real_escape_string($_POST['sexo']);
        $fecha_nacimiento = $mysqli->real_escape_string($_POST['fecha_nacimiento']);
        $dni = $mysqli->real_escape_string($_POST['dni']);
        $telefono = $mysqli->real_escape_string($_POST['telefono']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $direccion = $mysqli->real_escape_string($_POST['direccion']);
        $usuario = $mysqli->real_escape_string($_POST['usuario']);
        $clave = $mysqli->real_escape_string($_POST['clave']);

        $nombre_archivo = '';
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $nombre_archivo = $_FILES['foto']['name']; 
            $nombre_temporal1 = $_FILES['foto']['tmp_name']; 
            $tipo_archivo1 = $_FILES['foto']['type'];      
            $tamano_archivo1 = $_FILES['foto']['size']; 
           
            $fileNameCmps = explode(".", $nombre_archivo);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName1 = md5(time() . $nombre_archivo) . '.' . $fileExtension;
            $uploadFileDir = $CARPETA_UPLOAD;
            $dest_path = $uploadFileDir . $newFileName1;
        
            if(move_uploaded_file($nombre_temporal1, $dest_path))  {
                $message ='File is successfully uploaded.';
            }
            else {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        }

        $query = "INSERT INTO trabajadores (
        id, 
        nombre, 
        primer_apellido, 
        segundo_apellido, 
        sexo, 
        fecha_nacimiento, 
        dni, 
        telefono, 
        email, 
        direccion, 
        usuario, 
        clave, 
        foto,
        fecha_alta) VALUES 
                    (NULL,
                    '$nombre',
                    '$primer_apellido',
                    '$segundo_apellido', 
                    '$sexo', 
                    '$fecha_nacimiento', 
                    '$dni',
                    '$telefono',
                    '$email',
                    '$direccion',
                    '$usuario',
                    '$clave',
                    '$dest_path',
                    NOW());";

        /* Prepare statement */
        $stmt = $mysqli->prepare($query);

        if(!$stmt) {
            echo 'Error: '.$mysqli->error;
        }

        // Execute statement
        $stmt->execute();

        $id_centro = $mysqli->insert_id;

        echo json_encode($id_centro); 
        
        // close statement
        $stmt->close();
    }

?>