<!-- Main section-->


<script>
    var data_reservaciones = [];
    var eventos = [];

    $(document).ready(function() {
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>" + "reservas/reserva/reservaciones",
            success: function(result) {
                var json = JSON.parse(result);

                setCalendar(json);
            }
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
    });

    function setCalendar(eventos) {

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            initialDate: '<?php echo date("Y-m-d") ?>',
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events   
            displayEventEnd: true,
            eventTimeFormat: { // like '14:30:00'
                hour: '2-digit',
                minute: '2-digit',
                omitZeroMinute: false,
                meridiem: true,
                hour12: false
            },
            events: eventos,
            color: 'black', // an option!
            textColor: 'white', // an option!     
        });

        calendar.render();
    }

    function get_habitacion_disponible(habitacion) {
        $(".mensaje_habitacion").text("");
        var data = {
            start: $('#fecha_entrada_reserva').val(),
            end: $('#fecha_salida_reserva').val(),
            habitacion: habitacion
        };
        $.ajax({
            type: "post",
            data: data,
            url: "<?php echo base_url(); ?>" + "reservas/reserva/get_reservacion_habiatacion",
            success: function(result) {
                var data = JSON.parse(result);
                if (data != null) {
                    $(".mensaje_habitacion").text("HABITACION NO DISPONIBLE");
                }
            }
        });
    }
</script>

