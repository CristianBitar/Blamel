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
    <?php include("components/modal_cuota.php"); ?>

    <main class="main" id="top">
        <div class="container" data-layout="container">

            <!-- CONTENT  -->
            <div class="content">
                <?php include("includes/menu2.php"); ?>
                <div class="card">
                    <div class="card-body overflow-hidden p-lg-6">
                        <div class="row align-items-center">

                            <!-- FORMULARIO CURSO  -->
                            <form id="form" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                                <div class="card-body bg-light">
                                    <div class="mb-3 row">

                                        <label class="col-4 col-sm-2 col-form-label" for="id">Nº OT</label>
                                        <div class="col-8 col-sm-4">
                                            <input class="form-control" type="text" id="id" name="id" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="fecha_inicio">Fecha inicial</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label text-truncate" for="fecha_fin">Fecha fin</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" id="fecha_fin" name="fecha_fin" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
                                        <div class="col-sm-4">
                                            <select class="form-select" id="cliente" name="cliente" disabled>
                                            </select>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="salida_taller">Salida Taller</label>
                                        <div class="col-6 col-sm-4 salida_taller">
                                            <!-- <input class="form-control btn btn-falcon-success workShopExitBtn" type="button" value="Registrar" onclick="registerCheckOut()" /> -->
                                            <!-- <input class="form-control" type="text" id="salida_taller" name="salida_taller" disabled /> -->
                                            <!-- <div class="mb-3 row"></div> -->
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="inicio_trabajo">Inicio Trabajo</label>
                                        <div class="col-6 col-sm-4 inicio_trabajo">
                                            <!-- <input class="form-control btn btn-falcon-success initWorkBtn" type="button" value="Registrar" onclick="registerWorkInit()" /> -->
                                            <!-- <input class="form-control" type="text" id="inicio_trabajo" name="inicio_trabajo" disabled /> -->
                                            <!-- <div class="mb-3 row"></div> -->
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="parada">Parada</label>
                                        <div class="col-6 col-sm-4 parada">
                                            <!-- <input class="form-control btn btn-falcon-success stopBtn" type="button" value="Registrar" onclick="registerStall()" /> -->
                                            <!-- <input class="form-control" type="text" id="parada" name="parada" disabled /> -->
                                            <!-- <div class="mb-3 row"></div> -->
                                        </div>

                                        <label class="col-sm-12 col-form-label" for="motivo">Motivo</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" rows="4" id="motivo" name="motivo" value="" disabled></textarea>
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="continuar">Continuar</label>
                                        <div class="col-6 col-sm-4 continuar">
                                            <!-- <input class="form-control btn btn-falcon-success continueBtn" type="button" value="Registrar" onclick="registerContinue()" /> -->
                                            <!-- <input class="form-control" type="text" id="continuar" name="continuar" disabled /> -->
                                            <!-- <div class="mb-3 row"></div> -->
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="finalizar_trabajo">Finalizar trabajo</label>
                                        <div class="col-6 col-sm-4 finalizar_trabajo">
                                            <!-- <input class="form-control btn btn-falcon-success finishWorkBtn" type="button" value="Registrar" onclick="registerFinisWork()" /> -->
                                            <!-- <input class="form-control" type="text" id="finalizar_trabajo" name="finalizar_trabajo" disabled /> -->
                                            <!-- <div class="mb-3 row"></div> -->
                                        </div>

                                        <label class="col-6 col-sm-2 col-form-label" for="fecha_hora">Gastos OT</label>
                                        <div class="col-6 col-sm-4">
                                            <input class="form-control btn btn-primary addDueBtn" type="button" value="Añadir" onclick="openModalDues()" />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <div class="table-responsive scrollbar mt-3">
                                            <table class="table">
                                                <thead class="bg-200">
                                                    <tr>
                                                        <th scope="col">Gasto</th>
                                                        <th scope="col">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="dueTable">
                                                </tbody>
                                            </table>
                                        </div>

                                        <label class="col-sm-6 col-form-label">Total</label>
                                        <div class="col-sm-6">
                                            <input class="form-control total" type="text" disabled />
                                            <div class="mb-3 row"></div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3 d-flex justify-content-between">
                                                <input class="btn btn-falcon-primary me-1" type="button" value="Volver" onclick="goToDetail()"></input>
                                                <input type="button" value="Incidencia" class="btn btn-success saveBtn" onclick="goToIncidence()"></input>
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
    <script src="./vendors/jquery/jquery.min.js"> </script>
    <script src="./vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="./vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"> </script>
    <script src="./vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"> </script>
