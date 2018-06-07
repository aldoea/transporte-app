<?php  
	use PHPMailer\PHPMailer\PHPMailer;
	include "header.php";
	$status = (object)[];
	if (isset($_POST['enviar'])) {
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$clave_temp = md5('pollo'.rand(1,1000000)).md5('frito'.rand(1,1000000).crypt($email,"anything"));
			$sql = "UPDATE usuario SET clave_temp=:clave_temp WHERE email=:email";
			$stmt = $dreamtour->con->prepare($sql);
			$stmt->bindParam('clave_temp', $clave_temp);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$count = $stmt->rowCount();
			if ($count > 0) {
				require 'lib/vendor/autoload.php';				
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->SMTPDebug = 0;
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;				
				$mail->SMTPSecure = 'tls';
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->SMTPAuth = true;
				$mail->Username = "14030557@itcelaya.edu.mx";
				$mail->Password = "ab2pikachu";
				$mail->setFrom('14030557@itcelaya.edu.mx', 'Deposito Hogar');				
				$mail->addAddress($email, 'Estimado cliente');
				$mail->Subject = 'Recuperación de contraseña';
				$mail->msgHTML('Si usted solicito recuperar su contraseña, ingrese en el siguiente vinculo para restablecer su contraseña:
					<a href="http://localhost:8080/dreamtour/nueva_contrasena.php?email='.$email.'&clave_temp='.$clave_temp.'">Click aquí</a>
					');
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				}else {
					$status->msg = "El correo ha sido enviado";
					$status->code = true;
				}
			}else{
				$status->msg = "No existe el email";
				$status->code = false;
			}
		}
	}
?>
<main class="container justify-content-center mx-auto mt-3">
	<div class="col-md-6 offset-md-3">
		<form class="form-signin mx-auto" method="post" action="recovery.php">  
			<h1 class="h3 mb-3 font-weight-normal">Recuperar contraseña</h1>
			<label for="inputEmail" class="sr-only">Correo electronico</label>
			<input type="email" id="inputEmail" name="email" class="form-control mb-2" placeholder="Correo electronico" required="true" autofocus=""> 
			<input class="btn btn-lg btn-primary btn-block" type="submit" value="Recuperar" name="enviar">
		</form>
	</div>
	<div class="col-md-6 offset-md-3">
		<?php  
		if (isset($status->code)) {
			if ($status->code) {
				echo '<p class="text-success bg-light">'.$status->msg.'</p>';
			}else{
				echo '<p class="text-danger bg-light">'.$status->msg.'</p>';
			}
		}
		?>		
	</div>
</main>
?>

<?php  
include "footer.php"
?>