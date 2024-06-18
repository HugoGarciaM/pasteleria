<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with FoodHut landing page.">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>Pasteleria Pepita</title>

        <!-- font icons -->
        <link rel="stylesheet" href="{{asset('assets/vendors/themify-icons/css/themify-icons.css')}}">

        <link rel="stylesheet" href="{{asset('assets/vendors/animate/animate.css')}}">

        <!-- Bootstrap + FoodHut main styles -->
        <link rel="stylesheet" href="{{asset('assets/css/foodhut.css')}}">
    </head>
    <body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

        <!-- Navbar -->
        <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Acerca</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallary">Galeria</a>
                    </li>
                    <!-- <li class="nav-item"> -->
                    <!--     <a class="nav-link" href="#book-table">Book-Table</a> -->
                    <!-- </li> -->
                </ul>
                <a class="navbar-brand m-auto" href="#">
                    <img src="assets/imgs/logo.png" class="brand-img" alt="">
                    <span class="brand-txt">Pasteleria Pepita</span>
                </a>
                <ul class="navbar-nav">
                    <!-- <li class="nav-item"> -->
                    <!--     <a class="nav-link" href="#blog">Blog<span class="sr-only">(current)</span></a> -->
                    <!-- </li> -->
                    <!-- <li class="nav-item"> -->
                    <!--     <a class="nav-link" href="#testmonial">Reviews</a> -->
                    <!-- </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contactanos</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('register')}}" class="btn btn-primary ml-xl-4">Registrase</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- header -->
        <header id="home" class="header">
            <div class="overlay text-white text-center">
                <h1 class="display-2 font-weight-bold my-3">Pasteleria Pepita</h1>
                <h2 class="display-4 mb-5">Siempre fresco &amp; encantador</h2>
                <a class="btn btn-lg btn-primary" href="#gallary">Revisa nuestra Galeria</a>
            </div>
        </header>

        <!--  About Section  -->
        <div id="about" class="container-fluid wow fadeIn" id="about"data-wow-duration="1.5s">
            <div class="row">
                <div class="col-lg-6 has-img-bg"></div>
                <div class="col-lg-6">
                    <div class="row justify-content-center">
                        <div class="col-sm-8 py-5 my-5">
                            <h2 class="mb-4">sobre nosotros</h2>
                            <p>En Pasteleria Pepita, nos enorgullece ofrecer productos de la más alta calidad. Nuestro compromiso con la excelencia se refleja en cada uno de nuestros deliciosos pasteles, panes y postres, todos elaborados con ingredientes frescos y de primera calidad.</p>
                            <p>Nuestra historia comenzó con una pasión por la repostería y el deseo de compartir nuestras creaciones con la comunidad. Hoy en día, seguimos dedicándonos a crear experiencias dulces e inolvidables para nuestros clientes. Cada receta es una obra de amor, y nos esforzamos por mantener altos estándares de calidad en todo lo que hacemos.</p>
                            <p>Creemos que un buen postre puede hacer cualquier día un poco más especial. Ya sea que estés celebrando una ocasión importante o simplemente quieras disfrutar de un delicioso capricho, en [Nombre de la Pastelería] encontrarás lo que buscas. Visítanos y déjanos endulzar tu vida con nuestros productos frescos y artesanales.</p>
                            <p>Gracias por elegirnos y confiar en nosotros para tus momentos más dulces. ¡Esperamos verte pronto!</p>

                            <p style="text-align: center; font-style: italic; margin-top: 20px;">
                            <b>"Las personas que aman comer siempre son las mejores personas." – Julia Child</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  gallary Section  -->
        <div id="gallary" class="text-center bg-dark text-light has-height-md middle-items wow fadeIn">
            <h2 class="section-title">NUESTRO MENÚ</h2>
            <h5>Ahora mas cerca de ustedes, Ofrecemos una variedad de pasteles y postres, reservalos ¡<a href="{{route('register')}}">Registrandote!</a></h5>
        </div>
        <div class="gallary row">
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-1.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-2.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-3.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-4.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-5.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-6.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-7.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-8.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-9.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-10.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-11.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3 gallary-item wow fadeIn">
                <img src="assets/imgs/gallary-12.jpg"  class="gallary-img">
                <a href="#" class="gallary-overlay">
                    <i class="gallary-icon ti-plus"></i>
                </a>
            </div>
        </div>

        <!-- CONTACT Section  -->
        <div id="contact" class="container-fluid bg-dark text-light border-top wow fadeIn">
            <div class="row">
                <div class="col-md-6 px-0">
                    <div id="map" style="width: 100%; height: 100%; min-height: 400px"></div>
                </div>
                <div class="col-md-6 px-5 has-height-lg middle-items">
                    <h3>Encuéntranos</h3>
                    <p>Estamos ubicados en la ciudad de Oruro-Bolivia, Zona Sud de la cuidad</p>
                    <div class="text-muted">
                        <p><span class="ti-location-pin pr-3"></span> #555 Zona Sud, Mercado Roberto Young</p>
                        <p><span class="ti-support pr-3"></span> +591 61813282</p>
                        <p><span class="ti-email pr-3"></span>pasteleria@pepita.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- page footer  -->
        <div class="container-fluid bg-dark text-light has-height-md middle-items border-top text-center wow fadeIn">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Envíanos un correo electrónico</h3>
                    <P class="text-muted">pasteleria@pepita.com</P>
                </div>
                <div class="col-sm-4">
                    <h3>llamanos</h3>
                    <P class="text-muted">(123) 456-7890</P>
                </div>
                <div class="col-sm-4">
                    <h3>Encuéntranos</h3>
                    <P class="text-muted">#555 Zona Sud, Mercado Roberto Young</P>
                </div>
            </div>
        </div>
        <div class="bg-dark text-light text-center border-top wow fadeIn">
            <p class="mb-0 py-3 text-muted small">&copy; <script>document.write(new Date().getFullYear())</script></p>
        </div>
        {{-- end of page footer --}}

        <!-- core  -->
        <script src="{{asset('assets/vendors/jquery/jquery-3.4.1.js')}}"></script>
        <script src="{{asset('assets/vendors/bootstrap/bootstrap.bundle.js')}}"></script>

        <!-- bootstrap affix -->
        <script src="{{asset('assets/vendors/bootstrap/bootstrap.affix.js')}}"></script>

        <!-- wow.js -->
        <script src="{{asset('assets/vendors/wow/wow.js')}}"></script>

        <!-- google maps -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap"></script>

        <!-- FoodHut js -->
        <script src="{{asset('assets/js/foodhut.js')}}"></script>

    </body>
</html>

