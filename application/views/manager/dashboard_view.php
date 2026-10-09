<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Dashboard Utama
		<small><?php if(!empty($site_name)){ echo htmlspecialchars($site_name); }else{ echo 'Aplikasi Ujian Online'; } ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('manager'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- 1. HERO BANNER SELAMAT DATANG ADMIN -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 12px; background: linear-gradient(135deg, #00897b 0%, #004d40 100%); color: #fff; box-shadow: 0 4px 15px rgba(0,77,64,0.25); margin-bottom: 25px;">
                <div class="box-body" style="padding: 22px 28px;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-8 col-sm-12">
                            <h2 style="margin: 0 0 8px 0; font-weight: 700; font-size: 22px; color: #fff;">
                                <i class="fa fa-tachometer" style="margin-right: 8px;"></i>
                                Selamat Datang, <?php echo !empty($nama) ? htmlspecialchars($nama) : 'Administrator'; ?>!
                            </h2>
                            <p style="margin: 0; font-size: 13px; color: rgba(255,255,255,0.9); line-height: 1.6;">
                                Pusat kendali pelaksanaan ujian sekolah, bank soal, distribusi peserta, dan monitoring kelancaran server CBT secara real-time.
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-12 text-right" style="margin-top: 10px;">
                            <div style="display: inline-block; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 10px; padding: 10px 16px; text-align: right;">
                                <small style="display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">Token Ujian Terakhir</small>
                                <span style="font-size: 20px; font-weight: 800; letter-spacing: 2px; color: #ffeb3b;"><?php echo !empty($token_aktif) ? $token_aktif : '-'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. KARTU STATISTIK REAL-TIME (4 STATS CARDS) -->
    <div class="row">
        <!-- Total Peserta -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box stat-card bg-aqua" style="border-radius: 10px; box-shadow: 0 4px 12px rgba(0,192,239,0.2);">
                <div class="inner" style="padding: 16px 18px;">
                    <h3 style="font-size: 32px; font-weight: 700; margin: 0 0 5px 0;"><?php echo number_format(!empty($total_siswa) ? $total_siswa : 0); ?></h3>
                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Peserta Terdaftar</p>
                </div>
                <div class="icon" style="top: 10px; right: 12px; font-size: 65px; opacity: 0.3;">
                    <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo site_url('manager/peserta_daftar'); ?>" class="small-box-footer" style="border-radius: 0 0 10px 10px; padding: 6px 0; font-size: 12px;">
                    Kelola Peserta <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Bank Soal -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box stat-card bg-green" style="border-radius: 10px; box-shadow: 0 4px 12px rgba(0,166,90,0.2);">
                <div class="inner" style="padding: 16px 18px;">
                    <h3 style="font-size: 32px; font-weight: 700; margin: 0 0 5px 0;"><?php echo number_format(!empty($total_soal) ? $total_soal : 0); ?></h3>
                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Butir Soal Ujian</p>
                </div>
                <div class="icon" style="top: 10px; right: 12px; font-size: 65px; opacity: 0.3;">
                    <i class="fa fa-book"></i>
                </div>
                <a href="<?php echo site_url('manager/modul_daftar'); ?>" class="small-box-footer" style="border-radius: 0 0 10px 10px; padding: 6px 0; font-size: 12px;">
                    Buka Bank Soal <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Jadwal Tes -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box stat-card bg-yellow" style="border-radius: 10px; box-shadow: 0 4px 12px rgba(243,156,18,0.2);">
                <div class="inner" style="padding: 16px 18px;">
                    <h3 style="font-size: 32px; font-weight: 700; margin: 0 0 5px 0;"><?php echo number_format(!empty($total_tes) ? $total_tes : 0); ?></h3>
                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Jadwal Pelaksanaan Tes</p>
                </div>
                <div class="icon" style="top: 10px; right: 12px; font-size: 65px; opacity: 0.3;">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
                <a href="<?php echo site_url('manager/tes_daftar'); ?>" class="small-box-footer" style="border-radius: 0 0 10px 10px; padding: 6px 0; font-size: 12px;">
                    Daftar Ujian <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Siswa Aktif / Ujian Berjalan -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box stat-card bg-red" style="border-radius: 10px; box-shadow: 0 4px 12px rgba(221,75,57,0.2);">
                <div class="inner" style="padding: 16px 18px;">
                    <h3 style="font-size: 32px; font-weight: 700; margin: 0 0 5px 0;">
                        <?php echo number_format(!empty($siswa_aktif_tes) ? $siswa_aktif_tes : 0); ?>
                        <span class="live-dot" title="Live pengerjaan saat ini"></span>
                    </h3>
                    <p style="font-size: 13px; margin: 0; font-weight: 500;">Siswa Sedang Ujian</p>
                </div>
                <div class="icon" style="top: 10px; right: 12px; font-size: 65px; opacity: 0.3;">
                    <i class="fa fa-pencil-square-o"></i>
                </div>
                <a href="<?php echo site_url('manager/peserta_online'); ?>" class="small-box-footer" style="border-radius: 0 0 10px 10px; padding: 6px 0; font-size: 12px;">
                    Pantau Peserta Aktif <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- NOTIFIKASI CATATAN KOREKSI DARI GURU (JIKA ADA) -->
    <?php if(!empty($total_pending_koreksi) && $total_pending_koreksi > 0){ ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-warning" style="border-radius: 12px; background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; color: #92400e; padding: 18px 22px; box-shadow: 0 4px 15px rgba(245,158,11,0.15); margin-bottom: 25px;">
                <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                    <div class="col-md-9 col-xs-12">
                        <h4 style="margin: 0 0 6px 0; font-weight: 800; font-size: 16px; color: #92400e;">
                            <i class="fa fa-bell text-orange" style="margin-right: 6px;"></i> Notifikasi: Ada <?php echo $total_pending_koreksi; ?> Catatan Koreksi Butir Soal dari Bapak/Ibu Guru!
                        </h4>
                        <p style="margin: 0; font-size: 13px; color: #78350f; line-height: 1.5;">
                            Bapak/Ibu Guru telah memeriksa naskah bank soal dan memberikan catatan koreksi (seperti salah kunci jawaban, typo, atau opsi tertukar). Silakan segera ditinjau dan diperbaiki pada panel di bawah ini.
                        </p>
                    </div>
                    <div class="col-md-3 col-xs-12 text-right" style="margin-top: 10px;">
                        <a href="#panel-koreksi-guru" class="btn btn-warning btn-sm" style="font-weight: 800; border-radius: 8px; background: #ea580c; border-color: #c2410c; color: #fff; padding: 8px 16px; box-shadow: 0 2px 8px rgba(234,88,12,0.3);">
                            <i class="fa fa-pencil-square-o"></i> Lihat Catatan Koreksi &darr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- 3. MENU PINTAS AKSI CEPAT (QUICK SHORTCUTS) -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 10px; border: 1px solid #e0e0e0; margin-bottom: 25px;">
                <div class="box-header with-border" style="padding: 14px 20px;">
                    <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #333;">
                        <i class="fa fa-bolt text-yellow" style="margin-right: 6px;"></i> Aksi Cepat Operator &amp; Panitia
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo site_url('monitoring_soal'); ?>" target="_blank" class="btn btn-xs btn-primary" style="font-weight: 700; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none;">
                            <i class="fa fa-external-link"></i> Portal Telaah Guru (Publik)
                        </a>
                    </div>
                </div>
                <div class="box-body" style="padding: 18px 20px;">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6 quick-btn-box">
                            <a href="<?php echo site_url('manager/tes_qr_akses'); ?>" class="btn btn-default btn-block quick-action-btn" style="border-color: #fbcfe8; background: #fdf2f8;">
                                <i class="fa fa-qrcode text-purple" style="font-size: 26px; display: block; margin-bottom: 8px; color: #9333ea;"></i>
                                <span style="color: #6b21a8; font-weight: 800;">QR Akses Kuota (Proyektor)</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 quick-btn-box">
                            <a href="<?php echo site_url('monitoring_soal'); ?>" target="_blank" class="btn btn-default btn-block quick-action-btn" style="border-color: #93c5fd; background: #f0f9ff;">
                                <i class="fa fa-share-alt text-primary" style="font-size: 26px; display: block; margin-bottom: 8px;"></i>
                                <span style="color: #1e3c72; font-weight: 800;">Link Telaah Guru (SAS)</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 quick-btn-box">
                            <a href="<?php echo site_url('manager/tes_tambah'); ?>" class="btn btn-default btn-block quick-action-btn">
                                <i class="fa fa-plus-circle text-green" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                <span>Tambah Tes</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 quick-btn-box">
                            <a href="<?php echo site_url('manager/tes_token'); ?>" class="btn btn-default btn-block quick-action-btn">
                                <i class="fa fa-key text-yellow" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                <span>Rilis Token</span>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 quick-btn-box">
                            <a href="<?php echo site_url('manager/peserta_reset'); ?>" class="btn btn-default btn-block quick-action-btn">
                                <i class="fa fa-refresh text-red" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                <span>Reset Login</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PANEL NOTIFIKASI KOREKSI & VERIFIKASI NASKAH SOAL GURU -->
    <div class="row" id="panel-koreksi-guru">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 25px;">
                <div class="box-header with-border" style="padding: 16px 20px; background: #fafbfc; border-radius: 12px 12px 0 0;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-6 col-xs-12">
                            <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                <i class="fa fa-pencil-square-o text-orange" style="margin-right: 8px;"></i>
                                Masukan Koreksi &amp; Status Verifikasi Naskah Soal Guru
                            </h3>
                            <p style="margin: 3px 0 0 0; font-size: 12px; color: #64748b;">
                                Catatan perbaikan dari guru penelaah serta rekap pengesahan (TTD) kelayakan naskah soal ujian.
                            </p>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right" style="margin-top: 6px;">
                            <div class="btn-group btn-group-sm" id="btn-group-koreksi-tab">
                                <button type="button" class="btn btn-primary active" onclick="switchKoreksiTab('pending', this)">
                                    <i class="fa fa-exclamation-circle"></i> Catatan Koreksi Guru (<span id="cnt-pending-koreksi"><?php echo !empty($total_pending_koreksi) ? $total_pending_koreksi : 0; ?></span>)
                                </button>
                                <button type="button" class="btn btn-default" onclick="switchKoreksiTab('verified', this)">
                                    <i class="fa fa-certificate text-green"></i> Naskah Terverifikasi (<?php echo !empty($total_verified_topik) ? $total_verified_topik : 0; ?>)
                                </button>
                            </div>
                            <a href="<?php echo site_url('monitoring_soal'); ?>" target="_blank" class="btn btn-sm btn-info" style="margin-left: 6px; font-weight: 600;" title="Buka Portal Monitoring Guru">
                                <i class="fa fa-external-link"></i> Portal Guru
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="box-body" style="padding: 0;">
                    <!-- TAB 1: CATATAN KOREKSI PENDING -->
                    <div id="tab-koreksi-pending">
                        <?php if(!empty($daftar_koreksi_pending) && count($daftar_koreksi_pending) > 0){ ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" style="margin-bottom: 0; font-size: 13px;">
                                    <thead>
                                        <tr style="background: #fff7ed; color: #9a3412;">
                                            <th style="width: 40px;" class="text-center">No</th>
                                            <th style="width: 20%;">Mata Pelajaran / Topik</th>
                                            <th style="width: 16%;">Guru Penelaah</th>
                                            <th style="width: 34%;">Isi Catatan Koreksi Guru</th>
                                            <th style="width: 13%;">Waktu Masuk</th>
                                            <th style="width: 17%;" class="text-center">Aksi Perbaikan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no_k = 1;
                                        foreach($daftar_koreksi_pending as $dk){ 
                                        ?>
                                        <tr id="row-koreksi-<?php echo $dk->koreksi_id; ?>">
                                            <td class="text-center" style="vertical-align: middle; color: #64748b;"><?php echo $no_k++; ?></td>
                                            <td style="vertical-align: middle;">
                                                <span class="label label-primary" style="font-size: 10px;"><?php echo htmlspecialchars($dk->modul_nama); ?></span><br>
                                                <strong style="color: #1e293b;"><?php echo htmlspecialchars($dk->topik_nama); ?></strong>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="font-weight: 700; color: #1e293b;">
                                                    <i class="fa fa-user-circle text-orange"></i> <?php echo htmlspecialchars($dk->koreksi_guru_nama); ?>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="background: #fff; border: 1px solid #fed7aa; border-radius: 6px; padding: 8px 12px; color: #7c2d12; font-size: 12px; line-height: 1.5;">
                                                    <strong>Soal ID #<?php echo $dk->koreksi_soal_id; ?>:</strong> <?php echo nl2br(htmlspecialchars($dk->koreksi_catatan)); ?>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; font-size: 12px; color: #64748b;">
                                                <i class="fa fa-clock-o"></i> <?php echo date('d/m/Y H:i', strtotime($dk->koreksi_created_at)); ?>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a href="<?php echo site_url('manager/modul_soal/index/'.$dk->koreksi_soal_id); ?>" target="_blank" class="btn btn-xs btn-primary" style="font-weight: 700; margin-bottom: 3px;" title="Buka form edit soal ini">
                                                    <i class="fa fa-pencil"></i> Edit Soal
                                                </a>
                                                <button type="button" class="btn btn-xs btn-success" onclick="tandaiKoreksiSelesai(<?php echo $dk->koreksi_id; ?>, this)" title="Tandai catatan ini telah selesai diperbaiki">
                                                    <i class="fa fa-check"></i> Selesai
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="text-center text-muted" style="padding: 35px 20px;">
                                <i class="fa fa-check-circle" style="font-size: 38px; color: #10b981; margin-bottom: 10px;"></i>
                                <h4 style="color: #1e293b; font-weight: 700; margin: 0 0 5px 0;">Tidak Ada Catatan Revisi Baru</h4>
                                <p style="font-size: 13px; margin: 0; color: #64748b;">
                                    Seluruh butir naskah soal tidak memiliki catatan kesalahan atau telah selesai diperbaiki.
                                </p>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- TAB 2: NASKAH TERVERIFIKASI / ACC -->
                    <div id="tab-koreksi-verified" style="display: none;">
                        <?php if(!empty($daftar_verifikasi_terbaru) && count($daftar_verifikasi_terbaru) > 0){ ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" style="margin-bottom: 0; font-size: 13px;">
                                    <thead>
                                        <tr style="background: #f0fdf4; color: #166534;">
                                            <th style="width: 40px;" class="text-center">No</th>
                                            <th style="width: 30%;">Mata Pelajaran / Topik</th>
                                            <th style="width: 25%;">Guru Penelaah / Verifikator</th>
                                            <th style="width: 15%;">Status</th>
                                            <th style="width: 15%;">Waktu Verifikasi</th>
                                            <th style="width: 15%;" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no_v = 1;
                                        foreach($daftar_verifikasi_terbaru as $dv){ 
                                        ?>
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; color: #64748b;"><?php echo $no_v++; ?></td>
                                            <td style="vertical-align: middle;">
                                                <span class="label label-primary" style="font-size: 10px;"><?php echo htmlspecialchars($dv->modul_nama); ?></span><br>
                                                <strong><?php echo htmlspecialchars($dv->topik_nama); ?></strong>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <div style="font-weight: 700; color: #166534;">
                                                    <i class="fa fa-certificate text-green"></i> <?php echo htmlspecialchars($dv->verifikasi_guru_nama); ?>
                                                </div>
                                                <?php if(!empty($dv->verifikasi_guru_nip) && $dv->verifikasi_guru_nip != '-'){ ?>
                                                    <small class="text-muted">NIP: <?php echo htmlspecialchars($dv->verifikasi_guru_nip); ?></small>
                                                <?php } ?>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <?php if($dv->verifikasi_status == 'sesuai'){ ?>
                                                    <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                        <i class="fa fa-check-circle"></i> ACC (Sudah Sesuai)
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="label label-warning" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                        <i class="fa fa-warning"></i> Ada Revisi
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td style="vertical-align: middle; font-size: 12px; color: #64748b;">
                                                <i class="fa fa-calendar-check-o text-green"></i> <?php echo date('d/m/Y H:i', strtotime($dv->verifikasi_created_at)); ?>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle;">
                                                <a href="<?php echo site_url('monitoring_soal/detail/'.$dv->verifikasi_topik_id); ?>" target="_blank" class="btn btn-xs btn-default" style="border: 1px solid #cbd5e1; font-weight: 600;">
                                                    <i class="fa fa-eye text-primary"></i> Lihat Lembar Soal
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="text-center text-muted" style="padding: 35px 20px;">
                                <i class="fa fa-certificate" style="font-size: 38px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                <h4 style="color: #475569; font-weight: 700; margin: 0 0 5px 0;">Belum Ada Topik Yang Diverifikasi (ACC)</h4>
                                <p style="font-size: 13px; margin: 0; color: #64748b;">
                                    Bagikan link portal kepada Bapak/Ibu Guru untuk menelaah dan mengesahkan naskah soal.
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. PANEL MONITORING LIVE KONEKSI SISWA (IP PUBLIK VS WI-FI SEKOLAH) -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 15px rgba(0,0,0,0.04); margin-bottom: 25px;">
                <div class="box-header with-border" style="padding: 16px 20px; background: #fafbfc; border-radius: 12px 12px 0 0;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-7 col-xs-12">
                            <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #1e293b;">
                                <i class="fa fa-globe text-primary" style="margin-right: 8px;"></i>
                                Monitoring Live Siswa Ujian (IP Publik vs Wi-Fi Sekolah)
                            </h3>
                            <p style="margin: 3px 0 0 0; font-size: 12px; color: #64748b;">
                                Memantau siswa yang sedang mengerjakan ujian, mendeteksi jalur koneksi (Wi-Fi Sekolah vs Kuota HP) serta verifikasi jarak lokasi GPS.
                            </p>
                        </div>
                        <div class="col-md-5 col-xs-12 text-right" style="margin-top: 6px;">
                            <a href="<?php echo site_url('manager/tes_qr_akses'); ?>" class="btn btn-sm btn-purple" style="background: #9333ea; border-color: #7e22ce; color: #fff; font-weight: 700; margin-right: 6px; box-shadow: 0 2px 6px rgba(147,51,234,0.3);">
                                <i class="fa fa-qrcode"></i> Layar QR Proyektor
                            </a>
                            <!-- Filter Tabs -->
                            <div class="btn-group btn-group-sm" id="btn-group-filter-ip">
                                <button type="button" class="btn btn-primary active" onclick="filterMonitoringIp('semua', this)">
                                    Semua (<span id="cnt-semua"><?php echo !empty($siswa_monitoring) ? count($siswa_monitoring) : 0; ?></span>)
                                </button>
                                <button type="button" class="btn btn-default" onclick="filterMonitoringIp('public', this)">
                                    <span class="text-blue"><i class="fa fa-signal"></i> Kuota / IP Publik (<span id="cnt-public"><?php echo !empty($total_public_ip) ? $total_public_ip : 0; ?></span>)</span>
                                </button>
                                <button type="button" class="btn btn-default" onclick="filterMonitoringIp('local', this)">
                                    <span class="text-green"><i class="fa fa-wifi"></i> Wi-Fi Sekolah (<span id="cnt-local"><?php echo !empty($total_local_ip) ? $total_local_ip : 0; ?></span>)</span>
                                </button>
                            </div>
                            <a href="<?php echo site_url('manager/dashboard'); ?>" class="btn btn-sm btn-default" title="Segarkan Data" style="margin-left: 6px;">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body" style="padding: 0;">
                    <?php if(!empty($siswa_monitoring) && count($siswa_monitoring) > 0){ ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="table-monitoring-ip" style="margin-bottom: 0;">
                                <thead>
                                    <tr style="background: #f8fafc; font-size: 12px; color: #475569;">
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th>Nama Peserta / Username</th>
                                        <th>Kelas / Grup</th>
                                        <th>Mata Pelajaran / Tes</th>
                                        <th class="text-center">Jalur Koneksi</th>
                                        <th>Alamat IP</th>
                                        <th>Status Lokasi GPS</th>
                                        <th>Waktu Mulai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach($siswa_monitoring as $sm){ 
                                        $row_type = $sm->is_local_ip ? 'local' : 'public';
                                    ?>
                                        <tr class="row-monitoring row-<?php echo $row_type; ?>">
                                            <td class="text-center" style="font-size: 12px; color: #64748b;"><?php echo $no++; ?></td>
                                            <td>
                                                <div style="font-weight: 700; color: #1e293b; font-size: 13px;">
                                                    <?php echo htmlspecialchars($sm->user_firstname); ?>
                                                </div>
                                                <small class="text-muted"><i class="fa fa-user"></i> <?php echo htmlspecialchars($sm->user_name); ?></small>
                                            </td>
                                            <td style="font-size: 12px; font-weight: 600; color: #475569;">
                                                <span class="label label-default" style="font-size: 11px;"><?php echo !empty($sm->grup_nama) ? htmlspecialchars($sm->grup_nama) : '-'; ?></span>
                                            </td>
                                            <td style="font-size: 12px; color: #334155;">
                                                <b><?php echo !empty($sm->tes_nama) ? htmlspecialchars($sm->tes_nama) : '-'; ?></b>
                                            </td>
                                            <td class="text-center">
                                                <?php if($sm->is_local_ip){ ?>
                                                    <span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                                        <i class="fa fa-wifi"></i> Wi-Fi / LAN Sekolah
                                                    </span>
                                                <?php } else { ?>
                                                    <span class="label label-primary" style="font-size: 11px; padding: 4px 8px; border-radius: 4px; background-color: #2563eb !important;">
                                                        <i class="fa fa-signal"></i> Kuota / IP Publik
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td style="font-family: monospace; font-size: 12px; font-weight: 600; color: #0f172a;">
                                                <?php echo htmlspecialchars($sm->display_ip); ?>
                                            </td>
                                            <td style="font-size: 12px;">
                                                <?php if($sm->is_local_ip){ ?>
                                                    <span class="text-green" title="Bypass Lokasi GPS karena terhubung ke jaringan sekolah">
                                                        <i class="fa fa-check-circle"></i> Jaringan Sekolah
                                                    </span>
                                                <?php } else if(!empty($sm->jarak_meter) || $sm->jarak_meter === 0){ ?>
                                                    <span class="text-primary" style="font-weight: 600;">
                                                        <i class="fa fa-map-marker text-red"></i> ~<?php echo $sm->jarak_meter; ?>m dari Sekolah
                                                    </span>
                                                    <br><small class="text-muted">(GPS Terverifikasi)</small>
                                                <?php } else { ?>
                                                    <span class="text-muted"><i class="fa fa-map-marker"></i> Terverifikasi</span>
                                                <?php } ?>
                                            </td>
                                            <td style="font-size: 12px; color: #64748b;">
                                                <i class="fa fa-clock-o"></i> <?php echo date('H:i:s', strtotime($sm->tesuser_creation_time)); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="text-center text-muted" style="padding: 40px 20px;">
                            <i class="fa fa-users" style="font-size: 38px; color: #cbd5e1; margin-bottom: 10px;"></i>
                            <p style="font-size: 13px; margin: 0; color: #64748b;">
                                Saat ini belum ada siswa yang sedang aktif mengerjakan ujian hari ini.
                            </p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. DUA KOLOM: JADWAL UJIAN HARI INI & STATUS SERVER -->
    <div class="row">
        <!-- Kolom Kiri: Jadwal Ujian Aktif -->
        <div class="col-md-7 col-xs-12">
            <div class="box box-primary" style="border-radius: 10px; border-top: 3px solid #3c8dbc; min-height: 380px;">
                <div class="box-header with-border" style="padding: 14px 20px;">
                    <h3 class="box-title" style="font-size: 15px; font-weight: 700; color: #333;">
                        <i class="fa fa-clock-o text-primary" style="margin-right: 6px;"></i> Jadwal Ujian Aktif
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo site_url('manager/tes_daftar'); ?>" class="btn btn-xs btn-default">Semua Jadwal &rarr;</a>
                    </div>
                </div>
                <div class="box-body" style="padding: 0;">
                    <?php if(!empty($tes_berjalan) && count($tes_berjalan) > 0){ ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="margin-bottom: 0;">
                                <thead>
                                    <tr style="background: #f8fafc; font-size: 12px; color: #555;">
                                        <th>Nama Ujian</th>
                                        <th>Waktu Ujian</th>
                                        <th class="text-center">Durasi</th>
                                        <th class="text-center">Token</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($tes_berjalan as $t){ 
                                        $now = date('Y-m-d H:i:s');
                                        $is_active = ($now >= $t->tes_begin_time && $now <= $t->tes_end_time);
                                    ?>
                                        <tr>
                                            <td style="font-weight: 600; color: #222;">
                                                <?php echo htmlspecialchars($t->tes_nama); ?>
                                                <?php if($is_active){ ?>
                                                    <span class="label label-success" style="font-size: 10px; margin-left: 5px;">Sedang Berjalan</span>
                                                <?php } ?>
                                            </td>
                                            <td style="font-size: 12px; color: #666;">
                                                <i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($t->tes_begin_time)); ?><br>
                                                <small class="text-muted">s/d <?php echo date('d/m/Y H:i', strtotime($t->tes_end_time)); ?></small>
                                            </td>
                                            <td class="text-center" style="font-weight: 600; font-size: 12px;">
                                                <?php echo $t->tes_duration_time; ?> Menit
                                            </td>
                                            <td class="text-center">
                                                <?php if(!empty($t->tes_token) && $t->tes_token == 1){ ?>
                                                    <span class="badge bg-yellow" title="Memerlukan Token"><i class="fa fa-lock"></i> Wajib</span>
                                                <?php }else{ ?>
                                                    <span class="badge bg-gray"><i class="fa fa-unlock"></i> Bebas</span>
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo site_url('manager/tes_hasil/index/'.$t->tes_id); ?>" class="btn btn-xs btn-primary" title="Lihat Hasil Peserta">
                                                    <i class="fa fa-bar-chart"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="text-center text-muted" style="padding: 50px 20px;">
                            <i class="fa fa-calendar-o" style="font-size: 40px; margin-bottom: 12px; color: #ccc;"></i>
                            <p style="font-size: 14px; margin-bottom: 15px;">Belum ada jadwal tes yang aktif untuk hari ini.</p>
                            <a href="<?php echo site_url('manager/tes_tambah'); ?>" class="btn btn-sm btn-success">
                                <i class="fa fa-plus"></i> Buat Jadwal Ujian Sekarang
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Kesehatan & Status Server -->
        <div class="col-md-5 col-xs-12">
            <div class="box box-default" style="border-radius: 10px; border-top: 3px solid #00a65a; min-height: 380px;">
                <div class="box-header with-border" style="padding: 14px 20px;">
                    <h3 class="box-title" style="font-size: 15px; font-weight: 700; color: #333;">
                        <i class="fa fa-server text-green" style="margin-right: 6px;"></i> Status &amp; Jam Server CBT
                    </h3>
                </div>
                <div class="box-body" style="padding: 20px;">
                    <!-- Jam Digital Server Realtime -->
                    <div style="background: #f4f6f9; border-radius: 8px; padding: 14px; text-align: center; margin-bottom: 20px; border: 1px solid #e2e8f0;">
                        <small style="color: #666; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">Waktu Server Terkini</small>
                        <div id="live-clock" style="font-size: 24px; font-weight: 800; color: #1e293b; font-family: monospace; margin: 4px 0;">
                            <?php echo !empty($waktu_server) ? $waktu_server : date('Y-m-d H:i:s'); ?>
                        </div>
                        <small style="color: #00897b; font-weight: 600;"><i class="fa fa-globe"></i> <?php echo !empty($timezone) ? $timezone : date_default_timezone_get(); ?></small>
                    </div>

                    <!-- List Status Server -->
                    <ul class="list-group list-group-unbordered" style="margin-bottom: 0;">
                        <li class="list-group-item" style="padding: 10px 0; border-color: #f1f5f9;">
                            <span class="text-muted"><i class="fa fa-database" style="width: 20px;"></i> Status Database:</span>
                            <span class="pull-right label label-success" style="font-size: 11px;"><i class="fa fa-check"></i> Terhubung Normal</span>
                        </li>
                        <li class="list-group-item" style="padding: 10px 0; border-color: #f1f5f9;">
                            <span class="text-muted"><i class="fa fa-cloud-upload" style="width: 20px;"></i> Batas Upload PHP:</span>
                            <span class="pull-right" style="font-weight: 600; color: #333;">
                                <?php echo !empty($upload_max_filesize) ? $upload_max_filesize : '-'; ?> (POST: <?php echo !empty($post_max_size) ? $post_max_size : '-'; ?>)
                            </span>
                        </li>
                        <li class="list-group-item" style="padding: 10px 0; border-color: #f1f5f9;">
                            <span class="text-muted"><i class="fa fa-folder-open" style="width: 20px;"></i> Folder "uploads/":</span>
                            <span class="pull-right">
                                <?php if(!empty($dir_uploads) && $dir_uploads == 'Writeable'){ ?>
                                    <span class="label label-success"><i class="fa fa-check"></i> Writeable</span>
                                <?php }else{ ?>
                                    <span class="label label-danger"><i class="fa fa-times"></i> Not Writeable</span>
                                <?php } ?>
                            </span>
                        </li>
                        <li class="list-group-item" style="padding: 10px 0; border-color: #f1f5f9; border-bottom: none;">
                            <span class="text-muted"><i class="fa fa-sign-in" style="width: 20px;"></i> Sesi Login Aktif:</span>
                            <span class="pull-right badge bg-aqua" style="font-size: 11px;">
                                <?php echo !empty($siswa_login) ? $siswa_login : 0; ?> Peserta Online
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. BAGIAN INFORMASI LEGALITAS & TRIBUTE (DIBUAT RAPIH DI ACCORDION BAWAH) -->
    <div class="row" style="margin-top: 10px;">
        <div class="col-xs-12">
            <div class="box box-default collapsed-box" style="border-radius: 8px; border: 1px solid #d2d6de; box-shadow: none;">
                <div class="box-header with-border" style="cursor: pointer; padding: 12px 18px;" data-widget="collapse">
                    <h3 class="box-title" style="font-size: 13px; font-weight: 600; color: #666;">
                        <i class="fa fa-info-circle text-muted" style="margin-right: 6px;"></i> Petunjuk Penggunaan &amp; Informasi Lisensi ZYA CBT
                    </h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body" style="padding: 20px; font-size: 13px; color: #555; line-height: 1.6;">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-top: 0;">Tentang Aplikasi</h4>
                            <p>Aplikasi Ujian Online <b>SMART-CBT</b> dikembangkan untuk mendukung kelancaran pelaksanaan ujian berbasis komputer:</p>
                            <ol style="padding-left: 20px;">
                                <li>Sistem Ujian Online CBT Cepat, Aman, dan Terstruktur.</li>
                                <li>Mendukung Ujian Data Mandiri (QR Code 12 Jam) & WiFi Lokal Sekolah.</li>
                                <li>Dikelola oleh Tim ICT SMK 11 Maret.</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-size: 14px; font-weight: 700; color: #333; margin-top: 0;">Pengembang & Pengelola</h4>
                            <blockquote style="font-size: 13px; color: #666; border-left: 3px solid #00897b; margin: 0 0 10px 0;">
                                SMART-CBT &mdash; Solusi Computer-Based Test Terpadu SMK 11 Maret.
                            </blockquote>
                            <p style="margin: 0; font-size: 12px; color: #888;">
                                Dikelola oleh ICT-TIM-SMK11MARET. Semoga bermanfaat untuk kemajuan pendidikan Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- STYLING KHUSUS DASHBOARD -->
<style type="text/css">
    .stat-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }
    .quick-action-btn {
        padding: 14px 10px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #e2e8f0;
        background: #fff;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 13px;
        color: #333;
    }
    .quick-action-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .quick-btn-box {
        margin-bottom: 10px;
    }
    .live-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: #fff;
        border-radius: 50%;
        margin-left: 6px;
        vertical-align: middle;
        animation: pulse-dot 1.4s infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(0.9); opacity: 0.7; }
        50% { transform: scale(1.3); opacity: 1; }
        100% { transform: scale(0.9); opacity: 0.7; }
    }
</style>

<!-- SCRIPT LIVE SERVER CLOCK & FILTER IP & KOREKSI TAB -->
<script type="text/javascript">
    function filterMonitoringIp(type, btn){
        $('#btn-group-filter-ip .btn').removeClass('active btn-primary').addClass('btn-default');
        $(btn).removeClass('btn-default').addClass('active btn-primary');
        
        if(type === 'semua'){
            $('.row-monitoring').show();
        }else if(type === 'public'){
            $('.row-monitoring').hide();
            $('.row-public').show();
        }else if(type === 'local'){
            $('.row-monitoring').hide();
            $('.row-local').show();
        }
    }

    function switchKoreksiTab(tab, btn){
        $('#btn-group-koreksi-tab .btn').removeClass('active btn-primary').addClass('btn-default');
        $(btn).removeClass('btn-default').addClass('active btn-primary');

        if(tab === 'pending'){
            $('#tab-koreksi-verified').hide();
            $('#tab-koreksi-pending').fadeIn(150);
        } else {
            $('#tab-koreksi-pending').hide();
            $('#tab-koreksi-verified').fadeIn(150);
        }
    }

    function tandaiKoreksiSelesai(koreksi_id, btn){
        if(confirm('Tandai catatan koreksi ini telah selesai diperbaiki?')){
            $(btn).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                url: '<?php echo site_url("manager/modul_daftar/selesai_koreksi"); ?>/' + koreksi_id,
                type: 'GET',
                dataType: 'json',
                success: function(res){
                    if(res.status == 1){
                        $('#row-koreksi-' + koreksi_id).fadeOut(300, function(){
                            $(this).remove();
                            var cur = parseInt($('#cnt-pending-koreksi').text());
                            if(cur > 0) $('#cnt-pending-koreksi').text(cur - 1);
                        });
                    } else {
                        alert(res.message);
                        $(btn).prop('disabled', false).html('<i class="fa fa-check"></i> Selesai');
                    }
                },
                error: function(){
                    alert('Terjadi kesalahan koneksi server.');
                    $(btn).prop('disabled', false).html('<i class="fa fa-check"></i> Selesai');
                }
            });
        }
    }

    $(function(){
        // Server time sync ticker
        var serverTime = new Date("<?php echo date('Y/m/d H:i:s'); ?>");
        setInterval(function(){
            serverTime.setSeconds(serverTime.getSeconds() + 1);
            var y = serverTime.getFullYear();
            var m = String(serverTime.getMonth() + 1).padStart(2, '0');
            var d = String(serverTime.getDate()).padStart(2, '0');
            var h = String(serverTime.getHours()).padStart(2, '0');
            var i = String(serverTime.getMinutes()).padStart(2, '0');
            var s = String(serverTime.getSeconds()).padStart(2, '0');
            $('#live-clock').text(y + '-' + m + '-' + d + ' ' + h + ':' + i + ':' + s);
        }, 1000);
    });
</script>