<!-- START STYLES  -->
<style>
    table {
        border: 1px solid grey;
    }

    .td-cursor {
        cursor: pointer;
    }

    .action-button {
        cursor: pointer;
        position: relative;
    }

    .cursor {
        cursor: pointer;
    }

    .input-file {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        opacity: 0;
    }

    .hidden {
        display: none;
    }

    .avatar-size {
        width: 140px;
        height: 140px;
        border-radius: 25px;
        object-fit: cover;
    }
</style>
<!-- END STYLES  -->


<!-- GET  -->
<?php
if (isset($_GET['id'])) {
    $id_alumno = $mysqli->real_escape_string($_GET['id']);
    if (!$id_alumno) {
        echo 'Error: id no puede estar vacio ';
    }

    $listado_grupos = array();
    $query = "SELECT grupos.*, cursos.nombre AS nombre_curso, 
                (SELECT inscripcion_grupo.id 
                FROM inscripcion_grupo 
                WHERE inscripcion_grupo.id_grupo = grupos.id AND id_alumno = '$id_alumno' AND inscripcion_grupo.isDeleted = 0) AS inscripcion_grupo_id
            FROM grupos
            INNER JOIN cursos ON grupos.curso = cursos.id
            WHERE grupos.id NOT IN (
                SELECT id_grupo
                FROM inscripcion_grupo
                WHERE id_alumno = '$id_alumno' AND inscripcion_grupo.isDeleted = 0
            )
            AND grupos.isDeleted = 0
            GROUP BY grupos.id 
            ORDER BY grupos.id ASC";


    if ($result = $mysqli->query($query)) {

        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $nombre = $row['nombre'];
            $curso = $row['nombre_curso'];
            $plazas = $row['plazas'];
            $horario = $row['horario'];

            array_push($listado_grupos, array(
                'id' => $id,
                'nombre' => $nombre,
                'curso' => $curso,
                'plazas' => $plazas,
                'horario' => $horario,
            ));
        }
        /* free result set */
        $result->free();
    }
}
?>


