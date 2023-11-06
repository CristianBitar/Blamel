<?php
require_once("../nucleo/constantes.php");

// Conecta a la base de datos 
require_once("../nucleo/conexion.php");
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
?>

<!-- GET  -->
<?php
include('./controller/logs/buscar_logs.php');
?>


<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <?php include("includes/titulo.php"); ?>
    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <?php include("includes/Favicons.php"); ?>
    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <?php include("includes/Stylesheets.php"); ?>
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <!-- MENU  -->
            <?php include("includes/botonera.php"); ?>
            <?php include("includes/menu.php"); ?>
            </nav>

            <!-- CONTENT  -->
            <div class="content">
                <?php include("includes/menu2.php"); ?>
                <div class="card">
                    <div class="card-body overflow-hidden p-lg-6">
                        <div class="row align-items-center">

                            <div class="card-header">
                                <div class="row flex-between-end">
                                    <div class="col-auto align-self-center">
                                        <h5 class="mb-0"><?php echo nombreempresa . ' '; ?><small>Listado de Logs de accesos </small></h5>
                                    </div>
                                    <div class="col-auto ms-auto">
                                        <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
                                            <!-- <a href="./alta_ots" class="btn btn-falcon-success btn-sm" type="button"><span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span> <span class="ms-1">Nuevo OTS</span></a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body bg-light">
                                <div class="x_content">
                                    <p class="text-muted font-13 m-b-30">
                                        Listado de accesos. Se muestran los datos más relevantes. Utilice el buscador para localizar un registro
                                    </p>

                                    <table id="userTable" class="table mb-0 data-table fs--1">
                                        <thead class="bg-200 text-900">
                                            <tr>
                                                <th class="sort" data-sort="ip">IP</th>
                                                <th class="sort" data-sort="usuario">Usuario</th>
                                                <th class="sort" data-sort="fecha">Fecha</th>
                                                <th class="sort" data-sort="panel">Panel</th>
                                                <th class="sort" data-sort="estado">Estado</th>

                                            </tr>
                                        </thead>
                                        <tbody id="tBody">
                                            <?php
                                            for ($recorrer = 0; $recorrer < count($listado_logs); $recorrer++) {
                                            ?>
                                                <tr>
                                                    <td class="ip"><?php echo $listado_logs[$recorrer]['ip']; ?></td>
                                                    <td class="usuario"><?php echo $listado_logs[$recorrer]['usuario']; ?></td>
                                                    <td class="fecha"><?php echo $listado_logs[$recorrer]['fecha']; ?></td>
                                                    <td class="panel"><?php echo $listado_logs[$recorrer]['panel']; ?></td>
                                                    <td class="estado"><?php echo $listado_logs[$recorrer]['estado']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php include("includes/footer.php"); ?>
            </div>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->
    <?php include("includes/customize.php"); ?>
    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <?php include("includes/javascripts.php"); ?>
    <script src="./vendors/jquery/jquery.min.js"> </script>
    <script src="./vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="./vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"> </script>
    <script src="./vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"> </script>
</body>


</html>