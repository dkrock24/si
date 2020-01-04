<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>

     <script type="text/javascript">

      	var empresa_valor;

		$(document).ready(function(){
			$('#empresa').appendTo("body");
			var html_opciones;
			var option_hmtl = '<option value=0>Selecione Empresa</option>';
			var hml_empresa = "<?php foreach($empresa as $value){ ?><option value='<?php echo $value->id_empresa; ?>'><?php echo $value->nombre_comercial; ?></option><?php } ?>";
			var html_ = "<select class='form-control' name='empresa' id='empresa'>"+option_hmtl+hml_empresa+"</select>";
			$(window).on('load', function(e){
	      	e.preventDefault();
		      swal({
		      	html:true,
		        title : "Selecciona Empresa.",
		        text : html_,
		        type : "info",
		        showCancelButton : true,
		        confirmButtonColor : "primary",
		        confirmButtonText : "Iniciar!",
		        cancelButtonColor : "danger",
		        cancelButtonText : "No, cancelar!",
		        closeOnConfirm : false,
		        closeOnCancel : false
		      }, function (isConfirm) {
		        if (isConfirm) {
		          swal("Ok!", "Todo Esta Listo.", "success");
		          //redirec("index");
		          window.location.href='index';
		        } else {
		          swal("Cancelado", "Debes Hacer Login de Nuevo", "error");
		        }
		      });

		    });

		    $(document).on('change', '#empresa', function(){
		    	var id_empresa = $(this).val();
		      	$.ajax({
		            url: "set_empresa/"+id_empresa,  
		            datatype: 'json',      
		            cache : false,                

		                success: function(data){

		                },
		                error:function(){
		                }
		        });
		    });
 			
		    
		    
		});

		function abc(valor){
			alert(valor);
		}

		////'<option value="++"></option>'
		
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



