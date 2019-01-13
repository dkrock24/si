<script src="<?php echo base_url(); ?>../asstes/vendor/jquery/dist/jquery.js"></script>
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
            <!-- START widgets box-->
            <div class="row">
               <div class="col-lg-12 col-sm-12">
                  <a id="swal-demo51" href="" class="btn btn-primary">Try me!</a>
               </div>
               
            </div>
            <!-- END widgets box-->

         </div>
      </section>



      <script type="text/javascript">

		$(document).ready(function(){
			$(window).on('load', function(e){
	      	e.preventDefault();
		      swal({
		        title : "Are you sure?",
		        text : "You will not be able to recover this imaginary file!",
		        type : "warning",
		        showCancelButton : true,
		        confirmButtonColor : "#DD6B55",
		        confirmButtonText : "Yes, delete it!",
		        cancelButtonText : "No, cancel plx!",
		        closeOnConfirm : false,
		        closeOnCancel : false
		      }, function (isConfirm) {
		        if (isConfirm) {
		          swal("Deleted!", "Your imaginary file has been deleted.", "success");
		        } else {
		          swal("Cancelled", "Your imaginary file is safe :)", "error");
		        }
		      });

		    });								
		});
		
	</script>