<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

     <script type="text/javascript">

      	var empresa_valor;

		$(document).ready(function(){
			$('#empresa').appendTo("body");

			$(window).on('load', function(e){
	      	e.preventDefault();
		      swal({
		      	html:true,
		        title : "Información.",
		        text : "<?php echo $msj; ?>",
		        type : "info",
		        confirmButtonColor : "primary",
		        confirmButtonText : "Aceptar!",
		        closeOnConfirm : false
		      }, function (isConfirm) {
		        if (isConfirm) {
		          swal("Ok!", "Saliendo del Sistema.", "success");
		          //redirec("index");
		          window.location.href='<?php echo base_url()."login/index"; ?>';
		        } else {
		          swal("Cancelado", "Debes Hacer Login de Nuevo", "error");
		        }
		      });

		    });
 			 
		});
		
	</script>
<!-- Main section-->
      <section>
         <!-- Page content-->
         <div class="content-wrapper">
            <div class="content-heading">
               <!-- START Language list-->
               <div class="pull-right">
                  <div class="btn-group">
                     <button type="button" data-toggle="dropdown" class="btn btn-default">English</button>
                     <ul role="menu" class="dropdown-menu dropdown-menu-right animated fadeInUpShort">
                        <li><a href="#" data-set-lang="en">English</a>
                        </li>
                        <li><a href="#" data-set-lang="es">Spanish</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <!-- END Language list-->
               Dashboard
               <small data-localize="dashboard.WELCOME"></small>
            </div>

         </div>
      </section>



