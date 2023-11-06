<div class="modal fade" id="errroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel" style="color:#000000" ;><strong>Ha ocurrido un error inesperado</strong></h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="closeErrorModal()">Cancelar</button>
				<!-- <button type="button" class="btn btn-danger" onClick="deleteFile()">Eliminar</button> -->
			</div>
		</div>
	</div>
</div>

<script>
	function closeErrorModal() {
		$("#errroModal").modal('toggle');
	}
</script>