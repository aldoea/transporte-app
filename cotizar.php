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
		$destino = isset($_POST['destino']) ? $_POST['destino']:null;
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
		if ( !(!is_null($destino) && strlen($destino) >= 3) ) {
			array_push($validation_errors, "Destino no valido");
		}		
		if (count($validation_errors) == 0) {
			$precio = $dreamtour->cotizar($tipo, $fecha_salida, $fecha_regreso, $destino);
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
					<label class="font-weight-bold">Destino</label>
					<input type="text" id="destino" class="form-control" name="destino" placeholder="Destino..." required>
				</div>
				<button class="btn btn-lg btn-block btn-klein" name="cotizar" type="submit">Cotizar</button>
			</form>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-6 offset-md-3 text-right">
			<?php
				if (isset($precio) && !is_null($precio)) {
					echo '<span class="text-info display-4">$ '.$precio.'</span>';
				}
			?>			
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