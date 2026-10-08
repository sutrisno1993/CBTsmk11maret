<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Telaah Soal: <?php echo htmlspecialchars($topik->clean_nama); ?> | <?php echo !empty($site_name) ? htmlspecialchars($site_name) : 'CBT Online'; ?></title>
    
    <!-- Bootstrap 3.3.4 & Font Awesome -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1e3c72;
            --primary-dark: #14284d;
            --secondary: #2a5298;
            --accent: #ff7675;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0284c7;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Top Sticky Navbar */
        .main-navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            padding: 14px 0;
            box-shadow: 0 4px 20px rgba(30, 60, 114, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-nav-back {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-nav-back:hover, .btn-nav-back:focus {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
            text-decoration: none;
        }

        /* Header Info Card */
        .topic-header-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 24px 28px;
            margin-top: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            border-left: 6px solid var(--primary);
        }
        .topic-modul-badge {
            background: #e0e7ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .topic-title-main {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0 0 10px 0;
            line-height: 1.3;
        }
        .topic-meta-row {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            font-size: 13px;
            color: var(--text-muted);
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Question Card */
        .soal-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .soal-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 18px rgba(30, 60, 114, 0.06);
        }
        .soal-card-header {
            background: #f8fafc;
            padding: 14px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .soal-badge-no {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            padding: 5px 14px;
            border-radius: 6px;
            display: inline-block;
        }
        .soal-badge-type {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .soal-body {
            padding: 22px 24px;
        }
        .soal-teks {
            font-size: 15px;
            line-height: 1.7;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .soal-teks img, .opsi-box img {
            max-width: 100% !important;
            height: auto !important;
            display: inline-block;
            border-radius: 6px;
            margin: 8px 0;
            border: 1px solid #e2e8f0;
        }

        /* Option Boxes */
        .opsi-box {
            display: flex;
            align-items: flex-start;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            margin-bottom: 10px;
            transition: all 0.2s ease;
        }
        .opsi-box.opsi-benar {
            border: 2px solid #10b981;
            background: #f0fdf4;
        }
        .opsi-abjad {
            min-width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            background: #e2e8f0;
            color: #475569;
            margin-right: 14px;
            flex-shrink: 0;
        }
        .opsi-benar .opsi-abjad {
            background: #10b981;
            color: #ffffff;
        }
        .opsi-text {
            flex-grow: 1;
            font-size: 14px;
            line-height: 1.5;
            color: #334155;
            padding-top: 4px;
        }
        .opsi-benar .opsi-text {
            color: #166534;
            font-weight: 600;
        }
        .badge-kunci {
            background: #10b981;
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 5px 10px;
            border-radius: 6px;
            flex-shrink: 0;
            margin-left: 10px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Question Feedback / Correction Section */
        .soal-koreksi-section {
            background: #fafbfc;
            border-top: 1px solid #f1f5f9;
            padding: 16px 22px;
        }
        .koreksi-list {
            margin-bottom: 12px;
        }
        .koreksi-item {
            background: #fff;
            border: 1px solid #fed7aa;
            border-left: 4px solid #f97316;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .koreksi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 4px;
            font-weight: 700;
            color: #9a3412;
            font-size: 12px;
        }

        .btn-tulis-koreksi {
            background: #fff;
            border: 1px dashed #cbd5e1;
            color: #475569;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-tulis-koreksi:hover {
            border-color: #f97316;
            color: #ea580c;
            background: #fff7ed;
        }

        .form-koreksi-box {
            display: none;
            background: #fff7ed;
            border: 1px solid #ffedd5;
            border-radius: 10px;
            padding: 14px 16px;
            margin-top: 10px;
        }

        /* Verification / TTD Box */
        .verifikasi-card {
            background: #ffffff;
            border-radius: 16px;
            border: 2px solid #86efac;
            padding: 28px 30px;
            margin-top: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.08);
            background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
        }
        .ttd-canvas-box {
            border: 2px dashed #94a3b8;
            border-radius: 8px;
            background: #ffffff;
            position: relative;
            margin-bottom: 10px;
        }
        #signature-pad {
            width: 100%;
            height: 140px;
            display: block;
        }

        /* Stempel Digital ACC */
        .stempel-acc {
            display: inline-block;
            border: 3px double #15803d;
            border-radius: 12px;
            padding: 14px 24px;
            background: #f0fdf4;
            color: #15803d;
            text-align: center;
            transform: rotate(-2deg);
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.15);
        }

        /* Floating Quick Action */
        .floating-action {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .btn-floating {
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-radius: 30px;
            font-weight: 700;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        @media print {
            .no-print, .main-navbar, .floating-action, .btn-tulis-koreksi, .form-koreksi-box {
                display: none !important;
            }
            body, .soal-card, .topic-header-card {
                background: #fff !important;
                box-shadow: none !important;
            }
            .soal-card {
                page-break-inside: avoid !important;
                border: 1px solid #999 !important;
                margin-bottom: 20px !important;
            }
            .opsi-box {
                border: 1px solid #ccc !important;
            }
            .opsi-box.opsi-benar {
                border: 2px solid #000 !important;
                font-weight: bold !important;
            }
        }
    </style>
</head>
<body>

    <!-- Top Sticky Navbar -->
    <header class="main-navbar no-print">
        <div class="container navbar-container">
            <a href="<?php echo site_url('monitoring_soal'); ?>" class="btn-nav-back">
                <i class="fa fa-arrow-left"></i> Kembali ke Daftar Topik
            </a>
            <div style="font-size: 14px; font-weight: 700; color: #fff;">
                <i class="fa fa-file-text-o"></i> Lembar Telaah &amp; QC Soal
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="button" class="btn btn-sm btn-default" onclick="window.print();" style="border-radius: 8px; font-weight: 600; font-size: 12px; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fa fa-print"></i> Cetak / Simpan PDF
                </button>
                <a href="#section-verifikasi" class="btn btn-sm btn-success" style="border-radius: 8px; font-weight: 700; font-size: 12px; background: #10b981; border: none;">
                    <i class="fa fa-check-square-o"></i> TTD / Verifikasi
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        
        <!-- Header Info Card -->
        <div class="topic-header-card">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                <div class="col-md-8 col-sm-12">
                    <span class="topic-modul-badge">
                        <i class="fa fa-bookmark-o"></i> Modul: <?php echo htmlspecialchars($topik->modul_nama); ?>
                    </span>
                    <h2 class="topic-title-main">
                        <?php echo htmlspecialchars($topik->clean_nama); ?>
                    </h2>
                    <div class="topic-meta-row">
                        <span class="meta-item">
                            <i class="fa fa-list-ol text-primary"></i> <strong>Total Soal:</strong> <?php echo count($soal_list); ?> Butir Soal
                        </span>
                        <?php if(!empty($topik->tingkat) && $topik->tingkat != 'Umum'){ ?>
                            <span class="meta-item">
                                <i class="fa fa-graduation-cap text-primary"></i> <strong>Tingkat:</strong> Kelas <?php echo $topik->tingkat; ?>
                            </span>
                        <?php } ?>
                        <?php if(!empty($topik->topik_detail)){ ?>
                            <span class="meta-item">
                                <i class="fa fa-info-circle text-muted"></i> <?php echo htmlspecialchars($topik->topik_detail); ?>
                            </span>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 text-right" style="margin-top: 15px;">
                    <?php if(!empty($verifikasi) && $verifikasi->verifikasi_status == 'sesuai'){ ?>
                        <div class="stempel-acc">
                            <i class="fa fa-check-circle" style="font-size: 20px;"></i><br>
                            <span style="font-size: 14px; font-weight: 800; letter-spacing: 1px;">TERVERIFIKASI &amp; ACC</span><br>
                            <small style="font-size: 11px;">Penelaah: <strong><?php echo htmlspecialchars($verifikasi->verifikasi_guru_nama); ?></strong></small><br>
                            <small style="font-size: 10px; color: #166534;"><?php echo date('d-m-Y H:i', strtotime($verifikasi->verifikasi_created_at)); ?></small>
                        </div>
                    <?php } else { ?>
                        <div style="background: #fff9db; border: 1px solid #ffe066; padding: 10px 14px; border-radius: 8px; text-align: left; display: inline-block;">
                            <div style="font-size: 12px; font-weight: 700; color: #856404; margin-bottom: 2px;">
                                <i class="fa fa-info-circle"></i> Status Telaah Guru:
                            </div>
                            <span class="badge" style="background: #f59e0b; font-size: 11px; padding: 4px 8px;">
                                Sedang Ditelaah / Menunggu TTD
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Petunjuk Singkat Quality Control -->
        <div class="alert alert-info alert-dismissible no-print" style="border-radius: 12px; background: #f0f9ff; border-color: #bae6fd; color: #0369a1; font-size: 13px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-lightbulb-o" style="font-size: 16px; margin-right: 6px;"></i>
            <strong>Petunjuk Pemeriksaan Naskah Soal:</strong>
            Periksa setiap nomor butir soal di bawah ini. Kunci jawaban pilihan ganda ditandai dengan warna hijau <strong>[KUNCI JAWABAN BENAR]</strong>. Jika ada typo, salah kunci jawaban, atau opsi yang tertukar, klik tombol <strong>"✍️ Beri Catatan Koreksi"</strong> pada nomor terkait. Jika seluruh soal sudah benar, silakan isi form <strong>Verifikasi &amp; TTD Guru</strong> di bagian paling bawah.
        </div>

        <!-- Daftar Butir Soal -->
        <div class="row">
            <div class="col-xs-12">
                <?php if(empty($soal_list)){ ?>
                    <div class="soal-card text-center" style="padding: 60px 20px;">
                        <i class="fa fa-folder-open-o" style="font-size: 48px; color: #cbd5e1; margin-bottom: 12px;"></i>
                        <h4 style="color: #64748b; font-weight: 700;">Belum Ada Butir Soal</h4>
                        <p class="text-muted">Naskah soal untuk topik mata pelajaran ini belum diunggah.</p>
                    </div>
                <?php } else { ?>
                    <?php $no = 1; ?>
                    <?php foreach($soal_list as $item){ 
                        $s = $item['soal'];
                        $jawaban = $item['jawaban'];
                        $koreksi = $item['koreksi'];

                        $detail_soal = str_replace("[base_url]", base_url(), $s->soal_detail);
                    ?>
                    <div class="soal-card" id="soal-card-<?php echo $s->soal_id; ?>">
                        <!-- Card Header -->
                        <div class="soal-card-header">
                            <div>
                                <span class="soal-badge-no">SOAL NO. <?php echo $no++; ?></span>
                                &nbsp;
                                <?php if($s->soal_tipe == 1){ ?>
                                    <span class="label label-info soal-badge-type">Pilihan Ganda</span>
                                <?php } else if($s->soal_tipe == 2){ ?>
                                    <span class="label label-warning soal-badge-type">Essay / Uraian</span>
                                <?php } else { ?>
                                    <span class="label label-default soal-badge-type">Jawaban Singkat</span>
                                <?php } ?>

                                <span class="text-muted" style="font-size: 12px; margin-left: 8px;">
                                    (Tingkat Kesulitan: <?php 
                                        $diff = array(1=>'Sangat Mudah', 2=>'Mudah', 3=>'Sedang', 4=>'Sulit', 5=>'Sangat Sulit');
                                        echo isset($diff[$s->soal_difficulty]) ? $diff[$s->soal_difficulty] : 'Sedang';
                                    ?>)
                                </span>
                            </div>

                            <div class="no-print">
                                <button type="button" class="btn-tulis-koreksi" onclick="toggleFormKoreksi(<?php echo $s->soal_id; ?>)">
                                    <i class="fa fa-pencil-square-o text-orange"></i> ✍️ Beri Catatan Koreksi
                                </button>
                            </div>
                        </div>

                        <!-- Card Body (Teks Soal & Opsi) -->
                        <div class="soal-body">
                            <div class="soal-teks">
                                <?php echo $detail_soal; ?>
                            </div>

                            <!-- Audio Player jika ada -->
                            <?php if(!empty($s->soal_audio)){ ?>
                                <div style="background: #f8fafc; padding: 10px 14px; border-radius: 8px; margin-bottom: 16px; border-left: 4px solid var(--primary); display: inline-block;">
                                    <label style="font-size: 11px; margin-bottom: 4px; display: block; color: var(--text-muted);">
                                        <i class="fa fa-volume-up text-primary"></i> File Audio Listening:
                                    </label>
                                    <audio controls style="height: 32px;">
                                        <source src="<?php echo base_url().$this->config->item('upload_path').'/topik_'.$s->soal_topik_id.'/'.$s->soal_audio; ?>" type="audio/mpeg">
                                        Browser Anda tidak mendukung audio player.
                                    </audio>
                                </div>
                            <?php } ?>

                            <!-- Opsi Jawaban Pilihan Ganda -->
                            <?php if($s->soal_tipe == 1){ ?>
                                <div style="margin-top: 16px;">
                                    <div style="font-size: 11px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">
                                        Opsi Pilihan Jawaban &amp; Kunci:
                                    </div>
                                    <?php 
                                        $abjad = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
                                        $idx = 0;
                                        foreach($jawaban as $j){
                                            $huruf = isset($abjad[$idx]) ? $abjad[$idx] : ($idx + 1);
                                            $is_benar = ($j->jawaban_benar == 1);
                                            $teks_jawaban = str_replace("[base_url]", base_url(), $j->jawaban_detail);
                                            $idx++;
                                    ?>
                                        <div class="opsi-box <?php echo $is_benar ? 'opsi-benar' : ''; ?>">
                                            <div class="opsi-abjad"><?php echo $huruf; ?></div>
                                            <div class="opsi-text"><?php echo $teks_jawaban; ?></div>
                                            <?php if($is_benar){ ?>
                                                <div class="badge-kunci">
                                                    <i class="fa fa-check"></i> KUNCI JAWABAN BENAR
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            
                            <!-- Kunci Essay -->
                            <?php } else if($s->soal_tipe == 2){ ?>
                                <div style="background: #fffbeb; border: 1px dashed #fde68a; border-radius: 8px; padding: 14px 18px; margin-top: 12px;">
                                    <div style="font-size: 12px; font-weight: 700; color: #b45309; margin-bottom: 4px;">
                                        <i class="fa fa-key"></i> Pedoman Kunci Jawaban Essay:
                                    </div>
                                    <div style="font-size: 13px; color: #451a03; font-style: italic;">
                                        <?php echo !empty($s->soal_kunci) ? nl2br(htmlspecialchars($s->soal_kunci)) : '(Dinilai manual oleh guru)'; ?>
                                    </div>
                                </div>

                            <!-- Kunci Jawaban Singkat -->
                            <?php } else { ?>
                                <div style="background: #e0f2fe; border: 1px dashed #7dd3fc; border-radius: 8px; padding: 14px 18px; margin-top: 12px;">
                                    <div style="font-size: 12px; font-weight: 700; color: #0369a1; margin-bottom: 4px;">
                                        <i class="fa fa-key"></i> Kunci Jawaban Singkat:
                                    </div>
                                    <div style="font-size: 14px; font-weight: 800; color: #0c4a6e;">
                                        <?php echo !empty($s->soal_kunci) ? htmlspecialchars($s->soal_kunci) : '-'; ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <!-- Card Footer (Catatan Koreksi Guru) -->
                        <div class="soal-koreksi-section">
                            <!-- Container Catatan Koreksi yang sudah masuk -->
                            <div class="koreksi-list" id="koreksi-list-<?php echo $s->soal_id; ?>">
                                <?php if(!empty($koreksi)){ ?>
                                    <?php foreach($koreksi as $k){ ?>
                                        <div class="koreksi-item">
                                            <div class="koreksi-header">
                                                <span><i class="fa fa-comment-o"></i> Catatan dari: <strong><?php echo htmlspecialchars($k->koreksi_guru_nama); ?></strong></span>
                                                <small style="color: #9a3412; font-weight: normal;"><?php echo date('d/m/Y H:i', strtotime($k->koreksi_created_at)); ?></small>
                                            </div>
                                            <div style="color: #7c2d12; line-height: 1.5;">
                                                <?php echo nl2br(htmlspecialchars($k->koreksi_catatan)); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <!-- Form Input Koreksi Inline -->
                            <div class="form-koreksi-box" id="form-koreksi-<?php echo $s->soal_id; ?>">
                                <div style="font-size: 13px; font-weight: 700; color: #9a3412; margin-bottom: 10px;">
                                    <i class="fa fa-pencil text-orange"></i> Form Masukan / Koreksi untuk Soal Ini:
                                </div>
                                <div class="row">
                                    <div class="col-md-5 col-xs-12" style="margin-bottom: 10px;">
                                        <label style="font-size: 11px; color: #7c2d12;">Nama Guru Penelaah:</label>
                                        <input type="text" class="form-control input-sm input-guru-nama" id="koreksi-guru-<?php echo $s->soal_id; ?>" placeholder="Ketik nama Anda...">
                                    </div>
                                    <div class="col-md-7 col-xs-12" style="margin-bottom: 10px;">
                                        <label style="font-size: 11px; color: #7c2d12;">Catatan Koreksi / Revisi:</label>
                                        <textarea class="form-control input-sm" id="koreksi-catatan-<?php echo $s->soal_id; ?>" rows="2" placeholder="Contoh: Kunci jawaban salah ketik, opsi C seharusnya 25 bukan 20..."></textarea>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    <button type="button" class="btn btn-default btn-xs" onclick="toggleFormKoreksi(<?php echo $s->soal_id; ?>)">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-warning btn-xs" style="background: #ea580c; border-color: #c2410c; font-weight: 700;" onclick="submitKoreksi(<?php echo $s->soal_id; ?>, <?php echo $topik->topik_id; ?>)">
                                        <i class="fa fa-paper-plane"></i> Kirim Catatan Koreksi
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>

        <!-- Section Verifikasi & Tanda Tangan Guru (ACC Naskah Soal) -->
        <section class="verifikasi-card" id="section-verifikasi">
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <h3 style="font-size: 20px; font-weight: 800; color: #166534; margin: 0 0 8px 0;">
                        <i class="fa fa-check-square-o"></i> Lembar Verifikasi &amp; TTD Pengesahan Soal
                    </h3>
                    <p style="font-size: 13px; color: #374151; margin-bottom: 20px;">
                        Jika butir soal telah diperiksa seluruhnya dan dinilai <strong>SUDAH SESUAI</strong> dengan standar naskah ujian sekolah, silakan isi identitas dan tanda tangani formulir pengesahan ini.
                    </p>

                    <form id="form-verifikasi-topik">
                        <input type="hidden" name="topik_id" value="<?php echo $topik->topik_id; ?>">
                        
                        <div class="row">
                            <div class="col-sm-6 col-xs-12" style="margin-bottom: 12px;">
                                <label style="font-size: 12px; font-weight: 700; color: #1f2937;">Nama Lengkap Guru Penelaah / Pengampu: *</label>
                                <input type="text" name="guru_nama" id="verif-guru-nama" class="form-control" placeholder="Contoh: Dra. Hj. Nurhayati, M.Pd" value="<?php echo !empty($verifikasi) ? htmlspecialchars($verifikasi->verifikasi_guru_nama) : ''; ?>" required>
                            </div>

                            <div class="col-sm-6 col-xs-12" style="margin-bottom: 12px;">
                                <label style="font-size: 12px; font-weight: 700; color: #1f2937;">NIP / Kode Guru (Opsional):</label>
                                <input type="text" name="guru_nip" id="verif-guru-nip" class="form-control" placeholder="Contoh: 19780214..." value="<?php echo !empty($verifikasi) ? htmlspecialchars($verifikasi->verifikasi_guru_nip) : ''; ?>">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 12px;">
                            <label style="font-size: 12px; font-weight: 700; color: #1f2937;">Pernyataan Validasi &amp; Status Soal:</label>
                            <select name="status" class="form-control" style="font-weight: 600;">
                                <option value="sesuai" <?php echo (!empty($verifikasi) && $verifikasi->verifikasi_status == 'sesuai') ? 'selected' : ''; ?>>
                                    ✅ Naskah Soal SUDAH SESUAI &amp; Disetujui (ACC Siap Ujian)
                                </option>
                                <option value="revisi" <?php echo (!empty($verifikasi) && $verifikasi->verifikasi_status == 'revisi') ? 'selected' : ''; ?>>
                                    ⚠️ Masih Ada Perbaikan / Catatan Revisi
                                </option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-size: 12px; font-weight: 700; color: #1f2937;">Catatan Tambahan untuk Panitia / Operator (Opsional):</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Catatan opsional..."><?php echo !empty($verifikasi) ? htmlspecialchars($verifikasi->verifikasi_catatan) : ''; ?></textarea>
                        </div>

                        <div class="checkbox" style="margin-bottom: 15px;">
                            <label style="font-size: 13px; font-weight: 600; color: #166534;">
                                <input type="checkbox" id="check-setuju" required checked>
                                Saya menyatakan bahwa naskah soal mata pelajaran ini telah ditelaah dengan seksama dan bertanggung jawab atas kelayakan materi naskah soal.
                            </label>
                        </div>

                        <button type="button" class="btn btn-success" id="btn-submit-verif" onclick="submitVerifikasi()" style="font-weight: 800; padding: 10px 24px; border-radius: 8px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                            <i class="fa fa-check-circle"></i> Simpan &amp; Sahkan Pengesahan Naskah Soal (TTD)
                        </button>
                    </form>
                </div>

                <div class="col-md-5 col-xs-12 text-center" style="margin-top: 15px;">
                    <div style="background: #fff; border: 1px solid #bbf7d0; border-radius: 12px; padding: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                        <div style="font-size: 13px; font-weight: 800; color: #166534; margin-bottom: 8px;">
                            <i class="fa fa-certificate"></i> Tanda Tangan Digital Guru Penelaah
                        </div>
                        <p style="font-size: 11px; color: #6b7280; margin-bottom: 10px;">
                            Gunakan mouse / layar sentuh HP untuk membubuhkan tanda tangan (opsional):
                        </p>
                        <div class="ttd-canvas-box">
                            <canvas id="signature-pad" width="320" height="130"></canvas>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <small class="text-muted" style="font-size: 10px;">Tanggal: <?php echo date('d F Y'); ?></small>
                            <button type="button" class="btn btn-default btn-xs" onclick="clearSignature()">
                                <i class="fa fa-eraser"></i> Bersihkan TTD
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Floating Action Jump -->
    <div class="floating-action no-print">
        <a href="#section-verifikasi" class="btn btn-success btn-floating" style="background: #10b981; border: none;">
            <i class="fa fa-pencil"></i> TTD &amp; Sahkan Soal
        </a>
    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js"></script>

    <script>
        // Simpan & Ambil Nama Guru dari LocalStorage
        $(document).ready(function(){
            var savedGuru = localStorage.getItem('cbt_guru_penelaah');
            if(savedGuru){
                $('.input-guru-nama').val(savedGuru);
                if(!$('#verif-guru-nama').val()){
                    $('#verif-guru-nama').val(savedGuru);
                }
            }
        });

        // Toggle Tampilan Form Koreksi Per Soal
        function toggleFormKoreksi(soal_id){
            var box = $('#form-koreksi-' + soal_id);
            if(box.is(':visible')){
                box.slideUp(200);
            } else {
                box.slideDown(200);
                $('#koreksi-catatan-' + soal_id).focus();
            }
        }

        // Kirim Catatan Koreksi
        function submitKoreksi(soal_id, topik_id){
            var guru_nama = $('#koreksi-guru-' + soal_id).val().trim();
            var catatan = $('#koreksi-catatan-' + soal_id).val().trim();

            if(!guru_nama){
                alert('Silakan masukkan Nama Bapak/Ibu Guru terlebih dahulu.');
                $('#koreksi-guru-' + soal_id).focus();
                return;
            }

            if(!catatan){
                alert('Silakan tuliskan catatan koreksi atau bagian yang perlu diperbaiki.');
                $('#koreksi-catatan-' + soal_id).focus();
                return;
            }

            // Simpan ke LocalStorage untuk autofill nomor berikutnya
            localStorage.setItem('cbt_guru_penelaah', guru_nama);
            $('.input-guru-nama').val(guru_nama);
            if(!$('#verif-guru-nama').val()) $('#verif-guru-nama').val(guru_nama);

            $.ajax({
                url: '<?php echo site_url("monitoring_soal/simpan_koreksi"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    soal_id: soal_id,
                    topik_id: topik_id,
                    guru_nama: guru_nama,
                    catatan: catatan
                },
                success: function(res){
                    if(res.status == 1){
                        var html = '<div class="koreksi-item" style="animation: fadeIn 0.3s;">' +
                                   '  <div class="koreksi-header">' +
                                   '    <span><i class="fa fa-comment-o"></i> Catatan dari: <strong>' + res.guru_nama + '</strong></span>' +
                                   '    <small style="color: #9a3412; font-weight: normal;">' + res.waktu + '</small>' +
                                   '  </div>' +
                                   '  <div style="color: #7c2d12; line-height: 1.5;">' + res.catatan + '</div>' +
                                   '</div>';
                        $('#koreksi-list-' + soal_id).append(html);
                        $('#koreksi-catatan-' + soal_id).val('');
                        $('#form-koreksi-' + soal_id).slideUp(200);
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                },
                error: function(){
                    alert('Terjadi kesalahan koneksi server saat mengirim catatan koreksi.');
                }
            });
        }

        // Tanda Tangan Canvas Sederhana
        var canvas = document.getElementById('signature-pad');
        var ctx = canvas ? canvas.getContext('2d') : null;
        var drawing = false;

        if(canvas && ctx){
            ctx.strokeStyle = "#1e3c72";
            ctx.lineWidth = 2.5;
            ctx.lineCap = "round";

            function getPos(e){
                var rect = canvas.getBoundingClientRect();
                var clientX = e.clientX || (e.touches && e.touches[0] ? e.touches[0].clientX : 0);
                var clientY = e.clientY || (e.touches && e.touches[0] ? e.touches[0].clientY : 0);
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            canvas.addEventListener('mousedown', function(e){
                drawing = true;
                var pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
            });
            canvas.addEventListener('mousemove', function(e){
                if(drawing){
                    var pos = getPos(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
            });
            window.addEventListener('mouseup', function(){ drawing = false; });

            // Touch events untuk Mobile/Tablet
            canvas.addEventListener('touchstart', function(e){
                drawing = true;
                var pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(pos.x, pos.y);
                e.preventDefault();
            }, {passive: false});
            canvas.addEventListener('touchmove', function(e){
                if(drawing){
                    var pos = getPos(e);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }
                e.preventDefault();
            }, {passive: false});
            canvas.addEventListener('touchend', function(){ drawing = false; });
        }

        function clearSignature(){
            if(canvas && ctx){
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        }

        // Submit Verifikasi & TTD Pengesahan
        function submitVerifikasi(){
            var guru_nama = $('#verif-guru-nama').val().trim();
            if(!guru_nama){
                alert('Silakan isi Nama Lengkap Guru Penelaah terlebih dahulu.');
                $('#verif-guru-nama').focus();
                return;
            }

            if(!$('#check-setuju').is(':checked')){
                alert('Silakan centang pernyataan persetujuan naskah soal.');
                return;
            }

            localStorage.setItem('cbt_guru_penelaah', guru_nama);

            var ttdData = '';
            if(canvas){
                ttdData = canvas.toDataURL();
            }

            var formData = $('#form-verifikasi-topik').serialize() + '&ttd_digital=' + encodeURIComponent(ttdData);

            $('#btn-submit-verif').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Pengesahan...');

            $.ajax({
                url: '<?php echo site_url("monitoring_soal/simpan_verifikasi"); ?>',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(res){
                    $('#btn-submit-verif').prop('disabled', false).html('<i class="fa fa-check-circle"></i> Simpan & Sahkan Pengesahan Naskah Soal (TTD)');
                    if(res.status == 1){
                        alert(res.message);
                        window.location.reload();
                    } else {
                        alert(res.message);
                    }
                },
                error: function(){
                    $('#btn-submit-verif').prop('disabled', false).html('<i class="fa fa-check-circle"></i> Simpan & Sahkan Pengesahan Naskah Soal (TTD)');
                    alert('Terjadi kesalahan saat menyimpan pengesahan naskah soal.');
                }
            });
        }
    </script>
</body>
</html>
