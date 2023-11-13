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

    <link href="./vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
</head>

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
	<!-- Modal -->
	<?php include("components/modal_error.php"); ?>

    <main class="main" id="top">
        <div class="container" data-layout="container">

            <!-- CONTENT  -->
            <div class="content">
                <?php include("includes/menu2.php"); ?>
                <div class="card">
                    <div class="card-body overflow-hidden p-lg-6">
                        <div class="row align-items-center">

                            <!-- FORMULARIO CURSO  -->
                            <form id="alta_ticket" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="submitForm(event)">
                                <div class="card-body bg-light">
                                    <div class="mb-3 row">

                                        <label class="col-4 col-sm-2 col-form-label" for="id">Nº OT</label>
                                        <div class="col-8 col-sm-4">
                                            <input class="form-control" type="text" id="id" name="id" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                    
                                        <label class="col-sm-12 col-form-label" for="incidencia">Registrar Incidencia</label>
                                        <div class="col-sm-12" >
                                            <textarea class="form-control" id="incidencia" name="incidencia" value="" rows="10"></textarea>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-between">
            
                                                <a class="btn btn-falcon-primary me-1" onclick="goToOt()">Volver</a>
                                                <input type="submit" value="Guardar" class="btn btn-success saveBtn"></input>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                            <!-- FIN contenido -->
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
    <!-- <script src="./functions/common_functions.js"> </script> -->
    <script src="./vendors/jquery/jquery.min.js"> </script>
    <script src="./vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="./vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"> </script>
    <script src="./vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"> </script>
</body>

</html>

<script type="text/javascript">
    const [_, otId] = window.location.href?.split('id=') ?? [];
    const saveBtn = document.querySelector('.saveBtn');
    const nameInput = document.querySelector('#id');
    const incidenceTextArea = document.querySelector('#incidencia');
    const redirectToList = './listado_ots';
    const goToDetail = './edicion_ot?id=' + otId;
    const endpoints = {
        search: (id) => './controller/ots/buscar_ots.php?id=' + id,
        update: './controller/ots/edicion_ots_incidencia.php',
    };


    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (!otId) {
            window.location.href = redirectToList;
            return;
        }
        
        searchItem(otId)
    })();


    async function searchItem(otId) {
        try {
            updateSubmitButton(true, saveBtn);

            const response = await fetch(endpoints.search(otId))
            const ots = await response.json();

            if (!Object.keys(ots ?? {}).length) {
                window.location.href = redirectToList;
                return;
            }

            otsName = ots?.nombre ?? '-';
            updateSubmitButton(false, saveBtn);
            patchForm(ots);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            updateSubmitButton(false, saveBtn);
            window.location.href = redirectToList;
        }
    }

    function patchForm(ots) {
        nameInput.value = ots?.id;
        incidenceTextArea.value = ots?.incidencia;
    }

    async function submitForm(event) {
        event.preventDefault();
        const formData = new FormData();
  
        formData.append('id', otId);
        formData.append('incidencia', incidenceTextArea.value);

        callService(formData, endpoints.update, saveBtn);
    }

    async function callService(formData, url, button) {
        try {
            updateSubmitButton(true, button);
            const response = await fetch(url, {
                method: 'post',
                body: formData,
            });

            updateSubmitButton(false, button);
            window.location.href = redirectToList;
        } catch (error) {
            $("#errroModal").modal('show');
            updateSubmitButton(false, button);
        }
    }

    function goToOt() {
        window.location.href = goToDetail
    }

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>