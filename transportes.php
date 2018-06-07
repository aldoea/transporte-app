<?php  
	include "header.php";
	$transportes = $dreamtour->getTipos();	
?>
<main role="main" class="container">
	<div class="row">
		<div class="col-md-8 mx-auto">
			<div id="accordion">
				<?php  
					foreach ($transportes as $transporte) {
						echo '
							<div class="card">
								<div class="card-header p-0" id="heading_'.$transporte['id_tipo'].'">					
									<button class="btn bg-light collapsed p-0" data-toggle="collapse" data-target="#collapse_'.$transporte['id_tipo'].'" aria-expanded="false" aria-controls="collapse_'.$transporte['id_tipo'].'">
										<img class="card-img-top" src="images/unidades/'.$transporte['img'].'" alt="'.ucwords($transporte['nombre']).'">
										<h3>'.ucwords($transporte['nombre']).'</h3>
									</button>
								</div>

								<div id="collapse_'.$transporte['id_tipo'].'" class="collapse" aria-labelledby="heading_'.$transporte['id_tipo'].'" data-parent="#accordion">
									<div class="card-body">
										<p class="card-text">'.$transporte['descripcion'].'</p>
										<a class="btn btn-sm btn-darkorange" name="cotizar" href="cotizar.php?id_tipo='.$transporte['id_tipo'].'">Cotizar ahora</a>
									</div>
								</div>
							</div>
						';
					}
				?>
			</div>
		</div>
	</div>
</main>	
<?php  
	include "footer.php";
?>