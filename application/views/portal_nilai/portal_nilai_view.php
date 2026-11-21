<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($title) ? htmlspecialchars($title) : 'Portal Nilai Guru'; ?> | <?php echo !empty($site_name) ? htmlspecialchars($site_name) : 'SMART-CBT'; ?></title>

    <!-- Bootstrap 3.3.4 & Font Awesome -->
    <link href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>public/plugins/select2-4.0.5/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #0f172a;
            --primary-light: #2563eb;
            --emerald: #059669;
            --emerald-light: #10b981;
            --amber: #d97706;
            --danger: #dc2626;
            --bg-page: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Sticky Glass Navbar */
        .main-navbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #0f766e 100%);
            color: #fff;
            padding: 14px 0;
            box-shadow: 0 4px 25px rgba(15, 23, 42, 0.22);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .navbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none !important;
            color: #fff !important;
        }
        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            color: #34d399;
            box-shadow: inset 0 1px 1px rgba(255,255,255,0.2);
        }
        .brand-text h1 {
            font-size: 17px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.2px;
        }
        .brand-text p {
            font-size: 11.5px;
            margin: 2px 0 0 0;
            color: #cbd5e1;
            font-weight: 500;
        }
        .nav-btn {
            border-radius: 10px;
            font-weight: 700;
            font-size: 12.5px;
            padding: 8px 14px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
        }
        .nav-btn-glass {
            background: rgba(255,255,255,0.12);
            color: #fff !important;
            border: 1px solid rgba(255,255,255,0.22);
        }
        .nav-btn-glass:hover {
            background: rgba(255,255,255,0.22);
            transform: translateY(-1px);
        }
        .nav-btn-wa {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff !important;
            border: none;
            box-shadow: 0 3px 10px rgba(245, 158, 11, 0.3);
        }
        .nav-btn-wa:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(245, 158, 11, 0.45);
        }

        /* Hero Subheader */
        .hero-box {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 26px 0 22px 0;
            margin-bottom: 24px;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            font-size: 11.5px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .hero-title {
            font-size: 23px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0 0 6px 0;
            letter-spacing: -0.4px;
        }
        .hero-subtitle {
            font-size: 13.5px;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.6;
        }

        /* Step Filter Card */
        .filter-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 22px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            position: relative;
        }
        .step-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11.5px;
            font-weight: 800;
            color: #334155;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 7px;
        }
        .step-num {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: #1e3a8a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
        }
        .form-control-modern {
            height: 42px !important;
            border-radius: 10px !important;
            border: 1.5px solid #cbd5e1 !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            padding: 6px 12px !important;
            background-color: #f8fafc !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }
        .form-control-modern:focus {
            background-color: #fff !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12) !important;
        }

        /* Modernized Select2 */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border-radius: 10px !important;
            border: 1.5px solid #cbd5e1 !important;
            background-color: #f8fafc !important;
            padding: 6px 12px !important;
            transition: all 0.2s ease;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            color: #0f172a !important;
            padding-left: 2px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
            right: 8px !important;
        }

        /* KPI Summary Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }
        @media (max-width: 991px) {
            .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .kpi-grid { grid-template-columns: 1fr; }
        }
        .kpi-box {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        }
        .kpi-title {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.4px;
            margin-bottom: 4px;
        }
        .kpi-number {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
        }
        .kpi-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 3px;
            font-weight: 500;
        }
        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        /* Subject Banner & Jurusan Pill Toolbar */
        .subject-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: #fff;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 18px;
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.18);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .jurusan-toolbar {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .pill-jurusan {
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 700;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .pill-jurusan:hover {
            border-color: #94a3b8;
            background: #f1f5f9;
            color: #0f172a;
        }
        .pill-jurusan.active {
            background: #1e3a8a;
            color: #fff;
            border-color: #1e3a8a;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.25);
        }

        /* Class Card Modern */
        .kelas-card {
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid var(--border-color);
            margin-bottom: 16px;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .kelas-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.08);
            transform: translateY(-1px);
        }
        .kelas-card.card-selected {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.12);
        }
        .kelas-header {
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            background: #fff;
        }
        .kelas-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 19px;
            flex-shrink: 0;
        }
        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            margin-right: 6px;
            margin-top: 4px;
        }
        .pill-total { background: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; }
        .pill-sudah { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .pill-belum { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .pill-avg   { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        .btn-download-single {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: #fff !important;
            border: none;
            border-radius: 10px;
            padding: 9px 16px;
            font-size: 12.5px;
            font-weight: 800;
            box-shadow: 0 3px 10px rgba(5, 150, 105, 0.25);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none !important;
        }
        .btn-download-single:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.35);
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
        }
        .btn-preview-toggle {
            background: #f8fafc;
            color: #334155 !important;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 12.5px;
            font-weight: 700;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-preview-toggle:hover {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1d4ed8 !important;
        }

        /* Progress Bar Kehadiran Kelas */
        .kelas-progress-wrap {
            width: 140px;
            display: inline-block;
            vertical-align: middle;
            margin-left: 6px;
        }
        .kelas-progress-bar {
            height: 7px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }
        .kelas-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
            border-radius: 10px;
        }

        /* Floating Selection Bar */
        .floating-cart-bar {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #0f172a;
            color: #fff;
            padding: 12px 22px;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(255,255,255,0.15);
            z-index: 1050;
            display: none;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap;
        }

        /* Table Siswa Styling */
        .table-nilai-modern {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 0;
            font-size: 13px;
            border: 1px solid #e2e8f0;
        }
        .table-nilai-modern thead tr {
            background: #0f172a;
            color: #fff;
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .table-nilai-modern thead th {
            padding: 11px 12px !important;
            border-bottom: none !important;
            font-weight: 700;
        }
        .table-nilai-modern tbody td {
            padding: 10px 12px !important;
            vertical-align: middle !important;
            border-color: #f1f5f9 !important;
        }
        .score-badge {
            display: inline-block;
            min-width: 54px;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 800;
            font-size: 13.5px;
            text-align: center;
        }
        .score-high { background: #dcfce7; color: #15803d; }
        .score-mid  { background: #eff6ff; color: #1d4ed8; }
        .score-low  { background: #fef2f2; color: #b91c1c; }

        /* Toast Notification */
        #toast-copy {
            position: fixed;
            top: 80px;
            right: 24px;
            background: #059669;
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.35);
            z-index: 2000;
            display: none;
        }
    </style>
</head>
<body>

    <div id="toast-copy"><i class="fa fa-check-circle"></i> Tautan Portal Nilai berhasil disalin ke Clipboard!</div>

    <!-- Top Sticky Navbar -->
    <header class="main-navbar">
        <div class="container navbar-container">
            <a href="<?php echo site_url('portal_nilai'); ?>" class="brand-logo">
                <div class="brand-icon"><i class="fa fa-graduation-cap"></i></div>
                <div class="brand-text">
                    <h1><?php echo htmlspecialchars($site_name); ?> &mdash; PORTAL NILAI GURU</h1>
                    <p>Pusat Unduh Rekap Nilai Peserta Didik Terpisah per Kelas / Rombel</p>
                </div>
            </a>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button type="button" onclick="salin_link_portal()" class="nav-btn nav-btn-wa">
                    <i class="fa fa-whatsapp"></i> Bagikan Link ke WA Guru
                </button>
                <a href="<?php echo site_url('monitoring_soal'); ?>" class="nav-btn nav-btn-glass">
                    <i class="fa fa-check-square-o"></i> Portal Telaah Soal
                </a>
                <a href="<?php echo site_url('manager/welcome'); ?>" class="nav-btn nav-btn-glass">
                    <i class="fa fa-sliders"></i> Panel Admin
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Subheader -->
    <section class="hero-box">
        <div class="container">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                <div class="col-md-8 col-xs-12">
                    <div class="hero-badge">
                        <i class="fa fa-bolt"></i> Siap e-Rapor SMK &bull; Otomatis Skala 100 &bull; Urut Abjad A&ndash;Z
                    </div>
                    <h2 class="hero-title">Unduh Daftar Nilai Peserta Didik Sesuai Kelas yang Anda Ajar</h2>
                    <p class="hero-subtitle">
                        Pilih <b>Mata Pelajaran</b> dan <b>Kelas / Rombel</b> Anda. Anda dapat mengunduh <b>1 Kelas spesifik saja</b> (tanpa tercampur kelas lain), mencentang beberapa kelas yang Anda ajar, atau mengunduh bundel seluruh kelas sekaligus.
                    </p>
                </div>
                <div class="col-md-4 col-xs-12 text-right" style="margin-top: 12px;">
                    <?php if(!empty($selected_topik) && !empty($rekap_kelas)){ ?>
                        <a href="<?php echo site_url('portal_nilai/download_semua_kelas/'.$selected_topik->topik_id); ?>" class="btn btn-default" style="border-radius: 12px; font-weight: 800; font-size: 13px; padding: 11px 18px; border: 2px solid #0f172a; color: #0f172a; box-shadow: 0 3px 10px rgba(15,23,42,0.06);">
                            <i class="fa fa-files-o text-primary"></i> Bundel Semua Kelas (Multi-Sheet)
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <main class="container" style="padding-bottom: 80px;">

        <!-- 3-Step Selector Card -->
        <div class="filter-card">
            <form method="get" action="<?php echo site_url('portal_nilai'); ?>" id="form-pilih-mapel">
                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12" style="margin-bottom: 12px;">
                        <div class="step-label">
                            <span class="step-num">1</span> Filter Tingkat Kelas
                        </div>
                        <select id="filter-tingkat" class="form-control form-control-modern">
                            <option value="ALL">Semua Tingkat (X, XI, XII)</option>
                            <option value="X">Kelas X (Sepuluh)</option>
                            <option value="XI">Kelas XI (Sebelas)</option>
                            <option value="XII">Kelas XII (Dua Belas)</option>
                        </select>
                    </div>

                    <div class="col-md-5 col-sm-8 col-xs-12" style="margin-bottom: 12px;">
                        <div class="step-label">
                            <span class="step-num" style="background: #059669;">2</span> Pilih Mata Pelajaran / Ujian
                        </div>
                        <select name="topik_id" id="select-topik" class="form-control" style="width: 100%;">
                            <?php foreach($topik_list as $tp){ 
                                $is_sel = (!empty($selected_topik) && $selected_topik->topik_id == $tp->topik_id) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $tp->topik_id; ?>" data-tingkat="<?php echo htmlspecialchars($tp->tingkat); ?>" <?php echo $is_sel; ?>>
                                    [<?php echo htmlspecialchars($tp->modul_nama); ?>] <?php echo htmlspecialchars($tp->clean_nama); ?> (<?php echo intval($tp->jml_peserta_ujian); ?> Siswa Ujian)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12" style="margin-bottom: 12px;">
                        <div class="step-label">
                            <span class="step-num" style="background: #d97706;">3</span> Pilih Spesifik Kelas yang Anda Ajar
                        </div>
                        <select name="grup_id" id="filter-kelas-spesifik" class="form-control form-control-modern" style="border-color: #f59e0b !important; background-color: #fffbeb !important;">
                            <option value="ALL">-- Tampilkan Semua Kelas (<?php echo count($rekap_kelas); ?> Rombel) --</option>
                            <?php foreach($rekap_kelas as $rk){ 
                                $sel_g = (!empty($selected_grup_id) && strval($selected_grup_id) === strval($rk['grup_id'])) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $rk['grup_id']; ?>" <?php echo $sel_g; ?>>
                                    🎯 Hanya Kelas: <?php echo htmlspecialchars($rk['grup_label_alias']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Quick Banner untuk 1 Kelas Terpilih -->
            <div id="single-class-cta" style="display: none; margin-top: 10px; padding: 14px 18px; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%); border: 1.5px solid #34d399; border-radius: 12px; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: #059669; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fa fa-check"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 14px; color: #065f46;">
                            Mode Fokus 1 Kelas Aktif: <span id="cta-nama-kelas"></span>
                        </div>
                        <div style="font-size: 12px; color: #047857;">
                            File Excel yang diunduh dari tombol di kanan <b>100% hanya berisi siswa dari kelas ini saja</b>.
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" onclick="reset_filter_kelas()" class="btn btn-default btn-sm" style="border-radius: 8px; font-weight: 700;">
                        Tampilkan Semua Kelas
                    </button>
                    <a href="#" id="cta-btn-download" class="btn-download-single">
                        <i class="fa fa-file-excel-o"></i> Download Excel Kelas Ini Saja
                    </a>
                </div>
            </div>
        </div>

        <?php if(!empty($selected_topik)){ 
            $grand_total_siswa = 0;
            $grand_sudah = 0;
            $grand_belum = 0;
            $sum_avg = 0;
            $cnt_avg = 0;
            $global_max = 0;
            foreach($rekap_kelas as $rk){
                $grand_total_siswa += $rk['total_siswa'];
                $grand_sudah += $rk['sudah_ujian'];
                $grand_belum += $rk['belum_ujian'];
                if($rk['sudah_ujian'] > 0){
                    $sum_avg += $rk['rata_rata'];
                    $cnt_avg++;
                    if($rk['nilai_max'] > $global_max) $global_max = $rk['nilai_max'];
                }
            }
            $global_avg = ($cnt_avg > 0) ? round($sum_avg / $cnt_avg, 2) : 0;
            $persen_hadir = ($grand_total_siswa > 0) ? round(($grand_sudah / $grand_total_siswa) * 100) : 0;
        ?>

            <!-- 4 KPI Cards Mata Pelajaran -->
            <div class="kpi-grid">
                <div class="kpi-box">
                    <div>
                        <div class="kpi-title">Jumlah Rombel</div>
                        <div class="kpi-number"><?php echo count($rekap_kelas); ?> Kelas</div>
                        <div class="kpi-sub">Terhubung di Mapel Ini</div>
                    </div>
                    <div class="kpi-icon" style="background: #eff6ff; color: #1d4ed8;">
                        <i class="fa fa-sitemap"></i>
                    </div>
                </div>

                <div class="kpi-box">
                    <div>
                        <div class="kpi-title">Sudah Mengikuti Ujian</div>
                        <div class="kpi-number" style="color: #059669;"><?php echo $grand_sudah; ?> <small style="font-size: 14px; color: #64748b; font-weight: 600;">/ <?php echo $grand_total_siswa; ?></small></div>
                        <div class="kpi-sub">Partisipasi Kehadiran: <b><?php echo $persen_hadir; ?>%</b></div>
                    </div>
                    <div class="kpi-icon" style="background: #ecfdf5; color: #059669;">
                        <i class="fa fa-user-check"></i><i class="fa fa-check-circle"></i>
                    </div>
                </div>

                <div class="kpi-box">
                    <div>
                        <div class="kpi-title">Belum Ujian (Susulan)</div>
                        <div class="kpi-number" style="color: <?php echo $grand_belum > 0 ? '#d97706' : '#64748b'; ?>;"><?php echo $grand_belum; ?> Siswa</div>
                        <div class="kpi-sub">Otomatis ditandai di Excel</div>
                    </div>
                    <div class="kpi-icon" style="background: #fffbeb; color: #d97706;">
                        <i class="fa fa-clock-o"></i>
                    </div>
                </div>

                <div class="kpi-box">
                    <div>
                        <div class="kpi-title">Rata-Rata Nilai (Skala 100)</div>
                        <div class="kpi-number" style="color: #1e3a8a;"><?php echo $global_avg; ?></div>
                        <div class="kpi-sub">Nilai Tertinggi: <b><?php echo $global_max; ?></b></div>
                    </div>
                    <div class="kpi-icon" style="background: #e0e7ff; color: #1e3a8a;">
                        <i class="fa fa-line-chart"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Cepat Jurusan & Pencarian Kelas -->
            <div class="jurusan-toolbar">
                <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 6px;">
                    <span style="font-size: 12px; font-weight: 800; color: #334155; margin-right: 4px;">
                        <i class="fa fa-filter text-primary"></i> Filter Jurusan:
                    </span>
                    <button type="button" class="pill-jurusan active" onclick="filter_jurusan_pill('ALL', this)">Semua Jurusan</button>
                    <button type="button" class="pill-jurusan" onclick="filter_jurusan_pill('TKJ', this)">TKJ / TJKT</button>
                    <button type="button" class="pill-jurusan" onclick="filter_jurusan_pill('TKRO', this)">TKRO / TKR</button>
                    <button type="button" class="pill-jurusan" onclick="filter_jurusan_pill('TBSM', this)">TBSM / TSM</button>
                    <button type="button" class="pill-jurusan" onclick="filter_jurusan_pill('OTKP', this)">OTKP / MP / MPLB</button>
                    <button type="button" class="pill-jurusan" onclick="filter_jurusan_pill('AKL', this)">AKL / AK</button>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    <button type="button" onclick="buka_semua_rincian()" class="btn btn-default btn-xs" style="border-radius: 8px; font-weight: 700; padding: 5px 10px;">
                        <i class="fa fa-expand text-primary"></i> Buka Semua Tabel
                    </button>
                    <button type="button" onclick="tutup_semua_rincian()" class="btn btn-default btn-xs" style="border-radius: 8px; font-weight: 700; padding: 5px 10px;">
                        <i class="fa fa-compress"></i> Tutup Semua
                    </button>
                </div>
            </div>

            <!-- Daftar Kartu per Kelas / Rombel -->
            <?php if(!empty($rekap_kelas)){ ?>
                <?php foreach($rekap_kelas as $rk){ 
                    $is_hidden_card = (!empty($selected_grup_id) && $selected_grup_id !== 'ALL' && strval($selected_grup_id) !== strval($rk['grup_id']));
                    $pct_kls = ($rk['total_siswa'] > 0) ? round(($rk['sudah_ujian'] / $rk['total_siswa']) * 100) : 0;
                    $dl_url = site_url('portal_nilai/download_kelas/'.$selected_topik->topik_id.'/'.$rk['grup_id']);
                ?>
                    <div class="kelas-card item-kelas-card"
                         id="card-kelas-<?php echo $rk['grup_id']; ?>"
                         data-grup-id="<?php echo $rk['grup_id']; ?>"
                         data-label="<?php echo htmlspecialchars($rk['grup_label_alias']); ?>"
                         data-dl-url="<?php echo $dl_url; ?>"
                         style="<?php echo $is_hidden_card ? 'display:none;' : ''; ?>">
                        <div class="kelas-header">
                            <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                                <label style="margin: 0; cursor: pointer; display: flex; align-items: center;" title="Centang jika Anda ingin mengunduh beberapa kelas pilihan sekaligus">
                                    <input type="checkbox" class="chk-pilih-kelas" value="<?php echo $rk['grup_id']; ?>" onchange="update_centang_kelas()" style="width: 19px; height: 19px; cursor: pointer;">
                                </label>
                                <div class="kelas-avatar">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div>
                                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                        <h4 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">
                                            Kelas <?php echo htmlspecialchars($rk['grup_label_alias']); ?>
                                        </h4>
                                        <div class="kelas-progress-wrap hidden-xs" title="<?php echo $pct_kls; ?>% Siswa Sudah Ujian">
                                            <div class="kelas-progress-bar">
                                                <div class="kelas-progress-fill" style="width: <?php echo $pct_kls; ?>%;"></div>
                                            </div>
                                        </div>
                                        <span class="text-muted hidden-xs" style="font-size: 11.5px; font-weight: 700;"><?php echo $pct_kls; ?>%</span>
                                    </div>
                                    <div style="margin-top: 3px;">
                                        <span class="stat-pill pill-total"><i class="fa fa-user"></i> <?php echo $rk['total_siswa']; ?> Siswa</span>
                                        <span class="stat-pill pill-sudah"><i class="fa fa-check-circle"></i> Sudah Ujian: <?php echo $rk['sudah_ujian']; ?></span>
                                        <?php if($rk['belum_ujian'] > 0){ ?>
                                            <span class="stat-pill pill-belum"><i class="fa fa-exclamation-triangle"></i> Belum Ujian: <?php echo $rk['belum_ujian']; ?></span>
                                        <?php } ?>
                                        <span class="stat-pill pill-avg"><i class="fa fa-bar-chart"></i> Rata-rata: <?php echo $rk['rata_rata']; ?></span>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <button type="button" onclick="toggle_tabel_kelas(<?php echo $rk['grup_id']; ?>)" class="btn-preview-toggle">
                                    <i class="fa fa-eye text-primary"></i> Rincian Nilai
                                </button>
                                <a href="<?php echo $dl_url; ?>" class="btn-download-single" title="Unduh file Excel khusus kelas <?php echo htmlspecialchars($rk['grup_nama']); ?> saja">
                                    <i class="fa fa-file-excel-o"></i> Download Kelas <?php echo htmlspecialchars($rk['grup_nama']); ?> Saja
                                </a>
                            </div>
                        </div>

                        <?php if(!empty($rk['nama_belum_ujian']) && $rk['sudah_ujian'] > 0){ ?>
                            <div style="padding: 9px 22px; background: #fffbeb; border-top: 1px solid #fde68a; font-size: 12px; color: #92400e;">
                                <i class="fa fa-bell"></i> <b>Daftar Siswa Belum Ujian (Susulan) di Kelas <?php echo htmlspecialchars($rk['grup_nama']); ?>:</b>
                                <?php echo htmlspecialchars(implode(', ', $rk['nama_belum_ujian'])); ?>
                            </div>
                        <?php } ?>

                        <!-- Tabel Rincian Siswa per Kelas (Expandable) -->
                        <div id="tabel-kelas-<?php echo $rk['grup_id']; ?>" class="drawer-tabel-kelas" style="display: none; border-top: 1px solid #e2e8f0; padding: 18px 22px; background: #f8fafc;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; flex-wrap: wrap; gap: 8px;">
                                <div style="font-size: 13px; font-weight: 800; color: #1e293b;">
                                    <i class="fa fa-list-ol text-primary"></i> Daftar Nilai Peserta Didik Kelas <?php echo htmlspecialchars($rk['grup_label_alias']); ?> (Urut Abjad A&ndash;Z)
                                </div>
                                <input type="text" class="form-control input-sm" style="max-width: 240px; border-radius: 8px;" placeholder="🔍 Cari nama siswa di kelas ini..." onkeyup="cari_siswa_lokal(this, <?php echo $rk['grup_id']; ?>)">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-nilai-modern" id="table-siswa-<?php echo $rk['grup_id']; ?>">
                                    <thead>
                                        <tr>
                                            <th style="width: 45px; text-align: center;">No</th>
                                            <th style="width: 130px;">Username / NIS</th>
                                            <th>Nama Lengkap Peserta Didik</th>
                                            <th style="width: 115px; text-align: center;">Kelas</th>
                                            <th style="width: 115px; text-align: center;">Ruang / Sesi</th>
                                            <th style="width: 105px; text-align: center;">Benar / Soal</th>
                                            <th style="width: 85px; text-align: center;">Salah</th>
                                            <th style="width: 130px; text-align: center;">Nilai (Skala 100)</th>
                                            <th style="width: 145px; text-align: center;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no_s = 1; foreach($rk['siswa_list'] as $s){ 
                                            $sc_class = 'score-mid';
                                            if($s['nilai'] >= 75) $sc_class = 'score-high';
                                            else if($s['nilai'] < 60) $sc_class = 'score-low';
                                        ?>
                                            <tr style="<?php echo !$s['sudah_ujian'] ? 'background-color: #fffbeb;' : ''; ?>">
                                                <td class="text-center" style="color: #64748b; font-weight: 600;"><?php echo $no_s++; ?></td>
                                                <td style="font-family: monospace; font-weight: 700; color: #334155;"><?php echo htmlspecialchars($s['username']); ?></td>
                                                <td><b style="color: #0f172a;"><?php echo htmlspecialchars($s['nama']); ?></b></td>
                                                <td class="text-center"><span class="label label-default" style="background: #f1f5f9; color: #334155; font-size: 11px;"><?php echo htmlspecialchars($s['kelas']); ?></span></td>
                                                <td class="text-center" style="color: #64748b; font-size: 12px;"><?php echo htmlspecialchars($s['ruang']); ?></td>
                                                <td class="text-center"><?php echo $s['sudah_ujian'] ? '<span style="color:#059669; font-weight:700;">'.$s['jml_benar'].'</span> <span class="text-muted">/ '.$s['jml_soal'].'</span>' : '-'; ?></td>
                                                <td class="text-center"><?php echo $s['sudah_ujian'] ? '<span style="color:#dc2626; font-weight:600;">'.$s['jml_salah'].'</span>' : '-'; ?></td>
                                                <td class="text-center">
                                                    <?php if($s['sudah_ujian']){ ?>
                                                        <span class="score-badge <?php echo $sc_class; ?>"><?php echo $s['nilai']; ?></span>
                                                    <?php } else { ?>
                                                        <span class="text-muted">&mdash;</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if(!$s['sudah_ujian']){ ?>
                                                        <span class="label label-warning" style="padding: 4px 8px; border-radius: 6px;"><i class="fa fa-clock-o"></i> BELUM UJIAN</span>
                                                    <?php } else if($s['status'] === 'TERKUNCI ANTI-CHEAT'){ ?>
                                                        <span class="label label-danger" style="padding: 4px 8px; border-radius: 6px;"><i class="fa fa-lock"></i> TERKUNCI</span>
                                                    <?php } else if($s['status'] === 'SEDANG MENGERJAKAN'){ ?>
                                                        <span class="label label-info" style="padding: 4px 8px; border-radius: 6px;"><i class="fa fa-spinner"></i> MENGERJAKAN</span>
                                                    <?php } else { ?>
                                                        <span class="label label-success" style="padding: 4px 8px; border-radius: 6px;"><i class="fa fa-check"></i> SELESAI</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-warning" style="border-radius: 12px;">
                    <h4><i class="fa fa-info-circle"></i> Belum Ada Kelas Terhubung</h4>
                    Belum ada data kelas atau jadwal tes yang terhubung ke mata pelajaran ini.
                </div>
            <?php } ?>
        <?php } ?>
    </main>

    <!-- Floating Bar untuk Download Kelas yang Dicentang Guru -->
    <div class="floating-cart-bar" id="floating-centang-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span class="badge" style="background: #10b981; color: #fff; font-size: 13px; padding: 5px 10px;" id="cnt-kelas-centang">0</span>
            <span style="font-weight: 700; font-size: 13.5px;">Kelas yang Anda Ajar Terpilih</span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="batal_centang_semua()" class="btn btn-default btn-sm" style="border-radius: 8px; font-weight: 700; background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                Batal
            </button>
            <button type="button" onclick="download_kelas_tercentang()" class="btn btn-warning btn-sm" style="border-radius: 8px; font-weight: 800; color: #0f172a; background: #fde047; border: none; padding: 6px 16px;">
                <i class="fa fa-download"></i> Download Kelas yang Saya Centang Saja (.xlsx)
            </button>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>public/plugins/select2-4.0.5/js/select2.min.js"></script>
    <script type="text/javascript">
        var allTopikOptions = [];

        function toggle_tabel_kelas(grup_id){
            $('#tabel-kelas-' + grup_id).slideToggle(180);
        }

        function buka_semua_rincian(){
            $('.item-kelas-card:visible .drawer-tabel-kelas').slideDown(180);
        }

        function tutup_semua_rincian(){
            $('.drawer-tabel-kelas').slideUp(150);
        }

        function cari_siswa_lokal(input, grup_id){
            var q = ($(input).val() || '').toLowerCase();
            $('#table-siswa-' + grup_id + ' tbody tr').each(function(){
                var txt = $(this).text().toLowerCase();
                $(this).toggle(txt.indexOf(q) !== -1);
            });
        }

        function filter_jurusan_pill(jur, btn){
            $('.pill-jurusan').removeClass('active');
            $(btn).addClass('active');
            $('#filter-kelas-spesifik').val('ALL');
            $('#single-class-cta').hide();

            var aliases = {
                'TKJ': ['TKJ', 'TJKT'],
                'TKRO': ['TKRO', 'TKR'],
                'TBSM': ['TBSM', 'TSM'],
                'OTKP': ['OTKP', 'MP', 'MPLB'],
                'AKL': ['AKL', 'AK']
            };

            $('.item-kelas-card').each(function(){
                if(jur === 'ALL'){
                    $(this).show();
                }else{
                    var lbl = ($(this).data('label') || '').toUpperCase();
                    var list = aliases[jur] || [jur];
                    var matched = false;
                    for(var i = 0; i < list.length; i++){
                        var rgx = new RegExp('\\b' + list[i] + '\\b', 'i');
                        if(rgx.test(lbl)){
                            matched = true;
                            break;
                        }
                    }
                    $(this).toggle(matched);
                }
            });
        }

        function update_centang_kelas(){
            $('.chk-pilih-kelas').each(function(){
                var card = $(this).closest('.kelas-card');
                if($(this).is(':checked')){
                    card.addClass('card-selected');
                }else{
                    card.removeClass('card-selected');
                }
            });

            var cnt = $('.chk-pilih-kelas:checked').length;
            if(cnt > 0){
                $('#cnt-kelas-centang').text(cnt);
                $('#floating-centang-bar').css('display', 'flex');
            }else{
                $('#floating-centang-bar').hide();
            }
        }

        function batal_centang_semua(){
            $('.chk-pilih-kelas').prop('checked', false);
            update_centang_kelas();
        }

        function download_kelas_tercentang(){
            var ids = [];
            $('.chk-pilih-kelas:checked').each(function(){
                ids.push($(this).val());
            });
            if(ids.length === 0){
                alert('Silakan centang minimal 1 kelas yang Anda ajar terlebih dahulu.');
                return;
            }
            var topik_id = $('#select-topik').val();
            window.location.href = '<?php echo site_url("portal_nilai/download_pilihan"); ?>?topik_id=' + encodeURIComponent(topik_id) + '&grup_ids=' + encodeURIComponent(ids.join(','));
        }

        function reset_filter_kelas(){
            $('#filter-kelas-spesifik').val('ALL').trigger('change');
        }

        function salin_link_portal(){
            var url = window.location.href;
            if(navigator.clipboard){
                navigator.clipboard.writeText(url).then(function(){
                    $('#toast-copy').fadeIn(200);
                    setTimeout(function(){ $('#toast-copy').fadeOut(300); }, 3000);
                });
            }else{
                prompt('Salin link berikut untuk dibagikan ke Bapak/Ibu Guru:', url);
            }
        }

        function sync_single_class_cta(gid){
            if(!gid || gid === 'ALL'){
                $('#single-class-cta').hide();
                $('.item-kelas-card').show();
            }else{
                $('.item-kelas-card').hide();
                var card = $('#card-kelas-' + gid);
                card.show();
                $('#tabel-kelas-' + gid).slideDown(180);
                $('#cta-nama-kelas').text(card.data('label'));
                $('#cta-btn-download').attr('href', card.data('dl-url'));
                $('#single-class-cta').css('display', 'flex');
            }
        }

        $(function(){
            $('#select-topik option').each(function(){
                allTopikOptions.push({
                    val: $(this).val(),
                    text: $(this).text(),
                    tingkat: $(this).data('tingkat') || 'Umum'
                });
            });

            $('#select-topik').select2({ width: '100%' });

            $('#filter-tingkat').on('change', function(){
                var tk = $(this).val();
                var curVal = $('#select-topik').val();

                if($('#select-topik').hasClass('select2-hidden-accessible') || $('#select-topik').data('select2')){
                    try { $('#select-topik').select2('destroy'); } catch(e){}
                }

                var html = '';
                var firstMatch = '';
                var stillValid = false;
                for(var i = 0; i < allTopikOptions.length; i++){
                    var it = allTopikOptions[i];
                    if(tk === 'ALL' || it.tingkat === tk){
                        if(!firstMatch) firstMatch = it.val;
                        if(it.val === curVal) stillValid = true;
                        html += '<option value="' + it.val + '" data-tingkat="' + it.tingkat + '">' + it.text + '</option>';
                    }
                }

                $('#select-topik').html(html);
                if(stillValid){
                    $('#select-topik').val(curVal);
                }else if(firstMatch){
                    $('#select-topik').val(firstMatch);
                }
                $('#select-topik').select2({ width: '100%' });
                $('#form-pilih-mapel').submit();
            });

            $('#select-topik').on('change', function(){
                $('#filter-kelas-spesifik').val('ALL');
                $('#form-pilih-mapel').submit();
            });

            $('#filter-kelas-spesifik').on('change', function(){
                sync_single_class_cta($(this).val());
            });

            <?php if(!empty($selected_grup_id) && $selected_grup_id !== 'ALL'){ ?>
                sync_single_class_cta('<?php echo intval($selected_grup_id); ?>');
            <?php } ?>
        });
    </script>
</body>
</html>
