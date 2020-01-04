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
		margin: 10px;
		font-size: 16px;
		color:white; 
		width: 30%;
		float: right; 
		position: relative; 
		display: inline-block; 
		bottom: 10%;
		box-shadow: 2px 2px 5px black;
	}

	.icon{
		display: inline-block;
		position: absolute;
		padding-right:10px;
	}

</style>

<?php if($this->session->flashdata("success")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #82b74b">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <div class="icon">
		<i class="fa fa-check-circle fa-2x"></i>
	 </div>
	 <strong>Registro! </strong><br>  <?php echo $this->session->flashdata("success") ?> </div>

	

<?php endif;?>

<?php if($this->session->flashdata("danger")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #82b74b; color:white;">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <div class="icon">
		<i class="fa fa-trash-o fa-2x"></i>
	 </div>
	 <strong>Registro! </strong><br>  <?php echo $this->session->flashdata("danger") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("warning")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #82b74b; color:white;">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <div class="icon">
		<i class="fa fa-check-circle fa-2x"></i>
	 </div>
	 <strong>Registro! </strong><br>  <?php echo $this->session->flashdata("warning") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("info")):?>

	 <div role="alert" class="alert alert-info alert-dismissible fade in xyz alert-style">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong></strong> Registro Actualizado <?php echo $this->session->flashdata("info") ?> </div>

<?php endif;?>