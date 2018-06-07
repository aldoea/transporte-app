<?php  
	include "header.php";
	if (!isset($_SESSION['validado'])) {
		header("Location: index.php");
	}
	$id_usuario = null;
	if (isset($_SESSION['id_usuario'])) {		
		$id_usuario = $_SESSION['id_usuario'];		
	}
	if (isset($_GET['cancelar']) && isset($_GET['id_reservacion'])) {
		if (is_numeric($_GET['cancelar']) && is_numeric($_GET['id_reservacion'])) {
			if ($_GET['cancelar'] == 1) {
				$sql = "DELETE FROM 
							reservacion
						WHERE
							id_reservacion = :id_reservacion;
				";
				$stmt = $dreamtour->con->prepare($sql);
				$id_reservacion = $_GET['id_reservacion'];
				$stmt->bindParam(':id_reservacion', $id_reservacion);
				$stmt->execute();				
				header("Location: reservaciones.php");
			}
		}
	}
	$sql = "SELECT id_cliente, nombre, apaterno FROM cliente WHERE id_usuario=:id_usuario";
	$stmt = $dreamtour->con->prepare($sql);
	$stmt->bindParam(':id_usuario', $id_usuario);
	$stmt->execute();
	$cliente_data = $stmt->fetch(PDO::FETCH_ASSOC);
	$id_cliente = $cliente_data['id_cliente'];
	$nombre_cliente = $cliente_data['nombre']." ".$cliente_data['apaterno'];
	// GET RESERVACIONES
	$sql = "SELECT
				res.*,
				trans.id_transporte, 
				trans.capacidad, 
				trans.id_tipo, 
				tipo.id_tipo, 
				tipo.nombre AS unidad, 
				tipo.img, 
				op.id_operador, 
				op.nombre AS conductor, 
				op.apellido, 
				dest.id_destino, 
				dest.pais,		
				dest.estado, 
				dest.ciudad  
			FROM
				reservacion AS res INNER JOIN transporte AS trans
					ON
						res.id_transporte = trans.id_transporte
				INNER JOIN tipo 
					ON
						trans.id_tipo = tipo.id_tipo
				INNER JOIN operador AS op
					ON
						res.id_operador = op.id_operador
				INNER JOIN destino AS dest
					ON
						res.id_destino = dest.id_destino
			WHERE
				res.id_cliente = :id_cliente
				AND
				res.fecha_salida > now()
			ORDER BY
				res.fecha_salida
	;";
	$stmt = $dreamtour->con->prepare($sql);
	$stmt->bindParam(':id_cliente', $id_cliente);
	$stmt->execute();
	$reservaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
	<main class="container">
	  	<div class="col-md-12 mx-auto">
	  		<h2>Bienvenido nuevamente <span class="text-blueklein"><?php echo $nombre_cliente; ?></span>, estos son tus proximos viajes:</h2>
			
			<?php if(isset($_SESSION['cotizar'])): ?>
				<div id="accordion">
					<div class="card">
						<div class="card-header bg-darkorange" id="headingOne">
							<h5 class="mb-0">
								<button class="btn text-white btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									Tiene una cotizacion pendiente:
								</button>
							</h5>
						</div>

						<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
							<div class="card-body">
								<ul lass="list-unstyled mt-5">
									<li class="media mb-4">
										<div class="col-md-3">
											<img class="mr-3 img-thumbnail align-self-center" src="images/unidades/sprinter_estandar.jpg" alt="Generic placeholder image">					
										</div>
										<div class="col-md-9">
											<div class="media-body">
												<h5 class="mt-0 mb-1">XXXXXXX</h5>
												Hola mundo loco
											</div>
											<a href="reservar.php?reservar=1" role="button" class="btn btn-darkorange mt-2">Reservar ahora</a>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endif;	 ?>

			<ul class="list-unstyled mt-5">
				<?php foreach($reservaciones as $reserv): ?>
					<li class="media mb-4" style="border: 1px solid rgba(0,0,0,.125); border-radius: .25rem;">
						<div class="col-md-3">
							<img class="mr-3 img-thumbnail align-self-center" src="images/unidades/<?php echo $reserv['img'] ?>" alt="Generic placeholder image">					
						</div>
						<div class="col-md-9">
							<div class="media-body">
								<div class="row">
									<div class="col-12">
										<div class="row">
											<div class="col-md-10">										
												<h4 class="mt-0 mb-1"><?php echo $reserv['ciudad'] ?></h4>
												<p class="text-secondary"><?php echo $reserv['estado'].', '.$reserv['pais'] ?></p>	
											</div>
											<div class="col-md-2">
												<div class="text-right">
														<a href="reservaciones.php?cancelar=1&id_reservacion=<?php echo $reserv['id_reservacion'] ?>" class="text-danger">
															<i class="far fa-trash-alt">
															</i>
														</a>
												</div>												
											</div>
										</div>
									</div>
									<div class="col-4">
										<div class="row">
											<div class="col-md-12">
												<span><b>Fecha salida: </b><?php echo $reserv['fecha_salida'] ?></span>
											</div>
											<div class="col-md-12">
												<span><b>Fecha regreso: </b><?php echo $reserv['fecha_regreso'] ?></span>				
											</div>
										</div>
									</div>
									<div class="col-4">										
										<b>Conductor:</b>
										<p><?php echo ucwords($reserv['conductor'].' '.$reserv['apellido']) ?></p>		
									</div>
								</div>
								<div class="row">
									<div class="col-md-4">
										<b>Unidad:</b>
										<p><?php echo ucwords($reserv['unidad']) ?></p>
									</div>
									<div class="col-md-4">
										<b>Capacidad:</b>
										<p><?php echo $reserv['capacidad'] ?> pasajeros</p>
									</div>
									<div class="col-md-4">
										<b>Precio:</b>
										<p class="text-success font-weight-bold">$ <?php echo $reserv['costo'] ?></p>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</main>
<?php  
	include "footer.php";
?>