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

            <label class="col-sm-2 col-form-label" for="razon_social">Razón social</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="razon_social" name="razon_social" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="nif">NIF</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="nif" name="nif" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="nombre">Nombre comercial</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="nombre" name="nombre" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="direccion">Dirección</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="direccion" name="direccion" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="ciudad">Ciudad</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="ciudad" name="ciudad" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="provincia">Provincia</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="provincia" name="provincia" required />
                <div class="mb-3 row"></div>
            </div>
            
            <label class="col-sm-2 col-form-label" for="codigo_postal">CP</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="codigo_postal" name="codigo_postal" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="telefono_principal">Telf. principal</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="telefono_principal" name="telefono_principal" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="email">Email</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="email" name="email" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="web">Web</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="web" name="web" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="email_ofertas">Email ofertas</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="email_ofertas" name="email_ofertas" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="email_factura">Email facturas</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="email_factura" name="email_factura" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="iban">IBAN</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="iban" name="iban" required />
                <div class="mb-3 row"></div>
            </div>


            <label class="col-sm-2 col-form-label" for="forma_pago">Forma de pago</label>
            <div class="col-sm-4">
                <select class="form-select" id="forma_pago" name="forma_pago" required>
                    <option value="null"> --Seleccionar- </option>
                    <option value="VISA"> VISA</option>
                    <option value="AMEX">AMEX</option>
                    <option value="Contado">Contado</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="30 días">30 días</option>
                    <option value="Recibo bancario">Recibo bancario</option>
                    <option value="Pagare">Pagare</option>
                    <option value="60 días">60 días</option>
                    <option value="Habitual">Habitual</option>
                </select>
                <div class="mb-3 row"></div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <p></p>
                    <a class="btn btn-falcon-primary me-1" href="listado_clientes">Volver</a>
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
    const [_, clientId] = window.location.href?.split('id=') ?? [];
    const saveBtn = document.querySelector('.saveBtn');
    const deleteBtn = document.querySelector('.deleteBtn');
    const form = document.querySelector('form'); //FORM IMPUTS
    const inputs = form.querySelectorAll('input');
    const select = form.querySelectorAll('select');
    let clienteName = '-';
    const redirectToList = './listado_clientes';
    const endpoints = {
        search: (id) => './controller/cliente/buscar_cliente.php?id=' + id,
        update: './controller/cliente/edicion_cliente.php',
        save: './controller/cliente/alta_cliente.php',
        delete: './controller/cliente/borrar_cliente.php'
    };



    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (window.location.href?.includes('editar_cliente') && !clientId) {
            window.location.href = redirectToList;
            return
        }

        if (window.location.href?.includes('alta_cliente')) {
            deleteBtn?.classList.add('hidden');
        }

        if(clientId) {
            searchItem(clientId);
        }
    })();


    async function searchItem(clientId) {
        try {
            updateSubmitButton(true, saveBtn);

            const response = await fetch(endpoints.search(clientId))
            const ots = await response.json();

            if (!Object.keys(ots ?? {}).length) {
                window.location.href = redirectToList;
                return;
            }

            clienteName = ots?.nombre ?? '-';
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
        [...inputs ?? [], clientId, ...select ?? []]?.forEach(field => {
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

        [...inputs ?? [], clientId, ...select ?? []].forEach(field => {
            const {
                id,
                value,
            } = field ?? {};
            if (!id) return;
            if (id === 'trabajadores_asignados') return;
            formData.append(id, value);
        });

        if (clientId) formData.append('id', clientId);

        const endpoint = clientId ? endpoints.update : endpoints.save;
        callService(formData, endpoint, saveBtn, true,);
    }

    async function callService(formData, url, button, redirect = true) {
        try {
            updateSubmitButton(true, button);
            const response = await fetch(url, {
                method: 'post',
                body: formData,
            });

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
        document.querySelector('#modalInputName').value = clienteName ?? '-';
    }

    function deleteAction() {
        const formData = new FormData();
        formData.append('id', clientId);
        callService(formData, endpoints.delete, deleteBtn, true, false);
    }

    function updateSubmitButton(pending = false, button) {
        button.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>
<!-- END SCRIPTS  -->