<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel" style="color:#000000" ;><strong>Evento</strong></h4>
            </div>
            <div class="modal-body row">
                <label class="col-sm-12 col-form-label" for="titulo">Título</label>
                <div class="col-sm-12">
                    <input class="form-control" type="titlulo" id="titulo" name="titulo" disabled />
                    <div class="mb-3 row"></div>
                </div>

                <label class="col-sm-12 col-form-label" for="modalInitDate">Fecha inicio</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="modalInitDate" name="modalInitDate" disabled />
                    <div class="mb-3 row"></div>
                </div>

                <label class="col-sm-12 col-form-label" for="modalEndDate">Fecha fin</label>
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="modalEndDate" name="modalEndDate" disabled />
                    <div class="mb-3 row"></div>
                </div>
            </div>
    
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeEventModal()">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeEventModal() {
        $("#eventDetailsModal").modal('toggle');
    }
</script>