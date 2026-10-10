<div class="container">
	<!-- Content Header (Page header) -->
    <section class="content-header" style="text-align: center; padding-top: 20px;">
    	<h1 style="font-size: 24px; font-weight: 800; color: #0f172a; margin: 0;">
    		<?php if(!empty($site_name)){ echo $site_name; }else{ echo 'SMART-CBT'; } ?>
            <small style="display: block; font-size: 13px; color: #64748b; margin-top: 5px;">
                <?php if(!empty($cbt_keterangan)){ echo $cbt_keterangan; }else{ echo 'SMK 11 MARET &bull; Ujian Berbasis Komputer'; } ?>
            </small>
        </h1>
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
        			<div style="font-size: 24px; font-weight: 800; color: #0f172a;">
                        <i class="fa fa-graduation-cap" style="color: #2563eb; margin-right: 6px;"></i>SMART-CBT
                    </div>
                    <div style="font-size: 12px; font-weight: 600; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 3px;">
                        Portal Ujian Siswa
                    </div>
      			</div><!-- /.login-logo -->
      			<div class="login-box-body">
        			<p class="login-box-msg" style="font-size: 13px; color: #64748b; padding: 0 0 15px 0;">Masukkan Username dan Password ujian Anda</p>
					
					<?php if(!empty($pesan_qr) && $pesan_qr == 'success'): ?>
					<div class="alert alert-success" style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; line-height: 1.4; background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46;">
						<i class="fa fa-check-circle" style="font-size: 15px; color: #059669;"></i> <b>Akses Kuota Mandiri Terverifikasi!</b><br>
						<span>Izin akses perangkat aktif (Maksimal 12 Jam). Silakan login untuk memulai ujian.</span>
					</div>
					<?php elseif(!empty($pesan_qr) && $pesan_qr == 'error_2hours'): ?>
					<div class="alert alert-danger" style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; line-height: 1.4; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">
						<i class="fa fa-clock-o" style="font-size: 15px; color: #dc2626;"></i> <b>Batas Waktu Akses 12 Jam Telah Habis!</b><br>
						<span>Masa berlaku akses perangkat Anda telah selesai. Silakan minta dan pindai QR Code link terbaru dari Proktor / Pengawas di ruang ujian.</span>
					</div>
					<?php elseif(!empty($pesan_qr) && $pesan_qr == 'error'): ?>
					<div class="alert alert-danger" style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; line-height: 1.4; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;">
						<i class="fa fa-warning" style="font-size: 15px; color: #dc2626;"></i> <b>QR Code Kadaluarsa / Tidak Valid!</b><br>
						<span>Masa berlaku QR Code telah habis. Silakan scan ulang QR Code terbaru dari Pengawas di ruang ujian.</span>
					</div>
					<?php elseif(!empty($is_qr_valid) && empty($is_ip_bypass)): ?>
					<div style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; display: flex; align-items: center; justify-content: space-between;">
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="fa fa-qrcode" style="font-size: 16px; color: #059669;"></i>
							<span><b>Akses Kuota Mandiri Aktif</b> (Maks 12 Jam)</span>
						</div>
						<?php if(!empty($qr_remaining_seconds)): ?>
						<span class="badge" style="background: #059669; font-size: 11px; padding: 4px 8px; border-radius: 12px;">
							Sisa: <?php 
								$rem_h = floor($qr_remaining_seconds / 3600);
								$rem_m = ceil(($qr_remaining_seconds % 3600) / 60);
								echo ($rem_h > 0 ? $rem_h . ' jam ' : '') . $rem_m . ' mnt';
							?>
						</span>
						<?php endif; ?>
					</div>
					<?php elseif(empty($is_ip_bypass) && empty($is_qr_valid)): ?>
					<div style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; background: #fffbeb; color: #92400e; border: 1px solid #fde68a; line-height: 1.4;">
						<i class="fa fa-info-circle" style="font-size: 15px; color: #d97706;"></i> <b>Perangkat Belum Scan QR Code:</b><br>
						<span>Jika menggunakan kuota pribadi, Anda wajib memindai QR Code izin dari Pengawas/Proktor di ruang ujian (berlaku 12 jam).</span>
					</div>
					<?php endif; ?>

					<?php if(isset($radius_lock) && $radius_lock == 'ya' && empty($is_ip_bypass)): ?>
					<div id="gps-status-box" style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; display: flex; align-items: center; justify-content: space-between;">
						<div style="display: flex; align-items: center; gap: 8px;">
							<i class="fa fa-spinner fa-spin" id="gps-icon" style="font-size: 15px; color: #2563eb;"></i>
							<span id="gps-status-text">Mendeteksi lokasi GPS perangkat...</span>
						</div>
						<button type="button" id="btn-retry-gps" class="btn btn-xs btn-primary" style="display: none; margin-left: 8px; border-radius: 4px;" onclick="mintaLokasiSiswa()">
							<i class="fa fa-refresh"></i> Ulangi
						</button>
					</div>
					<?php elseif(isset($radius_lock) && $radius_lock == 'ya' && !empty($is_ip_bypass)): ?>
					<div style="margin-bottom: 15px; padding: 10px 14px; border-radius: 8px; font-size: 12px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 8px;">
						<i class="fa fa-wifi" style="font-size: 15px; color: #059669;"></i>
						<span><b>Jaringan WiFi Sekolah Terdeteksi</b></span>
					</div>
					<?php endif; ?>

                	<div id="form-pesan"></div>
          			<div class="form-group has-feedback" style="margin-bottom: 16px;">
            			<input type="text" id="username" autocomplete="off" name="username" class="form-control" placeholder="Username Peserta" required />
            			<span class="glyphicon glyphicon-user form-control-feedback" style="color: #94a3b8; line-height: 42px;"></span>
          			</div>
          		<div class="form-group has-feedback" style="margin-bottom: 16px;">
            		<input type="password" id="password" autocomplete="off" name="password" class="form-control" placeholder="Password" required />
            		<span class="glyphicon glyphicon-lock form-control-feedback" style="color: #94a3b8; line-height: 42px;"></span>
          		</div>
          		<div class="row" style="margin-bottom: 15px; display: flex; align-items: center;">
		            <div class="col-xs-12">                          
                      <div class="checkbox icheck" style="margin: 0;">
                        <label style="font-size: 13px; color: #64748b; font-weight: 500;">
                          <input type="checkbox" id="show-password"> Tampilkan Password
                        </label>
                      </div>    
		            </div>
	          	</div>
                <div>
                    <button type="submit" id="btn-submit-login" class="btn btn-primary btn-block" style="font-size: 15px; font-weight: 700; height: 44px; border-radius: 8px;">
                        <i class="fa fa-sign-in" style="margin-right: 6px;"></i> Masuk Ujian
                    </button>
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
        
        $('#form-login').submit(function(e){
            e.preventDefault();
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
                url:"<?php echo site_url('welcome/login'); ?>",
                type:"POST",
                data:$('#form-login').serialize(),
                cache: false,
                success:function(respon){
                    try {
                        var obj = typeof respon === 'object' ? respon : $.parseJSON(respon);
                        if(obj.status==1){
                            window.open("<?php echo site_url('tes_dashboard'); ?>","_self");
                        }else{
                            $('#form-pesan').html(pesan_err(obj.error));
                            $("#modal-proses").modal('hide');
                            $('#username').focus();   
                        }
                    } catch(e) {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan').html(pesan_err("Gagal memproses respon server: " + respon));
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