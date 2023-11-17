<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border">
            <div autocomplete="off">
                <div class="modal-header px-x1 bg-body-tertiary border-bottom-0">
                    <h5 class="modal-title">Seleccionar fechas</h5>
                    <button class="btn-close me-n1" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-x1 row">
  
                    <label class="col-sm-12 fs-0" for="eventStartDate">Fecha y hora inicial</label>
                    <input class="col-sm-12 form-control datetimepicker" id="startDate" type="text" required name="startDate" onchange="changeStartDate()"  placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                    <div class="mb-3 row"></div>

                    <label class="col-sm-12 fs-0" for="eventEndDate">Fecha y hora final</label>
                    <input class="col-sm-12 form-control datetimepicker" id="endDate" type="text" required name="endDate" onchange="changeEndDate()" placeholder="yyyy/mm/dd hh:mm" data-options='{"static":"true","enableTime":"true","dateFormat":"Y-m-d H:i"}' />
                    <div class="mb-3 row"></div>
                </div>
                <div class="modal-footer d-flex justify-content-end align-items-center bg-body-tertiary border-0">
                    <button class="btn btn-primary px-4" type="button" onclick="getDate()">Seleccionar</button>
                </div>
            </div>
        </div>
    </div>
</div>