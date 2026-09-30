<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Ulangan Harian
		<small>Ruang Kerja Praktis untuk Guru (Buat, Jalankan, Token & Nilai)</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('manager/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Ulangan Harian</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Pop-up Notifikasi Sukses Dibuat -->
    <div id="box-token-sukses" class="box box-solid bg-green" style="display: none; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,166,90,0.3);">
        <div class="box-body" style="padding: 25px 30px; text-align: center;">
            <h3 style="margin: 0 0 10px 0; font-weight: 700; font-size: 22px;">
                <i class="fa fa-check-circle" style="margin-right: 8px;"></i> Ulangan Harian Berhasil Dimulai!
            </h3>
            <p id="pesan-sukses-mode" style="font-size: 15px; margin-bottom: 15px; opacity: 0.95;">
                <i class="fa fa-unlock"></i> <b>Mode Bebas Token:</b> Siswa dapat langsung login dan klik <b>Mulai Tes</b> tanpa perlu memasukkan token!
            </p>
            <div id="box-hasil-token" style="display: none; margin: 15px 0;">
                <div style="display: inline-block; background: #ffffff; color: #008d4c; font-size: 38px; font-weight: 900; letter-spacing: 6px; padding: 10px 35px; border-radius: 8px; border: 2px dashed #00a65a; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                    <span id="hasil-token-baru">------</span>
                </div>
            </div>
            <p style="margin-top: 15px; font-size: 13px; opacity: 0.9;">
                Status ulangan otomatis aktif untuk kelas yang Anda pilih. Siswa dapat langsung mengerjakan sekarang.
            </p>
            <button class="btn btn-default btn-sm" style="font-weight: 600; margin-top: 5px;" onclick="$('#box-token-sukses').slideUp();">
                Tutup Kotak Ini
            </button>
        </div>
    </div>

    <!-- Petunjuk Alur Kerja Ulangan Harian -->
    <div class="callout callout-info" style="border-radius: 8px; border-left: 5px solid #00c0ef; background-color: #f4faff !important; color: #31708f; box-shadow: 0 2px 6px rgba(0,0,0,0.05); margin-bottom: 20px;">
        <h4 style="font-weight: 700; font-size: 15px; margin: 0 0 8px 0; color: #1e3c72;">
            <i class="fa fa-question-circle" style="margin-right: 5px;"></i> Alur Praktis Ulangan Harian (Semua Soal Pilihan Ganda &amp; Bebas Token)
        </h4>
        <div style="font-size: 13px; line-height: 1.6;">
            Soal Ulangan Harian disiapkan mandiri oleh <b>Bapak/Ibu Guru</b>:
            <ol style="margin-bottom: 0; padding-left: 20px; margin-top: 5px;">
                <li><b>Langkah 1 (Siapkan Soal):</b> Buka menu <a href="<?php echo site_url('manager/modul_daftar'); ?>" style="font-weight: bold; text-decoration: underline;">Bank Soal UH</a> &rarr; Upload naskah soal dari <b>Microsoft Word (.docx)</b> atau ketik butir soal pilihan ganda.</li>
                <li><b>Langkah 2 (Mulai Ulangan):</b> Di formulir bawah ini, pilih bank soal tersebut, centang kelas yang diuji, tentukan menit, lalu klik <b>MULAI ULANGAN SEKARANG</b>. Siswa langsung bisa ujian tanpa perlu token!</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <!-- FORMULIR CEPAT: BUAT & JALANKAN ULANGAN -->
        <div class="col-md-5 col-sm-12">
            <div class="box box-primary" style="border-radius: 10px; border-top: 4px solid #3c8dbc; box-shadow: 0 3px 12px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700; font-size: 16px; color: #1e3c72;">
                        <i class="fa fa-paper-plane text-blue" style="margin-right: 6px;"></i> Mulai Ulangan Harian Baru
                    </h3>
                </div>
                <?php echo form_open($url.'/mulai_ulangan', 'id="form-mulai-ulangan"'); ?>
                <div class="box-body" style="padding: 20px;">
                    <div id="form-pesan-error"></div>

                    <!-- 1. Nama Ulangan -->
                    <div class="form-group">
                        <label style="font-size: 13px; font-weight: 600;">1. Judul Ulangan Harian</label>
                        <input type="text" class="form-control input-lg" id="nama_ulangan" name="nama_ulangan" placeholder="Contoh: UH 1 Matematika - Bab Aljabar" required style="border-radius: 6px; font-size: 15px;">
                        <span class="help-block" style="font-size: 12px; margin-bottom: 0;">Ketik nama ulangan yang akan tampil di layar siswa.</span>
                    </div>

                    <!-- 2. Pilihan Soal -->
                    <div class="form-group" style="margin-top: 15px;">
                        <label style="font-size: 13px; font-weight: 600;">2. Naskah / Bank Soal yang Digunakan</label>
                        <div style="background: #f9fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 15px; margin-bottom: 10px;">
                            <div class="radio" style="margin-top: 0; margin-bottom: 10px;">
                                <label style="font-weight: 600; font-size: 13px;">
                                    <input type="radio" name="sumber_soal" id="sumber_lama" value="pilih" checked onclick="$('#box-pilih-topik').show(); $('#box-buat-topik').hide();">
                                    Gunakan Topik Soal yang Sudah Ada
                                </label>
                            </div>
                            <div class="radio" style="margin-bottom: 0;">
                                <label style="font-weight: 600; font-size: 13px;">
                                    <input type="radio" name="sumber_soal" id="sumber_baru" value="baru" onclick="$('#box-pilih-topik').hide(); $('#box-buat-topik').show();">
                                    Buat Topik Baru (Belum Ada Soal / Mau Import Nanti)
                                </label>
                            </div>
                        </div>

                        <!-- Dropdown Topik Lama -->
                        <div id="box-pilih-topik">
                            <select name="topik_id" id="topik_id" class="form-control" style="width: 100%;">
                                <?php if(!empty($daftar_topik)){ ?>
                                    <?php foreach($daftar_topik as $t){ ?>
                                        <option value="<?php echo $t->topik_id; ?>"><?php echo htmlspecialchars($t->topik_nama); ?></option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <option value="0">- Belum ada bank soal. Silakan upload / buat dulu di bawah -</option>
                                <?php } ?>
                            </select>
                            
                            <?php if(empty($daftar_topik)){ ?>
                                <div class="alert alert-warning" style="margin-top: 10px; margin-bottom: 10px; padding: 10px 12px; font-size: 12px; border-radius: 6px;">
                                    <b><i class="fa fa-exclamation-triangle"></i> Anda belum memiliki bank soal ulangan:</b><br/>
                                    Silakan siapkan soal terlebih dahulu lewat 2 tombol di bawah:
                                </div>
                            <?php } ?>

                            <div style="margin-top: 8px;">
                                <a href="<?php echo site_url('manager/modul_import_word'); ?>" class="btn btn-info btn-xs" style="border-radius: 4px; font-weight: 600; margin-right: 5px;" target="_blank">
                                    <i class="fa fa-file-word-o"></i> Upload Soal dari Word (.docx) &rarr;
                                </a>
                                <a href="<?php echo site_url('manager/modul_soal'); ?>" class="btn btn-default btn-xs" style="border-radius: 4px; font-weight: 600;" target="_blank">
                                    <i class="fa fa-pencil"></i> Tulis Butir Soal Baru &rarr;
                                </a>
                            </div>
                        </div>

                        <!-- Input Topik Baru -->
                        <div id="box-buat-topik" style="display: none;">
                            <input type="text" class="form-control input-sm" id="nama_topik_baru" name="nama_topik_baru" placeholder="Nama Topik Baru (Bisa dikosongkan jika sama dengan nama ulangan)" style="border-radius: 4px;">
                            <span class="help-block" style="font-size: 12px; color: #888;">Topik baru otomatis dibuat. Anda bisa memasukkan butir soal kapan saja lewat menu Bank Soal.</span>
                        </div>
                    </div>

                    <!-- 3. Pilih Kelas -->
                    <div class="form-group" style="margin-top: 15px;">
                        <label style="font-size: 13px; font-weight: 600;">3. Pilih Kelas yang Mengikuti Ujian</label>
                        <div style="background: #f9fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px 15px; max-height: 140px; overflow-y: auto;">
                            <?php if(!empty($daftar_kelas)){ ?>
                                <?php foreach($daftar_kelas as $k){ ?>
                                    <div class="checkbox" style="margin: 4px 0;">
                                        <label style="font-size: 13px;">
                                            <input type="checkbox" name="kelas[]" value="<?php echo $k->grup_id; ?>">
                                            <b><?php echo htmlspecialchars($k->grup_nama); ?></b>
                                        </label>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <span class="text-danger" style="font-size: 12px;">Belum ada data kelas peserta di sistem.</span>
                            <?php } ?>
                        </div>
                        <span class="help-block" style="font-size: 12px; margin-bottom: 0;">Centang satu atau lebih kelas yang diajar.</span>
                    </div>

                    <!-- 4. Durasi Waktu -->
                    <div class="form-group" style="margin-top: 15px;">
                        <label style="font-size: 13px; font-weight: 600;">4. Waktu Pengerjaan (Menit)</label>
                        <div class="input-group">
                            <input type="number" class="form-control input-lg" id="durasi" name="durasi" value="60" min="5" max="300" required style="border-radius: 6px 0 0 6px; font-size: 16px; font-weight: 700;">
                            <span class="input-group-addon" style="font-weight: 600;">Menit</span>
                        </div>
                        <!-- Tombol Cepat Menit -->
                        <div style="margin-top: 8px;">
                            <button type="button" class="btn btn-default btn-xs" onclick="$('#durasi').val(30);">30 Menit</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="$('#durasi').val(45);">45 Menit</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="$('#durasi').val(60);">60 Menit (Standar)</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="$('#durasi').val(90);">90 Menit</button>
                        </div>
                    </div>
                </div>
                <div class="box-footer" style="padding: 15px 20px; background: #fdfdfe; border-top: 1px solid #f0f0f0;">
                    <button type="submit" id="btn-submit-ulangan" class="btn btn-success btn-lg btn-block" style="border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%); border: none; padding: 12px; box-shadow: 0 4px 10px rgba(46,125,50,0.25);">
                        <i class="fa fa-play-circle" style="margin-right: 6px;"></i> MULAI ULANGAN SEKARANG
                    </button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

        <!-- DAFTAR ULANGAN HARIAN SAYA -->
        <div class="col-md-7 col-sm-12">
            <div class="box box-solid" style="border-radius: 10px; border: 1px solid #e2e8f0; box-shadow: 0 3px 12px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700; font-size: 16px; color: #222;">
                        <i class="fa fa-list text-green" style="margin-right: 6px;"></i> Daftar Ulangan Harian Saya
                    </h3>
                </div>
                <div class="box-body" style="padding: 0;">
                    <?php if(!empty($daftar_ulangan)){ ?>
                        <div class="table-responsive">
                            <table class="table table-hover" style="margin-bottom: 0;">
                                <thead>
                                    <tr style="background: #f8fafc; color: #555; font-size: 12px; text-transform: uppercase;">
                                        <th style="padding: 12px 15px;">Ulangan &amp; Kelas</th>
                                        <th style="padding: 12px; text-align: center;">Akses Token</th>
                                        <th style="padding: 12px; text-align: center;">Peserta</th>
                                        <th style="padding: 12px; text-align: center;">Status</th>
                                        <th style="padding: 12px 15px; text-align: right;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($daftar_ulangan as $row){ 
                                        $tes = $row['tes'];
                                    ?>
                                    <tr style="border-bottom: 1px solid #f0f0f0;">
                                        <td style="padding: 15px;">
                                            <div style="font-weight: 700; font-size: 14px; color: #1e3c72; margin-bottom: 3px;">
                                                <?php echo htmlspecialchars($tes->tes_nama); ?>
                                            </div>
                                            <div style="font-size: 12px; color: #666;">
                                                <i class="fa fa-users text-muted"></i> Kelas: <b><?php echo !empty($row['kelas']) ? htmlspecialchars($row['kelas']) : '-'; ?></b>
                                            </div>
                                            <div style="font-size: 11px; color: #888; margin-top: 3px;">
                                                <i class="fa fa-clock-o"></i> Durasi: <?php echo $tes->tes_duration_time; ?> Menit | Topik: <?php echo htmlspecialchars($row['topik_nama']); ?> | Tipe: <span class="label label-info" style="font-size: 10px;"><?php echo !empty($row['tipe_soal']) ? $row['tipe_soal'] : 'Pilihan Ganda'; ?></span>
                                            </div>
                                        </td>
                                        <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                            <?php if($row['is_aktif'] == 1){ ?>
                                                <?php if($tes->tes_token == 1 && !empty($tes->token_isi)){ ?>
                                                    <span class="label" style="background: #fff8e1; color: #b78103; border: 1.5px solid #ffe082; font-size: 15px; font-weight: 800; letter-spacing: 2px; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                                        <?php echo $tes->token_isi; ?>
                                                    </span>
                                                    <div style="margin-top: 4px;">
                                                        <a href="javascript:void(0)" onclick="ganti_token(<?php echo $tes->tes_id; ?>)" style="font-size: 11px; color: #888;" title="Ganti Token Baru">
                                                            <i class="fa fa-refresh"></i> Ganti
                                                        </a>
                                                    </div>
                                                <?php } else { ?>
                                                    <span class="label label-success" style="font-size: 11px; font-weight: 700; padding: 5px 8px; border-radius: 4px;">
                                                        <i class="fa fa-unlock"></i> Bebas Token
                                                    </span>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <span class="label label-default" style="font-size: 11px;">Selesai</span>
                                            <?php } ?>
                                        </td>
                                        <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                            <span class="badge bg-aqua" style="font-size: 13px; font-weight: 700; padding: 4px 10px;">
                                                <?php echo $row['jml_peserta']; ?>
                                            </span>
                                            <div style="font-size: 11px; color: #888; margin-top: 3px;">Selesai</div>
                                        </td>
                                        <td style="padding: 15px; text-align: center; vertical-align: middle;">
                                            <?php if($row['is_aktif'] == 1){ ?>
                                                <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="fa fa-circle"></i> Berjalan
                                                </span>
                                            <?php } else { ?>
                                                <span class="label label-default" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                    Selesai
                                                </span>
                                            <?php } ?>
                                        </td>
                                        <td style="padding: 15px; text-align: right; vertical-align: middle;">
                                            <!-- Tombol Nilai & Excel -->
                                            <a href="<?php echo site_url('manager/tes_hasil?tes='.$tes->tes_id); ?>" class="btn btn-primary btn-sm" style="border-radius: 5px; font-weight: 600; margin-bottom: 4px;" title="Lihat Nilai dan Download Rekapan Excel">
                                                <i class="fa fa-bar-chart"></i> Nilai & Excel
                                            </a>
                                            <br>
                                            <!-- Tombol Tutup / Buka Ulangan -->
                                            <?php if($row['is_aktif'] == 1){ ?>
                                                <a href="<?php echo site_url($url.'/tutup_ulangan/'.$tes->tes_id); ?>" onclick="return confirm('Yakin ingin menutup ulangan ini? Siswa tidak akan bisa mengerjakan lagi.');" class="btn btn-default btn-xs" style="color: #c0392b; font-weight: 600;" title="Tutup Ulangan (Selesai)">
                                                    <i class="fa fa-stop-circle"></i> Tutup Ulangan
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo site_url($url.'/aktifkan_ulangan/'.$tes->tes_id); ?>" class="btn btn-default btn-xs" style="color: #27ae60; font-weight: 600;" title="Buka Kembali Ulangan">
                                                    <i class="fa fa-play-circle"></i> Buka Lagi
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div style="padding: 40px 20px; text-align: center; color: #888;">
                            <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #f0f4f8; color: #3c8dbc; font-size: 30px; margin: 0 auto 15px auto;">
                                <i class="fa fa-clipboard"></i>
                            </div>
                            <h4 style="margin: 0 0 6px 0; font-weight: 600; color: #444;">Belum Ada Ulangan Harian</h4>
                            <p style="margin: 0; font-size: 13px;">Gunakan formulir di sebelah kiri untuk membuat dan menjalankan ulangan harian pertama Anda.</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function(){
        // Select2 untuk topik
        $('#topik_id').select2({
            width: '100%',
            placeholder: "🔍 Cari topik soal..."
        });

        // Submit Mulai Ulangan via AJAX
        $('#form-mulai-ulangan').submit(function(e){
            e.preventDefault();

            // Validasi minimal 1 kelas dipilih
            if($('input[name="kelas[]"]:checked').length === 0){
                alert('Silakan centang minimal 1 kelas yang akan mengikuti ulangan.');
                return false;
            }

            $('#btn-submit-ulangan').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyiapkan Ulangan...');

            $.ajax({
                url: "<?php echo site_url($url.'/mulai_ulangan'); ?>",
                type: "POST",
                data: $('#form-mulai-ulangan').serialize(),
                dataType: "json",
                success: function(resp){
                    $('#btn-submit-ulangan').prop('disabled', false).html('<i class="fa fa-play-circle"></i> MULAI ULANGAN SEKARANG');
                    if(resp.status == 1){
                        if(resp.use_token == 1){
                            $('#pesan-sukses-mode').html('Silakan tuliskan <b>TOKEN</b> di bawah ini di papan tulis kelas agar siswa dapat memulai pengerjaan:');
                            $('#hasil-token-baru').text(resp.token);
                            $('#box-hasil-token').show();
                        } else {
                            $('#pesan-sukses-mode').html('<i class="fa fa-unlock"></i> <b>Mode Bebas Token:</b> Siswa dapat langsung login dan klik <b>Mulai Tes</b> tanpa perlu memasukkan token!');
                            $('#box-hasil-token').hide();
                        }
                        $('#box-token-sukses').slideDown();
                        $('html, body').animate({ scrollTop: 0 }, 'fast');

                        // Reset nama ulangan
                        $('#nama_ulangan').val('');

                        // Reload halaman setelah 2 detik agar tabel ter-refresh
                        setTimeout(function(){
                            window.location.reload();
                        }, 2200);
                    } else {
                        $('#form-pesan-error').html('<div class="alert alert-danger" style="border-radius: 6px;">' + resp.pesan + '</div>');
                    }
                },
                error: function(){
                    $('#btn-submit-ulangan').prop('disabled', false).html('<i class="fa fa-play-circle"></i> MULAI ULANGAN SEKARANG');
                    alert('Gagal memproses ulangan. Silakan coba lagi.');
                }
            });
            return false;
        });
    });

    function ganti_token(tes_id){
        if(confirm('Ganti token baru untuk ulangan ini?')){
            $.getJSON("<?php echo site_url($url.'/refresh_token'); ?>/" + tes_id, function(resp){
                if(resp.status == 1){
                    alert('Token berhasil diganti menjadi: ' + resp.token);
                    window.location.reload();
                } else {
                    alert(resp.pesan);
                }
            });
        }
    }
</script>
