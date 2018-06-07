<?php  
	include "admin.header.php";
	$id_usuario = null;
	if (isset($_SESSION['id_usuario'])) {		
		$id_usuario = $_SESSION['id_usuario'];		
	}
?>
	<main class="container mt-5">
	  	<div class="col-md-12 mx-auto">
	  		<h2>Bienvenido al panel de administrador</h2>
		</div>
	</main>
<?php  
	include "admin.footer.php";
?>