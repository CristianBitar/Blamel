<div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel" style="color:#000000" ;><strong>Confirme que desea borrar el registro</strong></h4>
			</div>
			<!-- <div class="modal-body">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input id="teacherName" type="text" name="nombre" class="form-control col-md-7 col-xs-12" data- name="name" type="text" disabled>
				</div>
			</div> -->
			<!-- <br> -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeModalDeleteFile()">Cancelar</button>
				<button type="button" class="btn btn-danger" onClick="deleteFile()">Eliminar</button>
			</div>
		</div>
	</div>
</div>

<script>
	function closeModalDeleteFile() {
		$("#modalConfirmacion").modal('toggle');
	}
</script>