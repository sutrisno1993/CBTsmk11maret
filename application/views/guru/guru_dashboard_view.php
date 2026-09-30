<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Portal Guru CBT
		<small>Ruang Kerja Pengajar <?php if(!empty($site_name)){ echo htmlspecialchars($site_name); } ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('manager/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard Guru</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Welcome Banner Card -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 12px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #fff; box-shadow: 0 4px 15px rgba(30,60,114,0.25); margin-bottom: 25px;">
                <div class="box-body" style="padding: 25px 30px;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-9 col-sm-12">
                            <h2 style="margin: 0 0 8px 0; font-weight: 700; font-size: 24px; color: #fff;">
                                <i class="fa fa-graduation-cap" style="margin-right: 10px;"></i>
                                Selamat Datang, <?php echo !empty($nama) ? htmlspecialchars($nama) : 'Bapak/Ibu Guru'; ?>!
                            </h2>
                            <p style="margin: 0; font-size: 14px; color: rgba(255,255,255,0.9); line-height: 1.6;">
                                Portal Pengajar dirancang sederhana dan terfokus untuk membantu Anda memeriksa naskah soal sebelum ujian berlangsung dan mengunduh rekap hasil ujian peserta didik.
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-12 text-right" style="margin-top: 10px;">
                            <span class="label" style="background: rgba(255,255,255,0.2); font-size: 13px; padding: 6px 14px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3);">
                                <i class="fa fa-shield"></i> Guru Mata Pelajaran
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 KARTU AKSI UTAMA GURU (SANGAT SEDERHANA & TIDAK RIBET) -->
    <div class="row">
        <!-- Kartu 1: Ulangan Harian Praktis -->
        <div class="col-md-4 col-sm-12" style="margin-bottom: 20px;">
            <div class="box box-solid hover-card" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); height: 100%; transition: all 0.3s; border-top: 4px solid #27ae60;">
                <div class="box-body" style="padding: 25px 20px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; min-height: 310px;">
                    <div>
                        <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #e8f5e9; color: #27ae60; font-size: 32px; margin: 0 auto 16px auto;">
                            <i class="fa fa-pencil-square-o"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 19px; font-weight: 700; color: #222;">
                            Ulangan Harian
                        </h3>
                        <p style="color: #666; font-size: 13px; line-height: 1.6; margin-bottom: 20px;">
                            Ruang 1 halaman praktis untuk memulai ulangan baru, memilih kelas, dan langsung mendapatkan Token ujian tanpa konfigurasi teknis yang membingungkan.
                        </p>
                    </div>
                    <div>
                        <a href="<?php echo site_url('manager/guru_ulangan'); ?>" class="btn btn-success btn-lg btn-block" style="border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); border: none; padding: 11px; box-shadow: 0 4px 10px rgba(39,174,96,0.25);">
                            <i class="fa fa-play-circle"></i> Buka Ulangan Harian &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Preview Soal Panitia -->
        <div class="col-md-4 col-sm-12" style="margin-bottom: 20px;">
            <div class="box box-solid hover-card" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); height: 100%; transition: all 0.3s; border-top: 4px solid #f39c12;">
                <div class="box-body" style="padding: 25px 20px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; min-height: 310px;">
                    <div>
                        <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #fef5e7; color: #f39c12; font-size: 32px; margin: 0 auto 16px auto;">
                            <i class="fa fa-eye"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 19px; font-weight: 700; color: #222;">
                            Preview Soal Resmi (SAS)
                        </h3>
                        <p style="color: #666; font-size: 13px; line-height: 1.6; margin-bottom: 20px;">
                            Periksa naskah soal yang di-upload oleh Panitia Ujian Sekolah, validasi kunci jawaban warna hijau, dan langsung koreksi bila ada salah ketik (typo).
                        </p>
                    </div>
                    <div>
                        <a href="<?php echo site_url('manager/modul_daftar/index/panitia'); ?>" class="btn btn-warning btn-lg btn-block" style="border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #e67e22 0%, #f39c12 100%); border: none; padding: 11px; color: #fff; box-shadow: 0 4px 10px rgba(230,126,34,0.25);">
                            <i class="fa fa-check-square-o"></i> Preview Naskah Panitia &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Nilai Siswa & Excel -->
        <div class="col-md-4 col-sm-12" style="margin-bottom: 20px;">
            <div class="box box-solid hover-card" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); height: 100%; transition: all 0.3s; border-top: 4px solid #1e3c72;">
                <div class="box-body" style="padding: 25px 20px; text-align: center; display: flex; flex-direction: column; justify-content: space-between; min-height: 310px;">
                    <div>
                        <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #e8f0fe; color: #1e3c72; font-size: 32px; margin: 0 auto 16px auto;">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                        <h3 style="margin: 0 0 10px 0; font-size: 19px; font-weight: 700; color: #222;">
                            Hasil Nilai & Excel
                        </h3>
                        <p style="color: #666; font-size: 13px; line-height: 1.6; margin-bottom: 20px;">
                            Pantau perolehan nilai peserta didik, filter per mata pelajaran dan multi-kelas, serta langsung unduh rekap nilai lengkap ke format Excel.
                        </p>
                    </div>
                    <div>
                        <a href="<?php echo site_url('manager/tes_hasil'); ?>" class="btn btn-primary btn-lg btn-block" style="border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none; padding: 11px; box-shadow: 0 4px 10px rgba(30,60,114,0.25);">
                            <i class="fa fa-download"></i> Buka Hasil & Unduh Excel &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kotak Ganti Password Profil -->
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-6 col-md-offset-3 col-sm-12">
            <div class="box box-default collapsed-box" style="border-radius: 8px; border: 1px solid #d2d6de;">
                <div class="box-header with-border" style="cursor: pointer;" data-widget="collapse">
                    <h3 class="box-title" style="font-size: 14px; font-weight: 600; color: #555;">
                        <i class="fa fa-key text-yellow" style="margin-right: 6px;"></i> Ganti Password Akun Guru
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body" style="padding: 20px;">
                    <?php echo form_open('manager/dashboard/password', 'id="form-password"'); ?>
                        <div id="form-pesan-password"></div>
                        <div class="form-group">
                            <label style="font-size: 13px;">Password Saat Ini (Default: No WhatsApp)</label>
                            <input type="password" class="form-control" id="password-old" name="password-old" required>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 13px;">Password Baru</label>
                            <input type="password" class="form-control" id="password-new" name="password-new" required>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 13px;">Ulangi Password Baru</label>
                            <input type="password" class="form-control" id="password-confirm" name="password-confirm" required>
                        </div>
                        <button type="submit" id="btn-password" class="btn btn-primary btn-block" style="border-radius: 6px; font-weight: 600;">
                            Simpan Password Baru
                        </button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style type="text/css">
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
</style>

<script type="text/javascript">
    $(function(){
        $('#form-password').submit(function(e){
            e.preventDefault();
            $('#btn-password').prop('disabled', true);
            $.ajax({
                url: "<?php echo site_url('manager/dashboard/password'); ?>",
                type: "POST",
                data: $('#form-password').serialize(),
                dataType: "json",
                success: function(resp){
                    $('#btn-password').prop('disabled', false);
                    if(resp.status == 1){
                        $('#form-pesan-password').html('<div class="alert alert-success" style="border-radius: 6px;">Password berhasil diubah!</div>');
                        $('#form-password')[0].reset();
                    } else {
                        $('#form-pesan-password').html('<div class="alert alert-danger" style="border-radius: 6px;">' + resp.error + '</div>');
                    }
                },
                error: function(){
                    $('#btn-password').prop('disabled', false);
                    alert('Gagal memproses penggantian password.');
                }
            });
            return false;
        });
    });
</script>
