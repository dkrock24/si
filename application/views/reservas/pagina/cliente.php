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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    <style>

    .reserva_paquete {
        cursor:pointer;
    }

        .input-check {
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        .quantity {
  position: relative;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button
{
  -webkit-appearance: none;
  margin: 0;
}

input[type=number]
{
  -moz-appearance: textfield;
}

.quantity input {
  
  height: 42px;
  line-height: 1.65;
  float: left;
  display: block;
  padding: 0;
  margin: 0;
  padding-left: 20px;
  border: 1px solid #eee;
}

.quantity input:focus {
  outline: 0;
}

.quantity-nav {
  float: left;
  position: relative;
  height: 42px;
}

.quantity-button {
  position: relative;
  cursor: pointer;
  border-left: 1px solid #eee;
  width: 20px;
  text-align: center;
  color: #333;
  font-size: 13px;
  font-family: "Trebuchet MS", Helvetica, sans-serif !important;
  line-height: 1.7;
  -webkit-transform: translateX(-100%);
  transform: translateX(-100%);
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}

.quantity-button.quantity-up {
  position: absolute;
  height: 50%;
  top: 0;
  border-bottom: 1px solid #eee;
}

.quantity-button.quantity-down {
  position: absolute;
  bottom: -1px;
  height: 50%;
}

@media screen {
  #printSection {
      display: none;
  }
}

    @media print {
        body * {
            visibility:hidden;
        }
        #printSection, #printSection * {
            visibility:visible;
        }
        #printSection {
            position:absolute;
            left:0;
            top:0;
        }
    }

    </style>

    <script type="text/javascript">
    
    $(document).ready(function(){
        $("#reservacion_modal").appendTo('body');    
    });

    </script>

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
                            <a href="<?php echo base_url() ?>reservacion/empresa/index">
                                ORO Y <span>MIEL</span>
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
                                    <li class="smooth-menu"><a href="#pack">Precios </a></li>
                                    <li class="smooth-menu"><a href="#gallery">Instalaciones</a></li>
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
    <form action="reservar" name="reservar" method="post" enctype="multipart/form-data">
    <section id="home" class="about-us">

        <div class="container"><br><br><br><br><br><br>
            <div class="row">
                <div class="col-md-12">
                    <div class="single-travel-boxes">
                        <div id="desc-tabs" class="desc-tabs">

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="<?php echo base_url() ?>/reservacion/empresa/index" aria-controls="hotels" role="tab" data-toggle="tab">
                                        <i class="fa fa-building"></i>
                                        Hotel
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active fade in" id="tours">
                                    <div class="tab-para">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Nombre Responsable Reserva</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="text" class="form-control" required name="nombre_reserva" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Ingreso</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="date" name="fecha_entrada_reserva" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Hora</h2>
                                                    <div class="travel-person-icon">
                                                        <input type="time" name="hora_entrada_reserva" class="form-control" value="<?php echo date('15:00'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Salida</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="date" name="fecha_salida_reserva" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Hora</h2>
                                                    <div class="travel-person-icon">
                                                        <input type="time" name="hora_salida_reserva" class="form-control" value="<?php echo date('15:00'); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Adultos</h2>
                                                    <div class="travel-person-icon">
                                                        <input type="number" name="total_adultos_reserva" required min="1" value="1" max="100" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-sm-4">
                                                <div class="single-tab-select-box">
                                                    <h2>Niños</h2>
                                                    <div class="travel-person-icon">
                                                        <input type="number" name="total_ninos_reserva" min="0" value="0" max="100" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

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

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Número</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="text" class="form-control" required name="identificacion_numero_reserva" value="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">                                            

                                            <div class="col-lg-2 col-md-2 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Tipo Pago</h2>
                                                    <div class="travel-select-icon">
                                                        <select class="form-control " name="tipo_pago_reserva">
                                                            <option value="1">Efectivo</option><!-- /.option-->
                                                            <option value="2">T. Credito</option><!-- /.option-->
                                                            <option value="2">Abono Bancario</option><!-- /.option-->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-2 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Monto Abono</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="text" class="form-control" name="anticipo_pago_reserva" value="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Adjuntar Comprobante</h2>
                                                    <div class="travel-check-icon">
                                                        <input type="file" class="form-control" name="imagen_pago_reserva" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Telefono 1</h2>
                                                    <div class="travel-phone-icon">
                                                        <input type="text" class="form-control" required name="telefono_trabajo_reserva" value="">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="single-tab-select-box">
                                                    <h2>Telefono 2</h2>
                                                    <div class="travel-phone-icon">
                                                        <input type="text" class="form-control" name="telefono_celular_reserva" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                
                                            <h3 style="color:grey;">Comentarios</h3><br>
                                                <textarea class="form-control" name="comentario_reserva"></textarea>                                                
                                            </div>
                                           
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-12">
                                            <?php
                                            if($eventos) {
                                                foreach ($eventos as $key => $evento) 
                                                {
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <input type="checkbox" class="input-check" name="evento<?php echo $key ?>" value="<?php echo $evento->id_reserva_zona ?>" /> <?php echo $evento->nombre_zona ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </div>

                                            <div class="col-lg-4 col-md-5 col-sm-12">
                                            <br><br>
                                                <h4>
                                                    <?php
                                                    if (isset($unique)) {
                                                        echo "Tu Codigo de Reservación es : " . "<label class='badge badge-info' style='font-size:22px;background:orange;'>" . $unique . "<label>";
                                                        ?>
                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                $('#reservacion_modal').modal('show');
                                                            });                                                                
                                                        </script>
                                                        <?php
                                                    }
                                                    ?>
                                                </h4>
                                            </div>

                                            <div class="col-lg-5 col-md-4 col-sm-12"><br>
                                                <div class="about-btn travel-mrt-0 pull-right">
                                                    <?php if (!isset($unique)) : ?>
                                                        <input type="submit" class="about-view travel-btn" value="RESERVAR" />
                                                    <?php else: ?><br><br>
                                                        <a href="../index" class="about-view btn btn-default">Regresar</a>
                                                    <?php endif ?>
                                                </div>
                                            </div>

                                        </div>
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
    <section class="">
        <div class="row">
            <div class="col-sm-12">
                <div class="single-about-us">
                    <div class="about-us-txt"><br>
                        <?php
                        if (isset($unique)) {
                            ?>
                            <h2 style="color:black;text-align:center;background:white;">Gracias Por Tu Reserva!. En Breve Te contactaremos.</h2>
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
    </section>

    <!--packages start-->
    <section id="pack" class="packages" style="padding: 0px 0 90px;">
        <div class="container">
            <div class="gallary-header text-center">
            <br><br>
                <h2>
                    Paquetes
                </h2>
                <p>
                    Te ofrecemos los mejores precios para ti!
                </p>
            </div>
            <!--/.gallery-header-->
            <div class="packages-content">
                <div class="row">

                    <?php
                    $cnt = 0;
                    foreach ($paquetes as $key => $paquete) {
                        if (!$paquete->solo_imagen) {
                    ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="single-package-item">
                                    <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/packages/p1.jpg" alt="package-place" class="reserva_paquete img<?php echo $paquete->id_reserva_paquete; ?>" id="<?php echo $paquete->id_reserva_paquete; ?>">
                                    <div class="single-package-item-txt" id="reserva_informacion<?php echo $paquete->id_reserva_paquete; ?>">
                                        <h3><?php echo $paquete->nombre_paquete; ?> <span class="pull-right">$ <?php echo $paquete->precio_paquete; ?></span></h3>
                                        <div class="packages-para">
                                            <p><i class="fa fa-angle-right"></i> <?php echo $paquete->descripcion_paquete; ?></p>
                                        </div>
                                        <div class="packages-review">
                                            INCLUYE <br>
                                            <?php
                                            if ($paquete->estadia_paquete) {
                                            ?><span><i class="fa fa-angle-right"></i> ESTADIA</span><br><?php
                                            }
                                            if ($paquete->habitacion) {
                                                ?><span><i class="fa fa-angle-right"></i> HABITACION</span><br><?php
                                                }
                                                if ($paquete->comida_paquete) {
                                                    ?><span><i class="fa fa-angle-right"></i> COMIDA</span><br><?php
                                                }
                                                ?>
                                            <br>
                                            GRUPO DE PERSONAS <span><i class="fa fa-angle-right"></i> <?php echo $paquete->limite_personas ?></span><br>
                                        </div>
                                    </div>
                                    <div class="about-btn">
                                        <span style="padding-left:15px;">Selecionar</span>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <input type="checkbox" class="form-control" name="paquete_<?php echo $cnt; ?>" id="paquete" value="<?php echo $paquete->id_reserva_paquete; ?>" />
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <div class="quantity">
                                                        <input type="number" name="cantidad_<?php echo $cnt ?>" min="1" max="9" step="1" value="1">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="single-package-item">
                                    <?php if ($paquete->imagen_paquete) : ?>
                                        <img src="data: <?php echo $paquete->imagen_tipo ?> ;<?php echo 'base64'; ?>,<?php echo base64_encode($paquete->imagen_paquete) ?>" class="reserva_paquete img<?php echo $paquete->id_reserva_paquete; ?>" id="<?php echo $paquete->id_reserva_paquete; ?>" />

                                    <?php endif ?>
                                    <div class="single-package-item-txt" id="reserva_informacion<?php echo $paquete->id_reserva_paquete; ?>">
                                        <h3><?php echo $paquete->nombre_paquete; ?> <span class="pull-right">$ <?php echo $paquete->precio_paquete; ?></span></h3>
                                        <div class="packages-para">
                                            <p><i class="fa fa-angle-right"></i> <?php echo $paquete->descripcion_paquete; ?></p>
                                        </div>
                                        <div class="packages-review">
                                            INCLUYE <br>
                                            <?php
                                            if ($paquete->estadia_paquete) {
                                            ?><span><i class="fa fa-angle-right"></i> ESTADIA</span><br><?php
                                                }
                                                if ($paquete->habitacion) {
                                                    ?><span><i class="fa fa-angle-right"></i> HABITACION</span><br><?php
                                                    }
                                                    if ($paquete->comida_paquete) {
                                                        ?><span><i class="fa fa-angle-right"></i> COMIDA</span><br><?php
                                                    }
                                                    ?>
                                        </div>

                                    </div>
                                    <div class="about-btn">
                                        <span style="padding-left:15px;">Selecionar</span>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <input type="checkbox" class="form-control" name="paquete_<?php echo $cnt; ?>" id="paquete" value="<?php echo $paquete->id_reserva_paquete; ?>" />
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="quantity">
                                                    <input type="number" name="cantidad_<?php echo $cnt ?>" min="1" max="9" step="1" value="1">
                                                </div>
                                            </div>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                        $cnt++;
                    }
                    ?>
                </div>
                <!--/.row-->
            </div>
            <!--/.packages-content-->
        </div>
        <!--/.container-->

    </section>
    </form>
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
    <!--galley start-->
    <section id="gallery" class="gallery">
        <div class="container">
            <div class="gallery-details">
                <div class="gallary-header text-center">
                    <h2>
                        Instalaciones
                    </h2>
                    <p>
                        La mejor estancia para que disfrutes de un descanzo placentero
                    </p>
                </div>
                <!--/.gallery-header-->
                <div class="gallery-box">
                    <div class="gallery-content">
                        <div class="filtr-container">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g1.jpeg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                            Piscinas
                                            </a>
                                            <p><span>Infantiles</span><span>y para adultos</span></p>
                                        </div><!-- /.item-title -->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-6">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g2.jpeg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                Areas Comodas
                                            </a>
                                            <p><span>Infantiles</span><span>y para adultos</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-4">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g3.jpeg" alt="portfolio image" style="height: 300px;" />
                                        <div class="item-title">
                                            <a href="#">
                                                Espacios Libres
                                            </a>
                                            <p><span>Canchas</span><span>Abiertas</span></p>
                                        </div><!-- /.item-title -->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->


                                <div class="col-md-4">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g5.jpeg" alt="portfolio image" style="width: 100%;" />
                                        <div class="item-title">
                                            <a href="#">
                                                Habitaciones
                                            </a>
                                            <p><span>Comodas</span><span>para i</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-7">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g4.jpeg" alt="portfolio image" style="width: 100%;" />
                                        <div class="item-title">
                                            <a href="#">
                                                Areas Verdes
                                            </a>
                                            <p><span>Camina</span><span>Y disfruta</span></p>
                                        </div> <!-- /.item-title-->
                                    </div><!-- /.filtr-item -->
                                </div><!-- /.col -->

                                <div class="col-md-12">
                                    <div class="filtr-item">
                                        <img src="<?php echo base_url() ?>../asstes/pagina/reserva/images/gallary/g6.jpeg" alt="portfolio image" />
                                        <div class="item-title">
                                            <a href="#">
                                                Area comun
                                            </a>
                                            <p><span>Descanza</span><span>y pasala bien</span></p>
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

    <!-- footer-copyright start -->
    <footer class="footer-copyright">
        <div class="container">


            <div class="foot-icons ">
                <ul class="footer-social-links list-inline list-unstyled">
                    <li><a href="#" target="_blank" class="foot-icon-bg-1"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#" target="_blank" class="foot-icon-bg-2"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#" target="_blank" class="foot-icon-bg-3"><i class="fa fa-instagram"></i></a></li>
                </ul>
                <p>&copy; 2021 <a href="#">OroYMiel</a>. All Right Reserved</p>

            </div>
            <!--/.foot-icons-->
            <div id="scroll-Top">
                <i class="fa fa-angle-double-up return-to-top" id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
            </div>
            <!--/.scroll-Top-->
        </div><!-- /.container-->

    </footer><!-- /.footer-copyright-->



    <!-- Modal Large CLIENTES MODAL-->
    <div id="reserva_paquete" tabindex="-1" role="dialog" aria-labelledby="reserva_paquete" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info-dark">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="myModalLabelLarge" class="modal-title">Paquete Información</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <span class="load_paquete"></span>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <span class="load_detalle"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-gray-light">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Small-->

    <script>
        $(document).ready(function() {
            $("#reserva_paquete").appendTo('body');

            $(".reserva_paquete").on('click', function(e) {
                var reserva_paquete = $(this).attr('id');
                var el = $('#' + reserva_paquete).clone();
                $('.load_paquete').html(el);

                var reserva_informacion = $('#reserva_informacion' + reserva_paquete).clone();
                $('.load_detalle').html(reserva_informacion);

                $("#reserva_paquete").modal("show");
            });
        });

        jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });
    </script>

