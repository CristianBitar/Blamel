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
        $nif=$mysqli -> real_escape_string($_POST['nif']);
        $razon_social = $mysqli->real_escape_string($_POST['razon_social']);
        $direccion = $mysqli->real_escape_string($_POST['direccion']);
        $ciudad = $mysqli->real_escape_string($_POST['ciudad']);
        $provincia=$mysqli -> real_escape_string($_POST['provincia']);
        $codigo_postal = $mysqli->real_escape_string($_POST['codigo_postal']);
        $telefono_principal = $mysqli->real_escape_string($_POST['telefono_principal']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $web = $mysqli->real_escape_string($_POST['web']);
        $email_ofertas = $mysqli->real_escape_string($_POST['email_ofertas']);
        $email_factura = $mysqli->real_escape_string($_POST['email_factura']);
        $iban = $mysqli->real_escape_string($_POST['iban']);
        $forma_pago = $mysqli->real_escape_string($_POST['forma_pago']);

        $query = "UPDATE clientes 
                  SET nombre = '$nombre', 
                  nif = '$nif',
                  razon_social = '$razon_social', 
                  direccion = '$direccion',
                  ciudad = '$ciudad', 
                  provincia = '$provincia',
                  codigo_postal = '$codigo_postal',
                  telefono_principal = '$telefono_principal',
                  email = '$email',
                  web = '$web',
                  email_ofertas = '$email_ofertas',
                  email_factura = '$email_factura',
                  iban = '$iban',
                  forma_pago = '$forma_pago'
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