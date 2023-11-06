<!-- START STYLES  -->
<style>
    .cursor {
        cursor: pointer;
    }

    .hidden {
        display: none;
    }
</style>
<!-- END STYLES  -->



<!-- START HTML  -->
<form id="alta_ticket" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="submitForm(event)">
    <div class="card-body bg-light">
        <div class="mb-3 row">

            <label class="col-sm-2 col-form-label" for="nombre">Nº OT</label>
            <div class="col-sm-6">
                <input class="form-control" type="text" id="nombre" name="nombre" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="fecha_hora">Fecha y Hora</label>
            <div class="col-sm-2">
                <input class="form-control" type="date" id="fecha_hora" name="fecha_hora" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="cliente">Cliente</label>
            <div class="col-sm-6">
                <select class="form-select" id="cliente" name="cliente" required>
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="estado">Estado</label>
            <div class="col-sm-2">
                <select class="form-select" id="estado" name="estado" required>
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-3 col-form-label" for="trabajadores_asignados">Trabajadores asignados</label>
            <div class="col-sm-9">
                <select class="form-select" multiple id="trabajadores_asignados" name="trabajadores_asignados" required>
                </select>
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="direccion">Dirección</label>
            <div class="col-sm-10">
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

            <label class="col-sm-12 col-form-label" for="notas">Notas / Incidencias</label>
            <div class="col-sm-12">
                <textarea class="form-control" type="date" id="notas" name="notas" value=""></textarea>
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
    let otsName = '-';
    const redirectToList = './listado_ots';
    const endpoints = {
        searchAssignedWorkers: './controller/trabajador/buscar_trabajadores_listado.php',
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
            const [workerAssinedResponse, statusResponse, clientsResponse] = await Promise.allSettled([
                fetch(endpoints.searchAssignedWorkers),
                fetch(endpoints.searchStatus),
                fetch(endpoints.searchClients),
            ]);
            const workersAssigned = await workerAssinedResponse?.value.json() ?? []; //TODO CURSOS ACTIVOS
            const status = await statusResponse?.value.json() ?? [];
            const clients = await clientsResponse?.value.json() ?? [];
            // workersSelecteds = workersAssigned?.reduce((acc, item) => ({...acc, [item?.id]: false}), {});

            fillSelectors(workersAssigned, status?.map(item => ({
                ...item,
                nombre: item?.estado
            })), clients);

            if (otId) { //CARGAR USUARIO POR LA ASINCRONIA
                searchItem(otId);
            }
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            fillSelectors([], [], []);
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
            if (!id) return;

            field.value = ots?.[id] ?? '';
        });
    }

    async function submitForm(event) {
        event.preventDefault();

        const formData = new FormData();

        [...inputs ?? [], ...textarea ?? [], ...select ?? []].forEach(field => {
            const {
                id,
                value,
            } = field ?? {};
            if (!id) return;
            if (id === 'trabajadores_asignados') return;
            formData.append(id, value);
        });

        if (otId) formData.append('id', otId);

        const endpoint = otId ? endpoints.update : endpoints.save;
        callService(formData, endpoint, saveBtn, true,);
    }

    async function callService(formData, url, button, redirect = true, isSaveOrUpdate = true) {
        try {
            updateSubmitButton(true, button);
            const response = await fetch(url, {
                method: 'post',
                body: formData,
            });


            if(isSaveOrUpdate){
                const idOts = await response?.json() ?? null;

                for (let option of document.querySelector('#trabajadores_asignados')?.options ?? []) {
                    const {
                        value,
                        selected
                    } = option ?? {};
                    if (selected) {
                        await saveWorkersAssigned(endpoints?.saveAssignedWorkers, value, idOts ?? otId);
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

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>
<!-- END SCRIPTS  -->