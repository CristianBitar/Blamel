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
                                        <h5 class="mb-0"><?php echo nombreempresa . ' '; ?><small>OT´S asignadas</small></h5>
                                    </div>

                                </div>
                            </div>


                            <div class="card-body bg-light">
                                <div class="x_content">
                                    <table class="table">
                                        <thead class="bg-200">
                                            <tr>
                                                <th scope="col">OT</th>
                                                <th scope="col">Fecha Inicio</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dueTable">
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

<script type="text/javascript">
    const redirectToList = './detalle_ot';
    const endpoints = {
        search: './controller/ots/buscar_otss.php',
    };


    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        loadOts();
    })();


    async function loadOts() {
        try {
            const [otsResponse] = await Promise.allSettled([fetch(endpoints.search)]);
            const ots = await otsResponse?.value.json() ?? []; 
            fillTable(ots);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
        }
    }

    function fillTable(ots) {
        dueTable.innerHTML = '';

        if(!ots?.length){
            dueTable.innerHTML = `
                <tr><td colspan="2" class="text-center">No hay datos</td></tr>
            `;
            return;
        }
        
        (ots ?? [])?.forEach(item => {
            const { id, fecha_inicio } = item ?? {};
            dueTable.innerHTML += `
                <tr onclick="gotToOt(${id})">
                    <td>${id ?? '-'}</td>
                    <td>${fecha_inicio ?? '-'}</td>
                </tr>
            `;
        });
    }

    function gotToOt(id) {
        window.location.href = redirectToList + '?id=' + id;
    }
</script>

