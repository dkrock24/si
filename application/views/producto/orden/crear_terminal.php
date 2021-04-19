<script type="text/javascript">
   $(document).on('click', '.btn_cantidad', function() {

      $('.cantidad_input').css("display", "line");
   });
</script>

<style type="text/css">

</style>
<!-- Main section-->
<section>
   <!-- Page content-->
   <div class="content-wrapper">
      <h3 style="height: 50px; ">
         <a name="producto/orden/crear" style="top: -12px;position: relative; text-decoration: none" class="holdOn_plugin">
            <button type="button" class="mb-sm btn btn-success"> Productos</button>
         </a>
         <span style="top: -12px;position: relative; text-decoration: none"> Ingresar Información</span> </h3>

      <!-- START table-responsive-->
      <div class="row menu_title_bar">
         <div class="col-lg-6">
            <!-- START panel-->
            <div id="panelDemo10" class="panel ">
               <div class="panel-heading menuTop">El dispositivos con el que intentas ingresar no esta registrado, por favor ingresa la informacion requerida</div>
               <div class="panel-body">
                  <p>
                     <form id="crear_terminal" action="nuevo" method="post">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">DISPOSITIVO NOMBRE</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" name="nombre_input" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">LICENCIA EMPRESA</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control" name="licencia_input" value="">
                            </div>
                        </div>

                        <br>
                        <input type="submit" name="" class="btn btn-success" value="Guardar">
                     </form>
                  </p>
               </div>
               <div class="panel-footer"> - </div>
            </div>
            <!-- END panel-->
         </div>
      </div>
   </div>

</section>