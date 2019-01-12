<?php if($this->session->flashdata("success")):?>

	 <div role="alert" class="alert alert-success alert-dismissible fade in">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>El Nuevo ! </strong>  <?php echo $this->session->flashdata("success") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("danger")):?>

	 <div role="alert" class="alert alert-danger alert-dismissible fade in">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>El Nuevo ! </strong>  <?php echo $this->session->flashdata("danger") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("warning")):?>

	 <div role="alert" class="alert alert-warning alert-dismissible fade in">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong>El Nuevo ! </strong>  <?php echo $this->session->flashdata("warning") ?> </div>

<?php endif;?>

<?php if($this->session->flashdata("info")):?>

	 <div role="alert" class="alert alert-info alert-dismissible fade in">
	 <button type="button" data-dismiss="alert" aria-label="Close" class="close">
	    <span aria-hidden="true">&times;</span>
	 </button>
	 <strong></strong> El Registro Fue Actualizado <?php echo $this->session->flashdata("info") ?> </div>

<?php endif;?>