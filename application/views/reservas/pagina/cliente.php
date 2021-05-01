<!doctype html>
<html class="no-js" lang="en">

<head>
    <!-- META DATA -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!--font-family-->
    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

    <!-- TITLE OF SITE -->
    <title>Reservas</title>

    <!-- favicon img -->
    <link rel="shortcut icon" type="image/icon" href="<?php echo base_url() ?>../asstes/pagina/reserva/logo/favicon.png" />

    <!--font-awesome.min.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/font-awesome.min.css" />

    <!--animate.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/animate.css" />

    <!--hover.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/hover-min.css">

    <!--datepicker.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/datepicker.css">

    <!--owl.carousel.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/owl.theme.default.min.css" />

    <!-- range css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/jquery-ui.min.css" />

    <!--bootstrap.min.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/bootstrap.min.css" />

    <!-- bootsnav -->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/bootsnav.css" />

    <!--style.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/style.css" />

    <!--responsive.css-->
    <link rel="stylesheet" href="<?php echo base_url() ?>../asstes/pagina/reserva/css/responsive.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
    <!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
			your browser</a> to improve your experience and security.</p>
		<![endif]-->

    <!-- main-menu Start -->
    <header class="top-area">
        <div class="header-area">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="logo">
                            <a href="#">
                                Empresa<span>Name</span>
                            </a>
                        </div><!-- /.logo-->
                    </div><!-- /.col-->
                    <div class="col-sm-10">
                        <div class="main-menu">

                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <i class="fa fa-bars"></i>
                                </button><!-- / button-->
                            </div><!-- /.navbar-header-->
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    <li class="smooth-menu"><a href="#home">Inicio</a></li>
                                    <li class="smooth-menu"><a href="#gallery">Instalaciones</a></li>
                                    <li class="smooth-menu"><a href="#pack">Precios </a></li>
                                    <!--/.project-btn-->
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.main-menu-->
                    </div><!-- /.col-->
                </div><!-- /.row -->
                <div class="home-border"></div><!-- /.home-border-->
            </div><!-- /.container-->
        </div><!-- /.header-area -->

    </header><!-- /.top-area-->
    <!-- main-menu End -->


    <!--about-us start -->
    <section id="home" class="about-us">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="single-travel-boxes">
                        <div id="desc-tabs" class="desc-tabs">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#hotels" aria-controls="hotels" role="tab" data-toggle="tab">
                                        <i class="fa fa-building"></i>
                                        hotels
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active fade in" id="tours">
                                    <div class="tab-para">

                                        <form action="reservar" name="reservar" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="single-tab-select-box">

                                                        <h2>Nombre Reservacón</h2>

                                                        <div class="travel-check-icon">
                                                            <input type="text" class="form-control" required name="nombre_reserva" value="">
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-3 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Ingreso</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="date" name="fecha_entrada_reserva" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-3 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Salida</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="date" name="fecha_salida_reserva" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-1 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Adultos</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="number" name="total_adultos_reserva" required min="1" max="100" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-1 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Niños</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="number" name="total_ninos_reserva" required min="1" max="100" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="single-tab-select-box">

                                                        <h2>Documento</h2>
                                                        <div class="travel-select-icon">
                                                            <select class="form-control " name="identificacion_reserva">
                                                                <option value="DUI">DUI</option><!-- /.option-->
                                                                <option value="NIT">NIT</option><!-- /.option-->
                                                                <option value="PASAPORTE">PASAPORTE</option><!-- /.option-->
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Número</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="text" class="form-control" required name="identificacion_numero_reserva" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-3 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Tipo Pago</h2>
                                                        <div class="travel-select-icon">
                                                            <select class="form-control " name="tipo_pago_reserva">
                                                                <option value="1">Efectivo</option><!-- /.option-->
                                                                <option value="2">T. Credito</option><!-- /.option-->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-md-1 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Monto Abono</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="text" class="form-control" name="anticipo_pago_reserva" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-12">
                                                    <div class="single-tab-select-box">

                                                        <h2>Telefono 1</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="text" class="form-control" required name="telefono_trabajo_reserva" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Telefono 2</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="text" class="form-control" name="telefono_celular_reserva" value="">
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-4">
                                                    <div class="single-tab-select-box">
                                                        <h2>Adjuntar Comprobante</h2>
                                                        <div class="travel-check-icon">
                                                            <input type="file" class="form-control" name="imagen_pago_reserva" value="">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <h4>
                                                        <?php
                                                        if (isset($unique)) {
                                                            echo "Tu Codigo de Reserva es : " . "<label class='badge badge-info' style='font-size:22px;background:orange;'>".$unique."<label>";
                                                        }
                                                        ?>
                                                    </h4>
                                                </div>

                                                <div class="clo-sm-7">
                                                    <div class="about-btn travel-mrt-0 pull-right">
                                                        <input type="submit" class="about-view travel-btn" value="Registrar" />
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane fade in" id="hotels">
                                   
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--travel-box start-->
    <section class="travel-box">

        <div class="container">
            <div class="about-us-content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="single-about-us">
                            <div class="about-us-txt">
                                <?php
                                if (isset($unique)) {
                                    ?>
                                    <h2 style="color:white;">Gracias Por Tu Reserva!. En Breve Te contactaremos.</h2>
                                    <?php
                                } else {
                                    ?>
                                    <h2 style="color:white;">Realiza tu Reservación Ya!</h2>
                                    <?php
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-0">
                        <div class="single-about-us">

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <!--service start-->
    <section id="service" class="service">
        <div class="container">

            <div class="service-counter text-center">

                <div class="col-md-4 col-sm-4">
                    <div class="single-service-box">
                        <div class="service-img">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/service/s1.png" alt="service-icon" />
                        </div>
                        <!--/.service-img-->
                        <div class="service-content">
                            <h2>
                                <a href="#">
                                    Visitanos desde cualquier lugar
                                </a>
                            </h2>
                            <p>Estamos listos para que pases una linda estadia!</p>
                        </div>
                        <!--/.service-content-->
                    </div>
                    <!--/.single-service-box-->
                </div>
                <!--/.col-->

                <div class="col-md-4 col-sm-4">
                    <div class="single-service-box">
                        <div class="service-img">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/service/s2.png" alt="service-icon" />
                        </div>
                        <!--/.service-img-->
                        <div class="service-content">
                            <h2>
                                <a href="#">
                                    Modernas Instalaciones
                                </a>
                            </h2>
                            <p>Nuetro complejo cuenta con unas bonitas instalaciones modernas!</p>
                        </div>
                        <!--/.service-content-->
                    </div>
                    <!--/.single-service-box-->
                </div>
                <!--/.col-->

                <div class="col-md-4 col-sm-4">
                    <div class="single-service-box">
                        <div class="statistics-img">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/service/s3.png" alt="service-icon" />
                        </div>
                        <!--/.service-img-->
                        <div class="service-content">

                            <h2>
                                <a href="#">
                                    Viaja y Disfruta
                                </a>
                            </h2>
                            <p>Estamos preparados para brindarte lo mejor!</p>
                        </div>
                        <!--/.service-content-->
                    </div>
                    <!--/.single-service-box-->
                </div>
                <!--/.col-->

            </div>
            <!--/.statistics-counter-->
        </div>
        <!--/.container-->

    </section>
    <!--/.service-->
    <!--service end-->

    <!--galley start-->
    <section id="gallery" class="gallery">
        <div class="container">
            <div class="gallery-details">
                <div class="gallary-header text-center">
                    <h2>
                        top destination
                    </h2>
                    <p>
                        Where do you wanna go? How much you wanna explore?
                    </p>
                </div>
                <!--/.gallery-header-->
                <div class="gallery-box">
                    <div class="gallery-content">
                        <div class="filtr-container">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g1.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                china
                                            </a>
                                            <p><span>20 tours</span><span>15 places</span></p>
                                        </div><!-- /.item-title -->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-6">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g2.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                venuzuala
                                            </a>
                                            <p><span>12 tours</span><span>9 places</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-4">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g3.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                brazil
                                            </a>
                                            <p><span>25 tours</span><span>10 places</span></p>
                                        </div><!-- /.item-title -->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-4">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g4.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                australia
                                            </a>
                                            <p><span>18 tours</span><span>9 places</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-4">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g5.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                netharlands
                                            </a>
                                            <p><span>14 tours</span><span>12 places</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-8">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g6.jpg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                turkey
                                            </a>
                                            <p><span>14 tours</span><span>6 places</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                            </div><!-- /.row -->

                        </div><!-- /.filtr-container-->
                    </div><!-- /.gallery-content -->
                </div>
                <!--/.galley-box-->
            </div>
            <!--/.gallery-details-->
        </div>
        <!--/.container-->

    </section>
    <!--/.gallery-->
    <!--gallery end-->



    <!--packages start-->
    <section id="pack" class="packages">
        <div class="container">
            <div class="gallary-header text-center">
                <h2>
                    Precios Especiales
                </h2>
                <p>
                    Te ofrecemos los mejores precios para ti!
                </p>
            </div>
            <!--/.gallery-header-->
            <div class="packages-content">
                <div class="row">

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p1.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>italy <span class="pull-right">$499</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 3 Days 2 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> food facilities
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>254 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p1.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>england <span class="pull-right">$1499</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 6 Days 7 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> Free food
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>344 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p1.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>france <span class="pull-right">$1199</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 5 Days 6 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> food facilities
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>544 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p4.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>india <span class="pull-right">$799</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 4 Days 5 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> food facilities
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>625 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p4.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>spain <span class="pull-right">$999</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 4 Days 4 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> food facilities
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>379 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                    <div class="col-md-4 col-sm-6">
                        <div class="single-package-item">
                            <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p4.jpg" alt="package-place">
                            <div class="single-package-item-txt">
                                <h3>thailand <span class="pull-right">$799</span></h3>
                                <div class="packages-para">
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> 5 Days 6 nights
                                        </span>
                                        <i class="fa fa-angle-right"></i> 5 star accomodation
                                    </p>
                                    <p>
                                        <span>
                                            <i class="fa fa-angle-right"></i> transportation
                                        </span>
                                        <i class="fa fa-angle-right"></i> food facilities
                                    </p>
                                </div>
                                <!--/.packages-para-->
                                <div class="packages-review">
                                    <p>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <span>447 reviews</span>
                                    </p>
                                </div>
                                <!--/.packages-review-->
                                <div class="about-btn">
                                    <button class="about-view packages-btn">
                                        book now
                                    </button>
                                </div>
                                <!--/.about-btn-->
                            </div>
                            <!--/.single-package-item-txt-->
                        </div>
                        <!--/.single-package-item-->

                    </div>
                    <!--/.col-->

                </div>
                <!--/.row-->
            </div>
            <!--/.packages-content-->
        </div>
        <!--/.container-->

    </section>
    <!--/.packages-->
    <!--packages end-->


    <!--subscribe end-->

    <!-- footer-copyright start -->
    <footer class="footer-copyright">
        <div class="container">


            <div class="foot-icons ">
                <ul class="footer-social-links list-inline list-unstyled">
                    <li><a href="#" target="_blank" class="foot-icon-bg-1"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" target="_blank" class="foot-icon-bg-2"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" target="_blank" class="foot-icon-bg-3"><i class="fa fa-instagram"></i></a></li>
                </ul>
                <p>&copy; 2021 <a href="https://www.themesine.com">Empresa</a>. All Right Reserved</p>

            </div>
            <!--/.foot-icons-->
            <div id="scroll-Top">
                <i class="fa fa-angle-double-up return-to-top" id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
            </div>
            <!--/.scroll-Top-->
        </div><!-- /.container-->

    </footer><!-- /.footer-copyright-->
    <!-- footer-copyright end -->




    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <!--modernizr.min.js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>


    <!--bootstrap.min.js-->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/bootstrap.min.js"></script>

    <!-- bootsnav js -->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/bootsnav.js"></script>

    <!-- jquery.filterizr.min.js -->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/jquery.filterizr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!--jquery-ui.min.js-->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/jquery-ui.min.js"></script>

    <!-- counter js -->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/waypoints.min.js"></script>

    <!--owl.carousel.js-->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/owl.carousel.min.js"></script>

    <!-- jquery.sticky.js -->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/jquery.sticky.js"></script>

    <!--datepicker.js-->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/datepicker.js"></script>

    <!--Custom JS-->
    <script src="<?php echo base_url() ?>../asstes/pagina/reserva/js/custom.js"></script>


</body>

</html>