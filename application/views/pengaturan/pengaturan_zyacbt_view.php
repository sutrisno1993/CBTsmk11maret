<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Pengaturan ZYACBT
		<small>Melakukan pengaturan Identitas ZYACBT</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Pengaturan ZYACBT</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
			<?php echo form_open($url.'/simpan','id="form-pengaturan"'); ?>
                <div class="box">
                    <div class="box-header with-border">
    					<div class="box-title">Daftar Pengaturan ZYACBT</div>
                    </div><!-- /.box-header -->

                    <div class="box-body form-horizontal">
						<div id="form-pesan"></div>
                        <div class="form-group">
							<label class="col-sm-4 control-label">Nama</label>
                            <div class="col-sm-8">
								<input type="text" class="form-control input-sm" id="zyacbt-nama" name="zyacbt-nama" >
                                <p class="help-block">
									Nama Pelaksana ZYACBT.<br />
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
				$('#zyacbt_informasi').val(data.cbt_informasi);
				$('#zyacbt-informasi').val('');
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
		CKEDITOR.replace('zyacbt_informasi');
		
		load_data();
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