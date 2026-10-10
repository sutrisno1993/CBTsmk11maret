<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php if(!empty($site_name)){ echo $site_name; } ?> | <?php echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=0.9, minimum-scale=0.1, maximum-scale=10, user-scalable=yes' name='viewport' />
	<meta name="description" content="Aplikasi Ujian Online SMART-CBT" />
	<meta name="keywords" content="Aplikasi Ujian Online SMART-CBT" />
	<meta name="author" content="ICT-TIM-SMK11MARET" />
    <meta name="google" value="notranslate" />
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>public/plugins/adminlte/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
  
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

    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.reload.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>public/plugins/pnotify/pnotify.custom.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>public/app.js" type="text/javascript"></script>
    
    <!-- Tema Modern Ringan & Zero Overhead (Khusus Ujian Berkecepatan Tinggi) -->
    <style type="text/css">
      #isi-tes-soal img {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 8px 0;
      }
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
      .skin-blue .main-header li.user-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
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
      /* Panel Box Soal & Box Solid */
      .box.box-success.box-solid {
        border: none !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.05) !important;
        overflow: hidden;
        background: #ffffff !important;
      }
      .box.box-success.box-solid > .box-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        padding: 12px 18px !important;
      }
      .box.box-success.box-solid > .box-body {
        padding: 22px 20px !important;
      }
      .box.box-success.box-solid > .box-footer {
        background: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 14px 18px !important;
      }
      .box.box-success {
        border-top: none !important;
        border-radius: 12px !important;
        box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.08), 0 0 0 1px rgba(15, 23, 42, 0.05) !important;
      }
      /* Tombol Utama & Tombol Navigasi Soal */
      .btn-primary, .btn-success {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        border: none !important;
        border-radius: 8px !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.28) !important;
        transition: all 0.2s ease !important;
      }
      .btn-primary:hover, .btn-primary:active, .btn-primary:focus,
      .btn-success:hover, .btn-success:active, .btn-success:focus {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.38) !important;
        transform: translateY(-1px);
      }
      .btn-default {
        background: #ffffff !important;
        border: 1.5px solid #cbd5e1 !important;
        color: #334155 !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        transition: all 0.2s ease !important;
      }
      .btn-default:hover, .btn-default:focus {
        background: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
      }
      #btn-ragu {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        border: none !important;
        border-radius: 8px !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.28) !important;
        transition: all 0.2s ease !important;
      }
      /* Tombol Nomor Soal */
      button[id^="btn-soal-"] {
        border-radius: 8px !important;
        font-weight: 700 !important;
        min-width: 40px !important;
        height: 38px !important;
        margin: 3px !important;
        border: 1.5px solid #cbd5e1 !important;
        background: #ffffff !important;
        color: #334155 !important;
        transition: all 0.15s ease !important;
      }
      button[id^="btn-soal-"].btn-primary, .btn.btn-primary[id^="btn-soal-"] {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
        border: none !important;
        color: #ffffff !important;
        font-weight: 700 !important;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3) !important;
      }
      /* Footer */
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
      /* Callout Info */
      .callout.callout-info {
        background-color: #f0f7ff !important;
        border-left: 4px solid #2563eb !important;
        border-radius: 8px !important;
        color: #1e3a8a !important;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.06);
      }
      .callout.callout-info h4 {
        color: #1e3a8a !important;
        font-weight: 700;
      }
      /* Badge Sisa Waktu di Header Soal */
      #sisa-waktu {
        font-size: 15px !important;
        font-weight: 800 !important;
        font-family: monospace, sans-serif !important;
        background: rgba(15, 23, 42, 0.6) !important;
        color: #38bdf8 !important;
        padding: 5px 14px !important;
        border-radius: 20px !important;
        border: 1px solid rgba(56, 189, 248, 0.35) !important;
        letter-spacing: 1px !important;
      }
      /* Modal Header */
      .modal-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border-radius: 6px 6px 0 0;
      }
      .modal-header .close {
        color: #ffffff !important;
        opacity: 0.8;
      }
      .modal-header .close:hover {
        opacity: 1;
      }
      /* Pagination DataTables */
      .pagination > .active > a, .pagination > .active > span {
        background-color: #2563eb !important;
        border-color: #2563eb !important;
      }
    </style>

    <script type="text/javascript">
    function notify_success(pesan){
      new PNotify({
        title: 'Berhasil',
        text: pesan,
        type: 'success',
        history: false,
        delay:2000
      });
    }
        
    function notify_info(pesan){
      new PNotify({
        title: 'Informasi',
        text: pesan,
        type: 'info',
        history: false,
        delay:2000
      });
    }
    
    function notify_error(pesan){
      new PNotify({
        title: 'Error',
        text: pesan,
        type: 'error',
        history: false,
        delay:2000
      });
    } 
  </script>
  </head>
  <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
  <body class="skin-blue layout-top-nav">
    <div class="wrapper">

      <header class="main-header">               
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="<?php echo base_url(); ?>" class="navbar-brand"> <b><i class="fa fa-laptop" style="color: #60a5fa; margin-right: 6px;"></i><?php if(!empty($site_name)){ echo $site_name; }else{ echo 'SMART-CBT'; } ?></b></a>
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <ul class="nav navbar-nav">
                    <li><a href="#"><span id="timestamp"></span></a></li>
                  </ul>
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="<?php echo base_url(); ?>public/images/avatar.png" class="user-image" alt="User Image" />
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs"><?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?></span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header" style="max-height: 70px;">
                        <p>
                          <?php if(!empty($nama)){ echo $nama; }else{ echo 'User Tes'; } ?>
                          <?php if(!empty($group)){ echo ' | '.$group; } ?>
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a data-toggle="modal" href="#modal-password" class="btn btn-default btn-flat">Password</a>
                        </div>
                        <div class="pull-right">
                          <a href="<?php echo site_url(); ?>/welcome/logout" class="btn btn-default btn-flat">Log out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div><!-- /.navbar-custom-menu -->
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
          <?php if(!empty($nama)){ echo $nama; } ?> | <strong> <a href="<?php echo site_url(); ?>/welcome/logout" >Log out</a></strong>
        </div>
        <div class="container">
          <strong>&copy; 2026 ICT-TIM-SMK11MARET</strong>
        </div><!-- /.container -->
      </footer>
    </div><!-- ./wrapper -->

    <div class="modal" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
      <?php echo form_open('tes_dashboard/password','id="form-password"')?>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Ubah Password</h4>
          </div>
          <div class="modal-body">
                <span id="form-pesan-password"></span>
                <div class="box-body">
                  <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" class="form-control" id="password-old" name="password-old" placeholder="Old Password">
                  </div>
                  <div class="form-group">
                    <label>New Password</label>
                    <input type="password" class="form-control" id="password-new" name="password-new" placeholder="New Password">
                  </div>
                  <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Confirm Password">
                  </div>
                </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="password-submit">Ubah Password</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      <?php echo form_close(); ?> 
    </div><!-- /.modal -->
    
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

        $('#modal-password').on('shown.bs.modal', function (e) {
          $('#form-pesan-password').html('');
          $('#password-old').val('');
          $('#password-new').val('');
          $('#password-confirm').val('');
          $('#password-old').focus();
        });
        
        $('#form-password').submit(function(){        
          $.ajax({
            url:"<?php echo site_url(); ?>/tes_dashboard/password",
            type:"POST",
            data:$('#form-password').serialize(),
            cache: false,
            success:function(respon){
              var obj = $.parseJSON(respon);
              if(obj.status==1){
                $('#form-pesan-password').html('');
                $('#modal-password').modal('hide');
                notify_success('Password berhasil diubah');
              }else{
                $('#form-pesan-password').html(pesan_err(obj.error));
              }
            }
          });
          return false;
        });
    });
  </script>


  </body>
</html>
