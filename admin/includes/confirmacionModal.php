<div class="modal fade" id="confirmarBorrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel" style="color:#000000" ;><strong>Confirme que desea borrar el registro</strong></h4>
			</div>
			<div class="modal-body">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input id="modalInputName" type="text" name="nombre" class="form-control col-md-7 col-xs-12" data- name="name" type="text" disabled>
				</div>
			</div>
			<br>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeModalDelete()">Cancelar</button>
				<button type="button" class="btn btn-danger" onClick="deleteAction()">Eliminar</button>
			</div>
		</div>
	</div>
</div>

<script>
	function closeModalDelete() {
		$("#confirmarBorrarModal").modal('toggle');
	}
</script>