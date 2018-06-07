<?php  
	include "admin.header.php";
	$file_name = "operadores";
	$sql = "SELECT * FROM operador";
	$operadores = $admin->consultar($sql);
	$headers = array('ID', 'RFC', 'Nombre', 'Apellido', 'Telefono', 'Calle', 'Numero', 'Colonia', 'Ciudad', 'Fecha de nacimiento', 'Salario');
	#$keys = array('id_operador', 'rfc', 'nombre', 'apellido', 'telefono', 'calle', 'numero', 'colonia', 'ciudad', 'fecha_nacimiento', 'salario');
	
	if (isset($_POST['eliminar'])) {
		$id_operador = $_POST['identifier'];
		$sql = "DELETE FROM operador WHERE id_operador=:id_operador";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_operador', $id_operador);
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
		$id_operador = isset($_POST['id_operador']) ? $_POST['id_operador'] : null;
		$rfc = isset($_POST['rfc']) ? $_POST['rfc'] : null;
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : null;
		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		$calle = isset($_POST['calle']) ? $_POST['calle'] : null;
		$numero = isset($_POST['numero']) ? $_POST['numero'] : null;
		$colonia = isset($_POST['colonia']) ? $_POST['colonia'] : null;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
		$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
		$salario = isset($_POST['salario']) ? $_POST['salario'] : null;
		$sql = "UPDATE operador SET
					rfc = :rfc,
					nombre = :nombre,
					apellido = :apellido,
					telefono = :telefono,
					calle = :calle,
					numero = :numero,
					colonia = :colonia,
					ciudad = :ciudad,
					fecha_nacimiento = :fecha_nacimiento,
					salario = :salario
				WHERE
					id_operador = :id_operador;
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':rfc', $rfc);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellido', $apellido);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->bindParam(':calle', $calle);
		$stmt->bindParam(':numero', $numero);
		$stmt->bindParam(':colonia', $colonia);
		$stmt->bindParam(':ciudad', $ciudad);
		$stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
		$stmt->bindParam(':salario', $salario);
		$stmt->bindParam(':id_operador',$id_operador);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se modificaron operadores: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';		
		die();
	}
	if (isset($_POST['guardar'])) {
		$rfc = isset($_POST['rfc']) ? $_POST['rfc'] : null;
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$apellido = isset($_POST['apellido']) ? $_POST['apellido'] : null;
		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		$calle = isset($_POST['calle']) ? $_POST['calle'] : null;
		$numero = isset($_POST['numero']) ? $_POST['numero'] : null;
		$colonia = isset($_POST['colonia']) ? $_POST['colonia'] : null;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
		$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
		$salario = isset($_POST['salario']) ? $_POST['salario'] : null;
		$sql = "INSERT INTO operador(
					rfc,
					nombre,
					apellido,
					telefono,
					calle,
					numero,
					colonia,
					ciudad,
					fecha_nacimiento,
					salario
				)VALUES(
					:rfc,
					:nombre,
					:apellido,
					:telefono,
					:calle,
					:numero,
					:colonia,
					:ciudad,
					:fecha_nacimiento,
					:salario
				);
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':rfc', $rfc);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellido', $apellido);
		$stmt->bindParam(':telefono', $telefono);
		$stmt->bindParam(':calle', $calle);
		$stmt->bindParam(':numero', $numero);
		$stmt->bindParam(':colonia', $colonia);
		$stmt->bindParam(':ciudad', $ciudad);
		$stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
		$stmt->bindParam(':salario', $salario);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se insertaron nuevos operadores: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';	
		die();		
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
		<a class="btn btn-success mt-2 mb-2" role="button" href="form_controller.php?form_identifier=<?php echo $file_name ?>">Nuevo Operador</a>
		<?php 
			$admin->buildAdminTable($headers, $operadores, $file_name);
		?>
	</div>	
</main>
<?php
	include "admin.footer.php";
?>
