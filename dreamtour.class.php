<?php  
	session_start();
	/**
	* 
	*/
	class Dreamtour
	{
		var $con= null;
		public function conexion()
		{
			$bd = 'dream_tour';
			$server = 'localhost';
			$user = 'root';
			$password = '';
			$mbd = new PDO('mysql:host='.$server.';dbname='.$bd, $user, $password);
			$mysql_query = "SET NAMES 'utf8'";
			$stmt = $mbd->query($mysql_query);
			$stmt->execute();
			$this->con=$mbd;
		} # END conexion()

		public function getTipos()
		{
			$sql = "SELECT * FROM tipo";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $tipos;
		}
		public function getTiposById($id)
		{
			$sql = "SELECT * FROM tipo WHERE id=:id";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$stmt->bindParam(':id', $id);
			$tipo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $tipo;
		}

		public function getTransportes()
		{
			$sql = "SELECT * FROM transporte";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$stmt->execute();
			$transportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $transportes;
		}

		public function getTransportesById()
		{
			
		}

		public function getUsuarioByEmail($email)
		{
			$sql = "SELECT * FROM usuario where email=:email";
			$stmt = $this->con->prepare($sql);
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$usuario = $stmt->fetchObject();
			echo "<pre>";
			var_dump($usuario);
			echo "</pre>";
			return $usuario;
		}

		public function cotizar($tipo, $fecha_salida, $fecha_regreso, $destino)
		{
			//OBTENER valor						
			$sql = "SELECT tip.ponderante, tran.costo_compra FROM tipo tip INNER JOIN transporte tran ON tran.id_tipo=tip.id WHERE tip.id=:tipo ORDER BY tran.costo_compra, tip.ponderante LIMIT 1";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$stmt->bindParam(':tipo', $tipo);
			$stmt->execute();
			$data = $stmt->fetch(PDO::FETCH_ASSOC);			
			if ( isset($data['costo_compra']) ) {

				$costo_compra = $data['costo_compra'];
				$ponderante = $data['ponderante'];
				$viaticos = 400;
				$salario = 200;
				$destino = 5000;
				$diferencia_fechas = $fecha_salida->diff($fecha_regreso);
				$num_dias = (int) $diferencia_fechas->format('%d');
				$cotizacion = ((($costo_compra * $ponderante) + $salario + $viaticos) * $num_dias) + $destino;
				echo $cotizacion;
				return $cotizacion; 
			}else{
				die("Transporte no disponible");
			}
			// num_dias[(valor)*0.02+ salario + viaticos + destino)]
		}

		public function registrar($nombre, $email, $telefono=null, $contrasena, $contrasena_repeat)
		{
			$this->conexion();
			$this->con->beginTransaction();			
			try {       
			  // abniente de una transaccion
			  // 1-Comprobar el email que se esta registrando no exista en la bd			
			$usuario = $this->getUsuarioByEmail($email);			
			if (!isset($usuario->email)) {
			    // 2. si no existe el email se inserta en usuario
				$sql = "INSERT INTO usuario(email, contrasena) values(:email,:contrasena)";
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam(':email', $email);
				$contrasena = md5($contrasena);
				$stmt->bindParam(':contrasena',$contrasena);
				$stmt->execute();
			    // 3- se obtine el id del usuario
				$usuario = $this->getUsuarioByEmail($email);
				$id_usuario = $usuario->id_usuario;
			    // 4. se inserta en la tabla usuario_rol y se asigna el cliente
				$sql = "INSERT INTO usuario_rol(id_usuario, id_rol) VALUES(:id_usuario, 1)";
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam(':id_usuario', $id_usuario);
				$stmt->execute();
			    // 5. se inserta en la tabla cliente utilizando el id
				$sql = "INSERT INTO cliente(nombre,id_usuario) values(:nombre, :id_usuario)";
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam('nombre', $nombre);
				$stmt->bindParam('id_usuario',$id_usuario);
				$stmt->execute();
				$this->con->commit();
			    // 6. se confirma al usuario los mensajes         
				$this->login($email,$contrasena_repeat);         
			}else{
				$this->con->rollBack();
				$msg = "Registro fallido, ya existe una cuenta con ese correo";
			  }// END if email not exist
			} catch (Exception $e) {
				$this->con->rollBack();
				$msg = "Registro fallido";
			}
			echo $msg;
		}

		public function login($email, $contrasena)
		{			
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$contrasena = md5($contrasena);
				$sql = "SELECT id_usuario,email from usuario where email=:email and contrasena=:contrasena";
				$this->conexion();
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam(":email",$email);
				$stmt->bindParam(":contrasena",$contrasena);
				$stmt->execute();
				$user = $stmt->fetchObject();
				if (isset($user->email)) {
					$_SESSION['validado'] = true;
					$_SESSION['email'] = $email;
					$_SESSION['id_usuario'] = $user->id_usuario;
					$sql = "SELECT id_rol, rol from vwroles where email=:email";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(":email", $email);
					$stmt->execute();
					$_SESSION['roles'] = [];
					while($roles = $stmt->fetch(PDO::FETCH_ASSOC)){
						array_push($_SESSION['roles'], $roles);
					}
					header("Location: reservaciones.php");
				}else{
					session_destroy();
					die("Credenciales invalidas, verifique los datos ingresados e intente nuevamente");
				}				
			}else{
				die("Se necesita un email electrónico");
			}
		} # END login

		public function logout()
		{
			session_destroy();
			header("Location: index.php");
		} # END logout
	} # END CLASS Dreamtour
?>