<?php  
  include "header.php";
?>
<main role="main">

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="first-slide" src="images/unidades/camioneta_suburban.jpg" alt="First slide">
      <div class="container">
        <div class="carousel-caption bg-dark-oppacity text-left">
          <h1>Lujo sin precedentes</h1>
          <p>Viaja con todas las comodides que te mereces, contamos con las mejores unidades y el mejor servicio.</p>
          <p><a class="btn btn-lg btn-primary" href="transportes.php" role="button">Viaja ahora</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img class="second-slide" src="images/unidades/sprinter_basica.jpg" alt="Second slide">
      <div class="container">
        <div class="carousel-caption bg-dark-oppacity">
          <h1>El mejor servicio a tu medida</h1>
          <p>Contamos con gran variedad de opciones adecuadas a tus gustos y necesidades, encuentra tu transporte ideal al mejor precio.</p>
          <p><a class="btn btn-lg btn-primary" href="transportes.php" role="button">Viaja ahora</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img class="third-slide" src="images/sliders/travels.jpg" alt="Third slide">
      <div class="container">
        <div class="carousel-caption bg-dark-oppacity text-right">
          <h1>¿Negocios o placer?</h1>
          <p>No importa cuál sea el motivo de tu viaje, te acompañamos desde el primer momento de tu viaje para que sea la experiencia más placentera posible.</p>
          <p><a class="btn btn-lg btn-primary" href="transportes.php" role="button">Viaja ahora</a></p>
        </div>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<!-- Marketing messaging and featurettes
================================================== -->
<!-- Wrap the rest of the page in another container to center all the content. -->

<div class="container marketing">

  <!-- Three columns of text below the carousel -->
  <div class="row">
    <div class="col-lg-4">
      <img class="rounded-circle" src="images/marketing/driver.jpg" alt="Happy driver" width="140" height="140">
      <h2>Los mejores</h2>
      <p>En Dreamtour siempre contratamos a los mejores operadores para siempre brindarte el servicio profesional que tu mereces.</p>      
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="images/marketing/customer.jpg" alt="Generic placeholder image" width="140" height="140">
      <h2>Clientes satisfechos</h2>
      <p>Nuestros clientes satisfechos siempre regresan, porque saben que aquí encuentran siempre el mejor servicio</p>      
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
      <img class="rounded-circle" src="images/marketing/service.jpg" alt="Generic placeholder image" width="140" height="140">
      <h2>Equipo capacitado</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.</p>      
    </div><!-- /.col-lg-4 -->
  </div><!-- /.row -->


  <!-- START THE FEATURETTES -->

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading">Siempre conectado.<span class="text-muted">Siempre productivo.</span></h2>
      <p class="lead">No te preocupes por quedarte sin señal, mantente siempre comunicado a lo largo de tu viaje, ya que todas nuestras unidades cuentan con WiFi.</p>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-fluid mx-auto" src="images/marketing/wifi.jpg" alt="Generic placeholder image">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7 order-md-2">
      <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
      <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
    </div>
    <div class="col-md-5 order-md-1">
      <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
    </div>
  </div>

  <hr class="featurette-divider">

  <div class="row featurette">
    <div class="col-md-7">
      <h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
      <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
    </div>
    <div class="col-md-5">
      <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
    </div>
  </div>

  <hr class="featurette-divider">

  <!-- /END THE FEATURETTES -->
</div><!-- /.container -->
<?php  
  include "footer.php";
?>
