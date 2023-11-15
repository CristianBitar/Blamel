<!-- START STYLES  -->
<style>
    .cursor {
        cursor: pointer;
    }

    .hidden {
        display: none;
    }

    #collapseExample {
        margin-top: 20px; 
        height: 800px;
    }
</style>
<!-- END STYLES  -->


<!-- START HTML  -->
<form id="alta_ticket" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="submitForm(event)">
    <div class="card-body bg-light">
        <div class="mb-3 row">

            <label class="col-sm-2 col-form-label" for="nombre">Nº OT</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="nombre" name="nombre" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="fecha_hora">Fecha y Hora</label>
            <div class="col-sm-4 row">
                <input class="form-control" type="text" id="fecha_hora" name="fecha_hora" required disabled/>
                <button type="button" class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Ver calendario</button>
                <div class="mb-3 row"></div>
            </div>

            <div class="collapse" id="collapseExample">
                <!-- TABLA GRUPOS POR CURSO  -->
                <div class="card">
                    <div class="card-body">
                    <?php include("components/calendario_ots.php"); ?>
                    </div>
                </div>

                <!-- END HTML  -->
            </div>

            <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
            <div class="col-sm-4">
                <select class="form-select" id="cliente" name="cliente" required>
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="estado">Estado</label>
            <div class="col-sm-4">
                <select class="form-select" id="estado" name="estado" required>
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label text-truncate" for="trabajadores_asignados">Trabajadores asignados</label>
            <div class="col-sm-4">
                <input class="form-control cursor text-truncate" type="button" id="trabajadores_asignados" name="trabajadores_asignados"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
                <div class="dropdown-menu" aria-labelledby="disabledLinkExample" id="accordion">
                </div>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="direccion">Dirección</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="direccion" name="direccion" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="telefono">Teléfono</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="telefono" name="telefono" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="contacto">P. Contacto</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="contacto" name="contacto" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-12 col-form-label" for="materiales">Materiales necesarios</label>
            <div class="col-sm-12">
                <textarea class="form-control" type="date" id="materiales" name="materiales" value=""></textarea>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-12 col-form-label" for="incidencia">Notas / Incidencias</label>
            <div class="col-sm-12">
                <textarea class="form-control" type="date" id="incidencia" name="incidencia" value=""></textarea>
                <div class="mb-3 row"></div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <p></p>
                    <a class="btn btn-falcon-primary me-1" href="listado_ots">Volver</a>
                    <input type="submit" value="Guardar" class="btn btn-success saveBtn"></input>
                    <button type="button" class="btn btn-danger btn-xs deleteBtn" onclick="openDeleteConfirmModal()"><i class="far fa-trash-alt"></i></button>
                </div>
            </div>


        </div>
    </div>
</form>
<!-- END HTML  -->



