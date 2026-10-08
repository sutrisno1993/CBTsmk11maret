<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo !empty($judul_halaman) ? $judul_halaman : 'Manajemen & Daftar Soal'; ?>
		<small><?php echo !empty($subjudul_halaman) ? $subjudul_halaman : 'Monitoring kelengkapan butir soal dan manajemen naskah ujian'; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url('manager/modul_daftar'); ?>">Data Modul</a></li>
		<li class="active">Daftar Soal</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- 1. KPI WIDGET SUMMARY CARDS -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="inner">
                    <h3 id="stat-total-val"><?php echo !empty($stat_total) ? $stat_total : 0; ?></h3>
                    <p style="font-weight: 600;">Total Topik Ujian</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="javascript:void(0)" onclick="filter_status('semua')" class="small-box-footer" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    Lihat Semua Topik <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(221,75,57,0.3); border: 2px solid #ff7675;">
                <div class="inner">
                    <h3 id="stat-kosong-val"><?php echo !empty($stat_kosong) ? $stat_kosong : 0; ?></h3>
                    <p style="font-weight: 600;"><i class="fa fa-warning"></i> Belum Ada Soal (0 Butir)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <a href="javascript:void(0)" onclick="filter_status('kosong')" class="small-box-footer" style="background: rgba(0,0,0,0.25); font-weight: 700; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    Filter Topik Kosong Ini <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="inner">
                    <h3 id="stat-kurang-val"><?php echo !empty($stat_kurang) ? $stat_kurang : 0; ?></h3>
                    <p style="font-weight: 600;">Belum Lengkap (&lt; 40 Butir)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-hourglass-half"></i>
                </div>
                <a href="javascript:void(0)" onclick="filter_status('kurang')" class="small-box-footer" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    Lihat Yang Belum Lengkap <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="inner">
                    <h3 id="stat-lengkap-val"><?php echo !empty($stat_lengkap) ? $stat_lengkap : 0; ?></h3>
                    <p style="font-weight: 600;">Siap Ujian (&ge; 40 Butir)</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <a href="javascript:void(0)" onclick="filter_status('lengkap')" class="small-box-footer" style="border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                    Lihat Topik Siap <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. PANEL MONITORING KELENGKAPAN BANK SOAL -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700; font-size: 16px;">
                        <i class="fa fa-tasks text-primary"></i> Monitoring Kesiapan Bank Soal Topik Ujian
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-sm btn-info" onclick="bukaModalShareLink()" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none; font-weight: 700; margin-right: 8px; border-radius: 6px; box-shadow: 0 2px 6px rgba(30,60,114,0.25);">
                            <i class="fa fa-link"></i> 🔗 Salin &amp; Bagikan Link Monitoring Guru
                        </button>
                        <span class="badge bg-purple" style="font-size: 13px; padding: 6px 12px; border-radius: 12px;">
                            Total Butir Soal Terisi: <strong><?php echo !empty($stat_total_soal) ? $stat_total_soal : 0; ?></strong> Butir
                        </span>
                    </div>
                </div>

                <div class="box-body" style="padding: 20px;">
                    <!-- Filter Toolbar -->
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-7 col-xs-12">
                            <label style="font-size: 12px; text-transform: uppercase; color: #7f8c8d; margin-bottom: 5px;">Filter Status Kesiapan:</label><br>
                            <div class="btn-group btn-group-sm" role="group" id="btn-group-status">
                                <button type="button" class="btn btn-default active" onclick="filter_status('semua')" id="btn-f-semua" style="font-weight: 600;">
                                    Semua Topik (<?php echo !empty($stat_total) ? $stat_total : 0; ?>)
                                </button>
                                <button type="button" class="btn btn-danger" onclick="filter_status('kosong')" id="btn-f-kosong" style="font-weight: 700;">
                                    <i class="fa fa-times-circle"></i> Belum Ada Soal (<?php echo !empty($stat_kosong) ? $stat_kosong : 0; ?>)
                                </button>
                                <button type="button" class="btn btn-warning" onclick="filter_status('kurang')" id="btn-f-kurang" style="font-weight: 600;">
                                    <i class="fa fa-warning"></i> Kurang (&lt; 40) (<?php echo !empty($stat_kurang) ? $stat_kurang : 0; ?>)
                                </button>
                                <button type="button" class="btn btn-success" onclick="filter_status('lengkap')" id="btn-f-lengkap" style="font-weight: 600;">
                                    <i class="fa fa-check-circle"></i> Siap (&ge; 40) (<?php echo !empty($stat_lengkap) ? $stat_lengkap : 0; ?>)
                                </button>
                            </div>
                        </div>

                        <div class="col-md-2 col-xs-6" style="margin-top: 5px;">
                            <label style="font-size: 12px; text-transform: uppercase; color: #7f8c8d;">Hari Ujian:</label>
                            <select id="filter-hari" class="form-control input-sm" style="border-radius: 4px;">
                                <option value="">-- Semua Hari --</option>
                                <option value="SENIN">Senin</option>
                                <option value="SELASA">Selasa</option>
                                <option value="RABU">Rabu</option>
                                <option value="KAMIS">Kamis</option>
                                <option value="JUMAT">Jumat</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-xs-6" style="margin-top: 5px;">
                            <label style="font-size: 12px; text-transform: uppercase; color: #7f8c8d;">Pencarian Cepat:</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="filter-search" class="form-control" placeholder="Cari mapel / topik...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="$('#filter-search').val(''); filter_table();"><i class="fa fa-times"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Info jika ada topik kosong -->
                    <?php if(!empty($stat_kosong) && $stat_kosong > 0){ ?>
                    <div class="alert alert-danger alert-dismissible" style="border-radius: 6px; margin-bottom: 20px;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-exclamation-triangle"></i> Perhatian: <?php echo $stat_kosong; ?> Topik Belum Memiliki Soal!</h4>
                        Terdapat <strong><?php echo $stat_kosong; ?> topik mata pelajaran</strong> yang butir soalnya masih 0 (kosong). Silakan klik tombol <strong>"Import Word"</strong> atau <strong>"+ Tulis Soal"</strong> pada baris terkait untuk segera mengunggah naskah soal.
                    </div>
                    <?php } ?>

                    <!-- Table Monitoring Topik -->
                    <div class="table-responsive">
                        <table id="table-monitoring" class="table table-bordered table-striped table-hover" style="font-size: 13px;">
                            <thead>
                                <tr style="background: #f4f6f9; color: #333;">
                                    <th width="3%" class="text-center">No.</th>
                                    <th width="10%" class="text-center">Jadwal & Hari</th>
                                    <th width="18%">Mata Pelajaran (Modul)</th>
                                    <th width="20%">Nama Topik Ujian</th>
                                    <th width="13%" class="text-center">Jumlah Butir Soal</th>
                                    <th width="11%" class="text-center">Kesiapan</th>
                                    <th width="12%" class="text-center">Verifikasi Guru</th>
                                    <th width="13%" class="text-center">Aksi Cepat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(!empty($monitoring_topik)){
                                    $no = 1;
                                    foreach($monitoring_topik as $t){
                                        $jml = intval($t->jml_soal);
                                        $target = 40;
                                        $persen = min(100, round(($jml / $target) * 100));

                                        // Status
                                        if($jml == 0){
                                            $st_badge = '<span class="label label-danger" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-times-circle"></i> Kosong (0)</span>';
                                            $st_cat = 'kosong';
                                            $bar_color = 'progress-bar-danger';
                                            $row_bg = 'style="background-color: #fff5f5;"';
                                        } else if($jml < $target){
                                            $st_badge = '<span class="label label-warning" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-warning"></i> Kurang ('.$jml.'/'.$target.')</span>';
                                            $st_cat = 'kurang';
                                            $bar_color = 'progress-bar-warning';
                                            $row_bg = '';
                                        } else {
                                            $st_badge = '<span class="label label-success" style="font-size: 11px; padding: 4px 8px; border-radius: 4px;"><i class="fa fa-check-circle"></i> Siap ('.$jml.')</span>';
                                            $st_cat = 'lengkap';
                                            $bar_color = 'progress-bar-success';
                                            $row_bg = '';
                                        }

                                        // Ekstraksi Hari Ujian
                                        $hari = '-';
                                        $hari_class = 'label-default';
                                        if(preg_match('/\[(SENIN|SELASA|RABU|KAMIS|JUMAT)(-[0-9]+)?\]/i', $t->topik_nama, $m_h)){
                                            $hari = strtoupper($m_h[1]);
                                            if($hari == 'SENIN') $hari_class = 'label-primary';
                                            else if($hari == 'SELASA') $hari_class = 'label-info';
                                            else if($hari == 'RABU') $hari_class = 'label-success';
                                            else if($hari == 'KAMIS') $hari_class = 'label-warning';
                                            else if($hari == 'JUMAT') $hari_class = 'label-danger';
                                        }

                                        // Ekstraksi Tingkat Kelas
                                        $tingkat = '';
                                        if(preg_match('/\b(XII)\b/i', $t->topik_nama)){
                                            $tingkat = 'XII';
                                        } else if(preg_match('/\b(XI)\b/i', $t->topik_nama)){
                                            $tingkat = 'XI';
                                        } else if(preg_match('/\b(X)\b/i', $t->topik_nama)){
                                            $tingkat = 'X';
                                        }

                                        // Status Verifikasi & Catatan Koreksi
                                        $badge_verif = '<span class="text-muted" style="font-size: 11px;"><i class="fa fa-clock-o"></i> Belum ditelaah</span>';
                                        if(!empty($t->verifikasi) && $t->verifikasi->verifikasi_status == 'sesuai'){
                                            $badge_verif = '<span class="label label-success" style="font-size: 11px; padding: 3px 6px; border-radius: 3px;" title="Terverifikasi oleh '.$t->verifikasi->verifikasi_guru_nama.'"><i class="fa fa-check"></i> ACC (TTD)</span><br><small class="text-muted" style="font-size: 10px;">'.htmlspecialchars($t->verifikasi->verifikasi_guru_nama).'</small>';
                                        } else if(!empty($t->koreksi_info) && $t->koreksi_info->pending_koreksi > 0){
                                            $badge_verif = '<span class="label label-warning" style="font-size: 11px; padding: 3px 6px; border-radius: 3px; background-color: #f39c12 !important;"><i class="fa fa-commenting-o"></i> '.$t->koreksi_info->pending_koreksi.' Revisi</span>';
                                        }
                                ?>
                                <tr class="row-topik" data-status="<?php echo $st_cat; ?>" data-hari="<?php echo $hari; ?>" data-tingkat="<?php echo $tingkat; ?>" <?php echo $row_bg; ?>>
                                    <td class="text-center" style="vertical-align: middle; font-weight: 600;"><?php echo $no++; ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <span class="label <?php echo $hari_class; ?>" style="font-size: 11px; padding: 4px 8px; border-radius: 3px;">
                                            <?php echo $hari; ?>
                                        </span>
                                    </td>
                                    <td style="vertical-align: middle; font-weight: 600; color: #2c3e50;">
                                        <i class="fa fa-bookmark text-muted" style="margin-right: 5px;"></i>
                                        <?php echo htmlspecialchars($t->modul_nama); ?>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <strong><?php echo htmlspecialchars($t->topik_nama); ?></strong>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div style="display: flex; justify-content: space-between; margin-bottom: 3px; font-size: 11px; font-weight: 600;">
                                            <span><?php echo $jml; ?> Butir</span>
                                            <span class="text-muted">Target: <?php echo $target; ?></span>
                                        </div>
                                        <div class="progress progress-xs" style="margin-bottom: 0; background: #e9ecef; border-radius: 4px; overflow: hidden;">
                                            <div class="progress-bar <?php echo $bar_color; ?>" style="width: <?php echo max(5, $persen); ?>%"></div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php echo $st_badge; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <?php echo $badge_verif; ?>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="btn-group btn-group-xs">
                                            <a href="<?php echo site_url('monitoring_soal/detail/'.$t->topik_id); ?>" target="_blank" class="btn btn-default" style="background: #e0f2fe; color: #0369a1; border-color: #bae6fd;" title="Buka lembar telaah & QC soal guru">
                                                <i class="fa fa-external-link"></i> Telaah
                                            </a>
                                            <button type="button" class="btn btn-default" onclick="pilih_dan_lihat_soal('<?php echo $t->topik_id; ?>')" title="Lihat daftar butir soal topik ini di bawah">
                                                <i class="fa fa-eye text-primary"></i> Soal
                                            </button>
                                            <a href="<?php echo site_url('manager/modul_import_word?topik_id='.$t->topik_id); ?>" class="btn btn-info" title="Upload soal Word untuk topik ini">
                                                <i class="fa fa-file-word-o"></i> Word
                                            </a>
                                            <a href="<?php echo site_url('manager/modul_import_json?topik_id='.$t->topik_id); ?>" class="btn btn-warning" style="background-color: #6c5ce7; border-color: #6c5ce7; color: white;" title="Upload soal JSON / AI untuk topik ini">
                                                <i class="fa fa-code"></i> JSON
                                            </a>
                                            <a href="<?php echo site_url('manager/modul_soal?topik_id='.$t->topik_id); ?>" class="btn btn-primary" title="Tulis butir soal baru secara manual">
                                                <i class="fa fa-pencil"></i> Tulis
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted" style="padding: 20px;">Belum ada data topik yang dapat ditampilkan.</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. PANEL DETAIL BUTIR SOAL (LEMBAR SOAL) -->
    <div class="row" id="panel-detail-soal">
        <div class="col-xs-12">
            <div class="box box-default" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700;">
                        <i class="fa fa-list-alt text-blue"></i> Rincian Butir Soal: <span id="judul-daftar-soal" class="text-primary"></span>
                    </h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('manager/modul_soal'); ?>" id="btn-tulis-soal-topik" style="margin-right: 5px; font-weight: 600;" title="Tulis atau tambah butir soal baru">
                            <i class="fa fa-pencil"></i> Tulis Soal
                        </a>
                        <a class="btn btn-sm btn-warning" href="<?php echo site_url('manager/modul_import_json'); ?>" id="btn-import-json-topik" style="margin-right: 5px; font-weight: 600; background-color: #6c5ce7; border-color: #6c5ce7; color: white;" title="Upload naskah soal dari JSON / AI">
                            <i class="fa fa-code"></i> Import JSON / AI
                        </a>
                        <a class="btn btn-sm btn-info" href="<?php echo site_url('manager/modul_import_word'); ?>" id="btn-import-word-topik" style="margin-right: 5px; font-weight: 600;" title="Upload naskah soal dari Microsoft Word">
                            <i class="fa fa-file-word-o"></i> Import Word
                        </a>
                        <a class="btn btn-sm btn-success" style="cursor: pointer; margin-right: 5px; font-weight: 600;" onclick="preview_soal()" title="Periksa redaksi soal dan validasi kunci jawaban sebelum ujian">
                            <i class="fa fa-eye"></i> Preview & Cek Kunci (QC)
                        </a>
                        <a class="btn btn-sm btn-default" style="cursor: pointer;" onclick="cetak_soal()" title="Cetak naskah soal ke kertas / PDF">
                            <i class="fa fa-print"></i> Cetak Soal
                        </a>
                    </div>
                </div>

                <div class="box-body" style="padding: 20px;">
                    <!-- Dropdown Pemilihan Topik -->
                    <div class="row" style="margin-bottom: 20px; background: #fafbfc; padding: 15px; border-radius: 6px; border: 1px solid #e1e8ed;">
                        <div class="col-md-8 col-md-offset-2 col-xs-12">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="font-weight: 700; color: #34495e;">
                                    <i class="fa fa-filter text-primary"></i> Pilih Topik Mata Pelajaran Yang Ingin Dilihat:
                                </label>
                                <select name="topik" id="topik" class="form-control" style="width: 100%;">
                                    <?php if(!empty($select_topik)){ echo $select_topik; } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table Butir Soal -->
                    <table id="table-soal" class="table table-bordered table-striped" style="width: 100%;">
                        <thead>
                            <tr style="background: #f4f6f9;">
                                <th width="5%">No.</th>
                                <th width="15%">Tipe Soal</th>
                                <th width="80%">Konten Soal & Kunci Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </tbody>
                    </table>                        
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL SHARE LINK MONITORING & PREVIEW GURU -->
    <div class="modal fade" id="modal-share-link" tabindex="-1" role="dialog" aria-labelledby="modalShareLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #fff; padding: 18px 22px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.8;"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalShareLabel" style="font-weight: 800; font-size: 17px;">
                        <i class="fa fa-share-alt" style="margin-right: 6px;"></i> Bagikan Link Monitoring &amp; Preview Soal Guru
                    </h4>
                </div>
                <div class="modal-body" style="padding: 22px 24px;">
                    <p style="font-size: 13px; color: #475569; line-height: 1.6; margin-bottom: 16px;">
                        Bapak/Ibu Guru dapat mengakses tautan di bawah ini secara langsung <strong>tanpa perlu login</strong> untuk menelaah naskah butir soal, memeriksa kunci jawaban, memberikan catatan koreksi per butir soal, serta menandatangani verifikasi (ACC) kelayakan naskah soal.
                    </p>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="font-size: 12px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="fa fa-link text-primary"></i> Link Akses Portal Guru:
                        </label>
                        <div class="input-group">
                            <input type="text" id="input-public-url" class="form-control input-lg" value="<?php echo !empty($public_monitoring_url) ? $public_monitoring_url : site_url('monitoring_soal'); ?>" readonly style="background: #f8fafc; font-weight: 700; color: #1e3c72; font-size: 13px; border-radius: 6px 0 0 6px;">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-lg" type="button" onclick="salinLinkMonitoring()" id="btn-copy-link" style="background: #1e3c72; border-color: #1e3c72; font-weight: 700; font-size: 13px; border-radius: 0 6px 6px 0;">
                                    <i class="fa fa-copy"></i> Salin Link
                                </button>
                            </span>
                        </div>
                        <small id="copy-feedback" class="text-green" style="display: none; font-weight: 700; margin-top: 5px;">
                            <i class="fa fa-check-circle"></i> Tautan berhasil disalin ke clipboard! Siap dibagikan.
                        </small>
                    </div>

                    <div style="background: #f1f5f9; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; font-size: 12px; color: #334155;">
                        <div style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                            <i class="fa fa-shield text-green"></i> Fitur Portal Guru:
                        </div>
                        <ul style="margin: 0; padding-left: 18px; line-height: 1.6;">
                            <li>Nama topik otomatis dibersihkan (tanpa tag hari, hanya Mapel &amp; Kelas).</li>
                            <li>Indikator status topik: sudah ada soal vs topik kosong (0 butir).</li>
                            <li>Form catatan koreksi interaktif pada setiap nomor soal.</li>
                            <li>Pengesahan TTD digital guru bila naskah soal sudah sesuai standar.</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-xs-12" style="margin-bottom: 8px;">
                            <button type="button" class="btn btn-success btn-block" onclick="bagikanWhatsApp()" style="background: #25d366; border-color: #25d366; font-weight: 700; border-radius: 8px; padding: 9px 14px;">
                                <i class="fa fa-whatsapp" style="font-size: 16px;"></i> Bagikan ke WhatsApp Guru
                            </button>
                        </div>
                        <div class="col-sm-6 col-xs-12" style="margin-bottom: 8px;">
                            <a href="<?php echo !empty($public_monitoring_url) ? $public_monitoring_url : site_url('monitoring_soal'); ?>" target="_blank" class="btn btn-default btn-block" style="border-radius: 8px; font-weight: 700; padding: 9px 14px; border: 1px solid #cbd5e1;">
                                <i class="fa fa-external-link"></i> Buka Portal Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section><!-- /.content -->

<script lang="javascript">
    function bukaModalShareLink(){
        $('#copy-feedback').hide();
        $('#modal-share-link').modal('show');
    }

    function salinLinkMonitoring(){
        var copyText = document.getElementById("input-public-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value).then(function(){
            $('#copy-feedback').fadeIn(200);
            $('#btn-copy-link').html('<i class="fa fa-check"></i> Tersalin!');
            setTimeout(function(){
                $('#btn-copy-link').html('<i class="fa fa-copy"></i> Salin Link');
            }, 2500);
        }).catch(function(){
            document.execCommand("copy");
            $('#copy-feedback').fadeIn(200);
        });
    }

    function bagikanWhatsApp(){
        var url = $('#input-public-url').val();
        var pesan = encodeURIComponent("Bapak/Ibu Guru Yang Terhormat,\n\nBerikut tautan portal monitoring dan telaah naskah butir soal ujian:\n" + url + "\n\nSilakan periksa butir soal mata pelajaran masing-masing. Berikan catatan koreksi bila ada kekeliruan, atau lakukan pengesahan (TTD verifikasi) bila naskah soal sudah sesuai standar. Terima kasih.");
        window.open('https://api.whatsapp.com/send?text=' + pesan, '_blank');
    }

    function refresh_table(){
        $('#table-soal').dataTable().fnReloadAjax();
    }

    function preview_soal(){
        var topik_id = $('#topik').val();
        if(topik_id && topik_id != 'kosong'){
            window.open('<?php echo site_url(); ?>/manager/modul_daftar/preview/'+topik_id, '_blank');
        } else {
            alert('Silakan pilih topik mata pelajaran terlebih dahulu.');
        }
    }

    function cetak_soal(){
        var topik_id = $('#topik').val();
        if(topik_id && topik_id != 'kosong'){
            window.open('<?php echo site_url(); ?>/manager/modul_daftar/cetak_soal/'+topik_id,'_blank');
        } else {
            alert('Silakan pilih topik mata pelajaran terlebih dahulu.');
        }
    }

    function refresh_topik(){
        var judul = $('#topik option:selected').text();
        var topik_id = $('#topik').val();
        $('#judul-daftar-soal').html(judul);

        if(topik_id && topik_id != 'kosong'){
            $('#btn-tulis-soal-topik').attr('href', '<?php echo site_url("manager/modul_soal?topik_id="); ?>' + topik_id);
            $('#btn-import-json-topik').attr('href', '<?php echo site_url("manager/modul_import_json?topik_id="); ?>' + topik_id);
            $('#btn-import-word-topik').attr('href', '<?php echo site_url("manager/modul_import_word?topik_id="); ?>' + topik_id);
        }
    }

    // Fungsi Pilih dan Scroll Langsung dari Tabel Monitoring
    function pilih_dan_lihat_soal(topik_id){
        if(topik_id){
            $('#topik').val(topik_id).trigger('change');
            $('html, body').animate({
                scrollTop: $("#panel-detail-soal").offset().top - 20
            }, 500);
        }
    }

    // Filter Status pada Tabel Monitoring
    var current_status = 'semua';
    function filter_status(status){
        current_status = status;
        $('#btn-group-status button').removeClass('active');
        if(status === 'semua') $('#btn-f-semua').addClass('active');
        else if(status === 'kosong') $('#btn-f-kosong').addClass('active');
        else if(status === 'kurang') $('#btn-f-kurang').addClass('active');
        else if(status === 'lengkap') $('#btn-f-lengkap').addClass('active');

        filter_table();
    }

    function filter_table(){
        var hari = $('#filter-hari').val().toUpperCase();
        var search = $('#filter-search').val().toLowerCase();

        $('#table-monitoring tbody tr.row-topik').each(function(){
            var row_status = $(this).attr('data-status');
            var row_hari = ($(this).attr('data-hari') || '').toUpperCase();
            var row_text = $(this).text().toLowerCase();

            var match_status = (current_status === 'semua' || row_status === current_status);
            var match_hari = (hari === '' || row_hari === hari);
            var match_search = (search === '' || row_text.indexOf(search) > -1);

            if(match_status && match_hari && match_search){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

    $(function(){
        $('#topik').select2({
            width: '100%',
            placeholder: "🔍 Ketik untuk mencari mata pelajaran..."
        });
        
        $("#topik").change(function(){
            refresh_table();
            refresh_topik();
        });

        $('#filter-hari, #filter-search').on('change keyup', function(){
            filter_table();
        });

        $('#table-soal').DataTable({
            "paging": true,
            "iDisplayLength": 10,
            "bProcessing": false,
            "bServerSide": true, 
            "searching": true,
            "aoColumns": [
                {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"100px"},
                {"bSearchable": false, "bSortable": false}
            ],
            "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
            "autoWidth": false,
            "fnServerParams": function ( aoData ) {
                aoData.push( { "name": "topik", "value": $('#topik').val()} );
            }
        });
		 
		$(document).ready(function() {
			refresh_topik();

            // Jika ada selected_topik dari controller, pilih otomatis
            <?php if(!empty($selected_topik)){ ?>
                pilih_dan_lihat_soal('<?php echo $selected_topik; ?>');
            <?php } ?>
		});
    });
</script>