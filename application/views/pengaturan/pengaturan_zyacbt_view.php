<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pengaturan SMART-CBT
		<small>Melakukan pengaturan Identitas SMART-CBT</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Pengaturan SMART-CBT</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
			<?php echo form_open($url.'/simpan','id="form-pengaturan"'); ?>
                <div class="box">
                    <div class="box-header with-border">
    					<div class="box-title">Daftar Pengaturan SMART-CBT</div>
                    </div><!-- /.box-header -->

                    <div class="box-body form-horizontal">
						<div id="form-pesan"></div>
                        <div class="form-group">
							<label class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="zyacbt-nama" name="zyacbt-nama" >
                                <p class="help-block">
									Nama Pelaksana SMART-CBT.<br />
                                    Digunakan sebagai identitas pelaksanaan Tes.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Keterangan</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="zyacbt-keterangan" name="zyacbt-keterangan" >
                                <p class="help-block">
									Keterangan Pelaksana bisa diisi dengan Slogan ataupun Alamat dari Organisasi.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Link Login Operator</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-link-login" name="zyacbt-link-login">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Menampilkan Link <b>Log In Operator</b> pada Halaman login user.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Lock Mobile Exam Browser</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-mobile-lock-xambro" name="zyacbt-mobile-lock-xambro">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Lock Browser Mobile / Browser Android agar hanya dapat digunakan melalui Exam Browser
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Proteksi MultiLogin Peserta Tes</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-proteksi-multilogin" name="zyacbt-proteksi-multilogin">
									<option value="tidak">Tidak</option>
                                    <option value="ya">Ya</option>
								</select>
                                <p class="help-block">
									Proteksi MultiLogin Peserta Tes. Jika diaktifkan, maka user tidak bisa login didua perangkat. Jika user tidak logout, maka harus di lakukan Reset Login pada user tersebut.
								</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Anti-Cheating Browser (Cegah Buka Google / Pindah Tab)</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-anti-cheating" name="zyacbt-anti-cheating">
									<option value="tidak">Tidak (Nonaktif)</option>
                                    <option value="ya">Ya (Aktifkan Keamanan)</option>
								</select>
                                <p class="help-block">
									Mencegah kecurangan di browser (Chrome/Edge/Safari tanpa APK). Memblokir klik kanan &amp; copy-paste, mendeteksi buka tab baru/minimize, memberikan toleransi 7 detik untuk reconnect Wi-Fi, dan mengunci ujian otomatis jika melanggar 3 kali.
								</p>
							</div>
						</div>
						<div class="form-group" style="background: #fbfbfb; padding: 10px 0; border-top: 1px dashed #e2e8f0; border-bottom: 1px dashed #e2e8f0;">
							<label class="col-sm-4 control-label" style="color: #1e3c72; font-weight: 700;">Pengaturan Tipe Soal Global</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-tipe-soal-global" name="zyacbt-tipe-soal-global" style="font-weight: 600;">
									<option value="pilihan_ganda">Pilihan Ganda Saja (Tanpa Essay)</option>
                                    <option value="campuran">Campuran (Pilihan Ganda &amp; Essay)</option>
                                    <option value="essay">Essay Saja</option>
								</select>
                                <p class="help-block">
									Menentukan tipe soal default yang digunakan untuk ulangan/ujian. Saat ini diset <b>Pilihan Ganda Saja</b> sehingga sistem tidak memunculkan soal essay saat ulangan.
								</p>
							</div>
						</div>
						<div class="form-group" style="background: #fbfbfb; padding: 10px 0; border-bottom: 1px dashed #e2e8f0;">
							<label class="col-sm-4 control-label" style="color: #1e3c72; font-weight: 700;">Penggunaan Token Ujian Global</label>
                            <div class="col-sm-8">
								<select class="form-control input-sm" id="zyacbt-use-token" name="zyacbt-use-token" style="font-weight: 600;">
									<option value="tidak">Tidak (Bebas Token / Tanpa Token)</option>
                                    <option value="ya">Ya (Wajib Masukkan Token)</option>
								</select>
                                <p class="help-block">
									Jika diset <b>Tidak</b>, semua ulangan dan tes tidak meminta token. Siswa dapat langsung login dan klik <i>Mulai Tes</i> tanpa perlu memasukkan token dari pengawas/guru.
								</p>
							</div>
						</div>

						<!-- Bagian Kunci Lokasi GPS Sekolah -->
						<div style="background: #f0f7ff; border: 1px solid #c8e1ff; border-radius: 6px; padding: 15px; margin: 15px 0;">
							<h4 style="margin-top: 0; color: #0366d6; font-size: 15px; font-weight: 700;">
								<i class="fa fa-map-marker"></i> Pengaturan Kunci Lokasi &amp; Radius GPS Sekolah
							</h4>
							<p style="font-size: 12px; color: #586069; margin-bottom: 15px;">
								Membatasi siswa agar <b>wajib berada di lingkungan sekolah</b> saat login/ujian, meskipun siswa menggunakan <b>kuota data seluler pribadi</b> saat Wi-Fi kelas bermasalah/mental.
							</p>

							<div class="form-group">
								<label class="col-sm-4 control-label" style="color: #0366d6;">Kunci Lokasi Siswa (GPS)</label>
								<div class="col-sm-8">
									<select class="form-control input-sm" id="zyacbt-radius-lock" name="zyacbt-radius-lock" style="font-weight: 600;">
										<option value="tidak">Tidak (Nonaktif - Bebas Dari Mana Saja)</option>
										<option value="ya">Ya (Aktif - Wajib Berada di Lingkungan Sekolah)</option>
									</select>
									<p class="help-block">
										Jika diaktifkan, siswa yang mencoba login dari luar sekolah (di rumah/bolos) akan otomatis ditolak.
									</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label">Titik Koordinat Sekolah</label>
								<div class="col-sm-8">
									<div class="row">
										<div class="col-xs-6">
											<div class="input-group input-group-sm">
												<span class="input-group-addon">Lat</span>
												<input type="text" class="form-control" id="zyacbt-sekolah-latitude" name="zyacbt-sekolah-latitude" placeholder="-6.175392">
											</div>
										</div>
										<div class="col-xs-6">
											<div class="input-group input-group-sm">
												<span class="input-group-addon">Lng</span>
												<input type="text" class="form-control" id="zyacbt-sekolah-longitude" name="zyacbt-sekolah-longitude" placeholder="106.827153">
											</div>
										</div>
									</div>
									<div style="margin-top: 8px;">
										<button type="button" id="btn-detect-gps" class="btn btn-sm btn-info" onclick="ambilLokasiAdmin()">
											<i class="fa fa-crosshairs"></i> Ambil Koordinat Saya Saat Ini
										</button>
										<a id="btn-view-map" href="#" target="_blank" class="btn btn-sm btn-default" style="margin-left: 5px;">
											<i class="fa fa-external-link"></i> Cek di Google Maps
										</a>
									</div>
									<p class="help-block">
										Klik <i>Ambil Koordinat Saya Saat Ini</i> saat Anda berada di lingkungan sekolah, atau masukkan titik Latitude &amp; Longitude sekolah dari Google Maps.
									</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label">Radius Toleransi (Meter)</label>
								<div class="col-sm-8">
									<div class="input-group input-group-sm" style="max-width: 200px;">
										<input type="number" class="form-control" id="zyacbt-sekolah-radius" name="zyacbt-sekolah-radius" min="50" max="2000" step="10" placeholder="200">
										<span class="input-group-addon">Meter</span>
									</div>
									<p class="help-block">
										Batas jarak maksimal dari titik sekolah. Rekomendasi: <b>150 - 250 Meter</b> (mengakomodasi luas gedung sekolah &amp; toleransi GPS HP).
									</p>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label">Bypass IP / Subnet Jaringan Sekolah</label>
								<div class="col-sm-8">
									<input type="text" class="form-control input-sm" id="zyacbt-sekolah-ip-bypass" name="zyacbt-sekolah-ip-bypass" placeholder="192.168., 10., 172.16., 158.11., 127.0.0.1">
									<p class="help-block">
										Komputer Lab / Wi-Fi lokal dengan awalan IP di atas otomatis <b>lolos tanpa cek GPS</b> (sangat berguna untuk PC Lab sekolah yang tidak punya modul GPS satelit). Pisahkan dengan tanda koma.
									</p>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Informasi ke Peserta Tes</label>
                            <div class="col-sm-8">
								<input type="hidden" name="zyacbt-informasi" id="zyacbt-informasi" >
								<textarea class="textarea" id="zyacbt_informasi" name="zyacbt_informasi" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                <p class="help-block">
									Informasi yang diberikan ke peserta tes di Dashboard Peserta Tes
								</p>
							</div>
						</div>
                    </div>
					<div class="box-footer">
						<button type="submit" id="btn-simpan" class="btn btn-primary pull-right">Simpan Pengaturan</button>
					</div>
                </div>
			</form>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
	function updateMapLink(){
		var lat = $('#zyacbt-sekolah-latitude').val();
		var lng = $('#zyacbt-sekolah-longitude').val();
		if(lat && lng){
			$('#btn-view-map').attr('href', 'https://www.google.com/maps?q=' + lat + ',' + lng).show();
		}else{
			$('#btn-view-map').attr('href', 'https://www.google.com/maps').show();
		}
	}

	function ambilLokasiAdmin(){
		if(!navigator.geolocation){
			alert('Browser Anda tidak mendukung Geolocation GPS.');
			return;
		}
		var btn = $('#btn-detect-gps');
		btn.html('<i class="fa fa-spinner fa-spin"></i> Mendeteksi Lokasi...').prop('disabled', true);
		navigator.geolocation.getCurrentPosition(
			function(pos){
				$('#zyacbt-sekolah-latitude').val(pos.coords.latitude.toFixed(6));
				$('#zyacbt-sekolah-longitude').val(pos.coords.longitude.toFixed(6));
				updateMapLink();
				btn.html('<i class="fa fa-crosshairs"></i> Ambil Koordinat Saya Saat Ini').prop('disabled', false);
				notify_success('Koordinat GPS berhasil dideteksi: ' + pos.coords.latitude.toFixed(6) + ', ' + pos.coords.longitude.toFixed(6));
			},
			function(err){
				btn.html('<i class="fa fa-crosshairs"></i> Ambil Koordinat Saya Saat Ini').prop('disabled', false);
				alert('Gagal mendeteksi lokasi GPS: ' + err.message + '. Pastikan GPS aktif dan izin lokasi diizinkan di browser.');
			},
			{ enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
		);
	}

	function load_data(){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_pengaturan_zyacbt', function(data){
            if(data.data==1){
                $('#zyacbt-nama').val(data.cbt_nama);
                $('#zyacbt-keterangan').val(data.cbt_keterangan);
                $('#zyacbt-link-login').val(data.link_login_operator);
				$('#zyacbt-mobile-lock-xambro').val(data.mobile_lock_xambro);
				$('#zyacbt-proteksi-multilogin').val(data.proteksi_multilogin);
				$('#zyacbt-anti-cheating').val(data.anti_cheating);
				$('#zyacbt-tipe-soal-global').val(data.tipe_soal_global);
				$('#zyacbt-use-token').val(data.use_token);

				$('#zyacbt-radius-lock').val(data.radius_lock);
				$('#zyacbt-sekolah-latitude').val(data.sekolah_latitude);
				$('#zyacbt-sekolah-longitude').val(data.sekolah_longitude);
				$('#zyacbt-sekolah-radius').val(data.sekolah_radius);
				$('#zyacbt-sekolah-ip-bypass').val(data.sekolah_ip_bypass);
				updateMapLink();

				$('#zyacbt_informasi').val(data.cbt_informasi);
				$('#zyacbt-informasi').val('');
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
		CKEDITOR.replace('zyacbt_informasi');
		
		load_data();

		$('#zyacbt-sekolah-latitude, #zyacbt-sekolah-longitude').on('input change', function(){
			updateMapLink();
		});

        $('#form-pengaturan').submit(function(){
            $("#modal-proses").modal('show');
			$('#zyacbt-informasi').val(CKEDITOR.instances.zyacbt_informasi.getData());
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/simpan",
                    type:"POST",
                    data:$('#form-pengaturan').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });
    });
</script>