<!-- START HTML  -->
<form id="alta_ticket" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" onsubmit="submitWorker(event)">
    <div class="card-body bg-light">
        <div class="mb-3 row">

            <div class="col-sm-12 row d-flex pb-3">
                <div class="col-sm-12 d-flex justify-content-start">
                    <img class="avatar-size" id="imagePreview" src="./img/avatarPerfil.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                </div>
                <label class="col-sm-12 col-form-label cursor d-flex justify-content-start" for="foto">
                    Foto de perfil
                    <input class="hidden" onChange="selectFile(event)" type="file" name="foto" id="foto" />
                </label>
            </div>

            <label class="col-sm-2 col-form-label" for="nombre">Nombre</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="nombre" name="nombre" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="primer_apellido">1º Apellido</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="primer_apellido" name="primer_apellido" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="segundo_apellido">2º Apellido</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="segundo_apellido" name="segundo_apellido" />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="sexo">Sexo</label>
            <div class="col-sm-4 " role="gender" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="sexo" id="man" autocomplete="off" onchange="changeSex('Hombre')">
                <label class="btn btn-outline-secondary" for="man">Hombre</label>

                <input type="radio" class="btn-check" name="sexo" id="woman" autocomplete="off" onchange="changeSex('Mujer')">
                <label class="btn btn-outline-secondary" for="woman">Mujer</label>

                <input type="radio" class="btn-check" name="sexo" id="none" autocomplete="off" onchange="changeSex('N/B')">
                <label class="btn btn-outline-secondary" for="none">N/B</label>
            </div>

            <label class="col-sm-2 col-form-label" for="fecha_nacimiento">F. Nacimiento</label>
            <div class="col-sm-4">
                <input class="form-control" type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="dni">DNI</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" id="dni" name="dni" />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="telefono">Teléfono</label>
            <div class="col-sm-4">
                <input class="form-control" type="tel" id="telefono" name="telefono" required />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="email">Email</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="email" name="email" />
                <div class="mb-3 row"></div>
            </div>

            <label class="col-sm-2 col-form-label" for="direccion">Dirección</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="direccion" name="direccion" />
                <div class="mb-3 row"></div>
            </div>

            <div class="card" style="margin-top: 10px">
                <div class="card-header">
                    <h5 class="mb-0">Acceso App</h5>
                </div>
                <div class="card-body row">
                    <label class="col-sm-2 col-form-label" for="usuario">Login</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" id="usuario" name="usuario" />
                        <div class="mb-3 row"></div>
                    </div>

                    <label class="col-sm-2 col-form-label" for="clave">Password</label>
                    <div class="col-sm-4">
                        <input class="form-control" type="password" id="clave" name="clave" />
                        <div class="mb-3 row"></div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-5">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <p></p>
                    <a class="btn btn-falcon-primary me-1" href="listado_trabajadores">Volver</a>
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
    const [_, workerId] = window.location.href?.split('id=') ?? [];
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input');

    const saveBtn = document.querySelector('.saveBtn');
    const deleteBtn = document.querySelector('.deleteBtn');

    const inputImagePreview = document.querySelector('#imagePreview');

    let file = null;
    const filePreviewDefault = './img/avatarPerfil.png';
    const excludeFields = ['man', 'woman', 'none'];
    let sexo = 'N/B';
    let workerName = '-';
    const redirectToList = './listado_trabajadores';
    const endpoints = {
        search: (id) => './controller/trabajador/buscar_trabajador.php?id=' + id,
        update: './controller/trabajador/edicion_trabajador.php',
        save: './controller/trabajador/alta_trabajador.php',
        delete: './controller/trabajador/borrar_trabajador.php',
    };


    // ********************** CONSTRUCTOR **********************
    (function onInit() {
        if (window.location.href?.includes('editar_trabajador') && !workerId) {
            window.location.href = redirectToList;
            return
        }

        limitBirthday();

        if (window.location.href?.includes('alta_trabajador')) {
            deleteBtn?.classList.add('hidden');
            return;
        }

        if (workerId) {
            searchItem(workerId);
        }
    })();


    async function searchItem(workerId) {
        try {
            updateSubmitButton(true, saveBtn);

            const response = await fetch(endpoints.search(workerId))
            const student = await response.json();

            if (!Object.keys(student ?? {}).length) {
                window.location.href = redirectToList;
                return;
            }

            workerName = student?.nombre ?? '-';
            updateSubmitButton(false, saveBtn);
            patchForm(student);
        } catch (error) {
            setTimeout(() => {
                $("#errroModal").modal('show')
            }, 500);
            updateSubmitButton(false, saveBtn);
            window.location.href = redirectToList;
        }
    }

    function patchForm(student) {
        [...inputs ?? []]?.forEach(field => {
            const {
                id,
                value
            } = field ?? {};
            if (!id) return;

            if (id === 'foto') {
                const [_, ...restUrl] = student?.foto?.split('/') ?? [];
                const url = (restUrl ?? [])?.join('/')
                inputImagePreview.src = url ? './controller/' + url : filePreviewDefault
                file = student?.foto ?? null;
                return;
            }

            if (excludeFields.includes(id)) {
                const mapRadioButton = {
                    'Hombre': 'man',
                    'Mujer': 'woman',
                    'N/B': 'none',
                };
                field.checked = mapRadioButton?.[student?.sexo] === id || mapRadioButton?.[student?.estado] === id || mapRadioButton?.[student?.convivientes] === id;
                sexo = mapRadioButton?.[student?.sexo] === id ? student?.sexo : sexo;
            } else field.value = student?.[id] ?? '';
        });
    }

    async function submitWorker(event) {
        event?.preventDefault();
        const formData = new FormData();

        [...inputs ?? []].forEach(field => {
            const {
                id,
                value
            } = field ?? {};
            if (!id || excludeFields.includes(id)) return;
            if (id === 'foto') {
                formData.append('foto', file)
                return;
            };
            formData.append(id, value);
        });

        formData.append('sexo', sexo);

        if (workerId) formData.append('id', workerId);

        const url = workerId ? endpoints.update : endpoints.save;

        callService(formData, url, saveBtn);
    }

    function openDeleteConfirmModal() {
        $("#confirmarBorrarModal").modal('show');
        document.querySelector('#modalInputName').value = workerName ?? '-';
    }

    function deleteAction() {
        const formData = new FormData();
        formData.append('id', workerId);

        callService(formData, endpoints.delete, deleteBtn);
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

    function selectFile(event) {
        const reader = new FileReader();
        if (!event.target?.files) return;
        reader.onload = (e) => {
            file = event.target.files?.[0];
            inputImagePreview.src = e.target.result ?? filePreviewDefault
            event.target.value = '';
        }

        reader.readAsDataURL(event.target.files?.[0]);
    }

    function changeSex(value) {
        sexo = value ?? null
    }

    function changeCohabitant(value) {
        convivientes = value ?? null
    }

    function changeStatus(value) {
        estado = value ?? null;
    }

    function checkboxHandleClick(event, field) {
        checkBoxes = {
            ...checkBoxes ?? {},
            [field]: event?.target?.checked
        };
    }

    function limitBirthday() {
        document.querySelector('#fecha_nacimiento')?.setAttribute('max', new Date().toISOString().split("T")[0])
    }

    function updateSubmitButton(pending = false, button) {
        button?.classList?.[pending ? 'add' : 'remove']('disabled');
        if (pending) button.setAttribute('disabled', true)
        else button.removeAttribute('disabled')
    }
</script>
<!-- END SCRIPTS  -->
<script src="./vendors/dropzone/dropzone.min.js"></script>