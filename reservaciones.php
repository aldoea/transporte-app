<?php  
	include "header.php";
	if (!isset($_SESSION['validado'])) {
		header("Location: index.php");
	}
?>
	<main class="container justify-content-center mx-auto">
	  	<div class="col-md-6 offset-md-3">
	  		<h1>Bienvenido nuevamente, estos son tus proximos viajes:</h1>
		</div>
	</main>
<?php  
	include "footer.php";
?>