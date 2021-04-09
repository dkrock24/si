<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login POS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>../asstes/login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>../asstes/login/vendor/select2/select2.min.css">
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

				<form action="login" method="post" role="form" class="login100-form validate-form">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Usuario</span>
						<input class="input100" type="text" name="usuario" placeholder="Ingresar Usuario">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="passwd" placeholder="Ingresar Password">
						<input class="input100" type="hidden" name="uuid" id="uuid"/>
						<span class="focus-input100"></span>
					</div>
                    <!--
					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="#" class="txt1">
								Forgot Password?
							</a>
						</div>
					</div>
                    -->

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>../asstes/login/js/main.js"></script>

	<script src="<?php echo base_url(); ?>../asstes/js/device-uuid.js"></script>
<script>
	var uuid = new DeviceUUID().get();
    //
    console.log(uuid)
    //console.log('3a91f950-dec8-4688-ba14-5b7bbfc7a563')
	//$(".uuid").text(uuid);
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
    //console.log(dua)
    // IE cpuClass
    var uuid2 = du.hashMD5(dua.join(':'));
    var uuid3 = du.hashInt(dua.join(':'));
    //console.log(uuid2.slice(0,8), uuid2.slice(8,12), uuid2.slice(12,16), uuid2.slice(16,20), uuid2.slice(20))
    //console.log(navigator, screen, window.performance)
</script>

</body>
</html>