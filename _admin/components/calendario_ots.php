<style>
    #calendar {
        max-width: 1100px;
        height: 800px;
        margin: 40px auto;
    }
</style>

<div id='calendar'></div>

<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border">
            <div autocomplete="off">
                <div class="modal-header px-x1 bg-body-tertiary border-bottom-0">
                    <h5 class="modal-title">Seleccionar fechas</h5>
                    <button class="btn-close me-n1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-x1">
                    <div class="mb-3">
                        <label class="fs-0" for="eventStartDate">Fecha y hora inicial</label>
                        <input class="form-control datetimepicker" id="startDate" type="text" required name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                    </div>
                    <div class="mb-3">
                        <label class="fs-0" for="eventEndDate">Fecha y hora final</label>
                        <input class="form-control datetimepicker" id="endDate" type="text" required name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end align-items-center bg-body-tertiary border-0">
                    <button class="btn btn-primary px-4" type="button" onclick="getDate()">Seleccionar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // // ********************** CONSTRUCTOR **********************
    (function onInit() {
        loadOts();
    })();


    async function loadOts() {
        try {
            const response = await fetch('./controller/ots/buscar_ots_listado.php');
            const ots = await response?.json();
            loadCalendar(ots);
        } catch (error) {
            console.log(error)
        }
    }

    function loadCalendar(ots) {
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                timeZone: 'Europe/Madrid',
                themeSystem: 'bootstrap5',          
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                events: (ots ?? [])?.map(item => {
                    const { id: groupId, nombre: title, fecha_inicio, fecha_fin } = item ?? {};
                    return {
                        groupId,
                        title,
                        start: fecha_inicio?.replace(/ /g, 'T'),
                        ...(fecha_fin ? { end: fecha_fin?.replace(/ /g, 'T')} : {} )
                    }
                }),
                // eventColor: '#378006',
                dateClick: function(info) {
                    $("#addEventModal").modal('show');
                }
            });

            calendar.render();
        });
    }

</script> 