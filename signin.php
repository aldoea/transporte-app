<?php  
  include 'header.php';
    if (isset($_POST['login'])) {   
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $dreamtour->login($email,$contrasena);
  }
?>
<main class="container justify-content-center mx-auto">
  <div class="col-md-6 offset-md-3">
    <form class="form-signin" method="post" action="signin.php">      
      <h1 class="h3 mb-3 font-weight-normal">Por favor inicie sesión</h1>
      <label for="inputEmail" class="sr-only">Correo o alias</label>
      <input type="email" id="inputEmail" class="form-control mb-2" placeholder="Correo o alias" name="email" required autofocus>
      <label for="inputPassword" class="sr-only">Contraseña</label>
      <input type="password" id="inputPassword" class="form-control mb-2" placeholder="Contraseña" name="contrasena" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Recordarme
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Iniciar sesión</button>
      <p class="mt-5 mb-3 text-muted">No tengo una <a href="signup.php">cuenta</a> aún</p>  
    </form>
  </div>  
</main>    
<?php  
  include 'footer.php';
?>    