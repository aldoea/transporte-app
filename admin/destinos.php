<?php  
	include "admin.header.php";
	$file_name = "destinos";
	$sql = "SELECT * FROM destino;";			
	$destinos = $admin->consultar($sql);
	$headers = array('ID', 'Pais', 'Estado', 'Ciudad', 'Precio', 'Viaticos');
	
	if (isset($_POST['eliminar'])) {
		$id_destino = $_POST['identifier'];
		$sql = "DELETE FROM destino WHERE id_destino=:id_destino";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':id_destino', $id_destino);
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
		$id_destino = isset($_POST['id_destino']) ? $_POST['id_destino'] : null;
		$pais = isset($_POST['pais']) ? $_POST['pais'] : null;
		$estado = isset($_POST['estado']) ? $_POST['estado'] : null;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
		$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
		$viatico = isset($_POST['viaticos']) ? $_POST['viaticos'] : null;
		$sql = "UPDATE destino SET
					pais = :pais,
					estado = :estado,
					ciudad = :ciudad,
					precio = :precio,
					viaticos = :viaticos
				WHERE
					id_destino = :id_destino;
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':pais',$pais);
		$stmt->bindParam(':estado',$estado);
		$stmt->bindParam(':ciudad',$ciudad);
		$stmt->bindParam(':precio',$precio);
		$stmt->bindParam(':viaticos',$viatico);
		$stmt->bindParam(':id_destino',$id_destino);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se modificaron destinos: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';		
		die();
	}
	if (isset($_POST['guardar'])) {
		$pais = isset($_POST['pais']) ? $_POST['pais'] : null;
		$estado = isset($_POST['estado']) ? $_POST['estado'] : null;
		$ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : null;
		$precio = isset($_POST['precio']) ? $_POST['precio'] : null;
		$viatico = isset($_POST['viaticos']) ? $_POST['viaticos'] : null;
		$sql = "INSERT INTO destino(
					pais,
					estado,
					ciudad,
					precio,
					viaticos
				)VALUES(
					:pais,
					:estado,
					:ciudad,
					:precio,
					:viaticos
				);
		";
		$stmt = $admin->con->prepare($sql);
		$stmt->bindParam(':pais',$pais);
		$stmt->bindParam(':estado',$estado);
		$stmt->bindParam(':ciudad',$ciudad);
		$stmt->bindParam(':precio',$precio);
		$stmt->bindParam(':viaticos',$viatico);
		$stmt->execute();
		$rows_aff = $stmt->rowCount();
		echo "Se insertaron nuevos destinos: ".$rows_aff;
		echo '</br><a href="'.$file_name.'.php">Regresar</a>';	
		die();		
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
		<a class="btn btn-success mt-2 mb-2" role="button" href="form_controller.php?form_identifier=<?php echo $file_name ?>">Nuevo Destino</a>
		<?php 
			$admin->buildAdminTable($headers, $destinos, $file_name);
		?>
	</div>	
</main>
<?php
	include "admin.footer.php";
?>
