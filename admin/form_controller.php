<?php 
	include "admin.header.php";
	$form_dicc = array();
	$editable = false;
	$form_dicc['clientes'] = array(
		'id_cliente' => 'ID',
		'nombre' 	 => 'Nombre',
	 	'apaterno' 	 => 'Apellido paterno',
	 	'amaterno' 	 => 'Apellido materno',
	 	'telefono' 	 => 'Telefono',
	 	'domicilio'  => 'Domicilio',
	 	'email' 	 => 'Email'
	);
	$form_dicc['destinos'] = array(
		'id_destino' => 'ID',
		'pais' => 'Pais',
		'estado' => 'Estado',
		'ciudad' => 'Ciudad',
		'precio' => 'Precio',
		'viaticos' => 'Viaticos'
	);
	$form_dicc['operadores'] = array(
		'id_operador' => 'ID',
		'rfc' => 'RFC',
		'nombre' => 'Nombre',
		'apellido' => 'Apellido',
		'telefono' => 'Telefono',
		'calle' => 'Calle',
		'numero' => 'Numero',
		'colonia' => 'Colonia',
		'ciudad' => 'Ciudad',
		'fecha_nacimiento' => 'Fecha de nacimiento',
		'salario' => 'Salario'
	);
	$form_dicc['tipos'] = array(
		'id_tipo' => 'ID',
		'nombre' => 'Nombre',
		'ponderante' => 'Ponderante',
		'img' => 'Img',
		'descripcion' => 'Descripcion'
	);
	$form_dicc['transportes'] = array(
		'id_transporte' => 'Id_transporte',
		'marca' => 'Marca',
		'ano' => 'Año',
		'color' => 'Color',
		'serial' => 'Serial',
		'capacidad' => 'Capacidad',
		'tanque_combustible' => 'Tanque de combustible',
		'rendimiento' => 'Rendimiento',
		'kilometraje' => 'Kilometraje',
		'id_tipo' => 'Tipo identificador',
		'costo_compra' => 'Costo de compra'
	);

	$form_identifier = isset($_GET['form_identifier']) ? $_GET['form_identifier'] : null;
	$file_name = $form_identifier;
	$form_data = array();
	if (!is_null($form_identifier)) {
		if (array_key_exists($form_identifier, $form_dicc)) {
			$form_data = $form_dicc[$form_identifier];
		}else{
			die("No existe ese formulario");
		}
	}else{
		die("No tiene permiso");
	}
?>
<main role="main" class="container-fluid mx-0 mt-3 px-0">
	<div class="col-md-12 mx-auto px-0">
<?php 	
	if (isset($_GET['editar'])) {
		if (is_numeric($_GET['editar'])) {
			if ($_GET['editar'] == 1) {
				$identifier = $_GET['identifier'];
				$admin->buildEditableForm($form_data, $form_identifier, $identifier);
			}
		}
	}else{
		$admin->buildNewForm($form_data, $form_identifier);
	}
?>
	</div>	
</main>
<?php 
	include "admin.footer.php";
?>