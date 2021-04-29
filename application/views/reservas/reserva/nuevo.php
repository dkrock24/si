<!-- Main section-->


<script>

    var data_reservaciones = [];
    var eventos = [];

    $(document).ready(function(){
        $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>"+"reservas/reserva/reservaciones",
            success: function(result) {
                var json = JSON.parse(result);

                //console.log(json);
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
                events: 
                    json                
                });

                calendar.render();

                //setCalendar(result);                
            }
        });
    });
  //document.addEventListener('DOMContentLoaded', function() {

    function setCalendar(eventos){
        console.log(eventos);
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
        events: [
            eventos
        ]
        });

        calendar.render();
    }

    function get_habitacion_disponible(habitacion)
    {
        $(".mensaje_habitacion").text("");
        var data = {start:$('#fecha_entrada_reserva').val(), end:$('#fecha_salida_reserva').val(), habitacion:habitacion};
        $.ajax({
            type: "post",
            data: data,
            url: "<?php echo base_url(); ?>"+"reservas/reserva/get_reservacion_habiatacion",
            success: function(result) {
                var data = JSON.parse(result);        
                if(data!=null){
                    $(".mensaje_habitacion").text("HABITACION NO DISPONIBLE");
                }
            }
        });
    }


  //});

</script>

<style>

    .input-check{
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
    }

  #calendar {
    max-width: 100%;
    margin: 0 auto;
  }

</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">

        <h3 style="height: 50px; font-size: 13px;">
            <a name="reservas/reserva/index" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
                <button type="button" class="mb-sm btn btn-success"> Reservaciones</button> </a>
            <button type="button" style="top: -12px; position: relative;" class="mb-sm btn btn-info">/ Nueva</button>
        </h3>
        <div class="row">
            <div class="col-lg-12">
                <div id="panelDemo10" class="panel menu_title_bar">
                    <div class="panel-heading menuTop">Nueva Reservacion </div>
                    <div class="panel-body menuContent">
                        <div class="row">
                            <div class="col-lg-4">
                                <form class="form-horizontal" id='habitacion' method="post">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-left">Cliente</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="cliente_reserva" name="cliente_reserva">
                                                <?php
                                                foreach ($cliente as $c) {
                                                    ?>
                                                    <option value="<?php echo $c->id_cliente ?>"><?php echo $c->nombre_empresa_o_compania ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Nombre Reservación</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nombre_reserva" name="nombre_reserva" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Identificacion</label>
                                        <div class="col-sm-8">
                                        <select class="form-control" id="identificacion_reserva" name="identificacion_reserva">
                                            <option value="DUI">DUI</option>
                                            <option value="NIT">NIT</option>
                                            <option value="PASAPORTE">PASAPORTE</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Número Documento</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="identificacion_numero_reserva" name="identificacion_numero_reserva" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Ingreso</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="fecha_entrada_reserva" name="fecha_entrada_reserva" placeholder="" value="<?php echo date('Y-m-d') ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Salida</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="fecha_salida_reserva" name="fecha_salida_reserva" placeholder="" value="<?php echo date('Y-m-d',time()) ?>">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Adultos</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="total_adultos_reserva" name="total_adultos_reserva" placeholder="" value="1">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Niños</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="total_niños_reserva" name="total_niños_reserva" placeholder="" value="0">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Tipo Pago</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="tipo_pago_reserva" name="tipo_pago_reserva">
                                                <?php
                                                foreach ($pago as $p) {
                                                    ?>
                                                    <option value="<?php echo $p->id_modo_pago ?>"><?php echo $p->nombre_modo_pago ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Referencia Pago</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="referencia_pago_reserva" name="referencia_pago_reserva" placeholder="" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Monto Anticipo</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="anticipo_pago_reserva" name="anticipo_pago_reserva" placeholder="" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Telefono</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="telefono_trabajo_reserva" name="telefono_trabajo_reserva" placeholder="" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Celular</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="telefono_celular_reserva" name="telefono_celular_reserva" placeholder="" value="">

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label no-padding-right">Comentarios</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="comentarios" name="comentarios"></textarea>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <input type="button" name="<?php echo base_url() ?>reservas/habitacion/crear" data="habitacion" class="btn btn-success enviar_data" value="Guardar">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12"><hr>
                                        <h4><i class="fa fa-clock-o"></i> Reservaciones :</h4>
                                        <table class="">
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-primary">Ocupadas<br>
                                                        <span class=""><h2><?php echo count((array) $reservas_proceso) ?></h2></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-default">Reservadas
                                                        <span class=""><h2><?php echo count((array) $reservas_reservadas) ?></h2></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-lg-12">
                                        <hr>
                                        <h4><i class="fa fa-home"></i> Habitaciones :</h4>
                                        <table class="">
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-primary">Reservadas<br>
                                                        <span><h2><?php echo count((array) $habitacion_reservadas) ?></h2></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-default">Libres<br>
                                                        <span class=""><h2><?php echo count((array) $habitacion) - count((array) $habitacion_reservadas) ?></h2></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-default">Limpieza<br>
                                                        <span class=""><h2><?php echo count((array) $habitacion_limpieza) ?></h2></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-default">Mantenimiento<br>
                                                        <span class=""><h2><?php echo count((array) $habitacion_mantenimiento) ?></h2></span>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-default">TOTAL<br>
                                                        <span class=""><h2><?php echo count((array) $habitacion) + count((array) $habitacion_mantenimiento) + count((array) $habitacion_limpieza) ?></h2></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-lg-12">
                                        <hr>
                                        <h4><i class="fa fa-home"></i> Habitaciones:</h4>
                                        <span class="mensaje_habitacion" style="color:red;"></span> <br>
                                            <?php
                                            foreach ($habitacion as $habitaciones) {
                                                ?>
                                                <input type="checkbox" class="input-check" name="" onClick="get_habitacion_disponible(<?php echo $habitaciones->id_reserva_habitacion ?>);" value="<?php echo $habitaciones->codigo_habitacion ?>"/>
                                                <?php echo $habitaciones->codigo_habitacion ."  ". $habitaciones->nombre_habitacion ?>
                                                <br>
                                                <?php
                                            }
                                            ?>
                                        
                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-lg-4">
                                <div id='calendar'></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            
        </div>
    </div>
</section>