<!-- START SCRIPTS  -->
<script type="text/javascript">
    const [_, otId] = window.location.href?.split('id=') ?? [];
    const saveBtn = document.querySelector('.saveBtn');
    const deleteBtn = document.querySelector('.deleteBtn');
    const form = document.querySelector('form'); //FORM IMPUTS
    const inputs = form.querySelectorAll('input');
    const textarea = form.querySelectorAll('textarea');
    const select = form.querySelectorAll('select');
    const fechaHora = document.querySelector('#fecha_hora')
    let selectedWorkers = {};
    let workers = [];
    let patchValueSelectedWorkres = [];
    let otsName = '-';
    let fechaInicio = '-';
    let fechaFin = '-'
    const redirectToList = './listado_ots';
    const endpoints = {
        searchWorkres: './controller/trabajador/buscar_trabajadores_listado.php',
        searchAssignedWorkersByIdOt: (id) => './controller/trabajadores_asignados/buscar_trabajadores_asignados_por_id_ot.php?id=' + id,
        deleteAssignedWorkers: './controller/trabajadores_asignados/borrar_trabajadores_asignados.php',
        saveAssignedWorkers: './controller/trabajadores_asignados/alta_trabajador_asignado.php',
        searchStatus: './controller/estado/buscar_estados_listado.php',
        searchClients: './controller/cliente/buscar_clientes_listado.php',
        search: (id) => './controller/ots/buscar_ots.php?id=' + id,
        update: './controller/ots/edicion_ots.php',
        save: './controller/ots/alta_ots.php',
        delete: './controller/ots/borrar_ots.php'
    };



    // // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (window.location.href?.includes('editar_ots') && !otId) {
            window.location.href = redirectToList;
            return
        }

        loadSelectors();

        if (window.location.href?.includes('alta_ots')) {
            deleteBtn?.classList.add('hidden');
        }
    })();


    async function loadSelectors() {
        try {
            const [workersResponse, statusResponse, clientsResponse, workerAssinedSelectedResponse] = await Promise.allSettled([
                fetch(endpoints.searchWorkres),
                fetch(endpoints.searchStatus),
                fetch(endpoints.searchClients),
                ...(otId ? [ fetch(endpoints.searchAssignedWorkersByIdOt(otId)) ] : [])
            ]);

            workers = await workersResponse?.value.json() ?? []; 
            const status = await statusResponse?.value.json() ?? [];
            const clients = await clientsResponse?.value.json() ?? [];
            const workerAssinedSelected = await workerAssinedSelectedResponse?.value?.json();

            patchValueSelectedWorkres = [...workerAssinedSelected ?? []];

            fillSelectors(status?.map(item => ({
                ...item,
                nombre: item?.estado
            })), clients);

            selectedWorkers = (workerAssinedSelected ?? [])?.reduce((acc, item) => ({...acc, [item?.id]: true}),{});

            fillCheckbox(workers);
            fillWorkesInput()

            if (otId) { //CARGAR USUARIO POR LA ASINCRONIA
                searchItem(otId);
            }
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            fillSelectors([], []);
            fillCheckbox([]);
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
        [...inputs ?? [], ...textarea ?? [], ...select ?? []]?.forEach(field => {
            const {
                id,
                value
            } = field ?? {};
            if (!id || id === 'trabajadores_asignados') return;
            if(id === 'fecha_hora') {
                field.value = ots?.['fecha_inicio'] +' / '+ ots?.['fecha_fin'];
                return 
            }
            field.value = ots?.[id] ?? '';
        });
    }

    async function submitForm(event) {
        event?.preventDefault();

        const formData = new FormData();

        [...inputs ?? [], ...textarea ?? [], ...select ?? []].forEach(field => {
            const {
                id,
                value,
            } = field ?? {};
            if (!id) return;
            if (['trabajadores_asignados', 'fecha_hora', 'startDate', 'endDate'].includes(id)) return;

            formData.append(id, value);
        });

        formData.append('fecha_inicio', fechaInicio);
        formData.append('fecha_fin', fechaFin);

        if (otId) formData.append('id', otId);

        const endpoint = otId ? endpoints.update : endpoints.save;

        callService(formData, endpoint, saveBtn, true, otId);
    }

    async function callService(formData, url, button, redirect = true, isSaveOrUpdate = true) {
        try {
            updateSubmitButton(true, button);
            const response = await fetch(url, {
                method: 'post',
                body: formData,
            });


            if(isSaveOrUpdate){
                const idOts = otId ? otId : await response?.json() ?? null;

                const patchValueSelectedWorkresIds = (patchValueSelectedWorkres ?? [])?.map(item => item?.id);
                const selectedIds = getSelectedId();
                const savedWorkers = selectedIds?.filter(id => !patchValueSelectedWorkresIds?.includes(id));
                const deleteWorkes = patchValueSelectedWorkres?.reduce((acc, item) => ([...acc, ...(!selectedIds?.includes(item?.id)) ? [item?.asignacion_id] : []]),[])
                
                if(savedWorkers?.length > 0){
                    for (let workerId of savedWorkers ?? []) {
                        await saveWorkersAssigned(endpoints?.saveAssignedWorkers, workerId, idOts ?? otId);
                    }
                }

                if(deleteWorkes?.length > 0){
                    for (let workerAsignedId of deleteWorkes ?? []) {
                        await deleteWorkersAssigned(endpoints?.deleteAssignedWorkers, workerAsignedId);
                    }
                }
            }

            updateSubmitButton(false, button);
            if (redirect) window.location.href = redirectToList;
        } catch (error) {
            $("#errroModal").modal('show');
            updateSubmitButton(false, button);
            console.log(error)
        }
    }

    function openDeleteConfirmModal() {
        $("#confirmarBorrarModal").modal('show');
        document.querySelector('#modalInputName').value = otsName ?? '-';
    }

    function deleteAction() {
        const formData = new FormData();
        formData.append('id', otId);
        callService(formData, endpoints.delete, deleteBtn, true, false);
    }

    async function saveWorkersAssigned(url, id_trabajador, id_ots) {
        const formData = new FormData();
        formData.append('id_trabajador', id_trabajador);
        formData.append('id_ots', id_ots);
        return await fetch(url, {
            method: 'post',
            body: formData
        });
    }

    async function deleteWorkersAssigned(url, id) {
        const formData = new FormData();
        formData.append('id', id);
        return await fetch(url, {
            method: 'post',
            body: formData
        });
    }

    function fillSelectors(status, clients) {
        const clientSelector = document.querySelector('#cliente');
        const statusSelector = document.querySelector('#estado');
        clientSelector.innerHTML += clients?.length > 0 ? fillSelectorOptions(clients) : '<option value="null"> --No hay datos-- </option>';
        statusSelector.innerHTML += status?.length > 0 ? fillSelectorOptions(status) : '<option value="null"> --No hay datos-- </option>';
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

    function fillCheckbox(workers) {
        const accordion = document.querySelector('#accordion');
        (workers ?? [])?.forEach(item => {
            accordion.innerHTML +=
            `<div class="dropdown-item">
                <input class="form-check-input checkbox" type="checkbox" value="" id="${item?.id}" ${selectedWorkers?.[item?.id] ? 'checked' : null} onchange="onchangeCheckbox('${item?.id}')">
                <label class="flex align-items-center" for="${item?.id}">
                    ${ item?.nombre } ${ item?.primer_apellido ?? '' }
                </label>
            </div>`;
        })
    }

    function onchangeCheckbox(workerId) {
        selectedWorkers = {
            ...selectedWorkers,
            [workerId]: !selectedWorkers?.[workerId]
        };

        fillWorkesInput();
    }

    function fillWorkesInput() {    
        const inputWorkers = document.querySelector('#trabajadores_asignados');    
        const selectedId = getSelectedId();

        const workersSelecteds = (workers ?? [])?.filter(item => selectedId?.includes(item?.id))
        inputWorkers.value = '';
        (workersSelecteds ?? [])?.forEach((item, idx) => inputWorkers.value += item?.nombre + ' ' + item?.primer_apellido + ( idx < workersSelecteds?.length - 1 ? ', ' : ' '));
    }

    function getSelectedId() {
        return Object.entries(selectedWorkers ?? {})?.reduce((acc, item) => {
            const [id, bool] = item ?? []
            return [...acc, ...(bool ? [id] : []) ]
        }, []);
    }

    function getDate() {
        $("#addEventModal").modal('toggle');
        fechaInicio = document.querySelector('#startDate').value;
        fechaFin = document.querySelector('#endDate').value;
        fechaHora.value = fechaInicio +' / '+ fechaFin
    }

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>
<!-- END SCRIPTS  -->