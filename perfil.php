<?php  
	include "header.php";
	if (!isset($_SESSION['validado'])) {
		header("Location: index.php");
	}
	$id_usuario = null;
	$old_email = null;
	$status_contrasena = (object)[];
	if (isset($_SESSION['id_usuario'])) {		
		$id_usuario = $_SESSION['id_usuario'];
		$old_email = $_SESSION['email'];
	}	
	// GET DATA FROM cliente
	$sql = "SELECT c.*, u.email FROM cliente c INNER JOIN usuario u ON c.id_usuario=u.id_usuario WHERE c.id_usuario=:id_usuario";
	$stmt = $dreamtour->con->prepare($sql);
	$stmt->bindParam(':id_usuario', $id_usuario);
	$stmt->execute();
	$cliente_data = $stmt->fetch(PDO::FETCH_ASSOC);

	if (isset($_POST['guardar'])) {
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$apaterno = isset($_POST['apaterno']) ? $_POST['apaterno'] : null;
		$amaterno = isset($_POST['amaterno']) ? $_POST['amaterno'] : null;
		$domicilio = isset($_POST['domicilio']) ? $_POST['domicilio'] : null;
		$new_email = isset($_POST['email']) ? $_POST['email'] : null;

		$validation_errors = [];
		if (!strlen($nombre) > 3 && !is_null($nombre)) {
			array_push($validation_errors, "Nombre no correcto");
		}
		if (!strlen($apaterno) > 3 && !is_null($apaterno)) {
			array_push($validation_errors, "Apellido paterno no correcto");
		}
		if (!strlen($amaterno) > 3 && !is_null($amaterno)) {
			array_push($validation_errors, "Apellido Materno no correcto");
		}
		if (!strlen($domicilio) > 3 && !is_null($domicilio) ) {
			array_push($validation_errors, "Domicilio no correcto");
		}
		if (!(filter_var($new_email, FILTER_VALIDATE_EMAIL) && !is_null($new_email))) {
			array_push($validation_errors, "Email incorrecto");	
		}

		if (sizeof($validation_errors) == 0) {
			$dreamtour->actualizarPerfil($nombre, $apaterno, $amaterno, $domicilio, $new_email, $old_email, $id_usuario);
		}else{
			foreach ($validation_errors as $error) {
				echo '<p class="text-warning">'.$error.'</p>';
			}
		}
	} // guardar submit

	if (isset($_POST['nueva_contrasena'])) {
		$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena']:null;
		$contrasena2 = isset($_POST['contrasena2']) ? $_POST['contrasena2']:null;

		if ($contrasena == $contrasena2) {
			if ($dreamtour->cambiar_contrasena($contrasena, $contrasena2, $id_usuario)) {
				$status_contrasena->msg = "Se ha actualizado la contraseña con exito";
				$status_contrasena->validator = true;		
			}else{
				$status_contrasena->msg = "No se puede usar la misma contraseña, favor de usar una diferente";
				$status_contrasena->validator = false;
			}

		}else{
			$status_contrasena->msg = "Las contraseñas no coinciden";
			$status_contrasena->validator = false;
		}
	}
?>
	<main class="container no-gutters mt-3 mx-auto">
		<div class="row vdivide">
			<div class="col-md-7 pr-5">
				<h1>Mi perfil</h1>
				<form class="form-group" method="post" action="perfil.php">
					<label>Nombre</label>
					<input class="form-control bg-alice mb-2" type="text" placeholder="<?php echo $cliente_data['nombre']?>" value="<?php echo $cliente_data['nombre']?>" name="nombre">

					<label>Apellido Paterno</label>
					<input class="form-control bg-alice mb-2" type="text" placeholder="<?php echo $cliente_data['apaterno']?>" value="<?php echo $cliente_data['apaterno']?>" name="apaterno">

					<label>Apellido Materno</label>
					<input class="form-control bg-alice mb-2" type="text" placeholder="<?php echo $cliente_data['amaterno']?>" value="<?php echo $cliente_data['amaterno']?>" name="amaterno">

					<label>Domicilio</label>
					<input class="form-control bg-alice mb-2" type="text" placeholder="<?php echo $cliente_data['domicilio']?>" value="<?php echo $cliente_data['domicilio']?>" name="domicilio">

					<label>Email</label>
					<input class="form-control bg-alice mb-2" type="email" placeholder="<?php echo $cliente_data['email']?>" value="<?php echo $cliente_data['email']?>" name="email">
									
					<input class="btn btn-darkorange" type="submit"  name="guardar" value="Guardar">
				</form>
			</div>
			<div class="col-md-5">
				<form class="form-group" method="post" action="perfil.php">
				    <h1>Nueva contraseña</h1>           
				    <label for="inputPassword">Nueva contraseña</label>
				    <input type="password" id="inputPassword" name="contrasena" class="form-control bg-alice mb-2" placeholder="Contraseña" required="true" autocomplete="off">
				    <label for="inputPassword2">Repetir contraseña</label>
				    <input type="password" id="inputPassword2" name="contrasena2" class="form-control bg-alice mb-2" placeholder="Repetir contraseña" required="true" autocomplete="off">
				    <input class="btn btn-darkorange" type="submit" value="Establecer nueva contraseña" name="nueva_contrasena">
				</form>
				<?php
					if (isset($status_contrasena->validator)) {
						if ($status_contrasena->validator) {
							echo '<p class="text-success bg-light">'.$status_contrasena->msg.'</p>';
						}else{
							echo '<p class="text-danger bg-light">'.$status_contrasena->msg.'</p>';
						}
					}
				?>	
			</div>		
		</div>		
	</main>
<?php  
	include "footer.php";
?>