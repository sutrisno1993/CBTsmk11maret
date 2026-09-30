<!-- Content Header (Page header) -->
<section class="content-header no-print">
	<h1>
		Preview Soal (Quality Control)
		<small>Cek redaksi soal, opsi jawaban, dan kunci jawaban sebelum diujikan</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('manager/dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url('manager/modul_daftar'); ?>">Daftar Soal</a></li>
		<li class="active">Preview Soal</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row no-print" style="margin-bottom: 15px;">
        <div class="col-xs-12">
            <div class="box box-solid" style="border-radius: 8px; border-left: 5px solid #1e3c72; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <div class="box-body" style="padding: 16px 20px;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-7 col-sm-12">
                            <h3 style="margin: 0 0 6px 0; font-weight: 700; color: #1e3c72; font-size: 20px;">
                                <i class="fa fa-file-text-o"></i> <?php echo htmlspecialchars($topik->topik_nama); ?>
                            </h3>
                            <div style="font-size: 13px; color: #555;">
                                <span class="label label-primary" style="font-size: 12px; padding: 4px 8px; border-radius: 4px;">
                                    Modul: <?php echo htmlspecialchars($topik->modul_nama); ?>
                                </span>
                                &nbsp;&bull;&nbsp;
                                <strong>Total Soal:</strong> <?php echo count($soal_list); ?> butir soal
                                <?php if(!empty($topik->topik_detail)): ?>
                                    &nbsp;&bull;&nbsp; <span class="text-muted"><?php echo htmlspecialchars($topik->topik_detail); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 text-right" style="margin-top: 10px;">
                            <a href="<?php echo site_url('manager/modul_daftar'); ?>" class="btn btn-default" style="border-radius: 6px; font-weight: 600;">
                                <i class="fa fa-arrow-left"></i> Kembali ke Bank Soal
                            </a>
                            <button type="button" class="btn btn-primary" onclick="window.print();" style="border-radius: 6px; font-weight: 600; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none;">
                                <i class="fa fa-print"></i> Cetak / Simpan PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Petunjuk QC Guru -->
            <div class="alert alert-warning alert-dismissible" style="border-radius: 8px; background-color: #fff9e6; border-color: #ffe082; color: #856404; font-size: 13px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-lightbulb-o" style="font-size: 16px; margin-right: 6px;"></i>
                <strong>Petunjuk Quality Control Guru:</strong> Periksa naskah soal di bawah ini. Pastikan tidak ada kesalahan ketik (typo), kalimat ambigu, atau gambar yang terpotong. Kunci jawaban pilihan ganda ditandai dengan kotak hijau bertuliskan <strong>[KUNCI JAWABAN BENAR]</strong>. Jika ada kekeliruan, klik tombol <strong>Edit Soal Ini</strong> di kanan kartu untuk memperbaikinya secara langsung.
            </div>
        </div>
    </div>

    <!-- Tampilan Header Khusus Saat Print -->
    <div class="print-only" style="display: none; border-bottom: 2px solid #000; padding-bottom: 12px; margin-bottom: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 70%;">
                    <h2 style="margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase;">NASKAH QUALITY CONTROL SOAL</h2>
                    <div style="font-size: 14px; margin-top: 4px;">Mata Pelajaran (Topik): <strong><?php echo htmlspecialchars($topik->topik_nama); ?></strong></div>
                    <div style="font-size: 12px; color: #444;">Modul: <?php echo htmlspecialchars($topik->modul_nama); ?></div>
                </td>
                <td style="width: 30%; text-align: right; vertical-align: top; font-size: 12px;">
                    <div>Tanggal Cetak: <?php echo date('d-m-Y H:i'); ?></div>
                    <div>Jumlah Soal: <?php echo count($soal_list); ?> Butir</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Daftar Butir Soal -->
    <div class="row">
        <div class="col-xs-12">
            <?php if(empty($soal_list)): ?>
                <div class="box box-solid">
                    <div class="box-body text-center" style="padding: 50px 20px;">
                        <i class="fa fa-folder-open-o" style="font-size: 48px; color: #ccc;"></i>
                        <h4 style="color: #777; margin-top: 15px;">Belum Ada Soal di Topik Ini</h4>
                        <p class="text-muted">Silakan tambahkan butir soal atau import soal melalui menu Soal atau Import Spreadsheet/Word.</p>
                        <a href="<?php echo site_url('manager/modul_soal'); ?>" class="btn btn-primary" style="margin-top: 10px;">
                            <i class="fa fa-plus"></i> Tambah Soal Sekarang
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php $no = 1; ?>
                <?php foreach($soal_list as $item): ?>
                    <?php 
                        $s = $item['soal']; 
                        $jawaban = $item['jawaban'];

                        // Format teks soal
                        $detail_soal = str_replace("[base_url]", base_url(), $s->soal_detail);
                    ?>
                    <div class="box box-default soal-card" id="soal-<?php echo $s->soal_id; ?>" style="border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); margin-bottom: 22px; page-break-inside: avoid; border-top: 3px solid #d2d6de;">
                        <!-- Header Kartu Soal -->
                        <div class="box-header with-border" style="background-color: #fcfcfc; padding: 10px 18px; border-bottom: 1px solid #edf0f5;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span class="label" style="background-color: #1e3c72; font-size: 13px; font-weight: 700; padding: 5px 12px; border-radius: 4px;">
                                        SOAL NO. <?php echo $no++; ?>
                                    </span>
                                    &nbsp;
                                    <?php if($s->soal_tipe == 1): ?>
                                        <span class="label label-info" style="font-size: 11px; border-radius: 3px;">Pilihan Ganda</span>
                                    <?php elseif($s->soal_tipe == 2): ?>
                                        <span class="label label-warning" style="font-size: 11px; border-radius: 3px;">Essay / Uraian</span>
                                    <?php else: ?>
                                        <span class="label label-default" style="font-size: 11px; border-radius: 3px;">Jawaban Singkat</span>
                                    <?php endif; ?>

                                    &nbsp;
                                    <span class="text-muted" style="font-size: 11px;">
                                        (ID: #<?php echo $s->soal_id; ?> | Kesulitan: <?php 
                                            $diff = array(1=>'Sangat Mudah', 2=>'Mudah', 3=>'Sedang', 4=>'Sulit', 5=>'Sangat Sulit');
                                            echo isset($diff[$s->soal_difficulty]) ? $diff[$s->soal_difficulty] : 'Normal';
                                        ?>)
                                    </span>
                                </div>
                                <div class="no-print">
                                    <a href="<?php echo site_url('manager/modul_soal/index/'.$s->soal_id); ?>" target="_blank" class="btn btn-xs btn-default text-primary" style="font-weight: 600; border: 1px solid #c5d0de; padding: 3px 10px; border-radius: 4px;" title="Buka form edit untuk memperbaiki salah ketik atau kunci jawaban">
                                        <i class="fa fa-pencil text-yellow"></i> <strong>Edit Soal Ini (Koreksi)</strong>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Isi Teks Soal -->
                        <div class="box-body" style="padding: 20px 22px;">
                            <div class="teks-soal" style="font-size: 15px; line-height: 1.7; color: #222; margin-bottom: 18px;">
                                <?php echo $detail_soal; ?>
                            </div>

                            <!-- Pemutar Audio jika ada -->
                            <?php if(!empty($s->soal_audio)): ?>
                                <div style="background: #f7f9fa; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; border-left: 4px solid #3c8dbc; display: inline-block;">
                                    <label style="font-size: 12px; margin-bottom: 4px; display: block; color: #555;">
                                        <i class="fa fa-volume-up text-primary"></i> File Audio Soal:
                                    </label>
                                    <audio controls style="height: 34px;">
                                        <source src="<?php echo base_url().$this->config->item('upload_path').'/topik_'.$s->soal_topik_id.'/'.$s->soal_audio; ?>" type="audio/mpeg">
                                        Browser Anda tidak mendukung audio player.
                                    </audio>
                                </div>
                            <?php endif; ?>

                            <!-- Opsi Jawaban untuk Pilihan Ganda -->
                            <?php if($s->soal_tipe == 1): ?>
                                <div class="daftar-opsi" style="margin-top: 15px;">
                                    <div style="font-size: 12px; font-weight: 700; color: #666; text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">
                                        Pilihan Jawaban:
                                    </div>
                                    <div class="row">
                                        <?php 
                                            $abjad = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
                                            $idx = 0;
                                        ?>
                                        <?php foreach($jawaban as $j): ?>
                                            <?php 
                                                $huruf = isset($abjad[$idx]) ? $abjad[$idx] : ($idx + 1);
                                                $is_benar = ($j->jawaban_benar == 1);
                                                $teks_jawaban = str_replace("[base_url]", base_url(), $j->jawaban_detail);
                                                $idx++;
                                            ?>
                                            <div class="col-xs-12" style="margin-bottom: 8px;">
                                                <div class="opsi-box <?php echo $is_benar ? 'opsi-benar' : ''; ?>" style="display: flex; align-items: flex-start; padding: 10px 14px; border-radius: 6px; border: <?php echo $is_benar ? '2px solid #28a745' : '1px solid #e2e6ea'; ?>; background-color: <?php echo $is_benar ? '#f0fff4' : '#ffffff'; ?>; transition: all 0.2s;">
                                                    <span class="badge" style="background-color: <?php echo $is_benar ? '#28a745' : '#6c757d'; ?>; font-size: 13px; font-weight: 700; min-width: 28px; height: 28px; line-height: 20px; border-radius: 50%; margin-right: 12px; flex-shrink: 0; text-align: center;">
                                                        <?php echo $huruf; ?>
                                                    </span>
                                                    <div style="flex-grow: 1; font-size: 14px; color: <?php echo $is_benar ? '#155724' : '#333'; ?>; line-height: 1.5; padding-top: 2px;">
                                                        <?php echo $teks_jawaban; ?>
                                                    </div>
                                                    <?php if($is_benar): ?>
                                                        <span class="label label-success" style="font-size: 11px; padding: 5px 10px; border-radius: 4px; flex-shrink: 0; margin-left: 10px; font-weight: bold; background-color: #28a745 !important;">
                                                            <i class="fa fa-check"></i> KUNCI JAWABAN BENAR
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                            <!-- Untuk Essay / Uraian -->
                            <?php elseif($s->soal_tipe == 2): ?>
                                <div style="background-color: #fffbf0; border: 1px dashed #ffd54f; border-radius: 6px; padding: 14px 18px; margin-top: 10px;">
                                    <div style="font-size: 12px; font-weight: 700; color: #b78103; margin-bottom: 5px;">
                                        <i class="fa fa-pencil-square-o"></i> PEDOMAN JAWABAN ESSAY / KUNCI JAWABAN:
                                    </div>
                                    <div style="font-size: 13px; color: #444; font-style: italic;">
                                        <?php echo !empty($s->soal_kunci) ? nl2br(htmlspecialchars($s->soal_kunci)) : '(Tidak ada kunci jawaban spesifik - dinilai secara manual oleh Guru pada menu Evaluasi Tes).'; ?>
                                    </div>
                                </div>

                            <!-- Untuk Jawaban Singkat -->
                            <?php else: ?>
                                <div style="background-color: #e8f4fd; border: 1px dashed #90caf9; border-radius: 6px; padding: 14px 18px; margin-top: 10px;">
                                    <div style="font-size: 12px; font-weight: 700; color: #1565c0; margin-bottom: 5px;">
                                        <i class="fa fa-key"></i> KUNCI JAWABAN SINGKAT YANG DICOCOKKAN SISTEM:
                                    </div>
                                    <div style="font-size: 14px; font-weight: 700; color: #0d47a1;">
                                        <?php echo !empty($s->soal_kunci) ? htmlspecialchars($s->soal_kunci) : '-'; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<style type="text/css">
    .teks-soal img, .daftar-opsi img {
        max-width: 100% !important;
        height: auto !important;
        display: inline-block;
        border-radius: 4px;
        margin: 6px 0;
    }
    .soal-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        border-top-color: #1e3c72 !important;
    }

    @media print {
        .no-print, .main-header, .main-sidebar, .main-footer, .content-header {
            display: none !important;
        }
        .content-wrapper, .content {
            padding: 0 !important;
            margin: 0 !important;
            background: #fff !important;
        }
        .print-only {
            display: block !important;
        }
        .soal-card {
            border: 1px solid #999 !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
            page-break-inside: avoid !important;
        }
        .opsi-box {
            border: 1px solid #bbb !important;
            background: #fff !important;
        }
        .opsi-box.opsi-benar {
            border: 2px solid #000 !important;
            background: #eee !important;
            font-weight: bold !important;
        }
    }
</style>
