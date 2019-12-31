  <script src="<?php echo base_url(); ?>../asstes/vendor/modernizr/modernizr.custom.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/matchMedia/matchMedia.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/bootstrap/dist/js/bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery.easing/js/jquery.easing.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/animo.js/animo.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/slimScroll/jquery.slimscroll.min.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/screenfull/dist/screenfull.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>



  <script src="<?php echo base_url(); ?>../asstes/vendor/sparkline/index.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/demo/demo-rtl.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/printer/pdf/jspdf.debug.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/printer/pdf/jspdf.plugin.autotable.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/printer/print.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/js/generalAlert.js"></script>



  <!-- =============== PAGE VENDOR SCRIPTS ===============-->
  <!-- DATATABLES-->
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-colvis/js/dataTables.colVis.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables/media/js/dataTables.bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/dataTables.buttons.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.bootstrap.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.colVis.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.flash.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.html5.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-buttons/js/buttons.print.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-responsive/js/dataTables.responsive.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/vendor/datatables-responsive/js/responsive.bootstrap.js"></script>

  <!-- =============== APP SCRIPTS ===============-->
  <!--
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/bootstrap/dist/js/bootstrap.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery.easing/js/jquery.easing.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/animo.js/animo.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/slimScroll/jquery.slimscroll.min.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/screenfull/dist/screenfull.js"></script>
   <script src="<?php echo base_url(); ?>../asstes/vendor/jquery-localize-i18n/dist/jquery.localize.js"></script>

    -->
  <script src="<?php echo base_url(); ?>../asstes/vendor/sweetalert/dist/sweetalert.min.js"></script>

  <script src="<?php echo base_url(); ?>../asstes/vendor/select2/dist/js/select2.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/app.js"></script>
  <script src="<?php echo base_url(); ?>../asstes/js/moment.min.js"></script>



  </div>

  </body>

  </html>


  <script type="text/javascript">
    $(document).ready(function() {
      var interval = setInterval(function() {
        var momentNow = moment();
//        $('#time-part').html(momentNow.format('MMMM DD'));
        $('#format-date').html(momentNow.format('hh:mm A'));
      }, 100);

      var momentNow = moment();

      var months = {

        January: {
          Name : "January",
          Translate : "Enero"
        },

        February: {
          Name : "February",
          Translate : "Febrero"
        }, 

        March: {
          Name : "March",
          Translate : "Marzo"
        }, 

        April: {
          Name : "April",
          Translate : "Abril"
        }, 

        May: {
          Name : "May",
          Translate : "Mayo"
        }, 

        June: {
          Name : "June",
          Translate : "Junio"
        }, 

        July: {
          Name : "July",
          Translate : "julio"
        }, 

        August: {
          Name : "August",
          Translate : "Agosto"
        },

        September: {
          Name : "September",
          Translate : "Septiembre"
        },

        October: {
          Name : "October",
          Translate : "Octubre"
        },

        November: {
          Name : "November",
          Translate : "Noviembre"
        },

        December: {
          Name : "December",
          Translate : "Diciembre"
        },

      };

      for(var i in months){
        if(i ==  momentNow.format('MMMM') ){
          console.log(months[i].Translate);
          $('#time-part').html(months[i].Translate +" "+ momentNow.format('DD'));
        }
      }

  



    });
  </script>


  <div class="modal fade" id="opciones" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h3 style="color:black;"><span class="fa fa-print"></span> Lista de Campos</h3>
        </div>
        <div class="modal-body">
          <form role="form" id="pdfParametros" name="pdfParametros">

          <?php
            if($fields['field']){
              foreach ($fields['field'] as $item) {
                ?>
                  
                  <input type="checkbox" checked="checked" name="<?php echo $item ?>" value="<?php echo $item ?>" />
                  <label><?php echo $item ?></label>
                  <br/>
                <?php
              }
            }
          ?>
            
            
          </form>
        </div>
        <div class="modal-footer">
        <button onclick="b()" id="pdfParametros" class="btn btn-info">Guardar</button>
          
          
        </div>
      </div>
    </div>
  </div>