<!DOCTYPE html>
<html lang="en">
<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>../asstes/login/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/main.css">
    <!--===============================================================================================-->

    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.css">

    <title><?php echo $nodo[0]->nodo_nombre; ?></title>
</header>

<body class="" style="background:#ebedef;">
    <div class="row" style="height:100%;width:100%;background:red">
        <div class="card" style="height:100%;width:100%;background:#ebedef;">
            <div class="card-body" style="height:100%;width:100%;">
                <div class=" justify-content-between">

                    <div class="commandas" style="position: absolute;display:inline-block; margin-top:10px;width:100%;">
                        <div class="row listaComandas">
                            <?php
                            //var_dump($ordenes);
                        if ($ordenes){
                            foreach ($ordenes as $comanda) {
                            ?>                                
                                <div class="card comanda<?php echo $comanda->id; ?>">
                                    <div class="card-body row text-center">
                                        
                                        <div class="col">                                            
                                            <div class="text-uppercase text-muted small">
                                                <h2><?php echo $comanda->id; ?> <span class="badge badge-secondary">ORDEN</span></h2>
                                            </div>
                                        </div>
                                        <div class="c-vr"></div>
                                        
                                        <div class="col">
                                            <div class="text-uppercase text-muted small">
                                                <h2><?php echo count((array)$comanda->detalle); ?> <br><span class="badge badge-secondary">ITEMS</span></h2>
                                            </div>                                          
                                        </div>

                                        <div class="c-vr"></div>                                     
                                            
                                        <div class="col">
                                            <div class="text-value-xl">
                                            <br>
                                                <a class="btn btn-success" onClick="terminar_comanda(<?php echo $comanda->id ?>,<?php echo $nodo[0]->id_nodo ?>)" id="<?php echo $comanda->id ?>" nodo="<?php echo $nodo[0]->id_nodo ?>" style="color:white;">Completar</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header bg-facebook content-center">
                                        <table class="table">
                                            <?php
                                            foreach ($comanda->detalle as $detalle) {
                                            ?>
                                                <tr>
                                                    <td><?php echo (int) $detalle->cantidad ?></td>
                                                    <td><?php echo $detalle->descripcion ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    </div>
                                </div>                                
                                <br>
                            <?php
                            }
                        }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer" style="bottom:0px;position: relative; background:white;">
                <div class="row text-center">
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Nodo</div><h2><strong><i class="fa fa-tree"></i>  <?php echo $nodo[0]->nodo_nombre ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Sucursal</div><h2><strong><i class="fa fa-home"></i>  <?php echo $nodo[0]->nombre_sucursal ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Ordenes Activas</div><h2><i class="fa fa-bell"></i><strong class="ordenes_activas"><?php echo count((array) $ordenes) ?></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 100%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">Fecha Hora</div><h2><i class="fa fa-clock-o"></i><strong class="fecha"></strong> <strong class="hora"></strong></h2>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<!--===============================================================================================-->
<script src="<?php echo base_url(); ?>../asstes/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/popper.js"></script>
<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.min.js"></script>

<script src="<?php echo base_url(); ?>../asstes/js/moment.min.js"></script>

<script>

    getData();
    getTime();

    let ordenData = [];

    let total_ordenes = <?php if($ordenes){ echo count($ordenes); }else { echo 0;} ?>;

    $(document).ready(function(){
        const interval = setInterval(function() {
            LongPolling();
        }, <?php echo $nodo[0]->nodo_tiempo ?> );
        
    });

    function terminar_comanda(id,nodo)
    {
        let env = {
            "comandaId" :id,
            "comandaNodo" : nodo,
            "items" : ordenData
        }

        params = getGeneralParams();

        showNotification(params, env);
    }

    function getGeneralParams()
    {
        return params = {
            "type" : "info",
            "title" : "Remover Comanda",
            "mensaje" : "",
            "boton" : "info",
            "finalMessage" : "Gracias..."
        };
    }

    function showNotification(params, env) {
        
        var confirm = false;
        $('.cancel').focus();

        swal({
            html: true,
            title: params.title + " #"+env.comandaId,
            text: params.mensaje,
            type: params.type,
            showCancelButton: true,
            confirmButtonText: "Eliminar",
        }, function (isConfirm) {

            if (isConfirm) {

                swal("Eliminado", params.finalMessage);
                $(".comanda"+ env.comandaId).remove();
                confirm = true;

                $.ajax({
                    type: "post",
                    data: {env},
                    url: "<?php echo base_url(); ?>"+'nodo/moverComanda',
                    success: function(result) {

                        //$(".loadViews").html(result);
                        setTotalordenes(total_ordenes);
                    }
                });
                
            } else {
                swal("Salir", "Salir", "error");
            } 
        });
        return confirm;
    }

    function LongPolling()
    {
        $.ajax({ 
            type: "GET", 
            dataType: "json", 
            url: "<?php echo base_url(); ?>"+'nodo/polling/<?php echo $nodo[0]->nodo_key ?>',
            success: function(data){
                dibujarComanda(data);
            },
            error: function(err) {
                // do whatever you want when error occurs
            },
        });
    }

    function dibujarComanda(data)
    {
        let _htmlComanda = '';

        ordenData = [];

        $.each(data.ordenes, function(i, index){

            ordenData[index.id] = index;

            _htmlComanda += '<div class="card comanda'+index.id+'">';
                _htmlComanda += '<div class="card-body row text-center">';
                    _htmlComanda += '<div class="col">';
                        _htmlComanda += '<div class="text-uppercase text-muted small">';
                            _htmlComanda += '<h2>'+index.id+' <span class="badge badge-secondary">ORDEN</span> </h2>';
                        _htmlComanda += '</div>';
                    _htmlComanda += '</div>';
                    _htmlComanda += '<div class="c-vr"></div>',
                    _htmlComanda += '<div class="col">';
                        _htmlComanda += '<div class="text-uppercase text-muted small">';
                            _htmlComanda += '<h2>'+ get_total_items_orden(index) +' <br> <span class="badge badge-secondary">ITEMS</span> </h2>';
                        _htmlComanda += '</div>';
                    _htmlComanda += '</div>';
                    _htmlComanda += '<div class="c-vr"></div>';
                    _htmlComanda += '<div class="col">';
                        _htmlComanda += '<div class="text-uppercase text-muted small"><br><a class="btn btn-success" onClick="terminar_comanda('+index.id+','+data.nodo[0].id_nodo+')" id="'+index.id+'" nodo="'+data.nodo[0].id_nodo+'" style="color:white;">Completar</a></div>';
                    _htmlComanda += '</div>';
                _htmlComanda += '</div>';

                _htmlComanda += '<div class="card-header bg-facebook content-center">';
                    _htmlComanda += '<table class="table">';
                        $.each(index.detalle, function(i, detalle){

                            _htmlComanda += '<tr>';
                                _htmlComanda += '<td>'+ detalle.cantidad +'</td>';
                                _htmlComanda += '<td>'+ detalle.descripcion +'</td>';
                            _htmlComanda += '</tr>';
                        });
                    _htmlComanda += '</table>';
                _htmlComanda += '</div>';

            _htmlComanda += '</div>';

        });

        $(".ordenes_activas").text(getTotalOrednes(data));
        $(".listaComandas").html(_htmlComanda);
    }

    function get_total_items_orden(index)
    {
        return Object.keys(index.detalle).length;
    }

    function setTotalordenes(total)
    {
        $(".ordenes_activas").text(--total);
    }

    function getTotalOrednes(data)
    {
        if (!data.ordenes) {
            return 0;
        }

        return Object.keys(data.ordenes).length;
    }

    function getTime()
    {
        var interval = setInterval(function() {
  			var momentNow = moment();
  			//        $('#time-part').html(momentNow.format('MMMM DD'));
  			$('.hora').html(momentNow.format('hh:mm A'));
  		}, 100);
    }

    function getData()
    {
        var months = {

            January: {
                Name: "January",
                Translate: "Enero"
            },

            February: {
                Name: "February",
                Translate: "Febrero"
            },

            March: {
                Name: "March",
                Translate: "Marzo"
            },

            April: {
                Name: "April",
                Translate: "Abril"
            },

            May: {
                Name: "May",
                Translate: "Mayo"
            },

            June: {
                Name: "June",
                Translate: "Junio"
            },

            July: {
                Name: "July",
                Translate: "Julio"
            },

            August: {
                Name: "August",
                Translate: "Agosto"
            },

            September: {
                Name: "September",
                Translate: "Septiembre"
            },

            October: {
                Name: "October",
                Translate: "Octubre"
            },

            November: {
                Name: "November",
                Translate: "Noviembre"
            },

            December: {
                Name: "December",
                Translate: "Diciembre"
            },
        }

        var momentNow = moment();

        for (var i in months) {
  			if (i == momentNow.format('MMMM')) {
  				$('.fecha').html(months[i].Translate + " " + momentNow.format('DD') + "-" + momentNow.format('YY') + " / ");
  			}
  		}
    }
</script>

</html>
