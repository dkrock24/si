<!DOCTYPE html>
<html lang="en">
<head>
	<title>Codigo POS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>../asstes/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/css/main.css">
<!--===============================================================================================-->

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(<?php echo base_url(); ?>../asstes/login/images/login_background.jpg);">
					<span class="login100-form-title-1">
						Systema Punto de Venta
					</span>
				</div>

				<span action="<?php echo base_url() ?>login/login" method="post" role="form" class="login100-form validate-form">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                        <span class="label-input100">Codigo</span>
						<span class="codigo_terminal"></span>
					</div>

					<div class="container-login100-form-btn"></div>
                </span>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="<?php echo base_url(); ?>../asstes/js/device-uuid.js"></script>
<script>
	var uuid = new DeviceUUID().get();
    $(".codigo_terminal").text(uuid);
    document.getElementById("uuid").value = uuid;

    var du = new DeviceUUID().parse();
    var dua = [
        du.language,
        du.platform,
        du.os,
        du.cpuCores,
        du.isAuthoritative,
        du.silkAccelerated,
        du.isKindleFire,
        du.isDesktop,
        du.isMobile,
        du.isTablet,
        du.isWindows,
        du.isLinux,
        du.isLinux64,
        du.isMac,
        du.isiPad,
        du.isiPhone,
        du.isiPod,
        du.isSmartTV,
        du.pixelDepth,
        du.isTouchScreen
    ];
    var uuid2 = du.hashMD5(dua.join(':'));
    var uuid3 = du.hashInt(dua.join(':'));
</script>

</body>
</html>