<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
    <title>GITA PERTIWI</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico">
	<link href="<?php echo base_url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style_default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive_default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/default_tem.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style_nyunyu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive_nyunyu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/default_nyunyu.css">
	<script src="<?php echo base_url();?>assets/plugins/pace/pace.min.js"></script>
</head>
<body class="pace-top">
	<div id="page-loader" class="fade in"><span class="spinner"></span></div>
	<div id="page-container" class="fade">
        <div class="error">
            <div class="error-code m-b-10">404 <i class="fa fa-warning"></i></div>
            <div class="error-content">
                <div class="error-message">Halaman Tidak Ditemukan</div>
                <br/>
                <div>
                    <a href="<?php echo base_url();?>" class="btn btn-success">Halaman Utama</a>
					<button type="button" onclick="history.go(-1)" class="btn btn-success">Kembali </button>
                </div>
            </div>
        </div>
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	</div>
	<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
	<script>
		$(document).ready(function() {
			App.init();
		});
	</script>
</body>
</html>
