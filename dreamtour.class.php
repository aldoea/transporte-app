<?php 
/************************************************************************************************************************************
*CLASE DREAMTOUR
*@VERSION 1.0
*@AUTOR ALDOEA
************************************************************************************************************************************/
	session_start();
	class Dreamtour
	{
		var $con= null; // VARIABLE GLOBAL DE CONEXIÓN A BD
		/************************************************************
		* METODO: ESTABLECE CONEXIÓN A UNA BASE DE DATOS USANDO PDO Y ASIGNA LA CONEXION A UNA VARIBALE GLOBAL
		************************************************************/
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

		/************************************************************
		* METODO: REGRESA EL RESULTADO DE UNA CONSULTA A LA BASE DE DATOS
		* @param  $sql 			string 	CONSULTA A SER REALIZADA
		* @return $resultado 	array 	RESULTADOS OBTENIDOS DE LA CONSULTA
		************************************************************/
		public function consultar($sql)
		{
			$this->conexion();
			$resultado = $this->con->query($sql);			
			return $resultado->fetchAll(PDO::FETCH_ASSOC);
		} # END consultar

		/************************************************************
		* METODO: CONSTRUYE Y MUESTRA UNA TABLA GENERICA PARA EL PANEL DE ADMINISTRADOR
		* @param  $headers 	array 	CONTIENE LOS ENCABEZADOS DE LA TABLA
		* @param  $data 	array 	UN ARRAY ASOCIATIVO CON LA INFORMACÓN PERTINENTE A LA TABLA
		* @param  $keys 	array 	CONTIENE LAS LLAVES DE LAS DIMENSIONES DE $data QUE SE DESEAN MOSTRAR EN LA TABLA
		* @return null 		null  	IMPRIME TABLA CONSTRUIDA
		************************************************************/
		public function buildAdminTable($headers, $data, $file_name = null)
		{
			echo '
			<table class="table table-striped table-dark">
			  <thead>
			    <tr>';			
			foreach ($headers as $header) {
				echo '<th scope="col">'.$header.'</th>';								    	
		    }				    
		    echo '
			  </thead>
			  <tbody>';
			foreach ($data as $item) {
				echo '<tr>';				
				foreach ($item as $assoc_key => $value) {
					echo '<td id="'.$assoc_key.'" class="font-weight-light" scope="row">'.$value.'</td>';
				}
				echo '
					<td>
						<form action="'.$file_name.'.php" method="POST">
							<input type="hidden" name="identifier" value="'.$item[key($item)].'">
							<div class="btn-group btn-group-sm" role="group" aria-label="tools">
								<button type="submit" name="editar" class="btn btn-link ml-3 text-warning">
								    <i class="fas fa-pencil-alt"></i>
								</button>
								<button type="submit" name="eliminar" class="btn btn-link ml-3 text-danger">
								    <i class="fas fa-trash-alt"></i>
								</button>
							</div>
						</form>
					</td>		  	
				';
				echo "</tr>";
	  		}
		  	echo '
			  </tbody>
			</table>';
		} #END buildAdminTable	


		/************************************************************
		* METODO: CONSTRUYE Y MUESTRA UN FORMULARIO NUEVO GENERICO PARA UNA TABLA EN ESPECIFICO
		* @param  $form_data			array 	CONTIENE LA INFORMACION DEL FORMULARIO EN DOS DIMENSIONES
		* @param  $form_data['keys']	array 	CONTIENE LA INFORMACION DE LOS IDENTIFICADORES
		* @param  $form_data['labels']	array 	CONTIENE LA INFORMACION DE LAS ETIQUETAS
		* @param  $file_name			string 	CONTIENE El NOMBRE IDENTIFICADOR DEL ARCHIVO DE ORIGEN Y DESTINO DEL FORMULARIO
		* @return null 			null  	IMPRIME TABLA CONSTRUIDA
		************************************************************/
		public function buildNewForm($form_data, $file_name)
		{
			$counter = 0;
			echo '<div class="container mx-auto">
					<form method="POST" action="'.$file_name.'.php" enctype="multipart/form-data">
						<div class="form-group">
			';
			foreach ($form_data as $key => $label) {
				if ($counter == 0) {
					echo '
					<input type="hidden" name="'.$key.'" class="form-control">
				';
				}else{
				echo '
					<label>'.$label.'</label>
					<input type="'.$this->getInputType($key).'" name="'.$key.'" class="form-control" required="">
				';				}
				$counter += 1;
			}
			echo '
					</div>
					<button name="guardar" type="submit" class="btn btn-success">Enviar</button>
			  		<button type="reset" class="btn btn-danger">Limpiar</button>						
				</form>
			</div>';
		} //END buildForm

		/************************************************************
		* METODO: CONSTRUYE Y MUESTRA UN FORMULARIO CON LOS DATOS PRE-LLENADOS PARA UNA TABLA EN ESPECIFICO
		* @param  $form_data			array 	CONTIENE LA INFORMACION DEL FORMULARIO EN DOS DIMENSIONES
		* @param  $form_data['keys']	array 	CONTIENE LA INFORMACION DE LOS IDENTIFICADORES
		* @param  $form_data['labels']	array 	CONTIENE LA INFORMACION DE LAS ETIQUETAS
		* @param  $file_name			string 	CONTIENE El NOMBRE IDENTIFICADOR DEL ARCHIVO DE ORIGEN Y DESTINO DEL FORMULARIO
		* @return null 			null  	IMPRIME TABLA CONSTRUIDA
		************************************************************/
		public function buildEditableForm($form_data, $file_name, $identifier)
		{
			$counter = 0;
			$form_values = $this->getFormValues($file_name, $identifier);
			echo '<div class="container mx-auto">
					<form method="POST" action="'.$file_name.'.php" enctype="multipart/form-data">
						<div class="form-group">
			';
			foreach ($form_data as $key => $label) {
				if ($counter == 0) {
					echo '
					<input type="hidden" name="'.$key.'"  value="'.$form_values[$counter].'" class="form-control">
				';
				}else{
					$required_flag = $this->getInputType($key) != 'file';
					if ($required_flag) {						
						echo '
							<label>'.$label.'</label>
							<input type="'.$this->getInputType($key).'" name="'.$key.'" value="'.$form_values[$counter].'" class="form-control"  required="">
						';
					}else{
						echo '
							<label>'.$label.'</label>
							<input type="'.$this->getInputType($key).'" name="'.$key.'" value="'.$form_values[$counter].'" class="form-control">
						';
					}
				}
				$counter += 1;
			}
			echo '
					</div>
					<button name="actualizar" type="submit" class="btn btn-success">Enviar</button>
			  		<button type="reset" class="btn btn-danger">Limpiar</button>						
				</form>
			</div>';
		} //END buildForm

		/************************************************************
		* METODO: BUSCA Y DEVUELVE LOS VALORES PARA RELLENAR UN FORMULARIO EN ESPECIFICO, BUSCA DEPENDIENDO DEL ARCHIVO DE ORIGEN Y UN IDENTIFICADOR	
		* @param  $identifier 	int 	IDENTIFICADOR DISCRIMINANTE PARA EL QUERY
		* @param  $file_name 	string 	CONTIENE El NOMBRE IDENTIFICADOR DEL ARCHIVO DE ORIGEN Y DESTINO DEL FORMULARIO
		* @return $resultado 	array 	RESULTADO DE LA BUSQUEDA DESEADA
		************************************************************/
		public function getFormValues($file_name, $identifier)
		{
			$this->conexion();
			$resultado = array();
			switch ($file_name) {
				case 'clientes':
					$id_cliente = $identifier;
					$sql = "SELECT
								c.id_cliente,
								c.nombre,
								c.apaterno,
								c.amaterno,
								c.telefono,
								c.domicilio,
								u.email 
							FROM 
								cliente c INNER JOIN usuario u 
							ON 
								c.id_usuario=u.id_usuario
							WHERE
							 	id_cliente=:id_cliente;
					";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':id_cliente', $id_cliente);
					$stmt->execute();
					$cliente = $stmt->fetch();
					$resultado = $cliente;
					break;
				case 'destinos':
					$id_destino = $identifier;
					$sql = "SELECT * FROM destino WHERE id_destino=:id_destino;";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':id_destino', $id_destino);
					$stmt->execute();
					$destino = $stmt->fetch();
					$resultado = $destino;
				case 'operadores':
					$id_operador = $identifier;
					$sql = "SELECT * FROM operador WHERE id_operador=:id_operador;";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':id_operador', $id_operador);
					$stmt->execute();
					$operador = $stmt->fetch();
					$resultado = $operador;
				case 'tipos':
					$id_tipo = $identifier;
					$sql = "SELECT * FROM tipo WHERE id_tipo=:id_tipo;";					
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':id_tipo', $id_tipo);
					$stmt->execute();
					$tipo = $stmt->fetch();
					$resultado = $tipo;
					break;
				case 'transportes':
					$id_transporte = $identifier;
					$sql = "SELECT id_transporte, marca, ano, color, serial, capacidad, tanque_combustible, rendimiento, kilometraje, id_tipo, costo_compra FROM transporte WHERE id_transporte=:id_transporte;";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':id_transporte', $id_transporte);
					$stmt->execute();
					$transporte = $stmt->fetch();
					$resultado = $transporte;
				default:
					break;
			}
			return $resultado;
		}

		/************************************************************
		* METODO: SELECCIONA UN STRING QUE SERA DEVUELTO PARA SER EL TIPO DE INPUT DESEADO
		* @param  $indicator 	int 	IDENTIFICADOR DISCRIMINANTE PARA EL SWITCH		
		* @return generic		string 	RESULTADO DEL SWITCH
		************************************************************/
		public function getInputType($indicator)
		{
			switch ($indicator) {
				case 'fecha':
					return 'date';
					break;
				case 'fecha_nacimiento':
					return 'date';
					break;
				case 'img':
					return 'file';
				default:
					return 'text';
					break;
			}
		}
		/************************************************************
			  ____ ____  _   _ ____  ____  
			 / ___|  _ \| | | |  _ \/ ___| 
			| |   | |_) | | | | | | \___ \ 
			| |___|  _ <| |_| | |_| |___) |
			 \____|_| \_\\___/|____/|____/ 
			                               
		************************************************************/

		/*
			___ _ ___  ____ ____ 
			 |  | |__] |  | [__  
			 |  | |    |__| ___] 

		*/
		/************************************************************
		* METODO: REGRESA EL RESULTADO DE UNA CONSULTA POR TODOS LOS TIPOS EN LA BASE DE DATOS		
		* @return $tipos 	array 	RESULTADOS OBTENIDOS DE LA CONSULTA
		************************************************************/
		public function getTipos()
		{
			$sql = "SELECT * FROM tipo";
			$this->conexion();
			$stmt = $this->con->query($sql);
			$tipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $tipos;
		}
		/************************************************************
		* METODO: REGRESA EL RESULTADO DE UNA CONSULTA POR SOLO UN TIPO EN LA BASE DE DATOS
		* @param  $id 		integer ID QUE SE DESEA ENCONTRAR 		
		* @return $tipos 	array 	RESULTADOS OBTENIDOS DE LA CONSULTA
		************************************************************/
		public function getTiposById($id)
		{
			$sql = "SELECT * FROM tipo WHERE id_tipo=:id";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			$tipo = $stmt->fetch(PDO::FETCH_ASSOC);
			return $tipo;
		}
			
		// TRANSPORTES

		/************************************************************
		* METODO: REGRESA EL RESULTADO DE UNA CONSULTA POR TODOS LOS TRANSPORTES EN LA BASE DE DATOS		
		* @return $transportes 	array 	RESULTADOS OBTENIDOS DE LA CONSULTA
		************************************************************/
		public function getTransportes()
		{
			$sql = "SELECT * FROM transporte";
			$this->conexion();
			$stmt = $this->con->query($sql);
			$transportes = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $transportes;
		}
				
		// USUARIOS
		/************************************************************
		* METODO: REGRESA EL RESULTADO DE UNA CONSULTA POR UN USUARIO EN LA BASE DE DATOS EN BASE A SU EMAIL
		* @param $email 	string 	EL EMAIL POR EL CUAL SE BUSCA	
		* @return $tipos 	array 	RESULTADOS OBTENIDOS DE LA CONSULTA
		************************************************************/
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

		/************************************************************
			  ____  _   _ ____ ___ _   _ _____ ____ ____    _     ___   ____ ___ ____ 
			 | __ )| | | / ___|_ _| \ | | ____/ ___/ ___|  | |   / _ \ / ___|_ _/ ___|
			 |  _ \| | | \___ \| ||  \| |  _| \___ \___ \  | |  | | | | |  _ | | |    
			 | |_) | |_| |___) | || |\  | |___ ___) |__) | | |__| |_| | |_| || | |___ 
			 |____/ \___/|____/___|_| \_|_____|____/____/  |_____\___/ \____|___\____|
			                                                                          
		************************************************************/		

		/************************************************************
		* METODO: CALCULA LA COTIZACIÓN POR EL SERVICIO DE TRANSPORTE
		* @param $tipo 			integer ID DEL TIPO DE UNIDAD
		* @param $fecha_salida	date 	FECHA DE INICIO DEL VIAJE
		* @param $fecha_regreso	date 	FECHA DE TERMINO DEL VIAJE
		* @param $pais 			string 	PAIS DESTINO DEL VIAJE		
		* @param $estado 		string 	ESTADO DESTINO DEL VIAJE		
		* @param $ciudad 		string 	CIUDAD DESTINO DEL VIAJE		
		* @return $cotizacion 	decimal	COSTO TOTAL DEL VIAJE
		************************************************************/
		public function cotizar($tipo, $fecha_salida, $fecha_regreso, $pais, $estado, $ciudad)
		{
			//OBTENER valor
			$viaticos_default = 1000;
			$precio_default = 1500;
			$this->conexion();
			$this->con->beginTransaction();
			try {
				// Verifica disponibilidad de transporte
				$sql = "SELECT 
							tip.ponderante,
							tran.id_transporte,
							tran.costo_compra 
						FROM 
							tipo tip INNER JOIN transporte tran 
						ON 
							tran.id_tipo=tip.id_tipo 
						WHERE 
							tip.id_tipo=:tipo 
						ORDER BY 
							tran.costo_compra, 
							tip.ponderante 
						LIMIT 
							1";
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam(':tipo', $tipo);
				$stmt->execute();
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
				if ( isset($data['costo_compra']) ) {
					$id_transporte = $data['id_transporte'];
					$costo_compra = $data['costo_compra'];
					$ponderante = $data['ponderante'];
					$sql = "SELECT * FROM destino WHERE ciudad=:ciudad;";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':ciudad', $ciudad);
					$stmt->execute();
					$destino = $stmt->fetchObject();
				// OBTENER id_destino
					if (isset($destino->id_destino)) {
						$id_destino = $destino->id_destino;
						$destino_precio = $destino->precio;
						$viaticos = $destino->viaticos;
					}else{
						$sql = "INSERT INTO destino(
									pais, 
									estado, 
									ciudad, 
									precio, 
									viaticos
								) VALUES(
									:pais, 
									:estado, 
									:ciudad, 
									:precio, 
									:viaticos
								);";
						$stmt = $this->con->prepare($sql);
						$stmt->bindParam(':pais', $pais);
						$stmt->bindParam(':estado', $estado);
						$stmt->bindParam(':ciudad', $ciudad);
						$stmt->bindParam(':precio', $precio_default);
						$stmt->bindParam(':viaticos', $viaticos_default);
						$stmt->execute();
						$id_destino = $this->con->lastInsertId();
						$destino_precio = $precio_default;
						$viaticos = $viaticos_default;
					}
				// OBTENER id_operador
					$sql = "SELECT
								id_operador,
								salario
							FROM
								operador
							ORDER BY 
								rand() 
							LIMIT 
								1";
					$stmt = $this->con->query($sql);						
					$resultado = $stmt->fetchObject();
					$id_operador = $resultado->id_operador;
					$salario = $resultado->salario;
				// CALCULA NUMERO DE DIAS					
					$diferencia_fechas = $fecha_salida->diff($fecha_regreso);
					$num_dias = (int) $diferencia_fechas->format('%d');
				// COTIZA
					$cotizacion = ((($costo_compra * $ponderante) + $salario + $viaticos) * $num_dias) + $destino_precio;
				// GUARDA COTIZACION EN SESION
					$_SESSION['cotizar'] = array(
						"id_transporte" => $id_transporte,
						"id_operador" => $id_operador,
						"id_destino" => $id_destino,
						"fecha_salida" => $fecha_salida,
						"fecha_regreso" => $fecha_regreso,
						"costo" => $cotizacion
					);
					$this->con->commit();
					return $cotizacion;
				}else{
					$this->con->rollBack();
					die("Transporte no disponible");
				}
			} catch (Exception $e) {
				$this->con->rollBack();
				die("Error desconocido, contacte a un agente ".$e);
			}
			
		} # END cotizar

		/************************************************************
		* METODO: GUARDA LA COTIZACIÓN POR EL SERVICIO DE TRANSPORTE
		* @return null 	null INSERTA EN LA BD
		************************************************************/
		public function reservar()
		{
			if (isset($_SESSION['validado'])) {
				if ($_SESSION['validado']) {
					$this->con->beginTransaction();
					try {
						//OBTENER id_cliente
						$id_usuario = $_SESSION['id_usuario'];
						$id_transporte = $_SESSION['cotizar']['id_transporte'];
						$id_operador = $_SESSION['cotizar']['id_operador'];
						$id_destino = $_SESSION['cotizar']['id_destino'];
						$fecha_salida = $_SESSION['cotizar']['fecha_salida']->date;
						$fecha_regreso = $_SESSION['cotizar']['fecha_regreso']->date;
						$costo = $_SESSION['cotizar']['costo'];
						// OBTENER id_cliente
						$sql = "SELECT 
									id_cliente 
								FROM
									cliente
								WHERE 
									id_usuario=:id_usuario;";
						$stmt = $this->con->prepare($sql);
						$stmt->bindParam(':id_usuario', $id_usuario);
						$stmt->execute();
						$resultado = $stmt->fetchObject();
						$id_cliente = $resultado->id_cliente;
						// HACER RESERVACION
						$sql = "INSERT INTO reservacion(
									id_cliente,
									id_transporte,
									id_operador,
									id_destino,
									fecha_salida,
									fecha_regreso,
									costo
								)VALUES(
									:id_cliente,
									:id_transporte,
									:id_operador,
									:id_destino,
									:fecha_salida,
									:fecha_regreso,
									:costo
								)";
						$stmt= $this->con->prepare($sql);
						$stmt->bindParam(':id_cliente', $id_cliente);
						$stmt->bindParam(':id_transporte', $id_transporte);
						$stmt->bindParam(':id_operador', $id_operador);
						$stmt->bindParam(':id_destino', $id_destino);
						$stmt->bindParam(':fecha_salida', $fecha_salida);
						$stmt->bindParam(':fecha_regreso', $fecha_regreso);
						$stmt->bindParam(':costo', $costo);
						$stmt->execute();
						$rows_inserted = $stmt->rowCount();
						if ($rows_inserted > 0) {
							$this->con->commit();
							unset($_SESSION['cotizar']);
							header("Location: reservaciones.php");
						}else{
							$this->con->rollBack();
						}
					} catch (Exception $e) {
						$this->con->rollBack();
					}
				}
			}else{
				header("Location: signin.php");
			}
		}

		/************************************************************
			   ____  _____ ____ ____ ___ ___  _   _ 
			  / ___|| ____/ ___/ ___|_ _/ _ \| \ | |
			  \___ \|  _| \___ \___ \| | | | |  \| |
			   ___) | |___ ___) |__) | | |_| | |\  |
			  |____/|_____|____/____/___\___/|_| \_|
			                                        
		************************************************************/

		/************************************************************
		* METODO: REGISTRA UN NUEVO CLIENTE
		* @param  $nombre 				string 	NOMBE DEL NUEVO CLIENTE
		* @param  $email				string 	EMAIL DEL NUEVO CLIENTE
		* @param  $contrasena			string 	CONTRASEÑA DEL NUEVO CLIENTE
		* @param  $contrasena_repeat 	string 	CONTTRASEÑA REPETIDA DEL NUEVO CLIENTE
		* @return null 					null 	IMPRIME UN MENSAJE
		************************************************************/
		public function registrar($nombre, $email, $contrasena, $contrasena_repeat)
		{
			$this->conexion();
			$this->con->beginTransaction();			
			try {       
			  	// abniente de una transaccion
			  	// 1-Comprobar el email que se esta registrando no exista en la bd			
				$usuario = $this->getUsuarioByEmail($email);			
				if (!isset($usuario->email)) {
				    // 2. si no existe el email se inserta en usuario
					$sql = "INSERT INTO usuario(email, contrasena) VALUES(:email,:contrasena)";
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
					$sql = "INSERT INTO cliente(nombre,id_usuario) VALUES(:nombre, :id_usuario)";
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

		/************************************************************
		* METODO: INICIA UNA NUEVA SESION
		* @param  $email				string 	EMAIL DEL CLIENTE
		* @param  $contrasena			string 	CONTRASEÑA DEL CLIENTE
		* @return null 					null 	IMPRIME UN MENSAJE O REDIRECCIONA
		************************************************************/
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
					$id_usuario = $user->id_usuario;
					$_SESSION['validado'] = true;
					$_SESSION['email'] = $email;
					$_SESSION['id_usuario'] = $id_usuario;
					$sql = "SELECT id_rol, rol from vwroles where id_usuario=:id_usuario";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(":id_usuario", $id_usuario);
					$stmt->execute();
					$_SESSION['roles'] = [];
					$is_admin = false;
					while($roles = $stmt->fetch(PDO::FETCH_ASSOC)){
						array_push($_SESSION['roles'], $roles);
						if ($roles['rol'] == "Administrador" or $roles['rol'] == "Gerente") {
							$is_admin = true;
						}
					}
					if($is_admin) {
						header("Location: admin/index.php");
					}else{
						header("Location: reservaciones.php");
					}
				}else{
					die("Credenciales invalidas, verifique los datos ingresados e intente nuevamente");
				}				
			}else{
				die("Se necesita un email electrónico");
			}
		} # END login

		/************************************************************
		* METODO: CIERRA UNA SESION
		* @return null 	null 	REDIRECCIONA A HOME
		************************************************************/
		public function logout()
		{
			session_destroy();
			header("Location: index.php");
		} # END logout

		/************************************************************
		* METODO: VERIFICA LOS PERMISOS SEGUN LOS ROLES DEL USUARIO ACTIVO
		* @param  $roles 	array 	CONTIENE LOS ROLES A VALIDAR
		* @return null 		null 	REDIRECCIONA SI NO SE CUENTAN CON LOS PERMISOS
		************************************************************/
		public function validar($roles)
		{
			 if (isset($_SESSION)) {
			 	if (isset($_SESSION['validado'])) {
				 	if ($_SESSION['validado']) {
				 		$roles_usuario = $_SESSION['roles'];
				 		$aceptado = false;
				 		foreach ($roles_usuario as $rol_usuario) {
					 		if (in_array($rol_usuario['rol'], $roles)) {
					 			$aceptado = true;
					 		}			 			
				 		}
				 		if (!$aceptado) {
				 			header("Location: ../signin.php");
				 		}			 		
				 	}else{
				 		$this->logout();
				 		header("Location: ../signin.php");	
				 	}
			 	}else{
			 		header("Location: ../signin.php");
			 	}
			 }else{
			 	$this->logout();
			 	header("Location: ../signin.php");
			 }
		} # END validar

		/************************************************************
			 ____  ____   ___  _____ ___ _     _____ 
			|  _ \|  _ \ / _ \|  ___|_ _| |   | ____|
			| |_) | |_) | | | | |_   | || |   |  _|  
			|  __/|  _ <| |_| |  _|  | || |___| |___ 
			|_|   |_| \_\\___/|_|   |___|_____|_____|

		************************************************************/
		
		/************************************************************
		* METODO: ACTUALIZA LA INFORMACION DE PERFIL
		* @param  $nombre 	string 	CONTIENE EL NOMBRE DE USUARIO
		* @param  $apaterno 	string 	CONTIENE EL APELLIDO PATERNO DE USUARIO
		* @param  $amaterno 	string 	CONTIENE EL APELLIDO MATERNO DE USUARIO
		* @param  $domicilio 	string 	CONTIENE EL domicilio DE USUARIO
		* @param  $new_email 	string 	CONTIENE EL NUEVO CORREO DE USUARIO
		* @param  $old_email 	string 	CONTIENE EL VIEJO CORREO DE USUARIO
		* @param  $id_usuario 	string 	CONTIENE EL ID DE USUARIO
		* @return null 		null 	REDIRECCIONA EN CASO DE EXITO
		************************************************************/
		public function actualizarPerfil($nombre, $apaterno, $amaterno, $domicilio, $new_email, $old_email, $id_usuario)
		{
			$this->conexion();
			$this->con->beginTransaction();
			try {
				$sql = "SELECT email from usuario WHERE email=:new_email AND id_usuario!=:id_usuario";
				$stmt = $this->con->prepare($sql);
				$stmt->bindParam(':new_email', $new_email);
				$stmt->bindParam(':id_usuario', $id_usuario);
				$stmt->execute();
				$usuario = 	$stmt->fetchObject();
				if (!isset($usuario->email)) {
					if ($old_email != $new_email) {
						$sql = "UPDATE usuario SET email=:new_email WHERE id_usuario=:id_usuario";
						$stmt = $this->con->prepare($sql);
						$stmt->bindParam(':new_email', $new_email);
						$stmt->bindParam(':id_usuario', $id_usuario);					
						$stmt->execute();
					}
					$sql = "UPDATE cliente SET nombre=:nombre, apaterno=:apaterno, amaterno=:amaterno, domicilio=:domicilio WHERE id_usuario=:id_usuario";
					$stmt = $this->con->prepare($sql);
					$stmt->bindParam(':nombre', $nombre);
					$stmt->bindParam(':apaterno', $apaterno);
					$stmt->bindParam(':amaterno', $amaterno);
					$stmt->bindParam(':domicilio', $domicilio);
					$stmt->bindParam(':id_usuario',$id_usuario);					
					$stmt->execute();										
					$this->con->commit();
					$_SESSION['email'] = $new_email;
					header("Location: perfil.php");
				}else{
					echo "Correo ya existente, use otro";
					$this->con->rollBack();
				}
			} catch (Exception $e) {
				$this->con->rollBack();
			}
		} # END actualizarPerfil

		/************************************************************
		* METODO: ACTUALIZA LA CONTRASEÑA DE PERFIL
		* @param  $contrasena 	string 		CONTIENE LA CONTRASEÑA NUEVA
		* @param  $contrasena2 	string 		CONTIENE LA CONTRASEÑA NUEVA REPETIDA
		* @param  $id_usuario 	string 		CONTIENE EL ID DE USUARIO
		* @return boolean 		boolean 	REGRESA UN BOLEANO DEPENDIENDO DEL EXITO DE LA TRANSACCION
		************************************************************/
		public function cambiar_contrasena($contrasena, $contrasena2, $id_usuario)
		{			
			$sql = "UPDATE usuario SET contrasena=:contrasena WHERE id_usuario=:id_usuario";
			$this->conexion();
			$stmt = $this->con->prepare($sql);
			$contrasena = md5($contrasena);
			$stmt->bindParam(':contrasena', $contrasena);
			$stmt->bindParam(':id_usuario', $id_usuario);
			$stmt->execute();
			if ($stmt->rowCount()>0) {
				return true;
			}else{
				return false;
			}
		} # END cambiar_contrasena
	} # END CLASS Dreamtour
?>