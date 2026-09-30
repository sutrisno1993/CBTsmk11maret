<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Jadwal & Matriks Tes
		<small>Pemetaan jadwal pelaksanaan ujian, mata pelajaran, sesi, dan rombel peserta</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/manager"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Jadwal & Matriks Tes</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<!-- Filter & Toolbar -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title"><i class="fa fa-filter"></i> Filter & Aksi Jadwal</h3>
			<div class="box-tools pull-right">
				<a href="<?php echo site_url($url.'/cetak?tanggal='.$filter_tgl); ?>" target="_blank" class="btn btn-primary btn-sm">
					<i class="fa fa-print"></i> Cetak Jadwal / PDF
				</a>
			</div>
		</div>
		<div class="box-body">
			<form method="GET" action="<?php echo site_url($url); ?>" class="form-inline" id="form-filter">
				<div class="form-group">
					<label for="filter-tanggal" style="margin-right: 10px;">Pilih Tanggal Ujian : </label>
					<select name="tanggal" id="filter-tanggal" class="form-control input-sm" onchange="this.form.submit()">
						<option value="semua" <?php if($filter_tgl=='semua'){ echo 'selected'; } ?>>-- Tampilkan Semua Hari / Tanggal --</option>
						<?php 
						if(!empty($daftar_tanggal)){
							foreach($daftar_tanggal as $row_tgl){
								$nama_hari = date('l', strtotime($row_tgl->tgl_tes));
								$hari_indo = array(
									'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
									'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
								);
								$hari_str = isset($hari_indo[$nama_hari]) ? $hari_indo[$nama_hari] : $nama_hari;
								$tgl_formatted = date('d-m-Y', strtotime($row_tgl->tgl_tes));
								$selected = ($filter_tgl == $row_tgl->tgl_tes) ? 'selected' : '';
								echo '<option value="'.$row_tgl->tgl_tes.'" '.$selected.'>'.$hari_str.', '.$tgl_formatted.' ('.$row_tgl->jml_tes.' Tes)</option>';
							}
						}
						?>
					</select>
				</div>
				<noscript><button type="submit" class="btn btn-default btn-sm">Terapkan</button></noscript>
			</form>
		</div>
	</div>

	<?php if(empty($jadwal_harian)){ ?>
		<div class="callout callout-info">
			<h4><i class="fa fa-info-circle"></i> Tidak Ada Jadwal</h4>
			<p>Tidak ditemukan jadwal tes untuk filter tanggal yang dipilih. Silakan ubah filter tanggal atau tambahkan tes baru di menu <strong>Data Tes &gt; Tambah Tes</strong>.</p>
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

		<div class="box box-primary box-solid" style="margin-bottom: 25px;">
			<div class="box-header with-border">
				<h3 class="box-title">
					<i class="fa fa-calendar-check-o"></i> <strong><?php echo strtoupper($tgl_lengkap); ?></strong>
				</h3>
				<div class="box-tools pull-right">
					<span class="badge bg-aqua"><?php echo count($list_tes); ?> Sesi Ujian</span>
				</div>
			</div>
			<div class="box-body no-padding table-responsive">
				<table class="table table-bordered table-striped table-hover" style="margin-bottom: 0;">
					<thead>
						<tr style="background-color: #f4f4f4;">
							<th style="width: 50px; text-align: center;">No</th>
							<th style="width: 140px; text-align: center;"><i class="fa fa-clock-o"></i> Sesi / Waktu</th>
							<th style="width: 250px;"><i class="fa fa-file-text-o"></i> Nama Tes &amp; Mapel</th>
							<th><i class="fa fa-users"></i> Rombel yang Mengikuti</th>
							<th style="width: 130px; text-align: center;"><i class="fa fa-bar-chart"></i> Partisipasi</th>
							<th style="width: 130px; text-align: center;"><i class="fa fa-tag"></i> Status</th>
							<th style="width: 90px; text-align: center;">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						foreach($list_tes as $tes){ 
						?>
						<tr>
							<td style="text-align: center; vertical-align: middle; font-weight: bold;"><?php echo $no++; ?></td>
							
							<!-- Waktu / Sesi -->
							<td style="text-align: center; vertical-align: middle;">
								<?php if(!empty($tes['shift'])){ 
									$shift_badge = (strtolower($tes['shift'])=='pagi') ? 'label-warning' : 'label-danger';
									$shift_icon = (strtolower($tes['shift'])=='pagi') ? 'fa-sun-o' : 'fa-cloud';
								?>
									<span class="label <?php echo $shift_badge; ?>" style="display:inline-block; margin-bottom: 3px; font-size: 11px;"><i class="fa <?php echo $shift_icon; ?>"></i> Shift <?php echo $tes['shift']; ?></span><br />
								<?php } ?>
								<?php if(!empty($tes['jam_ke'])){ ?>
									<span class="label label-primary" style="display:inline-block; margin-bottom: 4px; font-size: 12px;"><i class="fa fa-tag"></i> <?php echo $tes['jam_ke']; ?></span><br />
								<?php } ?>
								<span style="font-size: 14px; font-weight: bold; color: #0073b7;">
									<?php echo $tes['sesi_waktu']; ?>
								</span>
								<br />
								<small class="text-muted"><i class="fa fa-hourglass-half"></i> <?php echo $tes['durasi']; ?> Menit</small>
								<?php if($tes['token']==1){ ?>
									<br /><span class="label label-danger" title="Ujian membutuhkan token"><i class="fa fa-key"></i> Token Aktif</span>
								<?php } ?>
							</td>

							<!-- Nama Tes & Mapel -->
							<td style="vertical-align: middle;">
								<span style="font-size: 14.5px; font-weight: bold; color: #333;">
									<?php echo $tes['tes_nama']; ?>
								</span>
								<?php if(!empty($tes['hari'])){ ?>
									&nbsp;<span class="label label-info" style="font-size: 11px;"><?php echo $tes['hari']; ?></span>
								<?php } ?>
								<?php if(!empty($tes['tes_detail'])){ ?>
									<div class="text-muted" style="font-size: 12px; margin-top: 2px;"><?php echo $tes['tes_detail']; ?></div>
								<?php } ?>
								<div style="margin-top: 6px;">
									<?php 
									if(!empty($tes['mapel'])){
										foreach($tes['mapel'] as $m){
											echo '<span class="label label-info" style="display:inline-block; margin-right:4px; margin-bottom:2px; font-weight:normal;">';
											echo '<i class="fa fa-book"></i> '.$m['modul'].' &rsaquo; '.$m['topik'].' ('.$m['jumlah_soal'].' Soal)';
											echo '</span> ';
										}
									} else {
										echo '<span class="text-danger" style="font-size:11px;">Belum ada topik soal disematkan</span>';
									}
									?>
								</div>
							</td>

							<!-- Rombel / Group -->
							<td style="vertical-align: middle;">
								<?php 
								if(!empty($tes['grup'])){
									echo '<div style="line-height: 24px;">';
									foreach($tes['grup'] as $g){
										echo '<span class="label label-success" style="font-size: 12px; margin-right: 4px; display: inline-block;">';
										echo '<i class="fa fa-graduation-cap"></i> '.$g;
										echo '</span> ';
									}
									echo '</div>';
									echo '<small class="text-muted">Total: '.count($tes['grup']).' Rombel</small>';
								} else {
									echo '<span class="label label-danger">Belum ada rombel dipilih</span>';
								}
								?>
							</td>

							<!-- Partisipasi Siswa -->
							<td style="text-align: center; vertical-align: middle;">
								<span style="font-size: 14px; font-weight: bold;"><?php echo $tes['total_ikut']; ?> / <?php echo $tes['total_target']; ?></span>
								<br />
								<small class="text-muted">Siswa (<?php echo $tes['total_selesai']; ?> Selesai)</small>
							</td>

							<!-- Status -->
							<td style="text-align: center; vertical-align: middle;">
								<span class="label <?php echo $tes['status_badge']; ?>" style="font-size: 11px; padding: 5px 8px;">
									<?php echo $tes['status_label']; ?>
								</span>
							</td>

							<!-- Aksi Pintas -->
							<td style="text-align: center; vertical-align: middle;">
								<div class="btn-group">
									<a href="<?php echo site_url('manager/tes_hasil?tes='.$tes['tes_id']); ?>" class="btn btn-default btn-xs" title="Lihat Hasil / Pantau">
										<i class="fa fa-bar-chart"></i>
									</a>
									<?php if($tes['token']==1){ ?>
									<a href="<?php echo site_url('manager/tes_token'); ?>" class="btn btn-default btn-xs text-yellow" title="Buka Menu Token">
										<i class="fa fa-key"></i>
									</a>
									<?php } ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<?php } ?>

	<?php } ?>
</section>
