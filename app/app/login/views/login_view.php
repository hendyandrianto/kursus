<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>GITA PERTIWI</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/favicon.ico">
    <link href="<?php echo base_url();?>assets/huruf/huruf.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style_default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive_default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/default_tem.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style_nyunyu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style-responsive_nyunyu.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/default_nyunyu.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/notifIt.css" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>assets/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/notifIt.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.blockUI.js"></script>
    <script src="<?php echo base_url();?>assets/js/login.js"></script>
    <script src="<?php echo base_url();?>assets/js/apps.min.js"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
</head>
<body class="pace-top bg-white">
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <div id="page-container" class="fade">
        <div class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image">
                <?php
                $gal = $this->db->query("SELECT * FROM tbl_bglogin ORDER BY RAND()")->result();
                foreach ($gal as $key) {
                    $bgna = $key->logo;
                }
                ?>
                <img src="<?php echo base_url();?>assets/img/login-bg/<?php echo $bgna;?>" data-id="login-cover-image" alt="" />
                </div>
                <div class="news-caption">
                    <h4 class="caption-title"><i class="ion-android-contacts fa-2x text-success"></i> Sistem Manajemen Kursus Mengemudi & Menjahit</h4>
                    ALAMAT : JL. KEBON TIWU I NO. 11 TELP. (0265) 323445 - 085295168608
                </div>
            </div>
            <div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> SIMKUM
                        <small>Sistem Manajemen Kursus Mengemudi & Menjahit</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </div>
                <div class="login-content">
                    <form action='javascript:doLogin()' autocomplete='off' method="POST" class="margin-bottom-0">
                        <div class="form-group m-b-15">
                            <input type="text" class="form-control input-lg" name="username" id="username" placeholder="Masukan Username" />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password" class="form-control input-lg" name="password" id="password" placeholder="Masukan Password" />
                        </div>
                        <div class="login-buttons">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
                        </div>
                        <hr />
                        <p class="text-center text-inverse">
                            <a href="https://www.facebook.com/Coder_01-1624497204480596" target="_blank">&copy; Coder[01] All Right Reserved 2015 </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
