<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

     <script type="text/javascript">

      	var empresa_valor;

		$(document).ready(function(){
			$('#empresa').appendTo("body");
			var html_opciones;
			var option_hmtl = '';
			var hml_empresa = "";
			var html_ = "";
			$(window).on('load', function(e){
	      	e.preventDefault();
		      swal({
		      	html:true,
		        title : "Acceso Restringido.",
		        text : html_,
		        type : "info",
		        
		        confirmButtonColor : "primary",
		        confirmButtonText : "Aceptar",
		        cancelButtonColor : "danger",
		        closeOnConfirm : false
		        
		      }, function (isConfirm) {
		        if (isConfirm) {
		          swal("Ok!", "Solicita Permiso.", "success");
		          //redirec("index");
		          //window.location.href='index';
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



