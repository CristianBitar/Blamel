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
    <?php include("includes/confirmacionModal.php"); ?>
    <?php include("components/modal_error.php"); ?>

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
                                        <h5 class="mb-0"><?php echo nombreempresa . ' '; ?><small>Modificar ficha OT </small></h5>
                                    </div>
                                    <div class="col-auto ms-auto">

                                    </div>
                                </div>
                            </div>

                            <!-- FORMULARIO CURSO  -->
                            <form id="form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <div class="card-body bg-light">
                                    <div class="mb-3 row">

                                        <label class="col-sm-2 col-form-label" for="id">Nº OT</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="id" name="id" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="fecha_hora">Fecha y Hora</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="fecha_hora" name="fecha_hora" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="estado">Estado</label>
                                        <div class="col-sm-4">
                                            <select class="form-select" id="estado" name="estado" disabled>
                                            </select>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-3 col-form-label" for="trabajadores_asignados">Trabajadores asignados</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="trabajadores_asignados" name="trabajadores_asignados" value="" rows="4" disabled></textarea>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
                                        <div class="col-sm-4">
                                            <select class="form-select" id="cliente" name="cliente" disabled>
                                            </select>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="direccion">Dirección</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="direccion" name="direccion" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="contacto">P. Contacto</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="contacto" name="contacto" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>
                                        
                                        <label class="col-sm-2 col-form-label" for="telefono">Teléfono</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="telefono" name="telefono" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-12 col-form-label" for="materiales">Materiales necesarios</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" id="materiales" name="materiales" value="" disabled></textarea>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-12 col-form-label" for="notas">Notas / Incidencias</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" id="notas" name="notas" value="" disabled></textarea>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-between">
                                                <!-- <p></p> -->
                                                <a class="btn btn-falcon-primary me-1" href="listado_ots">Volver</a>
                                                <input type="button" value="Gestionar" class="btn btn-success saveBtn" onclick="goToIncidence()"></input>
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
    const form = document.querySelector('form'); //FORM IMPUTS
    const inputs = form.querySelectorAll('input');
    const textarea = form.querySelectorAll('textarea');
    const select = form.querySelectorAll('select');
    const fechaHora = document.querySelector('#fecha_hora')
    const redirectToList = './listado_ots';
    const goToDetail = './edicion_ot?id=' + otId;
    const endpoints = {
        searchAssignedWorkers: './controller/trabajador/buscar_trabajadores_listado.php',
        searchClients: './controller/cliente/buscar_clientes_listado.php',
        searchStatus: './controller/estado/buscar_estados_listado.php',
        search: (id) => './controller/ots/buscar_ots.php?id=' + id,
    };


    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (!otId) {
            window.location.href = redirectToList;
            return;
        }
        
        loadSelectors();
    })();

    async function loadSelectors() {
        try {
            const [workerAssinedResponse, statusResponse, clientsResponse] = await Promise.allSettled([
                fetch(endpoints.searchAssignedWorkers),
                fetch(endpoints.searchStatus),
                fetch(endpoints.searchClients),
            ]);
            const workersAssigned = await workerAssinedResponse?.value.json() ?? []; //TODO CURSOS ACTIVOS
            const status = await statusResponse?.value.json() ?? [];
            const clients = await clientsResponse?.value.json() ?? [];

            fillSelectors(workersAssigned, status?.map(item => ({
                ...item,
                nombre: item?.estado
            })), clients);

            searchItem(otId, workersAssigned);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            fillSelectors([], [], []);
        }
    }

    async function searchItem(otId, workersAssigned) {
        try {
            updateSubmitButton(true, saveBtn);

            const response = await fetch(endpoints.search(otId))
            const ots = await response.json();

            if (!Object.keys(ots ?? {}).length) {
                window.location.href = redirectToList;
                return;
            }

            updateSubmitButton(false, saveBtn);
            patchForm(ots, workersAssigned);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            updateSubmitButton(false, saveBtn);
            window.location.href = redirectToList;
        }
    }

    function patchForm(ots, workersAssigned) {
        [...inputs ?? [], ...textarea ?? [], ...select ?? []]?.forEach(field => {
            const {
                id,
                value
            } = field ?? {};
            if (!id) return;

            if (id === 'fecha_hora') {
                field.value = ots?.['fecha_inicio'] + ' / ' + ots?.['fecha_fin'];
                return

            }
            if(id === 'trabajadores_asignados'){
                field.value = workersAssigned?.map(worker => worker?.nombre + ' ' +worker?.primer_apellido ?? '')?.join('\n');
                return 
            }

            field.value = ots?.[id] ?? '';
        });
    }

    function fillSelectors(workedAssigned, status, clients) {
        const clientSelector = document.querySelector('#cliente');
        const statusSelector = document.querySelector('#estado');
        const workedAssignedSelector = document.querySelector('#trabajadores_asignados'); //TODO

        clientSelector.innerHTML += clients?.length > 0 ? fillSelectorOptions(clients) : '<option value="null"> --No hay datos-- </option>';
        statusSelector.innerHTML += status?.length > 0 ? fillSelectorOptions(status) : '<option value="null"> --No hay datos-- </option>';
        workedAssignedSelector.innerHTML += workedAssigned?.length > 0 ? fillSelectorOptions(workedAssigned) : '<option value="null"> --No hay datos-- </option>';
    }

    function fillSelectorOptions(items) {
        return (items ?? [])?.map(item => {
            const {
                id,
                nombre,
            } = item ?? {};
            const label = nombre;
            return `<option value="${id}">${label ?? '-'}</option>`
        })?.join(',')?.replace(/,/g, '')
    }

    function goToIncidence() {
        window.location.href = goToDetail;
    }

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>