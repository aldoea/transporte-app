<?php  
  include "dreamtour.class.php";
  $dreamtour = new Dreamtour;
  $dreamtour->conexion();
?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Dreamtour</title>    
      <!-- Custom styles for this template -->   
    <!-- <link href="css/signin.css" rel="stylesheet"> -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="css/carousel.css" rel="stylesheet">
    <link rel="shortcut icon" href="https://cdn1.vectorstock.com/i/1000x1000/36/85/electric-bus-icon-vector-19713685.jpg">
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

  </head>
  <body>    
    <!-- <header class="container-fluid"> -->
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-blueklein">      
        <a class="navbar-brand" href="index.php">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="cotizar.php">Cotizar <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="transportes.php">Transportes</a>
            </li>
          </ul>
          <?php  
            if (!isset($_SESSION['validado'])) {
              echo '
                <ul class="navbar-nav flex-row ml-md-auto d-md-flex">    
                    <li class="nav-item">
                      <a class="nav-link p-2" href="signin.php">Login</a>
                    </li>
                    <li class="nav-item">                
                      <a class="nav-link p-2 text-darkorange-bold" href="signup.php">Registrarse</a>
                    </li>    
                </ul>
              ';
            }else{
              echo '
                <ul class="navbar-nav flex-row ml-md-auto d-md-flex">                        
                    <li class="nav-item dropdown mr-4">
                      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cuenta</a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="reservaciones.php">Mis reservaciones</a>
                        <a class="dropdown-item" href="perfil.php">Mi perfil</a>
                      </div>
                    </li>
                    <li class="nav-item">                
                      <a class="nav-link p-2 text-darkorange-bold" href="logout.php">Salir</a>
                    </li>    
                </ul>
              ';
            }
          ?>          
          <!-- <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Buscar transporte" aria-label="Buscar">
            <button class="btn btn-outline-light btn-outline-darkorange my-2 my-sm-0" type="submit">Buscar</button>
          </form> -->
        </div>
      </nav>
    <!-- </header> -->      