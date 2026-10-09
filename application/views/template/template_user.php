<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=10, user-scalable=yes' name='viewport'>
	<meta name="description" content="Aplikasi Ujian Online SMART-CBT">
	<meta name="keywords" content="Aplikasi Ujian Online SMART-CBT">
	<meta name="author" content="ICT-TIM-SMK11MARET">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
  
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>public/plugins/adminlte/js/app.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    
    <!-- Tema Biru Tua Elegan (Ringan & Zero Overhead) -->
    <style type="text/css">
      body.skin-blue, .content-wrapper, .wrapper {
        background-color: #f4f6fa !important;
      }
      .skin-blue .main-header .navbar {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        border-bottom: 2px solid #162d55;
        box-shadow: 0 2px 10px rgba(15, 34, 64, 0.25);
      }
      .skin-blue .main-header .navbar .navbar-brand {
        color: #ffffff !important;
        font-weight: 700;
        letter-spacing: 0.5px;
      }
      .skin-blue .main-header .navbar .nav > li > a {
        color: #e0e9f8 !important;
      }
      .skin-blue .main-header .navbar .nav > li > a:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
      }
      .login-box-body {
        border-top: 4px solid #1e3c72 !important;
        border-radius: 8px !important;
        box-shadow: 0 6px 24px rgba(30, 60, 114, 0.12) !important;
        background: #ffffff;
      }
      .login-logo b {
        color: #1e3c72 !important;
      }
      .btn-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
        border-color: #1a3668 !important;
        box-shadow: 0 2px 6px rgba(30, 60, 114, 0.25);
        transition: all 0.2s ease;
      }
      .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
        background: linear-gradient(135deg, #172f5a 0%, #21437c 100%) !important;
        border-color: #15294e !important;
      }
      .main-footer {
        border-top: 1px solid #d9e2ec !important;
        background: #ffffff !important;
        color: #486581 !important;
      }
      .main-footer a {
        color: #1e3c72 !important;
      }
    </style>
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><?php if(!empty($site_name)){ echo $site_name; } ?></b></a>
            </div>
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <li><a href="#"><span id="timestamp"></span></a></li>
              </ul>
            </div>
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper">
            <?php 
            if(!empty($content)){
                echo $content; 
            }
            ?>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer no-print">
        <div class="pull-right hidden-xs">
			<?php
				if(!empty($link_login_operator)){
					if($link_login_operator=='ya'){
						?>
							<strong> <a href="<?php echo site_url(); ?>/manager/" >Log In Operator</a></strong>
						<?php
					}
				}else{
					?>
						<strong> <a href="<?php echo site_url(); ?>/manager/" >Log In Operator</a></strong>
					<?php
				}
			?>
        </div>
        <div class="container">
          <strong>&copy; 2026 ICT-TIM-SMK11MARET</strong>
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <div class="modal" id="modal-proses" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div style="text-align: center;">
              <img width="50" src="<?php echo base_url(); ?>public/images/loading.gif" /> <br />Data Sedang diproses...              
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  <script type="text/javascript">
    $(function () {
        var serverTime = <?php if(!empty($timestamp)){ echo $timestamp; } ?>;
        var counterTime=0;
        var date;

        setInterval(function() {
          date = new Date();

          serverTime = serverTime+1;

          date.setTime(serverTime*1000);
          time = date.toLocaleTimeString();
          $("#timestamp").html(time);
        }, 1000);
    });
  </script>
  </body>
</html>