<style>
    .custom {
        color: red;
        background: orange;
    }

    .input-check {
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

    .box-padding {
        padding: 15px;
        position: relative;
        display: inline;
    }

    #calendar {
        max-width: 100%;
        margin: 0 auto;
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
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/reserva/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Reservaciones</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info"> Nueva</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Editar Reservacion </div>
                    <div class="panel-body menuContent">
                        <div class="row">

                        </div>
                        <div class="row">
                            <form class="form-horizontal" id='reservas' method="post">
                                <input type="hidden" name="id_reserva" value="<?php echo $reserva[0]->id_reserva; ?>"/>
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-4">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-left">Cliente</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="cliente_reserva" name="cliente_reserva">
                                                        <option value="<?php echo $reserva[0]->id_cliente; ?>"><?php echo $reserva[0]->nombre_empresa_o_compania; ?></option>
                                                        <?php
                                                        foreach ($cliente as $c) {
                                                            if($reserva[0]->id_cliente != $c->id_cliente) {
                                                        ?>
                                                            <option value="<?php echo $c->id_cliente ?>"><?php echo $c->nombre_empresa_o_compania ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Nombre Reservación</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nombre_reserva" name="nombre_reserva" value="<?php echo $reserva[0]->nombre_reserva; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Identificacion</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="identificacion_reserva" name="identificacion_reserva">
                                                        <option value="<?php echo $reserva[0]->identificacion_reserva; ?>"><?php echo $reserva[0]->identificacion_reserva; ?></option>
                                                        <option value="DUI">DUI</option>
                                                        <option value="NIT">NIT</option>
                                                        <option value="PASAPORTE">PASAPORTE</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Número Documento</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="identificacion_numero_reserva" name="identificacion_numero_reserva" value="<?php echo $reserva[0]->identificacion_numero_reserva; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Estado</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="estado_reserva" name="estado_reserva">
                                                        <?php
                                                        foreach ($estados as $estado) {
                                                            if($reserva[0]->estado_reserva == $estado->id_reserva_estados) {
                                                            ?>
                                                            <option value="<?php echo $reserva[0]->estado_reserva; ?>"><?php echo $estado->nombre_reserva_estados; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        foreach ($estados as $estado) {
                                                            if($reserva[0]->estado_reserva != $estado->id_reserva_estados) {
                                                            ?>
                                                            <option value="<?php echo $estado->id_reserva_estados ?>"><?php echo $estado->nombre_reserva_estados ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Estadia</label>
                                                <div class="col-sm-8 no-padding-left">
                                                <?php
                                                    $estadia_aplica = $reserva[0]->estadia_aplica ? 'checked' : '';
                                                ?>
                                                <input type="checkbox" <?php echo $estadia_aplica; ?> class="input-check" id="estadia_aplica" name="estadia_aplica" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Habitacón</label>
                                                <div class="col-sm-8 no-padding-left">
                                                <?php
                                                    $habitacion_aplica = $reserva[0]->habitacion_aplica ? 'checked' : '';
                                                ?>
                                                <input type="checkbox" <?php echo $habitacion_aplica; ?> class="input-check" id="habitacion_aplica" name="habitacion_aplica" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Comida</label>
                                                <div class="col-sm-8 no-padding-left">
                                                <?php
                                                    $comida_aplica = $reserva[0]->comida_aplica ? 'checked' : '';
                                                ?>
                                                <input type="checkbox" <?php echo $comida_aplica; ?> class="input-check" id="comida_aplica" name="comida_aplica" value="">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4">

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Ingreso</label>
                                                <div class="col-sm-8">
                                                    <input type="datetime-local" class="form-control" id="fecha_entrada_reserva" name="fecha_entrada_reserva" placeholder="" value="<?php $date = new DateTime($reserva[0]->fecha_entrada_reserva);echo $date->format('Y-m-d\T14:00'); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Adultos</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="total_adultos_reserva" name="total_adultos_reserva" placeholder="" value="<?php echo $reserva[0]->total_adultos_reserva; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Tipo Pago</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" id="tipo_pago_reserva" name="tipo_pago_reserva">
                                                        <?php
                                                        foreach ($pago as $p) {
                                                            if($reserva[0]->tipo_pago_reserva == $p->id_modo_pago){
                                                        ?>
                                                            <option value="<?php echo $p->id_modo_pago ?>"><?php echo $p->nombre_modo_pago ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        foreach ($pago as $p) {
                                                            if($reserva[0]->tipo_pago_reserva == $p->id_modo_pago){
                                                            ?>
                                                                <option value="<?php echo $p->id_modo_pago ?>"><?php echo $p->nombre_modo_pago ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Monto Anticipo</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="anticipo_pago_reserva" name="anticipo_pago_reserva" placeholder="" value="<?php echo $reserva[0]->anticipo_pago_reserva; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Telefono</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="telefono_trabajo_reserva" name="telefono_trabajo_reserva" placeholder="" value="<?php echo $reserva[0]->telefono_trabajo_reserva; ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Comentarios</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" id="comentarios" name="comentarios"><?php echo $reserva[0]->comentarios; ?></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Salida</label>
                                                <div class="col-sm-8">
                                                    <input type="datetime-local" class="form-control" id="fecha_salida_reserva" name="fecha_salida_reserva" placeholder="" value="<?php $date = new DateTime($reserva[0]->fecha_salida_reserva);echo $date->format('Y-m-d\T14:00'); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Niños</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="total_ninos_reserva" name="total_ninos_reserva" placeholder="" value="<?php echo $reserva[0]->total_ninos_reserva; ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Referencia</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="referencia_pago_reserva" name="referencia_pago_reserva" placeholder="" value="<?php echo $reserva[0]->referencia_pago_reserva; ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Color</label>
                                                <div class="col-sm-8">
                                                    <input type="color" class="form-control" id="color" name="color" value="<?php echo $reserva[0]->color; ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Celular</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="telefono_celular_reserva" name="telefono_celular_reserva" placeholder="" value="<?php echo $reserva[0]->telefono_celular_reserva; ?>">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-4 col-sm-8">
                                                    <a name="<?php echo base_url() ?>reservas/reserva/update" data="reservas" class="btn btn-success enviar_data btn btn-default" style="width: 100% !important;"><i class="fa fa-save" style="font-size:24px;"></i> Guardar</a>
                                                    <br><br>
                                                    <a href="<?php echo base_url() ?>producto/orden/nuevo" class="btn btn-default" style="width: 100% !important;"><i class="fa fa-shopping-cart" style="font-size:24px;"></i> Abrir Orden</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                        <hr>
                                        <h4><i class="fa fa-users"></i> Paquetes:</h4>
                                        <?php
                                            $_paquetes = [];
                                            if ($paquete_) {
                                                foreach ($paquete_ as $key => $paquete) {
                                                    $_paquetes[] = $paquete->id_reserva_paquete;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-left"><?php echo $paquete->nombre_paquete ?></label>
                                                            <div class="col-sm-12">
                                                                <div class="quantity">
                                                                    <input type="number" name="cantidad-<?php echo $key ?>" min="1" max="9" step="1" value="1">
                                                                </div>
                                                                <input type="checkbox" checked class="input-check" name="paquete-<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $paquete->id_reserva_paquete ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            foreach ($paquetes as $key => $paquete__) {
                                                $existe = in_array($paquete__->id_reserva_paquete,$_paquetes);
                                                if (empty($existe)) {
                                                    $existe = null;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-4 control-label no-padding-left"><?php echo $paquete__->nombre_paquete ?></label>
                                                            <div class="col-sm-12">
                                                                <div class="quantity">
                                                                    <input type="number" name="cantidad-<?php echo $key ?>" min="1" max="9" step="1" value="1">
                                                                </div>
                                                                <input type="checkbox" class="input-check" name="paquete-<?php echo $key ?>" id="<?php echo $key ?>" value="<?php echo $paquete__->id_reserva_paquete ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <hr>
                                            <h4><i class="fa fa-home"></i> Habitaciones:</h4>
                                            <span class="mensaje_habitacion" style="color:red;"></span>
                                            <?php
                                            $habitacion_asignada = [];
                                            if ($habitacion_) {
                                                foreach ($habitacion_ as $key => $habitaciones) {
                                                    $habitacion_asignada[] = $habitaciones->id_reserva_habitacion;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="control-label "><?php echo $habitaciones->codigo_habitacion . "  " . $habitaciones->nombre_habitacion ?></label><br>
                                                                <input type="checkbox" checked class="input-check" name="habitacion-<?php echo $key ?>" id="habitaciones" onClick="get_habitacion_disponible(<?php echo $habitaciones->id_reserva_habitacion ?>);" value="<?php echo $habitaciones->id_reserva_habitacion ?>" />
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }

                                            if ($habitacion) {
                                                foreach ($habitacion as $key => $habitaciones) {
                                                    $existe = in_array($habitaciones->id_reserva_habitacion,$habitacion_asignada);
                                                    if(empty($existe)){
                                                        $existe = null;
                                                    ?>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <label for="inputEmail3" class="control-label "><?php echo $habitaciones->codigo_habitacion . "  " . $habitaciones->nombre_habitacion ?></label><br>
                                                                        <input type="checkbox" class="input-check" name="habitacion-<?php echo $key ?>" id="habitaciones" onClick="get_habitacion_disponible(<?php echo $habitaciones->id_reserva_habitacion ?>);" value="<?php echo $habitaciones->id_reserva_habitacion ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else {
                                                echo "Vacio";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-12">
                                            <hr>
                                            <h4><i class="fa fa-cutlery"></i> Mesas:</h4>
                                            <?php
                                            $cc = 0;
                                            $mesa_asignada = [];
                                            if($mesa_){
                                                foreach ($mesa_ as $key => $_mesa) {
                                                    $mesa_asignada[] = $_mesa->id_reserva_mesa;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class=" control-label"><?php echo $_mesa->codigo_mesa . "  " . $_mesa->nombre_mesa ?></label><br>
                                                                <input type="checkbox" checked class="input-check" name="mesa-<?php echo $key ?>" id="mesas" value="<?php echo $_mesa->id_reserva_mesa ?>" />
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                            }

                                            if ($mesa) {
                                                foreach ($mesa as $key => $mesas) {
                                                    $existe = in_array($mesas->id_reserva_mesa,$mesa_asignada);
                                                    if(empty($existe)){
                                                        $existe = null;
                                                    ?>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class=" control-label"><?php echo $mesas->codigo_mesa . "  " . $mesas->nombre_mesa ?></label><br>
                                                                <input type="checkbox" class="input-check" name="mesa-<?php echo $key ?>" id="mesas" value="<?php echo $mesas->id_reserva_mesa ?>" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else {
                                                echo "Vacio";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-lg-12">
                                            <hr>
                                            <h4><i class="fa fa-map-signs"></i> Estadias:</h4>
                                            <?php
                                            $zona_asignada = [];
                                            if($zona_){
                                                foreach ($zona_ as $key => $z) {
                                                    $zona_asignada[] = $z->id_reserva_zona;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="control-label"><?php echo $z->codigo_zona . "  " . $z->nombre_zona ?></label><br>
                                                            <input type="checkbox" checked class="input-check" name="zona-<?php echo $key ?>" id="zonas" value="<?php echo $z->id_reserva_zona ?>" />
                                                        </div>                                                        
                                                    </div>
                                                <?php
                                                }
                                            }

                                            if ($zona) {
                                                foreach ($zona as $key => $zonas) {
                                                    $existe = in_array($zonas->id_reserva_zona,$zona_asignada);
                                                    if(empty($existe)){
                                                        $existe = null;
                                                    ?>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="control-label"><?php echo $zonas->codigo_zona . "  " . $zonas->nombre_zona ?></label><br>
                                                            <input type="checkbox" class="input-check" name="zona-<?php echo $key ?>" id="zonas" value="<?php echo $zonas->id_reserva_zona ?>" />
                                                        </div>                                                        
                                                    </div>
                                                <?php
                                                    }
                                                }
                                            } else {
                                                echo "Vacio";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5" style="background:#ecedef;">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <h4><i class="fa fa-clock-o"></i> Reservaciones :</h4>
                                            <table class="">
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-primary">En Proceso<br>
                                                            <span class="">
                                                                <h2><?php echo count((array) $reservas_proceso) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-default">En Espera
                                                            <span class="">
                                                                <h2><?php echo count((array) $reservas_reservadas) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-lg-9">
                                            <h4><i class="fa fa-dashboard"></i> Habitaciones :</h4>
                                            <table class="">
                                                <tr>
                                                    <td>
                                                        <button type="button" class="btn btn-primary">Ocupadas<br>
                                                            <span>
                                                                <h2><?php echo count((array) $habitacion_reservadas) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-default">Libres<br>
                                                            <span class="">
                                                                <h2><?php echo  count((array) $habitacion) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-default">Limpieza<br>
                                                            <span class="">
                                                                <h2><?php echo count((array) $habitacion_limpieza) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-default">TOTAL<br>
                                                            <span class="">
                                                                <h2><?php echo count((array) $habitacion)  +  count((array) $habitacion_limpieza) ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-default">CAPACIDAD<br>
                                                            <span class="">
                                                                <h2><?php echo $capacidad; ?></h2>
                                                            </span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table><br><br>
                                        </div>
                                    </div>
                                    <div id='calendar'></div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

        </div>
    </div>
</section>