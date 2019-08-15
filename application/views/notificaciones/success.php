<script type="text/javascript">
	$(document).ready(function(){
		var intervalID = window.setInterval(myCallback, 3000);

		function myCallback() {
		  $(".xyz").fadeOut( "slow" );
		}
	});
	
</script>

<style type="text/css">

	.alert-style{
		font-size: 18px;
		color:white; 
		width: 30%;
		float: right; 
		position: relative; 
		display: inline-block; 
		margin-top: 0px;
	}

</style>

<?php if($this->session->flashdata("success")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #69bbd6">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>Registro! </strong>  <?php echo $this->session->flashdata("success") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("danger")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #d26464; color:white;">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>Registro! </strong>  <?php echo $this->session->flashdata("danger") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("warning")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #e4246b; color:white;">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>Registro! </strong>  <?php echo $this->session->flashdata("warning") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("info")):?>

	 <div role="alert" class="alert alert-info alert-dismissible fade in xyz alert-style">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong></strong> Registro Actualizado <?php echo $this->session->flashdata("info") ?> </div>

<?php endif;?>