<?php  
	include "admin.header.php";
	$file_name = "tipos";	
	$tipos = $admin->getTipos();
	$headers = array('ID', 'Nombre', 'Ponderante', 'Img', 'Descripcion');
	#$keys = array('id_tipo', 'rfc', 'nombre', 'apellido', 'telefono', 'calle', 'numero', 'colonia', 'ciudad', 'fecha_nacimiento', 'salario');
	
	if (isset($_POST['eliminar'])) {
		$id_tipo = $_POST['identifier'];
		$sql = "DELETE FROM tipo WHERE id_tipo=:id_tipo";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_tipo', $id_tipo);
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
		$errores = array();
		$id_tipo = isset($_POST['id_tipo']) ? $_POST['id_tipo'] : null;		
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$ponderante = isset($_POST['ponderante']) ? $_POST['ponderante'] : null;
		$origen = isset($_FILES['img']['tmp_name']) ? $_FILES['img']['tmp_name'] : null;
		$img = isset($_FILES['img']['name']) ? $_FILES['img']['name'] : null;
		$destino = "../images/unidades/".$img;
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
		if (strlen($img) == 0) {
			$sql = "SELECT img FROM tipo WHERE id_tipo=:id_tipo;";
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':id_tipo', $id_tipo);
			$stmt->execute();
			$img = $stmt->fetchObject();
			$img = $img->img;
		}
		$archivos_permitidos= array("image/jpeg","image/png");	
		$max_size = 200000;
		if ($_FILES['img']['error'] != 4) {
			if ($_FILES['img']['error'] == 0) {
				if (in_array($_FILES['img']['type'], $archivos_permitidos)) {
					if ($_FILES['img']['size'] < $max_size) {
						if (move_uploaded_file($origen, $destino)) {
							echo "Se subio la imagen correctamente";
							echo "<br/>";
						}else{
							array_push($errores, "Error desconocido, no se subio la imagen");
						}	
					}else{
						array_push($errores, "Imagen muy grande, tamaño maximo: 50KB");				
					}		
				}else{
					array_push($errores, "Archivo no valido");			
				}			
			}else{
				array_push($errores, "Error desconocido, contacte a soporte");
			}
		}

		$sql = "UPDATE tipo SET
					nombre = :nombre,
					ponderante = :ponderante,
					img = :img,
					descripcion = :descripcion
				WHERE
					id_tipo = :id_tipo;
		";
		if (sizeof($errores) == 0) {
			$stmt = $admin->con->prepare($sql);
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':ponderante', $ponderante);
			$stmt->bindParam(':img', $img);
			$stmt->bindParam(':descripcion', $descripcion);
			$stmt->bindParam(':id_tipo',$id_tipo);
			$stmt->execute();
			$rows_aff = $stmt->rowCount();
			echo "Se modificaron tipos: ".$rows_aff;
		}else{
			foreach ($errores as $error) {
				echo $error;
				echo "<br/>";
			}
		}	
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';		
		die();
	}
	if (isset($_POST['guardar'])) {
		$errores = array();
		$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
		$ponderante = isset($_POST['ponderante']) ? $_POST['ponderante'] : null;		
		$origen = isset($_FILES['img']['tmp_name']) ? $_FILES['img']['tmp_name'] : null;
		$img = isset($_FILES['img']['name']) ? $_FILES['img']['name'] : null;
		$destino = "../images/unidades/".$img;	
		$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;

		$archivos_permitidos= array("image/jpeg","image/png");	
		$max_size = 200000;
		if ($_FILES['img']['error'] != 4) {
			if ($_FILES['img']['error'] == 0) {
				if (in_array($_FILES['img']['type'], $archivos_permitidos)) {
					if ($_FILES['img']['size'] < $max_size) {
						if (move_uploaded_file($origen, $destino)) {
							echo "Se subio la imagen correctamente";
							echo "<br/>";
						}else{
							array_push($errores, "Error desconocido, no se subio la imagen");
						}	
					}else{
						array_push($errores, "Imagen muy grande, tamaño maximo: 50KB");				
					}		
				}else{
					array_push($errores, "Archivo no valido");			
				}			
			}else{
				array_push($errores, "Error desconocido, contacte a soporte");
			}
		}

		$sql = "INSERT INTO tipo(
					nombre,
					ponderante,
					img,
					descripcion
				)VALUES(
					:nombre,
					:ponderante,
					:img,
					:descripcion
				);
		";
		if (sizeof($errores) == 0) {
			$stmt = $admin->con->prepare($sql);		
			$stmt->bindParam(':nombre', $nombre);
			$stmt->bindParam(':ponderante', $ponderante);
			$stmt->bindParam(':img', $img);
			$stmt->bindParam(':descripcion', $descripcion);
			$stmt->execute();
			$rows_aff = $stmt->rowCount();
			echo "Se insertaron nuevos tipos: ".$rows_aff;
		}else{
			foreach ($errores as $error) {
				echo $error;
				echo "<br/>";
			}
		}	
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';
		die();		
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
		<a class="btn btn-success mt-2 mb-2" role="button" href="form_controller.php?form_identifier=<?php echo $file_name ?>">Nuevo tipo</a>
		<?php 
			$admin->buildAdminTable($headers, $tipos, $file_name);
		?>
	</div>	
</main>
<?php
	include "admin.footer.php";
?>
