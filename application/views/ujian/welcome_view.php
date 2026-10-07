<div class="container">
	<!-- Content Header (Page header) -->
    <section class="content-header">
    	<h1>
    		<?php if(!empty($site_name)){ echo $site_name; } ?>
            <small><?php if(!empty($cbt_keterangan)){ echo $cbt_keterangan; }else{ echo 'Ujian Online Berbasis Komputer'; } ?></small>
        </h1>
        <ol class="breadcrumb">
        	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Selamat Datang</li>
        </ol>
	</section>

	<!-- Main content -->
    <section class="content">
    	<div class="row">
    	<?php echo form_open('welcome/login','id="form-login" class="form-horizontal"')?>
			<input type="hidden" name="latitude" id="latitude" value="">
			<input type="hidden" name="longitude" id="longitude" value="">
			<input type="hidden" name="accuracy" id="accuracy" value="">
    	</div>
    	<div class="row">
    		<div class="login-box">
    			<div class="login-logo">
        			<b>User Login</b>
      			</div><!-- /.login-logo -->
      			<div class="login-box-body">
        			<p class="login-box-msg">Masukkan Username dan Password</p>
					
					<?php if(isset($radius_lock) && $radius_lock == 'ya' && empty($is_ip_bypass)): ?>
					<div id="gps-status-box" style="margin-bottom: 15px; padding: 10px 12px; border-radius: 6px; font-size: 12px; background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; display: flex; align-items: center; justify-content: space-between;">
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="fa fa-spinner fa-spin" id="gps-icon" style="font-size: 15px; color: #4338ca;"></i>
							<span id="gps-status-text">Mendeteksi lokasi GPS perangkat...</span>
						</div>
						<button type="button" id="btn-retry-gps" class="btn btn-xs btn-primary" style="display: none; margin-left: 8px;" onclick="mintaLokasiSiswa()">
							<i class="fa fa-refresh"></i> Ulangi
						</button>
					</div>
					<?php elseif(isset($radius_lock) && $radius_lock == 'ya' && !empty($is_ip_bypass)): ?>
					<div style="margin-bottom: 15px; padding: 8px 12px; border-radius: 6px; font-size: 12px; background: #e6fffa; color: #234e52; border: 1px solid #b2f5ea; display: flex; align-items: center; gap: 8px;">
						<i class="fa fa-wifi text-green" style="font-size: 15px;"></i>
						<span><b>Jaringan Sekolah Terdeteksi</b> (Bypass Lokasi GPS)</span>
					</div>
					<?php endif; ?>

                	<div id="form-pesan"></div>
          			<div class="form-group has-feedback">
            			<input type="text" id="username" autocomplete="off" name="username" class="form-control" placeholder="Username"/>
            			<span class="glyphicon glyphicon-user form-control-feedback"></span>
          			</div>
          		<div class="form-group has-feedback">
            		<input type="password" id="password" autocomplete="off" name="password" class="form-control" placeholder="Password"/>
            		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
          		</div>
          		<div class="row">
		            <div class="col-xs-8">                          
                  <div class="checkbox icheck">
                    <label>
                      <input type="checkbox" id="show-password"> Show Password
                    </label>
                  </div>    
		            </div><!-- /.col -->
		            <div class="col-xs-4">
		              	<button type="submit" id="btn-submit-login" class="btn btn-primary btn-block btn-flat">Login</button>
		            </div><!-- /.col -->
	          	</div>
    		</div><!-- /.login-box -->
    	</div>
    </section><!-- /.content -->
</div><!-- /.container -->

