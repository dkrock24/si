<script type="text/javascript">
	$(document).ready(function(){
		var intervalID = window.setInterval(myCallback, 5000);

		function myCallback() {
		  $(".xyz").fadeOut( "slow" );
		}
	});
	
</script>

<style type="text/css">

	.alert-style{
		margin: 10px;
		font-size: 16px;
		color:grey; 
		width: 30%;
		margin-left:68%;
		position: absolute; 
		display: inline-block; 
		box-shadow: 2px 2px 5px black;
		z-index:1000;
	}
	.icon{
		display: inline-block;
		position: absolute;
		padding-right:10px;
	}

</style>

<?php if($this->session->flashdata("success")):?>

	 <div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #fff;">
		<div class="row">
			<div class="col-lg-1" style="border-left:1px solid #2465b9; background:#2465b9;margin-top:-10px;margin-bottom:-10px;">
				<div class="icon" style="color:white;position:relative;height:150px;vertical-align: baseline;">
					<i class="fa fa-check-circle fa-2x" style="margin-top:50%;margin-left:-18%;"></i>
				</div>
			</div>
			<div class="col-lg-11" style="color:black;">
				<button type="button" data-dismiss="alert" aria-label="Close" class="close" style="color:black;">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong style="color:#2465b9;">Registro! </strong><br>  <?php echo $this->session->flashdata("success") ?> 
			</div>
		</div>
	</div>	

<?php endif;?>

<?php if($this->session->flashdata("danger")):?>

	<div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #fff;">
		<div class="row">
			<div class="col-lg-1" style="border-left:1px solid #f44336; background:#f44336;margin-top:-10px;margin-bottom:-10px;">
				<div class="icon" style="color:white;position:relative;height:150px;vertical-align: baseline;">
					<i class="fa fa-check-circle fa-2x" style="margin-top:50%;margin-left:-18%;"></i>
				</div>
			</div>
			<div class="col-lg-11" style="color:black;">
				<button type="button" data-dismiss="alert" aria-label="Close" class="close" style="color:black;">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong style="color:#2465b9;">Registro! </strong><br>  <?php echo $this->session->flashdata("danger") ?> 
			</div>
		</div>
	</div>

<?php endif;?>

<?php if($this->session->flashdata("warning")):?>

	<div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #fff;">
		<div class="row">
			<div class="col-lg-1" style="border-left:1px solid #ffeb3b; background:#ffeb3b;margin-top:-10px;margin-bottom:-10px;">
				<div class="icon" style="color:black;position:relative;height:150px;vertical-align: baseline;">
					<i class="fa fa-check-circle fa-2x" style="margin-top:50%;margin-left:-18%;"></i>
				</div>
			</div>
			<div class="col-lg-11" style="color:black;">
				<button type="button" data-dismiss="alert" aria-label="Close" class="close" style="color:black;">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong style="color:#2465b9;">Registro! </strong><br>  <?php echo $this->session->flashdata("warning") ?> 
			</div>
		</div>
	</div>

<?php endif;?>

<?php if($this->session->flashdata("info")):?>

	<div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #fff;">
		<div class="row">
			<div class="col-lg-1" style="border-left:1px solid #4CAF50; background:#4CAF50;margin-top:-10px;margin-bottom:-10px;">
				<div class="icon" style="color:white;position:relative;height:150px;vertical-align: baseline;">
					<i class="fa fa-check-circle fa-2x" style="margin-top:50%;margin-left:-18%;"></i>
				</div>
			</div>
			<div class="col-lg-11" style="color:black;">
				<button type="button" data-dismiss="alert" aria-label="Close" class="close" style="color:black;">
					<span aria-hidden="true">&times;</span>
				</button>
				<strong style="color:#2465b9;">Registro! </strong><br>  <?php echo $this->session->flashdata("info") ?> 
			</div>
		</div>
	</div>

<?php endif;?>

<?php if($this->session->flashdata("reporte")):?>

<div role="alert" class="alert alert-dismissible fade in xyz alert-style" style="background: #fff;">
	<div class="row">
		<div class="col-lg-1" style="border-left:1px solid #4CAF50; background:#4CAF50;margin-top:-10px;margin-bottom:-10px;">
			<div class="icon" style="color:white;position:relative;height:150px;vertical-align: baseline;">
				<i class="fa fa-check-circle fa-2x" style="margin-top:50%;margin-left:-18%;"></i>
			</div>
		</div>
		<div class="col-lg-11" style="color:black;">
			<button type="button" data-dismiss="alert" aria-label="Close" class="close" style="color:black;">
				<span aria-hidden="true">&times;</span>
			</button>
			<strong style="color:#2465b9;">Registro! </strong><br>  <?php echo $this->session->flashdata("reporte") ?> 
		</div>
	</div>
</div>

<?php endif;?>