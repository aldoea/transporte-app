<?php  
	include "../dreamtour.class.php";
	$admin = new Dreamtour;
	$admin->validar(array('Gerente','Administrador'));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Panel de administrador</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
	<link rel="shortcut icon" href="https://cdn1.vectorstock.com/i/1000x1000/36/85/electric-bus-icon-vector-19713685.jpg">
	<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="index.php">Administrador</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">		      
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Catálogos
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="clientes.php">Clientes</a>
						<a class="dropdown-item" href="destinos.php">Destinos</a>
						<a class="dropdown-item" href="operadores.php">Operadores</a>
						<a class="dropdown-item" href="tipos.php">Tipo de unidades</a>
						<a class="dropdown-item" href="transportes.php">Transportes</a>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="../index.php">Vista de Cliente</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>