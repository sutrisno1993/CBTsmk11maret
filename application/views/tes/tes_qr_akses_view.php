<style>
.qr-container {
    background: #ffffff;
    padding: 24px;
    border-radius: 12px;
    display: inline-block;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}
.qr-container:hover {
    box-shadow: 0 8px 25px rgba(60, 141, 188, 0.2);
    border-color: #3c8dbc;
}
.countdown-badge {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.countdown-badge.warning {
    background: #fffbeb;
    border-color: #fde68a;
    color: #92400e;
}
.countdown-badge.danger {
    background: #fef2f2;
    border-color: #fecaca;
    color: #991b1b;
}

/* Fullscreen Projector Mode */
#projector-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: #0f172a;
    color: #fff;
    z-index: 99999;
    overflow-y: auto;
    padding: 30px 20px;
    text-align: center;
    box-sizing: border-box;
}
.projector-qr-box {
    background: #ffffff;
    padding: 25px;
    border-radius: 20px;
    display: inline-block;
    margin: 15px auto;
    box-shadow: 0 0 40px rgba(59, 130, 246, 0.35);
}
.projector-step-card {
    background: rgba(30, 41, 59, 0.8);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 15px;
    text-align: left;
    margin-bottom: 12px;
}
</style>

<!-- Include QR Code Library -->
<script src="<?php echo base_url(); ?>public/plugins/qrcode/qrcode.min.js"></script>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		QR Code Akses Siswa
		<small>Akses ujian via Kuota / Data Pribadi (Solusi keterbatasan WiFi)</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url(); ?>/manager/tes_daftar">Data Tes</a></li>
		<li class="active">QR Akses Siswa</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
            <div class="callout callout-info" style="margin-bottom: 18px; border-left-width: 5px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                <h4><i class="fa fa-signal"></i> Solusi Koneksi Ujian Mandiri (Data Seluler Siswa - Maks 12 Jam):</h4>
                <p style="font-size: 13px; line-height: 1.6;">
                    Fitur ini mengatasi kendala <b>WiFi sekolah yang tidak mampu menampung seluruh perangkat siswa sekaligus</b>.
                    Pengawas cukup menampilkan QR Code di layar proyektor. Siswa memindai QR Code ini menggunakan HP mereka untuk mendapatkan izin akses ujian secara resmi selama <b>maksimal 12 jam</b>.
                    <b>QR Code ini dinamis dan berlaku selama 12 jam (Shift Pagi / Siang). Setelah 12 jam, siswa wajib meminta/memindai link QR Code terbaru ke proktor atau pengawas.</b>
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Tampilan QR Code & Aksi Proyektor -->
        <div class="col-md-6 col-sm-12">
            <div class="box box-primary text-center" style="padding-bottom: 15px;">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-qrcode text-primary"></i> QR Code Akses Aktif (12 Jam)</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-xs" onclick="fetchQrStatus(true)" title="Perbarui Status">
                            <i class="fa fa-refresh"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div style="margin-bottom: 12px;">
                        <span id="countdown-badge" class="countdown-badge">
                            <i class="fa fa-clock-o"></i> <span id="countdown-text">Menghitung waktu...</span>
                        </span>
                    </div>

                    <!-- Tempat Render QR Code Canvas -->
                    <div class="qr-container" style="margin-bottom: 15px;">
                        <div id="qrcode-canvas"></div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <span class="label label-primary" style="font-size: 12px; padding: 4px 10px;">
                            Token: <b id="label-token"><?php echo $current_token; ?></b>
                        </span>
                        <span class="label label-default" style="font-size: 12px; padding: 4px 10px; margin-left: 5px;">
                            Berlaku Hingga: <b id="label-valid-until"><?php echo $valid_until; ?></b>
                        </span>
                    </div>

                    <!-- Link URL Lengkap -->
                    <div class="form-group" style="max-width: 480px; margin: 0 auto 15px auto;">
                        <label style="font-size: 11px; color: #666; text-transform: uppercase;">URL Akses Yang Discan Siswa:</label>
                        <div class="input-group">
                            <input type="text" id="input-access-url" class="form-control input-sm" value="<?php echo htmlspecialchars($access_url); ?>" readonly style="background:#f8fafc; font-weight:600; color:#334155;">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-sm" onclick="copyAccessUrl()" title="Salin URL">
                                    <i class="fa fa-copy"></i> Salin
                                </button>
                                <a href="<?php echo htmlspecialchars($access_url); ?>" target="_blank" class="btn btn-info btn-sm" title="Uji Coba Buka di Tab Baru">
                                    <i class="fa fa-external-link"></i> Buka
                                </a>
                            </span>
                        </div>
                    </div>

                    <!-- Tombol Masuk Mode Proyektor -->
                    <div style="margin-top: 15px;">
                        <button type="button" class="btn btn-primary btn-lg" onclick="openProjectorMode()" style="padding: 10px 24px; font-weight: bold; border-radius: 30px; box-shadow: 0 4px 12px rgba(60, 141, 188, 0.35);">
                            <i class="fa fa-television"></i> Tampilkan Layar Penuh (Proyektor Kelas)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Pengaturan URL Publik & Petunjuk Siswa -->
        <div class="col-md-6 col-sm-12">
            <!-- Box Pengaturan URL Publik -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe text-primary"></i> Pengaturan Domain / URL Akses Publik</h3>
                </div>
                <div class="box-body">
                    <div id="pesan-public-url"></div>
                    <p style="font-size: 12px; color: #555;">
                        Masukkan alamat <b>IP Publik</b> atau <b>Domain</b> server sekolah Anda di bawah ini agar QR Code yang discan siswa mengarah ke jaringan internet publik:
                    </p>
                    <form id="form-public-url" onsubmit="savePublicUrl(event)">
                        <div class="form-group">
                            <label style="font-size: 12px;">URL Publik (Contoh: <code>http://115.187.31.99/zyacbtpublic</code>)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-link"></i></span>
                                <input type="text" id="public_url" name="public_url" class="form-control" value="<?php echo htmlspecialchars($public_url); ?>" placeholder="http://115.187.31.99/zyacbtpublic" required autocomplete="off">
                            </div>
                            <p class="help-block" style="font-size: 11px;">Pastikan menggunakan awalan <code>http://</code> atau <code>https://</code> tanpa tanda garis miring (slash) di akhir.</p>
                        </div>
                        <button type="submit" id="btn-save-url" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Simpan URL Publik
                        </button>
                        <button type="button" class="btn btn-default btn-sm pull-right" onclick="resetToLocalUrl()">
                            <i class="fa fa-undo"></i> Gunakan Localhost / Server Ini
                        </button>
                    </form>
                </div>
            </div>

            <!-- Box Petunjuk Pelaksanaan Untuk Siswa -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-list-ol text-info"></i> Petunjuk Scan Untuk Siswa di Kelas</h3>
                </div>
                <div class="box-body" style="font-size: 13px;">
                    <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                        <div style="background: #3c8dbc; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">1</div>
                        <div>
                            <b>Aktifkan Kuota Pribadi:</b> Matikan sambungan WiFi HP, pastikan Data Seluler aktif dan memiliki kuota internet.
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                        <div style="background: #3c8dbc; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">2</div>
                        <div>
                            <b>Buka Scanner:</b> Buka aplikasi Kamera HP, Google Lens, atau pemindai QR Code bawaan.
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                        <div style="background: #3c8dbc; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">3</div>
                        <div>
                            <b>Arahkan ke Layar:</b> Sorot QR Code di layar proyektor hingga muncul link ujian.
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; margin-bottom: 8px;">
                        <div style="background: #00a65a; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; flex-shrink: 0;">4</div>
                        <div>
                            <b>Login CBT:</b> Ketuk link tersebut, browser akan terbuka dengan status terverifikasi, lalu masukkan Username dan Password ujian Anda.
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-warning btn-xs pull-right" onclick="regenerateSalt()">
                        <i class="fa fa-refresh"></i> Rotasi Ulang Token Sekarang
                    </button>
                    <small class="text-muted"><i class="fa fa-shield"></i> Keamanan waktu 12 jam otomatis aktif.</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- OVERLAY FULLSCREEN MODE PROYEKTOR                                          -->
<!-- ========================================================================= -->
<div id="projector-overlay">
    <div style="max-width: 1100px; margin: 0 auto;">
        <!-- Header Proyektor -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.15); padding-bottom: 15px; margin-bottom: 20px;">
            <div style="text-align: left;">
                <h2 style="margin: 0; font-size: 26px; font-weight: 800; color: #60a5fa; letter-spacing: 0.5px;">
                    <i class="fa fa-qrcode"></i> SCAN QR CODE UNTUK MENGIKUTI UJIAN
                </h2>
                <div style="font-size: 14px; color: #94a3b8; margin-top: 4px;">
                    Khusus Siswa yang Menggunakan Data Seluler / Kuota Pribadi
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-danger btn-sm" onclick="closeProjectorMode()" style="border-radius: 20px; padding: 6px 16px;">
                    <i class="fa fa-times"></i> Keluar (ESC)
                </button>
            </div>
        </div>

        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
            <!-- QR Code Besar di Proyektor -->
            <div class="col-md-7 col-xs-12" style="text-align: center;">
                <div class="projector-qr-box">
                    <div id="projector-qrcode-canvas"></div>
                </div>
                <div style="margin-top: 10px;">
                    <span id="projector-countdown-badge" class="countdown-badge" style="font-size: 16px; padding: 10px 22px;">
                        <i class="fa fa-clock-o"></i> <span id="projector-countdown-text">Masa berlaku 12 jam</span>
                    </span>
                </div>
                <div style="margin-top: 8px; font-size: 13px; color: #cbd5e1;">
                    URL: <code id="projector-url-text" style="background: rgba(0,0,0,0.4); color: #38bdf8; font-size: 14px; padding: 4px 8px; border-radius: 4px;"><?php echo htmlspecialchars($access_url); ?></code>
                </div>
            </div>

            <!-- Petunjuk Siswa di Proyektor -->
            <div class="col-md-5 col-xs-12" style="text-align: left;">
                <h3 style="font-size: 18px; font-weight: 700; color: #f8fafc; margin-top: 0; margin-bottom: 15px;">
                    <i class="fa fa-info-circle text-primary"></i> Langkah Masuk Ujian:
                </h3>

                <div class="projector-step-card">
                    <div style="display: flex; gap: 10px;">
                        <div style="font-size: 24px; color: #60a5fa;"><i class="fa fa-signal"></i></div>
                        <div>
                            <b style="color: #60a5fa;">1. Sambungkan Kuota</b>
                            <p style="margin: 3px 0 0 0; font-size: 13px; color: #cbd5e1;">Matikan WiFi HP Anda dan nyalakan Data Seluler pribadi.</p>
                        </div>
                    </div>
                </div>

                <div class="projector-step-card">
                    <div style="display: flex; gap: 10px;">
                        <div style="font-size: 24px; color: #38bdf8;"><i class="fa fa-camera"></i></div>
                        <div>
                            <b style="color: #38bdf8;">2. Buka Kamera / Pemindai</b>
                            <p style="margin: 3px 0 0 0; font-size: 13px; color: #cbd5e1;">Buka aplikasi kamera HP atau pemindai QR Code bawaan.</p>
                        </div>
                    </div>
                </div>

                <div class="projector-step-card">
                    <div style="display: flex; gap: 10px;">
                        <div style="font-size: 24px; color: #34d399;"><i class="fa fa-qrcode"></i></div>
                        <div>
                            <b style="color: #34d399;">3. Pindai QR Code di Layar</b>
                            <p style="margin: 3px 0 0 0; font-size: 13px; color: #cbd5e1;">Arahkan kamera ke QR Code di samping hingga muncul notifikasi link.</p>
                        </div>
                    </div>
                </div>

                <div class="projector-step-card">
                    <div style="display: flex; gap: 10px;">
                        <div style="font-size: 24px; color: #facc15;"><i class="fa fa-user-circle"></i></div>
                        <div>
                            <b style="color: #facc15;">4. Buka Link & Login</b>
                            <p style="margin: 3px 0 0 0; font-size: 13px; color: #cbd5e1;">Buka link tersebut, lalu login dengan Username & Password Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var currentAccessUrl = "<?php echo $access_url; ?>";
    var expiresInSeconds = <?php echo intval($expires_in); ?>;
    var qrGenerator = null;
    var projectorQrGenerator = null;
    var timerInterval = null;

    function renderQrCodes(url){
        currentAccessUrl = url;
        $('#input-access-url').val(url);
        $('#projector-url-text').text(url);

        // Render Standard QR (240px)
        if(!qrGenerator){
            qrGenerator = new QRCode(document.getElementById("qrcode-canvas"), {
                text: url,
                width: 240,
                height: 240,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.M
            });
        }else{
            qrGenerator.makeCode(url);
        }

        // Render Projector QR (360px)
        if(!projectorQrGenerator){
            projectorQrGenerator = new QRCode(document.getElementById("projector-qrcode-canvas"), {
                text: url,
                width: 360,
                height: 360,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.M
            });
        }else{
            projectorQrGenerator.makeCode(url);
        }
    }

    function formatTime(seconds){
        var h = Math.floor(seconds / 3600);
        var m = Math.floor((seconds % 3600) / 60);
        var s = seconds % 60;
        if(h > 0){
            return h + " jam " + (m < 10 ? "0" + m : m) + " mnt " + (s < 10 ? "0" + s : s) + " dtk";
        }
        return (m < 10 ? "0" + m : m) + " menit " + (s < 10 ? "0" + s : s) + " detik";
    }

    function updateCountdownDisplay(){
        if(expiresInSeconds <= 0){
            $('#countdown-text').text("Memperbarui token baru...");
            $('#projector-countdown-text').text("Memperbarui token baru...");
            fetchQrStatus(false);
            return;
        }

        var text = "Berlaku 12 Jam (Sisa: " + formatTime(expiresInSeconds) + ")";
        $('#countdown-text').text(text);
        $('#projector-countdown-text').text(text);

        if(expiresInSeconds < 300){
            $('#countdown-badge, #projector-countdown-badge').removeClass('warning').addClass('danger');
        }else if(expiresInSeconds < 900){
            $('#countdown-badge, #projector-countdown-badge').removeClass('danger').addClass('warning');
        }else{
            $('#countdown-badge, #projector-countdown-badge').removeClass('warning danger');
        }

        expiresInSeconds--;
    }

    function startTimer(){
        if(timerInterval) clearInterval(timerInterval);
        updateCountdownDisplay();
        timerInterval = setInterval(updateCountdownDisplay, 1000);
    }

    function fetchQrStatus(notify){
        $.getJSON('<?php echo site_url()."/".$url; ?>/get_qr_status', function(res){
            if(res.status == 1){
                expiresInSeconds = res.expires_in;
                $('#label-token').text(res.token);
                $('#label-valid-until').text(res.valid_until);
                renderQrCodes(res.access_url);
                startTimer();
                if(notify){
                    notify_success('Status QR Code berhasil diperbarui!');
                }
            }
        });
    }

    function savePublicUrl(e){
        e.preventDefault();
        var urlVal = $('#public_url').val().trim();
        if(!urlVal){
            alert('Masukkan URL Publik terlebih dahulu!');
            return;
        }

        $('#btn-save-url').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
        $.ajax({
            url: '<?php echo site_url()."/".$url; ?>/simpan_public_url',
            type: 'POST',
            data: { public_url: urlVal },
            dataType: 'json',
            success: function(res){
                $('#btn-save-url').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan URL Publik');
                if(res.status == 1){
                    $('#pesan-public-url').html('<div class="alert alert-success alert-dismissible" style="padding:8px 12px; font-size:12px;"><button type="button" class="close" data-dismiss="alert">&times;</button>' + res.pesan + '</div>');
                    renderQrCodes(res.access_url);
                    notify_success(res.pesan);
                }else{
                    $('#pesan-public-url').html('<div class="alert alert-danger alert-dismissible" style="padding:8px 12px; font-size:12px;"><button type="button" class="close" data-dismiss="alert">&times;</button>' + res.pesan + '</div>');
                }
            },
            error: function(){
                $('#btn-save-url').prop('disabled', false).html('<i class="fa fa-save"></i> Simpan URL Publik');
                alert('Terjadi kesalahan koneksi server.');
            }
        });
    }

    function resetToLocalUrl(){
        $('#public_url').val("<?php echo site_url(); ?>".replace(/\/$/, ""));
        $('#form-public-url').submit();
    }

    function regenerateSalt(){
        if(confirm('Apakah Anda yakin ingin merotasi ulang seluruh token QR Code sekarang? Semua siswa yang memindai QR sebelumnya perlu memindai QR terbaru ini.')){
            $.getJSON('<?php echo site_url()."/".$url; ?>/regenerate_salt', function(res){
                fetchQrStatus(true);
            });
        }
    }

    function copyAccessUrl(){
        var copyText = document.getElementById("input-access-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        notify_success('Link URL akses berhasil disalin ke clipboard!');
    }

    function openProjectorMode(){
        $('#projector-overlay').fadeIn(200);
        // Render ulang QR projector
        renderQrCodes(currentAccessUrl);
        // Request fullscreen if supported
        var elem = document.documentElement;
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    function closeProjectorMode(){
        $('#projector-overlay').fadeOut(200);
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            closeProjectorMode();
        }
    });

    $(function(){
        renderQrCodes(currentAccessUrl);
        startTimer();

        // Polling status setiap 30 detik untuk memastikan sinkronisasi server
        setInterval(function(){
            fetchQrStatus(false);
        }, 30000);
    });
</script>
