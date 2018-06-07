<?php  
  include 'header.php';

  // SUBMIT ACTION
  if (isset($_POST['crear'])) {
    /*
     __     __    _ _     _            _                       
     \ \   / /_ _| (_) __| | __ _  ___(_) ___  _ __   ___  ___ 
      \ \ / / _` | | |/ _` |/ _` |/ __| |/ _ \| '_ \ / _ \/ __|
       \ V / (_| | | | (_| | (_| | (__| | (_) | | | |  __/\__ \
        \_/ \__,_|_|_|\__,_|\__,_|\___|_|\___/|_| |_|\___||___/
                                                               
    */
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : null;
    $contrasena_repeat = isset($_POST['contrasena_repeat']) ? $_POST['contrasena_repeat'] : null;

    $validation_errors = [];
    if ( !(!is_null($nombre) && strlen($nombre) > 3) ) {
      array_push($validation_errors, "Nombre incorrecto, intente con otro diferente");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($validation_errors, "El correo electrónico es invalido");
    }
    if($contrasena != $contrasena_repeat){
      array_push($validation_errors, "Las contraseñas no coinciden");
    }
    if (count($validation_errors) == 0) {
      $dreamtour->registrar($nombre, $email, $contrasena, $contrasena_repeat);
    }else{
      foreach ($validation_errors as $error) {
        echo $error;
        echo "<br/>";
      }
    }
  }
?>    
<main class="container justify-content-center mx-auto">
  <div class="col-md-6 offset-md-3">
    <form class="form-signin" method="post" action="signup.php">      
      <h1 class="h3 mb-3 font-weight-normal">Crear un usuario</h1>
      <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" class="form-control" id="nombre" aria-describedby="nombre" placeholder="Nombre" required="">
          <label for="correo">Correo</label>            
          <input type="email" name="email" class="form-control" id="correo" aria-describedby="correo" placeholder="Correo" required="">
          <label for="nombre">Contraseña</label>
          <input type="password" name="contrasena" class="form-control" id="contrasena" aria-describedby="contrasena" placeholder="Contraseña" required="">
          <label for="nombre">Contraseña</label>
          <input type="password" name="contrasena_repeat" class="form-control" id="contrasena_repeat" aria-describedby="contrasena" placeholder="Repetir contraseña" required="">
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="crear" type="submit">Crear usuario</button>
      <p class="mt-5 mb-3 text-muted">Ya tengo una <a href="signin.php">cuenta</a></p>  
    </form>
  </div>
</main>
<?php  
  include 'footer.php';
?>    