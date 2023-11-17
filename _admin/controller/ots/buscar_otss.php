<?php
    // require_once ("../../../nucleo/constantes.php");   
    // // Conecta a la base de datos 
    // require_once ("../../../nucleo/conexion.php");
    // // require_once ("../../nucleo/funciones.php"); 

    // //Se toman los valores de la sesion
    // @session_start();

    // if (!isset($_SESSION['id'])){
    //     header("Location: login");
    //     exit(0);
    // }

    // if(!isset($_SESSION['tout'])) {
    //     $_SESSION['tout'] = time();
    // }
    // else  {

    //     if(($_SESSION['tout']+3600) < time()) {

    //         @session_destroy();
    //         header("Location: login");
    //         exit(0);
    //     }

    //     $_SESSION['tout'] = time();
    // }


    // ************** GET **************
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $listado_ots = array(); 
        // $query = "SELECT * FROM ots WHERE isDeleted = 0 ORDER BY id ASC";
        $query = "SELECT ots.id, ots.nombre, ots.fecha_inicio, clientes.nombre AS cliente, estados.estado, estados.id AS estadoId, ots.telefono
        FROM ots 
        INNER JOIN clientes ON clientes.id = ots.cliente
        INNER JOIN estados ON estados.id = ots.estado
        WHERE ots.isDeleted = 0 ORDER BY id ASC";

        if ($result = $mysqli->query($query)) {

            while ($row = $result->fetch_assoc())   {	
                $id = $row['id'];
                $estadoId = $row['estadoId'];
                $nombre = $row['nombre'];
                $fecha_inicio = $row['fecha_inicio'];
                $cliente = $row['cliente'];
                $estado = $row['estado'];
                $telefono = $row['telefono'];
                // $contacto = $row['contacto'];
                // $materiales = $row['materiales'];
                // $notas = $row['notas'];

                array_push($listado_ots, array(
                    'id'=>$id, 
                    'estadoId'=>$estadoId, 
                    'nombre'=>$nombre, 
                    'fecha_inicio'=>$fecha_inicio,
                    'cliente'=>$cliente,
                    'estado'=>$estado,
                    'telefono'=>$telefono,
                    // 'contacto'=>$contacto,
                    // 'materiales'=>$materiales,
                    // 'notas'=>$notas,
                ));
            }
            /* free result set */
            $result->free();
        }

        // Devolvemos el array pasado a JSON como objeto
        // echo json_encode($listado_ots);
    }

?>



<!-- <span class="badge badge-subtle-success">Success</span> ACTIVA -->
<!-- <span class="badge badge-subtle-danger">Danger</span> CANCELADA  -->
<!-- <span class="badge badge-subtle-warning">Warning</span> PENDIETE  -->
<!-- <span class="badge badge-subtle-primary">Primary</span> TERMINADA  -->
<!-- <span class="badge badge-subtle-secondary">Secondary</span> CERRADA -->