<script type="text/javascript">
    var isRadiusLock = <?php echo (isset($radius_lock) && $radius_lock == 'ya') ? 'true' : 'false'; ?>;
    var isIpBypass = <?php echo (!empty($is_ip_bypass)) ? 'true' : 'false'; ?>;

    function mintaLokasiSiswa(){
        if(!isRadiusLock || isIpBypass) return;

        if(!navigator.geolocation){
            $('#gps-icon').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle').css('color', '#dc2626');
            $('#gps-status-text').html('Browser tidak mendukung pendeteksian lokasi GPS.');
            $('#gps-status-box').css({'background': '#fef2f2', 'color': '#991b1b', 'border-color': '#fecaca'});
            return;
        }

        $('#btn-retry-gps').hide();
        $('#gps-icon').removeClass('fa-map-marker fa-check-circle fa-exclamation-triangle').addClass('fa-spinner fa-spin').css('color', '#4338ca');
        $('#gps-status-text').html('Mendeteksi lokasi GPS perangkat...');
        $('#gps-status-box').css({'background': '#eef2ff', 'color': '#3730a3', 'border-color': '#c7d2fe'});

        navigator.geolocation.getCurrentPosition(
            function(pos){
                $('#latitude').val(pos.coords.latitude);
                $('#longitude').val(pos.coords.longitude);
                $('#accuracy').val(pos.coords.accuracy);

                $('#gps-icon').removeClass('fa-spinner fa-spin fa-exclamation-triangle').addClass('fa-check-circle').css('color', '#16a34a');
                $('#gps-status-text').html('<b>Lokasi Terdeteksi</b> (Akurasi: ±' + Math.round(pos.coords.accuracy) + 'm)');
                $('#gps-status-box').css({'background': '#f0fdf4', 'color': '#166534', 'border-color': '#bbf7d0'});
                $('#btn-retry-gps').show();
            },
            function(err){
                var errMsg = 'Gagal mendeteksi lokasi GPS.';
                if(err.code === 1){
                    errMsg = '<b>Izin Lokasi Ditolak.</b> Wajib aktifkan GPS & izinkan akses lokasi browser.';
                }else if(err.code === 2){
                    errMsg = '<b>GPS Tidak Aktif.</b> Mohon nyalakan GPS di pengaturan HP.';
                }else if(err.code === 3){
                    errMsg = '<b>Waktu Deteksi Habis.</b> Silakan coba ulangi deteksi lokasi.';
                }
                $('#gps-icon').removeClass('fa-spinner fa-spin').addClass('fa-exclamation-triangle').css('color', '#dc2626');
                $('#gps-status-text').html(errMsg);
                $('#gps-status-box').css({'background': '#fef2f2', 'color': '#991b1b', 'border-color': '#fecaca'});
                $('#btn-retry-gps').show();
            },
            { enableHighAccuracy: true, timeout: 12000, maximumAge: 0 }
        );
    }

    function showpassword(){
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    $(function () {
        $('#username').focus(); 

        if(isRadiusLock && !isIpBypass){
            mintaLokasiSiswa();
        }

        $('#show-password').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });  

        $('#show-password').on('ifChanged', function(event){
          showpassword();
        });
        
        $('#form-login').submit(function(){
            if(isRadiusLock && !isIpBypass){
                var lat = $('#latitude').val();
                var lng = $('#longitude').val();
                if(!lat || !lng || lat == '0' || lng == '0'){
                    $('#form-pesan').html(pesan_err('<b>Akses Ditolak: Lokasi GPS Belum Terdeteksi!</b><br>Harap aktifkan GPS di HP dan izinkan akses lokasi di browser untuk dapat login ujian.'));
                    mintaLokasiSiswa();
                    return false;
                }
            }

            $("#modal-proses").modal('show');
            $.ajax({
              url:"<?php echo site_url(); ?>/welcome/login",
      			    type:"POST",
      			    data:$('#form-login').serialize(),
      			    cache: false,
       		        success:function(respon){
          		    	var obj = $.parseJSON(respon);
       		            if(obj.status==1){
       		                window.open("<?php echo site_url(); ?>/tes_dashboard","_self");
           		        }else{
                            $('#form-pesan').html(pesan_err(obj.error));
                            $("#modal-proses").modal('hide');
                            $('#username').focus();   
           		        }
          			},
					error: function(request, status, errorThrown) {
						$("#modal-proses").modal('hide');
						$('#form-pesan').html(pesan_err("Terjadi Kesalahan Sistem. Silahkan hubungi Administrator.<br/> "+errorThrown));
					}
       		});
            
       		return false;
        });    
    });
</script>