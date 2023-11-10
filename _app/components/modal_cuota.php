<div class="modal fade" id="modalAgregarCuotas" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="modal-content" onsubmit="addDue(event)">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel" style="color:#000000" ;><strong>Agregar Cuota</strong></h4>
			</div>

            <div class="modal-body">
                <label class="col-sm-2 col-form-label" for="gasto">Gasto</label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input id="gasto" type="text" name="gasto" class="form-control col-md-7 col-xs-12" required>
				</div>
			</div>

            <div class="modal-body">
                <label class="col-sm-2 col-form-label" for="importe">Importe</label>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input id="importe" type="number" name="importe" class="form-control col-md-7 col-xs-12" required>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-falcon-danger" onclick="dimissModal()">Cancelar</button>
				<button type="submit" class="btn btn-success">Agregar</button>
			</div>
		</form>
	</div>
</div>