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
    
    <!-- Tema Modern Ringan & Zero Overhead (Khusus Ujian Berkecepatan Tinggi) -->
    <style type="text/css">
      body.skin-blue, .content-wrapper, .wrapper {
        background-color: #f1f5f9 !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        -webkit-font-smoothing: antialiased;
      }
      .skin-blue .main-header .navbar {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        border-bottom: 1px solid rgba(255,255,255,0.08) !important;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.15) !important;
      }
      .skin-blue .main-header .navbar .navbar-brand {
        color: #ffffff !important;
        font-weight: 800 !important;
        letter-spacing: 0.5px !important;
        font-size: 19px !important;
      }
      .skin-blue .main-header .navbar .nav > li > a {
        color: #cbd5e1 !important;
        font-weight: 500;
      }
      .skin-blue .main-header .navbar .nav > li > a:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
      }
      #timestamp {
        background: rgba(255, 255, 255, 0.1);
        padding: 4px 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 13px;
        color: #93c5fd !important;
        border: 1px solid rgba(255, 255, 255, 0.15);
        font-weight: 600;
      }
      .login-box {
        margin-top: 35px !important;
      }
      .login-box-body {
        border-top: 4px solid #2563eb !important;
        border-radius: 14px !important;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.1), 0 0 0 1px rgba(15, 23, 42, 0.04) !important;
        background: #ffffff !important;
        padding: 28px !important;
      }
      .login-logo {
        margin-bottom: 20px !important;
      }
      .login-logo b {
        color: #0f172a !important;
        font-weight: 800 !important;
        font-size: 26px !important;
        letter-spacing: -0.5px;
      }
      .form-control {
        border-radius: 8px !important;
        border: 1.5px solid #cbd5e1 !important;
        height: 42px !important;
        font-size: 14px !important;
        transition: all 0.2s ease !important;
        box-shadow: none !important;
      }
      .form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15) !important;
      }
      .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        border: none !important;
        border-radius: 8px !important;
        height: 42px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        letter-spacing: 0.3px !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28) !important;
        transition: all 0.2s ease !important;
      }
      .btn-primary:hover, .btn-primary:active, .btn-primary:focus {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.38) !important;
        transform: translateY(-1px);
      }
      .main-footer {
        border-top: 1px solid #e2e8f0 !important;
        background: #ffffff !important;
        color: #64748b !important;
        font-size: 13px !important;
        padding: 18px 0 !important;
      }
      .main-footer a {
        color: #2563eb !important;
        font-weight: 600;
      }
      .main-footer a:hover {
        text-decoration: underline;
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
              <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><i class="fa fa-graduation-cap" style="color: #60a5fa; margin-right: 6px;"></i><?php if(!empty($site_name)){ echo $site_name; }else{ echo 'SMART-CBT'; } ?></b></a>
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