</body>

<!-- Modal Large RESERVAS MODAL-->
<div id="reservacion_modal" tabindex="-1" role="dialog" aria-labelledby="reservacion_modal"  class="modal fade">
      <div class="modal-dialog modal-lg">
         <div class="modal-content" id="reserva_info">
            <div class="modal-header bg-info-dark">
                <i class="fa fa-clock-o"></i> Reservación <b># <?php echo $unique; ?></b> : Datos Ingresados
               <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
                <?php
                if(isset($reserva)) {
                ?>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Nombre Reserva</h2>
                                <div class="">
                                    <?php echo $reserva['nombre_reserva']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="single-tab-select-box">
                                <h2>Ingreso</h2>
                                <div class="">
                                    <?php echo $reserva['fecha_entrada_reserva']; ?>
                                    <?php echo $reserva['hora_entrada_reserva']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="single-tab-select-box">
                                <h2>Salida</h2>
                                <div class="">
                                    <?php echo $reserva['fecha_salida_reserva']; ?>
                                    <?php echo $reserva['hora_salida_reserva']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="single-tab-select-box">
                                <h2>Adultos / Niños</h2>
                                <div class="">
                                    <?php echo $reserva['total_adultos_reserva']; ?> / <?php echo $reserva['total_ninos_reserva']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">

                                <h2>Documento</h2>
                                <div class="">
                                    <?php echo $reserva['identificacion_reserva']; ?> : 
                                    <?php echo $reserva['identificacion_numero_reserva']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Tipo Pago</h2>
                                <div class="">
                                    <?php echo $reserva['tipo_pago_reserva']; ?> : 
                                    <?php echo $reserva['anticipo_pago_reserva']; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Telefonos</h2>
                                <div class="">
                                    <?php echo $reserva['telefono_trabajo_reserva']; ?> / <?php echo $reserva['telefono_celular_reserva']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Eventos</h2>
                                <div class="">
                                    <?php echo $reserva['eventos']; ?>
                                </div>
                                <h2>Paquetes</h2>
                                <div class="">
                                    <?php echo $reserva['paquete']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Comentarios</h2>
                                <div class="">
                                    <?php echo $reserva['comentario_reserva']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="single-tab-select-box">
                                <h2>Nota</h2>
                                <div class="">Tu Código de reservación es : <b># <?php echo $unique; ?></b> Guarda / Imprime tu comprobante y presentalo al entrar
                                o mandalo via whatsapp si el ejecutivo de <b>ORO Y MIEL</b> te lo solicita. </div>
                            </div>
                        </div>
                    </div>
                    
                <?php
                }
                ?>
            </div>
            <div class="modal-footer bg-gray-light">
                <!-- <button type="button" id="btnPrint" class="btn btn-info">Imprimir</button> -->
               <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
         </div>
      </div>
   </div>
<!-- Modal Small-->

</html>