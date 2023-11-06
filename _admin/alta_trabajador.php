<?php
	require_once("../nucleo/constantes.php");

	// Conecta a la base de datos 
	require_once("../nucleo/conexion.php");
	//Se toman los valores de la sesion
	@session_start();

	if (!isset($_SESSION['id'])) {
	    header("Location: login");
	    exit(0);
	}
		
	if (!isset($_SESSION['tout'])) {
	    $_SESSION['tout'] = time();
	} else {
		
	    if (($_SESSION['tout'] + 3600) < time()) {  
	      @session_destroy();
	      header("Location: login");
	      exit(0);
	    }

	    $_SESSION['tout'] = time();
	}
?>

<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- ===============================================-->
	<!--    Document Title-->
	<!-- ===============================================-->
	<?php include("includes/titulo.php"); ?>
	<!-- ===============================================-->
	<!--    Favicons-->
	<!-- ===============================================-->
	<?php include("includes/Favicons.php"); ?>
	<!-- ===============================================-->
	<!--    Stylesheets-->
	<!-- ===============================================-->
	<?php include("includes/Stylesheets.php"); ?>
</head>

<body>

	<!-- ===============================================-->
	<!--    Main Content-->
	<!-- ===============================================-->
	<!-- Modal -->
	<?php include("components/modal_error.php"); ?>

	<main class="main" id="top">
		<div class="container" data-layout="container">
			<!-- MENU  -->
			<?php include("includes/botonera.php"); ?>
			<?php include("includes/menu.php"); ?>
			</nav>

			<!-- CONTENT  -->
			<div class="content">
				<?php include("includes/menu2.php"); ?>
				<div class="card">
					<div class="card-body overflow-hidden p-lg-6">
						<div class="row align-items-center">

							<div class="card-header">
								<div class="row flex-between-end">
									<div class="col-auto align-self-center">
										<h5 class="mb-0"><?php echo nombreempresa . ' '; ?><small>Alta ficha Trabajador </small></h5>
									</div>
									<div class="col-auto ms-auto">

									</div>
								</div>
							</div>

							<!-- FORMULARIO CURSO  -->
							<?php include("components/formulario_trabajador.php"); ?>
							<!-- FIN contenido -->
						</div>
					</div>
				</div>
				<?php include("includes/footer.php"); ?>
			</div>

		</div>
	</main>
	<!-- ===============================================-->
	<!--    End of Main Content-->
	<!-- ===============================================-->

	<?php include("includes/customize.php"); ?>

	<!-- ===============================================-->
	<!--    JavaScripts-->
	<!-- ===============================================-->
	<?php include("includes/javascripts.php"); ?>
	<!-- <script src="./functions/common_functions.js"> </script> -->
	<script src="./vendors/jquery/jquery.min.js"> </script>
    <script src="./vendors/datatables.net/jquery.dataTables.min.js"></script>
    <script src="./vendors/datatables.net-bs5/dataTables.bootstrap5.min.js"> </script>
    <script src="./vendors/datatables.net-fixedcolumns/dataTables.fixedColumns.min.js"> </script>
</body>

</html>