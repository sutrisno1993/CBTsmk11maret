<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Portal Monitoring & Telaah Naskah Soal | <?php echo !empty($site_name) ? htmlspecialchars($site_name) : 'CBT Online'; ?></title>
    
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

        /* Navbar Header */
        .main-navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            padding: 16px 0;
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
        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #fff;
        }
        .brand-logo:hover, .brand-logo:focus {
            color: #fff;
            text-decoration: none;
        }
        .brand-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ffeb3b;
        }
        .brand-text h1 {
            font-size: 17px;
            font-weight: 800;
            margin: 0;
            letter-spacing: 0.3px;
        }
        .brand-text p {
            font-size: 11px;
            margin: 0;
            opacity: 0.85;
        }

        /* Hero Banner */
        .hero-banner {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 30px 0 25px 0;
            margin-bottom: 25px;
        }
        .hero-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0 0 8px 0;
        }
        .hero-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }

        /* KPI Stat Cards */
        .kpi-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 18px 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.06);
        }
        .kpi-val {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .kpi-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kpi-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        /* Filter Controls */
        .filter-section {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            padding: 16px 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .filter-btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .btn-filter {
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 14px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-filter:hover {
            background: #f1f5f9;
            color: var(--primary);
        }
        .btn-filter.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 6px rgba(30, 60, 114, 0.25);
        }

        .search-box {
            position: relative;
        }
        .search-box input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 9px 16px 9px 38px;
            font-size: 13px;
            transition: all 0.2s;
        }
        .search-box input:focus {
            border-color: var(--secondary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.15);
        }
        .search-box i {
            position: absolute;
            left: 14px;
            top: 12px;
            color: #94a3b8;
            font-size: 14px;
        }

        /* Topik Cards */
        .topik-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid var(--border-color);
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.25s ease;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: calc(100% - 20px);
        }
        .topik-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.08);
            border-color: #cbd5e1;
        }
        .topik-header {
            padding: 16px 18px 12px 18px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }
        .topik-badge-modul {
            background: #e0e7ff;
            color: #3730a3;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .topik-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
            line-height: 1.4;
        }
        .topik-tingkat-badge {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 8px;
            border-radius: 6px;
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        .topik-body {
            padding: 16px 18px;
            flex-grow: 1;
        }
        .soal-count-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .progress-thin {
            height: 6px;
            border-radius: 10px;
            background: #f1f5f9;
            overflow: hidden;
            margin-bottom: 14px;
        }
        .status-badge-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
        }
        .badge-status {
            font-size: 11px;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-acc {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-revisi {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-kosong {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .badge-siap {
            background: #e0f2fe;
            color: #075985;
            border: 1px solid #bae6fd;
        }

        .topik-footer {
            padding: 12px 18px;
            background: #fafbfc;
            border-top: 1px solid #f1f5f9;
        }
        .btn-preview-card {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 9px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-preview-card.btn-active {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(30, 60, 114, 0.25);
        }
        .btn-preview-card.btn-active:hover {
            background: linear-gradient(135deg, #162d55 0%, #21437c 100%);
            color: #ffffff;
            text-decoration: none;
            transform: translateY(-1px);
        }
        .btn-preview-card.btn-disabled {
            background: #f1f5f9;
            color: #94a3b8;
            border: 1px solid #e2e8f0;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Verified Stamp */
        .verified-ribbon {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #15803d;
            background: #f0fdf4;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px dashed #86efac;
            margin-top: 8px;
        }

        /* Footer */
        .page-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 24px 0;
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 20px;
            }
            .filter-btn-group {
                overflow-x: auto;
                padding-bottom: 6px;
            }
            .btn-filter {
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

    <!-- Main Navigation Bar -->
    <header class="main-navbar">
        <div class="container navbar-container">
            <a href="<?php echo site_url('monitoring_soal'); ?>" class="brand-logo">
                <div class="brand-icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <div class="brand-text">
                    <h1><?php echo htmlspecialchars($site_name); ?></h1>
                    <p>Portal Telaah & Verifikasi Soal Ujian Guru</p>
                </div>
            </a>
            <div>
                <a href="<?php echo site_url('manager/welcome'); ?>" class="btn btn-sm btn-default" style="border-radius: 8px; font-weight: 600; font-size: 12px; background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fa fa-lock"></i> Area Operator / Admin
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="hero-title">
                        <i class="fa fa-clipboard-check text-primary"></i> Monitoring & Quality Control Soal Ujian
                    </h2>
                    <p class="hero-desc">
                        Selamat datang Bapak/Ibu Guru. Silakan pilih mata pelajaran dan kelas Anda untuk <strong>memeriksa kelengkapan butir soal, redaksi, opsi pilihan, dan kunci jawaban</strong>. Berikan catatan koreksi bila ada kekeliruan atau lakukan pengesahan (TTD) apabila naskah soal sudah sesuai standar.
                    </p>
                </div>
                <div class="col-md-4 text-right hidden-xs hidden-sm" style="padding-top: 10px;">
                    <span class="badge" style="background: #e0e7ff; color: #3730a3; font-size: 13px; padding: 8px 16px; border-radius: 20px;">
                        <i class="fa fa-check-circle"></i> Akses Langsung Tanpa Perlu Login
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Container -->
    <main class="container">
        
        <!-- KPI Summary Cards -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-val" style="color: var(--primary);"><?php echo $stat_total; ?></div>
                        <div class="kpi-label">Total Topik Mapel</div>
                    </div>
                    <div class="kpi-icon-box" style="background: #e0e7ff; color: var(--primary);">
                        <i class="fa fa-book"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-val" style="color: var(--success);"><?php echo $stat_terisi; ?></div>
                        <div class="kpi-label">Sudah Ada Soal</div>
                    </div>
                    <div class="kpi-icon-box" style="background: #dcfce7; color: var(--success);">
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-val" style="color: var(--danger);"><?php echo $stat_kosong; ?></div>
                        <div class="kpi-label">Belum Ada Soal (0)</div>
                    </div>
                    <div class="kpi-icon-box" style="background: #fee2e2; color: var(--danger);">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-val" style="color: #0284c7;"><?php echo $stat_acc; ?></div>
                        <div class="kpi-label">Sudah Sesuai (ACC)</div>
                    </div>
                    <div class="kpi-icon-box" style="background: #e0f2fe; color: #0284c7;">
                        <i class="fa fa-certificate"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls & Search -->
        <div class="filter-section">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                <!-- Filter Status -->
                <div class="col-md-5 col-sm-12" style="margin-bottom: 10px;">
                    <label style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 6px; display: block;">
                        Filter Status Soal:
                    </label>
                    <div class="filter-btn-group" id="group-filter-status">
                        <button class="btn-filter active" onclick="setFilterStatus('semua', this)">Semua (<?php echo $stat_total; ?>)</button>
                        <button class="btn-filter" onclick="setFilterStatus('terisi', this)"><i class="fa fa-check text-green"></i> Ada Soal (<?php echo $stat_terisi; ?>)</button>
                        <button class="btn-filter" onclick="setFilterStatus('kosong', this)"><i class="fa fa-times text-red"></i> Kosong (<?php echo $stat_kosong; ?>)</button>
                        <button class="btn-filter" onclick="setFilterStatus('acc', this)"><i class="fa fa-certificate text-blue"></i> ACC / TTD (<?php echo $stat_acc; ?>)</button>
                    </div>
                </div>

                <!-- Filter Kelas -->
                <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 6px; display: block;">
                        Tingkat Kelas:
                    </label>
                    <div class="filter-btn-group" id="group-filter-kelas">
                        <button class="btn-filter active" onclick="setFilterKelas('semua', this)">Semua</button>
                        <button class="btn-filter" onclick="setFilterKelas('X', this)">Kelas X</button>
                        <button class="btn-filter" onclick="setFilterKelas('XI', this)">Kelas XI</button>
                        <button class="btn-filter" onclick="setFilterKelas('XII', this)">Kelas XII</button>
                    </div>
                </div>

                <!-- Live Search -->
                <div class="col-md-4 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; margin-bottom: 6px; display: block;">
                        Cari Mata Pelajaran / Topik:
                    </label>
                    <div class="search-box">
                        <i class="fa fa-search"></i>
                        <input type="text" id="input-search" placeholder="Ketik nama mapel atau kelas..." onkeyup="applyFilters()">
                    </div>
                </div>
            </div>
        </div>

        <!-- Topics Grid -->
        <div class="row" id="topik-grid-container">
            <?php if(!empty($topik_list)){ ?>
                <?php foreach($topik_list as $t){ 
                    $jml = intval($t->jml_soal);
                    $has_soal = ($jml > 0);
                    $is_acc = $t->is_acc;
                    $status_filter = $has_soal ? 'terisi' : 'kosong';
                    if($is_acc) $status_filter .= ' acc';
                    if($t->pending_koreksi > 0) $status_filter .= ' revisi';
                    
                    $target = 40;
                    $persen = min(100, round(($jml / $target) * 100));
                ?>
                <div class="col-md-4 col-sm-6 col-xs-12 topik-item-wrapper" 
                     data-status="<?php echo $status_filter; ?>" 
                     data-has-soal="<?php echo $has_soal ? '1' : '0'; ?>"
                     data-acc="<?php echo $is_acc ? '1' : '0'; ?>"
                     data-kelas="<?php echo $t->tingkat; ?>" 
                     data-search="<?php echo strtolower($t->clean_nama . ' ' . $t->modul_nama . ' ' . $t->topik_nama); ?>">
                    
                    <div class="topik-card">
                        <div class="topik-header">
                            <div>
                                <span class="topik-badge-modul">
                                    <i class="fa fa-bookmark-o"></i> <?php echo htmlspecialchars($t->modul_nama); ?>
                                </span>
                                <h3 class="topik-title">
                                    <?php echo htmlspecialchars($t->clean_nama); ?>
                                </h3>
                            </div>
                            <?php if(!empty($t->tingkat) && $t->tingkat != 'Umum'){ ?>
                                <span class="topik-tingkat-badge">
                                    Kelas <?php echo $t->tingkat; ?>
                                </span>
                            <?php } ?>
                        </div>

                        <div class="topik-body">
                            <!-- Indikator Jumlah Butir Soal -->
                            <div class="soal-count-box">
                                <span style="font-weight: 700; color: <?php echo $has_soal ? '#0f172a' : '#ef4444'; ?>;">
                                    <i class="fa <?php echo $has_soal ? 'fa-file-text-o text-primary' : 'fa-times-circle text-danger'; ?>"></i>
                                    <?php echo $jml; ?> Butir Soal Terinput
                                </span>
                                <span style="font-size: 11px; color: var(--text-muted);">
                                    Target: <?php echo $target; ?> Butir
                                </span>
                            </div>

                            <div class="progress progress-thin">
                                <div class="progress-bar <?php echo ($jml == 0) ? 'progress-bar-danger' : (($jml < $target) ? 'progress-bar-warning' : 'progress-bar-success'); ?>" 
                                     style="width: <?php echo max(6, $persen); ?>%;"></div>
                            </div>

                            <!-- Badges Status -->
                            <div class="status-badge-row">
                                <?php if($is_acc){ ?>
                                    <span class="badge-status badge-acc" title="Naskah soal telah disetujui & diverifikasi">
                                        <i class="fa fa-check-circle"></i> Sudah Sesuai (ACC)
                                    </span>
                                <?php } else if($t->pending_koreksi > 0){ ?>
                                    <span class="badge-status badge-revisi" title="Terdapat catatan revisi dari guru yang sedang ditangani">
                                        <i class="fa fa-commenting-o"></i> <?php echo $t->pending_koreksi; ?> Catatan Revisi
                                    </span>
                                <?php } else if($has_soal){ ?>
                                    <span class="badge-status badge-siap" title="Soal sudah diupload, siap ditelaah guru">
                                        <i class="fa fa-eye"></i> Siap Ditelaah Guru
                                    </span>
                                <?php } else { ?>
                                    <span class="badge-status badge-kosong" title="Belum ada soal yang diinput oleh operator/guru">
                                        <i class="fa fa-exclamation-triangle"></i> Belum Ada Soal
                                    </span>
                                <?php } ?>

                                <?php if(!empty($t->verifikasi) && !empty($t->verifikasi->verifikasi_guru_nama)){ ?>
                                    <span style="font-size: 11px; color: var(--text-muted);">
                                        <i class="fa fa-user-circle"></i> <?php echo htmlspecialchars($t->verifikasi->verifikasi_guru_nama); ?>
                                    </span>
                                <?php } ?>
                            </div>

                            <!-- Info TTD jika sudah ACC -->
                            <?php if($is_acc && !empty($t->verifikasi)){ ?>
                                <div class="verified-ribbon">
                                    <i class="fa fa-shield"></i>
                                    <span>Terverifikasi TTD: <?php echo htmlspecialchars($t->verifikasi->verifikasi_guru_nama); ?> (<?php echo date('d/m/Y', strtotime($t->verifikasi->verifikasi_created_at)); ?>)</span>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="topik-footer">
                            <?php if($has_soal){ ?>
                                <a href="<?php echo site_url('monitoring_soal/detail/'.$t->topik_id); ?>" class="btn-preview-card btn-active">
                                    <i class="fa fa-search-plus"></i> Buka &amp; Telaah Naskah Soal
                                </a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" class="btn-preview-card btn-disabled" title="Soal belum diunggah oleh pihak operator/guru">
                                    <i class="fa fa-ban"></i> Soal Belum Diinput (0 Butir)
                                </a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <?php } ?>
            <?php } else { ?>
                <div class="col-xs-12 text-center" style="padding: 60px 20px;">
                    <i class="fa fa-folder-open-o" style="font-size: 50px; color: #cbd5e1; margin-bottom: 12px;"></i>
                    <h4 style="color: #64748b; font-weight: 700;">Belum Ada Data Topik</h4>
                    <p class="text-muted">Topik mata pelajaran ujian belum ditambahkan oleh administrator.</p>
                </div>
            <?php } ?>
        </div>

        <!-- Empty Filter State -->
        <div id="empty-search-state" class="text-center" style="display: none; padding: 60px 20px;">
            <i class="fa fa-search" style="font-size: 44px; color: #cbd5e1; margin-bottom: 12px;"></i>
            <h4 style="color: #475569; font-weight: 700;">Tidak Menemukan Mata Pelajaran Terkait</h4>
            <p style="color: #94a3b8; font-size: 13px;">Coba ubah kata kunci pencarian atau sesuaikan opsi filter status/kelas di atas.</p>
            <button class="btn btn-sm btn-default" onclick="resetAllFilters()" style="border-radius: 8px; font-weight: 600; margin-top: 5px;">
                <i class="fa fa-refresh"></i> Reset Semua Filter
            </button>
        </div>

    </main>

    <!-- Page Footer -->
    <footer class="page-footer">
        <div class="container">
            <p style="margin: 0;">
                &copy; <?php echo date('Y'); ?> <strong><?php echo htmlspecialchars($site_name); ?></strong>. Portal Monitoring &amp; Telaah Bank Soal Guru CBT.
            </p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo base_url(); ?>public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js"></script>

    <script>
        var currentStatus = 'semua';
        var currentKelas = 'semua';

        function setFilterStatus(status, btn){
            currentStatus = status;
            $('#group-filter-status .btn-filter').removeClass('active');
            $(btn).addClass('active');
            applyFilters();
        }

        function setFilterKelas(kelas, btn){
            currentKelas = kelas;
            $('#group-filter-kelas .btn-filter').removeClass('active');
            $(btn).addClass('active');
            applyFilters();
        }

        function resetAllFilters(){
            currentStatus = 'semua';
            currentKelas = 'semua';
            $('#input-search').val('');
            $('#group-filter-status .btn-filter').removeClass('active');
            $('#group-filter-status .btn-filter:first').addClass('active');
            $('#group-filter-kelas .btn-filter').removeClass('active');
            $('#group-filter-kelas .btn-filter:first').addClass('active');
            applyFilters();
        }

        function applyFilters(){
            var search = $('#input-search').val().toLowerCase().trim();
            var visibleCount = 0;

            $('.topik-item-wrapper').each(function(){
                var itemStatus = $(this).attr('data-status');
                var hasSoal = $(this).attr('data-has-soal');
                var isAcc = $(this).attr('data-acc');
                var itemKelas = $(this).attr('data-kelas');
                var itemSearch = $(this).attr('data-search');

                // Filter status
                var matchStatus = false;
                if(currentStatus === 'semua') matchStatus = true;
                else if(currentStatus === 'terisi' && hasSoal === '1') matchStatus = true;
                else if(currentStatus === 'kosong' && hasSoal === '0') matchStatus = true;
                else if(currentStatus === 'acc' && isAcc === '1') matchStatus = true;

                // Filter kelas
                var matchKelas = false;
                if(currentKelas === 'semua') matchKelas = true;
                else if(itemKelas === currentKelas) matchKelas = true;

                // Filter search text
                var matchSearch = (search === '' || itemSearch.indexOf(search) > -1);

                if(matchStatus && matchKelas && matchSearch){
                    $(this).fadeIn(150);
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            if(visibleCount === 0){
                $('#empty-search-state').show();
            } else {
                $('#empty-search-state').hide();
            }
        }
    </script>
</body>
</html>
