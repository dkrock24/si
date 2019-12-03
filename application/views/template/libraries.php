<!DOCTYPE html>
<html>
  <head>
    
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/vendor/whirl/dist/whirl.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/bootstrap.css" id="bscss">
    <link rel="stylesheet" href="<?php echo base_url(); ?>../asstes/css/app.css" id="maincss">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/css_general.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/css/modal_style.css">

  </head>
  <title>
      <?php
      if(isset($title)){ echo $title; }else{ echo "Administracion"; }
      ?>
  </title>
  <body>