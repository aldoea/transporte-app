<?php 
	include "header.php";	

	function validateDate($date, $format = 'Y-m-d' ){
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	$id_tipo = null;
	if (isset($_GET['id_tipo'])) {
		$id_tipo = $_GET['id_tipo'];
	}
	/*
	 __     __    _ _     _            _                       
	 \ \   / /_ _| (_) __| | __ _  ___(_) ___  _ __   ___  ___ 
	  \ \ / / _` | | |/ _` |/ _` |/ __| |/ _ \| '_ \ / _ \/ __|
	   \ V / (_| | | | (_| | (_| | (__| | (_) | | | |  __/\__ \
	    \_/ \__,_|_|_|\__,_|\__,_|\___|_|\___/|_| |_|\___||___/
	                                                           
	*/
	$precio = null;
	if ( isset($_POST['cotizar']) ) {
		$tipo = isset($_POST['tipo']) ? $_POST['tipo']:null;
		$fecha_salida = isset($_POST['fecha_salida']) ? $_POST['fecha_salida']:null;
		$fecha_regreso = isset($_POST['fecha_regreso']) ? $_POST['fecha_regreso']:null;
		$pais = isset($_POST['pais']) ? $_POST['pais']:null;
		$estado = isset($_POST['estado']) ? $_POST['estado']:null;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad']:null;
		$validation_errors = [];
		// $tipo validaciones
		if ( !is_null($tipo) && is_numeric($tipo) ) {
			if ( !count($dreamtour->getTiposById($tipo) ) > 1 ) {
				array_push($validation_errors, "Tipo de transporte no valido");
			}
		}
		// $fecha_salida & $fecha_regreso validaciones
		if ( !is_null($fecha_salida) && !is_null($fecha_regreso) ){
			if ( validateDate($fecha_salida) && validateDate($fecha_regreso) ) {
				$fecha_salida = new DateTime($fecha_salida);
				$fecha_regreso = new DateTime($fecha_regreso);
				$es_mayor = $fecha_regreso > $fecha_salida;
				if ( !$es_mayor ) {
					array_push($validation_errors, "Fechas no validas");
				}
			}else{
				array_push($validation_errors, "Fechas no validas");
			}
		}
		// $destino validaciones
		if ( !(!is_null($pais) && strlen($pais) >= 2) ) {
			array_push($validation_errors, "Pais no valido");
		}	
		if ( !(!is_null($estado) && strlen($estado) >= 2) ) {
			array_push($validation_errors, "Estado no valido");
		}	
		if ( !(!is_null($ciudad) && strlen($ciudad) >= 2) ) {
			array_push($validation_errors, "Ciudad no valido");
		}		
		if (count($validation_errors) == 0) {
			$precio = $dreamtour->cotizar($tipo, $fecha_salida, $fecha_regreso, $pais, $estado, $ciudad);
		}else{
			foreach ($validation_errors as $error) {
				echo $error;
				echo "<br/>";
			}
		}
	}
 ?>
<main role="main" class="container">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h1>Cotiza tu viaje ahora.</h1>
			<form method="post" action="cotizar.php">
				<div class="form-group">
					<label class="font-weight-bold">Selecionar transporte</label>
					<?php  include "components/transportes.dropdown.php" ?>
					<label class="font-weight-bold">Fecha salida</label>
					<input type="date" id="fecha_salida" class="form-control" name="fecha_salida" required>
					<label class="font-weight-bold">Fecha regreso</label>
					<input type="date" id="fecha_regreso" class="form-control" name="fecha_regreso" required>
					<label class="font-weight-bold">País</label>
					<input type="text" id="pais" class="form-control" name="pais" placeholder="México..." required> 
					<label class="font-weight-bold">Estado</label>
					<input type="text" id="estado" class="form-control" name="estado" placeholder="Jalisco..." required> 
					<label class="font-weight-bold">Ciudad</label>
					<input type="text" id="ciudad" class="form-control" name="ciudad" placeholder="Puerto Vallarta..." required>
				</div>
				<button class="btn btn-lg btn-block btn-klein" name="cotizar" type="submit">Cotizar</button>
			</form>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-6 offset-md-3 text-right">
			<?php
				if (isset($precio) && !is_null($precio)) :
			?>	
				<span class="display-4">
					<a href="" class="text-success" data-toggle="modal" data-target="#confirmationModal">
						Reservar:
					</a>
				</span>
				<span class="text-info display-4">$ <?php echo $precio; ?></span>;

				<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="confirmationModalLabel">Confirmar Reservacion</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								Estás a punto de realizar la reservacion ¿Deseas continuar?
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<a href="reservar.php?reservar=1" role="button" class="btn btn-success">Confirmar</a>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>		
		</div>
	</div>
</main>	
<!-- 
	Seleccionar transporte
	Seleccionar destino
	Seleccionar fechas	
 -->
<?php  
	include "footer.php";
?>