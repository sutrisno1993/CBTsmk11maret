<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Jadwal Pelaksanaan Ujian - <?php echo $cbt_nama; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/plugins/font-awesome/css/font-awesome.min.css">
	<style type="text/css">
		body {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			color: #000;
			background: #fff;
			padding: 20px;
		}
		.kop-surat {
			text-align: center;
			border-bottom: 2px solid #000;
			padding-bottom: 10px;
			margin-bottom: 20px;
		}
		.kop-surat h2 {
			margin: 0;
			font-size: 20px;
			font-weight: bold;
			text-transform: uppercase;
		}
		.kop-surat h4 {
			margin: 4px 0 0 0;
			font-size: 14px;
			font-weight: normal;
		}
		.kop-surat p {
			margin: 2px 0 0 0;
			font-size: 11px;
			color: #333;
		}
		.table-jadwal {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 25px;
		}
		.table-jadwal th, .table-jadwal td {
			border: 1px solid #000;
			padding: 6px 8px;
			font-size: 11px;
		}
		.table-jadwal th {
			background-color: #eee !important;
			text-align: center;
			font-weight: bold;
		}
		.header-hari {
			background-color: #ddd !important;
			font-size: 12px;
			font-weight: bold;
			padding: 6px 10px;
			border: 1px solid #000;
			border-bottom: none;
			margin-top: 15px;
		}
		.badge-rombel {
			display: inline-block;
			padding: 2px 5px;
			margin: 1px 2px 1px 0;
			border: 1px solid #444;
			border-radius: 3px;
			font-size: 10px;
			font-weight: bold;
		}
		.ttd-area {
			margin-top: 30px;
			float: right;
			text-align: center;
			width: 250px;
		}
		@media print {
			body {
				padding: 0;
			}
			.no-print {
				display: none !important;
			}
			.page-break {
				page-break-before: always;
			}
		}
	</style>
</head>
<body>

	<!-- Tombol Cetak (Hanya tampil di layar) -->
	<div class="no-print" style="margin-bottom: 20px; padding: 10px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 4px;">
		<button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Dokumen / Simpan PDF</button>
		<button onclick="window.close()" class="btn btn-default btn-sm"><i class="fa fa-times"></i> Tutup Halaman</button>
		<span class="text-muted" style="margin-left: 15px;">Tips: Gunakan ukuran kertas A4 / F4 dengan orientasi Landscape atau Portrait.</span>
	</div>

	<!-- Kop Dokumen -->
	<div class="kop-surat">
		<h2><?php echo strtoupper($cbt_nama); ?></h2>
		<h4>JADWAL PELAKSANAAN UJIAN BERBASIS KOMPUTER (CBT)</h4>
		<p><?php echo $cbt_keterangan; ?> | Dicetak pada: <?php echo date('d-m-Y H:i'); ?> WIB</p>
	</div>

	<?php if(empty($jadwal_harian)){ ?>
		<div class="alert alert-warning text-center">
			Tidak ada jadwal ujian untuk ditampilkan.
		</div>
	<?php } else { ?>

		<?php 
		$hari_indo = array(
			'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
			'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
		);
		$bulan_indo = array(
			'01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni',
			'07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'
		);

		foreach($jadwal_harian as $tgl_key => $list_tes){ 
			$nama_hari = date('l', strtotime($tgl_key));
			$hari_str = isset($hari_indo[$nama_hari]) ? $hari_indo[$nama_hari] : $nama_hari;
			$d = date('d', strtotime($tgl_key));
			$m = date('m', strtotime($tgl_key));
			$y = date('Y', strtotime($tgl_key));
			$tgl_lengkap = $hari_str . ', ' . $d . ' ' . (isset($bulan_indo[$m]) ? $bulan_indo[$m] : $m) . ' ' . $y;
		?>

		<div class="header-hari">
			<i class="fa fa-calendar"></i> HARI &amp; TANGGAL: <?php echo strtoupper($tgl_lengkap); ?>
		</div>
		<table class="table-jadwal">
			<thead>
				<tr>
					<th style="width: 35px;">NO</th>
					<th style="width: 110px;">JAM / SESI</th>
					<th style="width: 60px;">DURASI</th>
					<th style="width: 220px;">MATA PELAJARAN / TOPIK</th>
					<th>ROMBEL YANG MENGIKUTI</th>
					<th style="width: 65px;">TOKEN</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				foreach($list_tes as $tes){ 
				?>
				<tr>
					<td style="text-align: center; font-weight: bold;"><?php echo $no++; ?></td>
					<td style="text-align: center; font-weight: bold;">
						<?php if(!empty($tes['shift'])){ echo '<span style="display:block; font-size:10px; font-weight:bold; color:#d9534f;">Shift '.$tes['shift'].'</span>'; } ?>
						<?php if(!empty($tes['jam_ke'])){ echo '<span style="display:block; font-size:10px; color:#333;">['.$tes['jam_ke'].']</span>'; } ?>
						<?php echo $tes['sesi_waktu']; ?> WIB
					</td>
					<td style="text-align: center;"><?php echo $tes['durasi']; ?> Mnt</td>
					<td>
						<strong><?php echo $tes['tes_nama']; ?></strong>
						<?php 
						if(!empty($tes['mapel'])){
							echo '<br /><span style="font-size: 10px; color: #333;">';
							foreach($tes['mapel'] as $m){
								echo '• ['.$m['modul'].'] '.$m['topik'].' ('.$m['jumlah_soal'].' Soal)<br />';
							}
							echo '</span>';
						}
						?>
					</td>
					<td>
						<?php 
						if(!empty($tes['grup'])){
							foreach($tes['grup'] as $g){
								echo '<span class="badge-rombel">'.$g.'</span> ';
							}
							echo '<br /><small style="color: #666;">(Total: '.count($tes['grup']).' Rombel - '.$tes['total_target'].' Siswa)</small>';
						} else {
							echo '-';
						}
						?>
					</td>
					<td style="text-align: center;">
						<?php echo ($tes['token']==1) ? 'YA' : 'TIDAK'; ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<?php } ?>

		<!-- Tanda Tangan Panitia -->
		<div class="ttd-area">
			<p>Mengetahui,<br />Ketua Panitia / Proktor</p>
			<br /><br /><br />
			<p><strong>( .................................................... )</strong><br />NIP. </p>
		</div>
		<div style="clear: both;"></div>

	<?php } ?>

</body>
</html>
