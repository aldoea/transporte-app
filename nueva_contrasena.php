<?php  
	include "header.php";
	if ( !isset($_GET['email']) && !isset($_GET['clave_temp']) ) {
		die();
	}
	$email = $_GET['email'];
	$clave_temp = $_GET['clave_temp'];
	$sql = "SELECT * FROM usuario where email=:email and clave_temp=:clave_temp";
	$stmt = $dreamtour->con->prepare($sql);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':clave_temp', $clave_temp);
	$stmt->execute();
	if ($resultado=$stmt->fetchObject()) {
		if (isset($_POST['recuperar'])) {
			$contrasena = $_POST['contrasena'];
			$contrasena2 = $_POST['contrasena2'];
			if ($contrasena == $contrasena2) {
				$contrasena = md5($contrasena);
				$sql = "UPDATE usuario SET contrasena=:contrasena, clave_temp=null WHERE email=:email and clave_temp=:clave_temp";
				$stmt = $dreamtour->con->prepare($sql);
				$stmt->bindParam(':contrasena', $contrasena);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':clave_temp', $clave_temp);
				$stmt->execute();
				if ($stmt->rowCount()>0) {
					$dreamtour->login($email, $contrasena2);
				}else{
					echo "INTERNAL FATAL ERROR!!!!! Reinicie su computadora y su modem";
				}
			}else{
				echo "Las contraseñas no coinciden";
			}
		}
	}else{
		echo "No se encontro";
		die();
	}
?>

<main class="container justify-content-center mx-auto mt-3">
    <div class="col-md-6 offset-md-3">
        <form class="form-signin" method="post" action="nueva_contrasena.php?email=<?php echo $email;?>&clave_temp=<?php echo $clave_temp ?>">
            <h1 class="h3 mb-3 font-weight-normal">Nueva contraseña</h1>           
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="contrasena" class="form-control mb-2" placeholder="Contraseña" required="true" autocomplete="off">
            <label for="inputPassword2" class="sr-only">Password</label>
            <input type="password" id="inputPassword2" name="contrasena2" class="form-control mb-2" placeholder="Repetir contraseña" required="true" autocomplete="off">
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Establecer nueva contraseña" name="recuperar">
        </form>
    </div>
</main>