</body>

</html>

<script type="text/javascript">
    const [_, otId] = window.location.href?.split('id=') ?? [];
    const saveBtn = document.querySelector('.saveBtn');
    const addDueBtn = document.querySelector('.addDueBtn');;
    const total = document.querySelector('.total');
    const dueTable = document.querySelector('#dueTable');
    const form = document.querySelector('#form'); //FORM IMPUTS
    const inputs = form.querySelectorAll('input');
    const textarea = form.querySelectorAll('textarea');
    const select = form.querySelectorAll('select');
    const fechaHora = document.querySelector('#fecha_hora')
    const redirectToList = './listado_ots';
    const redirectToDetail = './detalle_ot?id=' + otId;
    const redirectToIncidence = './alta_incidencia?id=' + otId;
    const endpoints = {
        searchClients: './controller/cliente/buscar_clientes_listado.php',
        searchDues: (id) => './controller/gasto_ot/buscar_gastos_por_ot.php?id=' + id,
        saveDue: './controller/gasto_ot/alta_gasto_ot.php',
        search: (id) => './controller/ots/buscar_ots.php?id=' + id,
        updateWorkShoExit: './controller/ots/salir_taller_ot.php',
        updateInitWork: './controller/ots/inicio_trabajo_ot.php',
        updateStop: './controller/ots/parada_ot.php',
        updateContinue: './controller/ots/continuar_ot.php',
        updateFinishWork: './controller/ots/finalizar_trabajo_ot.php',
    };


    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (!otId) {
            window.location.href = redirectToList;
            return;
        }

        loadSelectors();
        loadBills();
    })();

    async function loadSelectors() {
        try {
            const [clientsResponse] = await Promise.allSettled([fetch(endpoints.searchClients)]);
            const clients = await clientsResponse?.value.json() ?? [];

            fillSelectors(clients);
            searchItem(otId);

        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            fillSelectors([]);
        }
    }

    async function loadBills() {
        try {
            const [duesResponse] = await Promise.allSettled([fetch(endpoints.searchDues(otId))]);
            const dues = await duesResponse?.value.json() ?? []; 
            fillBillsTable(dues);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
        }
    }

    async function searchItem(otId) {
        try {
            updateSubmitButton(true, saveBtn);

            const response = await fetch(endpoints.search(otId))
            const ots = await response.json();

            if (!Object.keys(ots ?? {}).length) {
                window.location.href = redirectToList;
                return;
            }

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
        [...inputs ?? [], ...textarea ?? [], ...select ?? []]?.forEach(field => {
            const {
                id,
                value
            } = field ?? {};

            if (!id || id === 'trabajadores_asignados') return;

            field.value = ots?.[id] ?? '';
        });

        loadRegisterActions(ots)
    }

    async function callService(formData, url, button, isBill = false, redirect = true, reloadOt) {
        try {
            updateSubmitButton(true, button);

            const response = await fetch(url, {
                method: 'post',
                body: formData,
            });

            updateSubmitButton(false, button);

            if(redirect) window.location.href = redirectToList;
            if(isBill) loadBills();
            if(reloadOt) searchItem(otId)
        } catch (error) {
            $("#errroModal").modal('show');
            updateSubmitButton(false, button);
        }
    }

    function fillSelectors(clients) {
        const clientSelector = document.querySelector('#cliente');
        clientSelector.innerHTML += clients?.length > 0 ? fillSelectorOptions(clients) : '<option value="null"> --No hay datos-- </option>';
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

    function fillBillsTable(dues) {
        let totalAmount = 0;
        dueTable.innerHTML = '';

        if(!dues?.length){
            dueTable.innerHTML = `
                <tr><td colspan="2" class="text-center">No hay datos</td></tr>
            `;
            total.value = '0 €';
            return 
        }
        
        (dues ?? [])?.forEach(item => {
            const { gasto, importe} = item ?? {};
            totalAmount += +importe
            dueTable.innerHTML += `
                <tr>
                    <td>${gasto ?? '-'}</td>
                    <td>${importe ?? '-'} €</td>
                </tr>
            `;
        });

        total.value = totalAmount?.toString() +' €';
    }

    function goToDetail() {
        window.location.href = redirectToDetail;
    }

    function goToIncidence() {
        window.location.href = redirectToIncidence;
    }

    function registerCheckOut() {
        const workShopExitBtn = document.querySelector('.workShopExitBtn');
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.updateWorkShoExit, workShopExitBtn, false, false, true);
    }

    function registerWorkInit() {
        const initWorkBtn = document.querySelector('.initWorkBtn');
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.updateInitWork, initWorkBtn, false, false, true);
    }

    function registerStall() {
        const stopBtn = document.querySelector('.stopBtn');
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.updateStop, stopBtn, false, false, true);
    }

    function registerContinue() {
        const continueBtn = document.querySelector('.continueBtn');
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.updateContinue, continueBtn, false, false, true);
    }

    function registerFinisWork() {
        const finishWorkBtn = document.querySelector('.finishWorkBtn');
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.updateFinishWork, finishWorkBtn, false, false, true); 
    }

    function openModalDues() {
        $("#modalAgregarCuotas").modal('show');
    }

    function dimissModal() {
        $("#modalAgregarCuotas").modal('hide');
    }

    function loadRegisterActions(ot) {
        const actions = {
            salida_taller: 'registerCheckOut',
            inicio_trabajo: 'registerWorkInit',
            parada: 'registerStall',
            continuar: 'registerContinue',
            finalizar_trabajo: 'registerFinisWork'
        };

        const buttons = {
            salida_taller: 'workShopExitBtn',
            inicio_trabajo: 'initWorkBtn',
            parada: 'stopBtn',
            continuar: 'continueBtn',
            finalizar_trabajo: 'finishWorkBtn'
        };

        const fields = Object.keys(actions ?? {});

        const selectedFields = Object.entries(ot ?? {})?.reduce((acc, field) => {
            const [key, value] = field ?? [];
            return {...acc,...(fields?.includes(key) ? {[key]: value} : {}) }
        },{});

        let lastIndexValue = true;
        Object.entries(selectedFields ?? {})?.forEach((item) => {
            const [key, value] = item ?? [];
            const div = document.querySelector('.'+key);
            console.log(key)
            if(value) {
                div.classList?.remove('col-6');
                div.classList?.add('col-12');
                div.innerHTML = `
                    <input class="form-control" type="text" id="${ key }" name="${ key }" disabled value="${value}" />
                    <div class="mb-3 row"></div>
                `;
            }
            else {
                const ifDisable =  key === 'parada' ? ''
                                 : key === 'finalizar_trabajo' ? (!ot?.inicio_trabajo || (ot?.inicio_trabajo && ot?.parada && !ot?.continuar) ? 'disabled' : '')
                                 : !lastIndexValue ? 'disabled' : '';

                div.classList?.add('col-6');
                div.innerHTML = `
                    <input class="form-control btn btn-falcon-success ${buttons?.[key]}" type="button" value="Registrar" onclick="${actions?.[key]}()" ${ifDisable}/> 
                    <div class="mb-3 row"></div>
                `;
            }
            lastIndexValue = value
        });
    }

    function addDue(event) {
        event?.preventDefault();
        $("#modalAgregarCuotas").modal('hide');

        const gastoInput = document.querySelector('#gasto');
        const importeInput = document.querySelector('#importe');

        const spent = gastoInput?.value;
        const amount = importeInput?.value;

        if(!spent && !amount) return;

        const formData = new FormData();
        formData.append('gasto', spent);
        formData.append('importe', amount);
        formData.append('id_ot', otId);

        callService(formData, endpoints.saveDue, addDueBtn, true, false);

        gastoInput.value = null;
        importeInput.value = null;
    }

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>