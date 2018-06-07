<?php  
	include "admin.header.php";
	$file_name = "transportes";
	$sql = "SELECT id_transporte, marca, ano, color, serial, capacidad, tanque_combustible, rendimiento, kilometraje, id_tipo, costo_compra FROM transporte;";
	$transportes = $admin->consultar($sql);
	$headers = array(
		'Id_transporte',
		'Marca',
		'Año',
		'Color',
		'Serial',
		'Capacidad',
		'Tanque de combustible',
		'Rendimiento',
		'Kilometraje',
		'Tipo identificador',
		'Costo de compra'
	);

	if (isset($_POST['eliminar'])) {
		$id_transporte = $_POST['identifier'];
		$sql = "DELETE FROM transporte WHERE id_transporte=:id_transporte";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_transporte', $id_transporte);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se eliminaron: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';
		die();
	}
	if (isset($_POST['editar'])) {
		$identifier = $_POST['identifier'];
		header("Location: form_controller.php?form_identifier=".$file_name."&identifier=".$identifier."&editar=1");
		die();
	}
	if (isset($_POST['actualizar'])) {
		$id_transporte = isset($_POST['id_transporte']) ? $_POST['id_transporte'] : null;		
		$marca = isset($_POST['marca']) ? $_POST['marca'] : null;
		$ano = isset($_POST['ano']) ? $_POST['ano'] : null;
		$color = isset($_POST['color']) ? $_POST['color'] : null;
		$serial = isset($_POST['serial']) ? $_POST['serial'] : null;
		$capacidad = isset($_POST['capacidad']) ? $_POST['capacidad'] : null;
		$tanque_combustible = isset($_POST['tanque_combustible']) ? $_POST['tanque_combustible'] : null;
		$rendimiento = isset($_POST['rendimiento']) ? $_POST['rendimiento'] : null;
		$kilometraje = isset($_POST['kilometraje']) ? $_POST['kilometraje'] : null;
		$id_tipo = isset($_POST['id_tipo']) ? $_POST['id_tipo'] : null;
		$costo_compra = isset($_POST['costo_compra']) ? $_POST['costo_compra'] : null;
		$sql = "UPDATE transporte SET					
					marca=:marca,
					ano=:ano,
					color=:color,
					serial=:serial,
					capacidad=:capacidad,
					tanque_combustible=:tanque_combustible,
					rendimiento=:rendimiento,
					kilometraje=:kilometraje,
					id_tipo=:id_tipo,
					costo_compra=:costo_compra
				WHERE
					id_transporte = :id_transporte;
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_transporte', $id_transporte);
		$stmt->bindParam(':marca', $marca);
		$stmt->bindParam(':ano', $ano);
		$stmt->bindParam(':color', $color);
		$stmt->bindParam(':serial', $serial);
		$stmt->bindParam(':capacidad', $capacidad);
		$stmt->bindParam(':tanque_combustible', $tanque_combustible);
		$stmt->bindParam(':rendimiento', $rendimiento);
		$stmt->bindParam(':kilometraje', $kilometraje);
		$stmt->bindParam(':id_tipo', $id_tipo);
		$stmt->bindParam(':costo_compra', $costo_compra);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se modificaron transportes: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';		
		die();
	}
	if (isset($_POST['guardar'])) {
		$marca = isset($_POST['marca']) ? $_POST['marca'] : null;
		$ano = isset($_POST['ano']) ? $_POST['ano'] : null;
		$color = isset($_POST['color']) ? $_POST['color'] : null;
		$serial = isset($_POST['serial']) ? $_POST['serial'] : null;
		$capacidad = isset($_POST['capacidad']) ? $_POST['capacidad'] : null;
		$tanque_combustible = isset($_POST['tanque_combustible']) ? $_POST['tanque_combustible'] : null;
		$rendimiento = isset($_POST['rendimiento']) ? $_POST['rendimiento'] : null;
		$kilometraje = isset($_POST['kilometraje']) ? $_POST['kilometraje'] : null;
		$id_tipo = isset($_POST['id_tipo']) ? $_POST['id_tipo'] : null;
		$costo_compra = isset($_POST['costo_compra']) ? $_POST['costo_compra'] : null;		
		$sql = "INSERT INTO transporte(
					marca,
					ano,
					color,
					serial,
					capacidad,
					tanque_combustible,
					rendimiento,
					kilometraje,
					id_tipo,
					costo_compra
				)VALUES(
					:marca,
					:ano,
					:color,
					:serial,
					:capacidad,
					:tanque_combustible,
					:rendimiento,
					:kilometraje,
					:id_tipo,
					:costo_compra
				);
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':marca', $marca);
		$stmt->bindParam(':ano', $ano);
		$stmt->bindParam(':color', $color);
		$stmt->bindParam(':serial', $serial);
		$stmt->bindParam(':capacidad', $capacidad);
		$stmt->bindParam(':tanque_combustible', $tanque_combustible);
		$stmt->bindParam(':rendimiento', $rendimiento);
		$stmt->bindParam(':kilometraje', $kilometraje);
		$stmt->bindParam(':id_tipo', $id_tipo);
		$stmt->bindParam(':costo_compra', $costo_compra);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se insertaron nuevos transportes: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';	
		die();		
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
		<a class="btn btn-success mt-2 mb-2" role="button" href="form_controller.php?form_identifier=<?php echo $file_name ?>">Nuevo transporte</a>
		<?php 
			$admin->buildAdminTable($headers, $transportes, $file_name);
		?>
	</div>	
</main>
<?php
	include "admin.footer.php";
?>
