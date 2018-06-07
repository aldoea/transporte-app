<?php  
	include "admin.header.php";
	$file_name = "clientes";
	$sql = "SELECT
				c.id_cliente,
				c.nombre,
				c.apaterno,
				c.amaterno,
				c.telefono,
				c.domicilio,
				u.email 
			FROM 
				cliente c INNER JOIN usuario u 
			ON 
				c.id_usuario=u.id_usuario;";
	$clientes = $admin->consultar($sql);
	$headers = array('ID', 'Nombre', 'Apellido paterno', 'Apellido materno', 'Telefono', 'Domicilio', 'Email');
	
	if (isset($_POST['eliminar'])) {
		$id_cliente = $_POST['identifier'];
		$sql = "DELETE FROM cliente WHERE id_cliente=:id_cliente";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_cliente', $id_cliente);
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
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$apaterno = isset($_POST['apaterno']) ? $_POST['apaterno'] : null;
		$amaterno = isset($_POST['amaterno']) ? $_POST['amaterno'] : null;
		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		$domicilio = isset($_POST['domicilio']) ? $_POST['domicilio'] : null;
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		$id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : null;
		$admin->con->beginTransaction();
		try {
			// ACTUALIZA USUARIO
			$sql = "UPDATE 
						usuario 
					SET
						email=:email
					WHERE 
						id_usuario 
					IN(
						SELECT 
							cliente.id_usuario 
						FROM 
							cliente 
						WHERE 
							id_cliente=:id_cliente);";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':id_cliente', $id_cliente);
			$stmt->execute();


			// ACTUALIZA CLIENTE
			$sql = "UPDATE 
						cliente 
					SET
						nombre = :nombre,
						apaterno = :apaterno,
						amaterno = :amaterno,
						telefono = :telefono,
						domicilio = :domicilio
					WHERE 
						id_cliente=:id_cliente";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':apaterno', $apaterno);
			$stmt->bindParam(':amaterno', $amaterno);
			$stmt->bindParam(':telefono', $telefono);
			$stmt->bindParam(':domicilio', $domicilio);
			$stmt->bindParam(':id_cliente', $id_cliente);
			$stmt->execute();
			$admin->con->commit();
			$rows_aff = $stmt->rowCount();
			echo "Se modificaron clientes: ".$rows_aff;
			echo '</br><a href="'.$file_name.'.php">Regresar</a>';
		} catch (Exception $e) {
			$admin->con->rollBack();		
		}
		die();
	}
	if (isset($_POST['guardar'])) {
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$apaterno = isset($_POST['apaterno']) ? $_POST['apaterno'] : null;
		$amaterno = isset($_POST['amaterno']) ? $_POST['amaterno'] : null;
		$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
		$domicilio = isset($_POST['domicilio']) ? $_POST['domicilio'] : null;
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		$admin->con->beginTransaction();
		try {
			// INSERTA USUARIO
			$sql = "INSERT INTO usuario(email, contrasena) VALUES(:email,:contrasena)";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':email', $email);
			$contrasena = md5("passwords");
			$stmt->bindParam(':contrasena',$contrasena);
			$stmt->execute();
			$id_usuario = $admin->con->lastInsertId();
			// INSERTA ROL DE USUARIO COMO CLIENTE
			$sql = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, 1)";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':id_usuario', $id_usuario);
			$stmt->execute();
			// INSERTA CLIENTE
			$sql = "INSERT INTO cliente(
						nombre,
						apaterno,
						amaterno,
						telefono,
						domicilio,
						id_usuario
					)VALUES(
						:nombre,
						:apaterno,
						:amaterno,
						:telefono,
						:domicilio,
						:id_usuario
					);";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':apaterno', $apaterno);
			$stmt->bindParam(':amaterno', $amaterno);
			$stmt->bindParam(':telefono', $telefono);
			$stmt->bindParam(':domicilio', $domicilio);
			$stmt->bindParam(':id_usuario', $id_usuario);
			$stmt->execute();
			$admin->con->commit();
			$rows_aff = $stmt->rowCount();
			echo "Se insertaron nuevos clientes: ".$rows_aff;
			echo '</br><a href="'.$file_name.'.php">Regresar</a>';
		} catch (Exception $e) {
			$admin->con->rollBack();		
		}
		die();		
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
		<a class="btn btn-success mt-2 mb-2" role="button" href="form_controller.php?form_identifier=<?php echo $file_name ?>">Nuevo cliente</a>
		<?php 
			$admin->buildAdminTable($headers, $clientes, $file_name);
		?>
	</div>	
</main>
<?php
	include "admin.footer.php";
?>