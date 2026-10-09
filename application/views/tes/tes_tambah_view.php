<style>
.smart-group-box {
    border: 1px solid #d2d6de;
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.06);
}
.filter-pill-btn {
    border-radius: 12px !important;
    padding: 2px 9px !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    margin-right: 4px;
    margin-bottom: 4px;
    transition: all 0.15s ease-in-out;
}
.group-card {
    display: flex;
    align-items: center;
    padding: 7px 10px;
    border: 1px solid #d9e2ec;
    border-radius: 5px;
    background: #fff;
    cursor: pointer;
    margin-bottom: 0;
    font-weight: normal;
    transition: all 0.15s ease-in-out;
}
.group-card:hover {
    border-color: #3c8dbc !important;
    background-color: #f0f7fd !important;
}
.group-card.item-checked {
    border-color: #00a65a !important;
    background-color: #eef9f2 !important;
    box-shadow: 0 1px 3px rgba(0, 166, 90, 0.15);
}
.group-card input[type="checkbox"] {
    margin: 0 8px 0 0;
    cursor: pointer;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Tes
		<small>Menambah tes, mengubah tes, dan menghapus tes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Tambah tes</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
            <div class="box">
                <?php echo form_open($url.'/tambah_tes','id="form-tambah-tes"  class="form-horizontal"'); ?>
                <div class="box-header with-border">
                    <div class="box-title">Mengelola Tes</div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="col-xs-6">
                        <div id="form-pesan-tes"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="tambah-id" id="tambah-id" />
                                <input type="hidden" name="tambah-nama-lama" id="tambah-nama-lama" />
                                <input type="text" name="tambah-nama" id="tambah-nama" class="form-control input-sm" placeholder="Contoh: PENILAIAN SUMATIF TENGAH SEMESTER (PSTS) GANJIL" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-9">
                                <textarea name="tambah-deskripsi" id="tambah-deskripsi" class="form-control input-sm" placeholder="Keterangan pelaksanaan tes"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tanggal Ujian</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="date" id="preset-tanggal" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>" />
                                </div>
                                <p class="help-block">Pilih tanggal untuk otomatis menentukan Hari dan Rentang Waktu</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Hari</label>
                            <div class="col-sm-9">
                                <select name="tambah-hari" id="tambah-hari" class="form-control input-sm">
                                    <option value="">- Pilih Hari -</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                                <p class="help-block">Hari pelaksanaan tes (otomatis dari tanggal atau pilih manual)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Shift</label>
                            <div class="col-sm-9">
                                <select name="tambah-shift" id="tambah-shift" class="form-control input-sm">
                                    <option value="">- Pilih Shift -</option>
                                    <option value="Pagi">Shift Pagi</option>
                                    <option value="Siang">Shift Siang</option>
                                </select>
                                <p class="help-block">Shift pelaksanaan ujian (Pagi atau Siang)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jam Ke</label>
                            <div class="col-sm-9">
                                <select name="tambah-jam-ke" id="tambah-jam-ke" class="form-control input-sm">
                                    <option value="">- Pilih Jam Ke -</option>
                                    <option value="Jam Ke-1">Jam Ke-1</option>
                                    <option value="Jam Ke-2">Jam Ke-2</option>
                                    <option value="Jam Ke-3">Jam Ke-3</option>
                                </select>
                                <p class="help-block">Jam Ke dalam shift (otomatis mengatur rentang waktu & durasi)</p>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-3 control-label">Rentang Waktu</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" name="tambah-rentang-waktu" id="tambah-rentang-waktu" class="form-control input-sm" value="<?php if(!empty($rentang_waktu)){ echo $rentang_waktu; } ?>" readonly />
                                </div>
                                <p class="help-block">Otomatis terisi dari Hari/Shift/Jam Ke, atau klik untuk atur manual</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pilih Group / Kelas</label>
                            <div class="col-sm-9">
                                <div class="smart-group-box">
                                    <!-- Filter Toolbar -->
                                    <div style="background: #f7f9fa; padding: 10px 12px; border-bottom: 1px solid #e1e6eb;">
                                        <!-- Tingkat (Grade) Filter -->
                                        <div style="margin-bottom: 6px; display: flex; align-items: center; flex-wrap: wrap;">
                                            <span style="font-size: 11px; font-weight: bold; color: #555; text-transform: uppercase; margin-right: 8px;">
                                                <i class="fa fa-graduation-cap text-primary"></i> Tingkat:
                                            </span>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-xs filter-pill-btn btn-filter-tingkat active" data-tingkat="ALL">Semua</button>
                                                <button type="button" class="btn btn-default btn-xs filter-pill-btn btn-filter-tingkat" data-tingkat="X">Kelas X</button>
                                                <button type="button" class="btn btn-default btn-xs filter-pill-btn btn-filter-tingkat" data-tingkat="XI">Kelas XI</button>
                                                <button type="button" class="btn btn-default btn-xs filter-pill-btn btn-filter-tingkat" data-tingkat="XII">Kelas XII</button>
                                            </div>
                                        </div>

                                        <!-- Jurusan (Major) Filter -->
                                        <div style="margin-bottom: 8px; display: flex; align-items: center; flex-wrap: wrap;">
                                            <span style="font-size: 11px; font-weight: bold; color: #555; text-transform: uppercase; margin-right: 8px;">
                                                <i class="fa fa-briefcase text-primary"></i> Jurusan:
                                            </span>
                                            <div id="filter-jurusan-container" style="display: flex; flex-wrap: wrap;">
                                                <button type="button" class="btn btn-primary btn-xs filter-pill-btn btn-filter-jurusan active" data-jurusan="ALL">Semua Jurusan</button>
                                                <?php if(!empty($jurusan_list)){ foreach($jurusan_list as $jur){ ?>
                                                    <button type="button" class="btn btn-default btn-xs filter-pill-btn btn-filter-jurusan" data-jurusan="<?php echo htmlspecialchars($jur); ?>"><?php echo htmlspecialchars($jur); ?></button>
                                                <?php } } ?>
                                            </div>
                                        </div>

                                        <!-- Search & Action Toolbar -->
                                        <div class="row" style="margin-left: -4px; margin-right: -4px;">
                                            <div class="col-xs-7" style="padding-left: 4px; padding-right: 4px;">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-addon" style="background:#fff; border-right:none; padding: 4px 8px;"><i class="fa fa-search text-muted"></i></span>
                                                    <input type="text" id="filter-grup-search" class="form-control input-sm" placeholder="🔍 Ketik cari nama kelas..." style="border-left:none;">
                                                </div>
                                            </div>
                                            <div class="col-xs-5 text-right" style="padding-left: 4px; padding-right: 4px;">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" id="btn-select-all-filtered" class="btn btn-default btn-sm" title="Pilih semua kelas yang tampil" style="font-size: 11px; padding: 4px 7px;">
                                                        <i class="fa fa-check-square-o text-green"></i> Pilih Semua
                                                    </button>
                                                    <button type="button" id="btn-deselect-all-filtered" class="btn btn-default btn-sm" title="Batal pilih kelas yang tampil" style="font-size: 11px; padding: 4px 7px;">
                                                        <i class="fa fa-square-o text-red"></i> Batal
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Bar -->
                                    <div style="background: #eef2f7; padding: 5px 12px; font-size: 11px; border-bottom: 1px solid #e1e6eb; display:flex; justify-content:space-between; align-items:center;">
                                        <div class="text-muted">
                                            Menampilkan <b id="stat-grup-visible" class="text-dark">0</b> dari <b id="stat-grup-total" class="text-dark">0</b> kelas
                                        </div>
                                        <div>
                                            <span class="badge bg-green" id="stat-grup-selected" style="font-size: 11px; padding: 3px 8px;">0 Kelas Terpilih</span>
                                        </div>
                                    </div>

                                    <!-- Group Cards Container -->
                                    <div id="group-list-container" style="max-height: 240px; overflow-y: auto; padding: 8px; background: #fafbfc;">
                                        <div class="row" id="group-cards-row" style="margin-left: -4px; margin-right: -4px;">
                                            <?php 
                                            if(!empty($group_list)){ 
                                                foreach($group_list as $g){ 
                                                    $isChecked = !empty($g['selected']) ? 'checked' : '';
                                                    $activeClass = !empty($g['selected']) ? 'item-checked' : '';
                                            ?>
                                                <div class="col-xs-6 group-item" 
                                                     data-id="<?php echo $g['id']; ?>"
                                                     data-nama="<?php echo htmlspecialchars(strtolower($g['nama'])); ?>"
                                                     data-tingkat="<?php echo htmlspecialchars($g['tingkat']); ?>"
                                                     data-jurusan="<?php echo htmlspecialchars($g['jurusan']); ?>"
                                                     style="padding-left: 4px; padding-right: 4px; margin-bottom: 6px;">
                                                    <label class="group-card <?php echo $activeClass; ?>">
                                                        <input type="checkbox" name="tambah-group[]" value="<?php echo $g['id']; ?>" class="check-group" <?php echo $isChecked; ?>>
                                                        <div style="flex: 1; min-width: 0;">
                                                            <div style="font-weight: 600; font-size: 12px; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                                <?php echo htmlspecialchars($g['nama']); ?>
                                                            </div>
                                                            <div style="margin-top: 2px;">
                                                                <?php 
                                                                    if(!empty($g['tingkat'])){ echo '<span class="label label-default" style="font-size:9px; padding:1px 4px; margin-right:3px;">Kelas '.$g['tingkat'].'</span>'; }
                                                                    if(!empty($g['jurusan'])){ echo '<span class="label label-info" style="font-size:9px; padding:1px 4px;">'.$g['jurusan'].'</span>'; }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            <?php 
                                                } 
                                            } else { 
                                            ?>
                                                <div class="col-xs-12 text-center text-muted" style="padding: 20px;">
                                                    Belum ada data grup/kelas yang tersedia.
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div id="group-empty-search" class="text-center text-muted" style="display: none; padding: 25px 10px;">
                                            <i class="fa fa-filter" style="font-size: 24px; color: #ccc; display:block; margin-bottom: 6px;"></i>
                                            Tidak ada kelas yang cocok dengan filter yang aktif.
                                        </div>
                                    </div>
                                </div>
                                <p class="help-block" style="margin-top: 4px; font-size: 11px;">
                                    <i class="fa fa-info-circle text-primary"></i> Klik tombol Tingkat & Jurusan di atas untuk memilih rombel sekaligus secara instan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Waktu Tes</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" name="tambah-waktu" id="tambah-waktu" class="form-control input-sm" value="90" />
                                    <span class="input-group-addon">Menit</span>
                                </div>
                                <p class="help-block">Waktu durasi tes (otomatis dari jadwal sesi, bisa diubah manual)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Poin Dasar</label>
                            <div class="col-sm-9">
                                <input type="text" name="tambah-poin" id="tambah-poin" class="form-control input-sm" value="2.5" />
                                <p class="help-block">Poin per butir soal (Default: 2.5 x 40 butir = 100)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jawaban Salah</label>
                            <div class="col-sm-9">
                                <input type="text" name="tambah-poin-salah" id="tambah-poin-salah" class="form-control input-sm" value="0.00" />
                                <p class="help-block">Poin untuk jawaban salah</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jawaban Kosong</label>
                            <div class="col-sm-9">
                                <input type="text" name="tambah-poin-kosong" id="tambah-poin-kosong" class="form-control input-sm" value="0.00" />
                                <p class="help-block">Poin untuk jawaban kosong</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tunjukkan Hasil</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="tambah-tunjukkan-hasil" id="tambah-tunjukkan-hasil" value="1" checked>
                                <p class="help-block">Menunjukkan hasil nilai ke user saat tes sudah selesai</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Detail Hasil</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="tambah-detail-hasil" id="tambah-detail-hasil" value="1" >
                                <p class="help-block">Menunjukkan detail jawaban ke user saat tes sudah selesai</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Token</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="tambah-token" id="tambah-token" value="1" >
                                <p class="help-block">Saat awal tes, user memasukkan Token dari operator (Default: Tidak aktif)</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" id="btn-tambah-simpan" class="btn btn-primary pull-right">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row hide" id="kolom-soal">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Tambah Soal <div id="judul-tambah-soal"></div></div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-xs-6">
                        <?php echo form_open($url.'/tambah_soal','id="form-tambah-soal"  class="form-horizontal"'); ?>
                        <div id="form-pesan-soal"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modul</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="soal-tes-id" id="soal-tes-id">
                                <select class="form-control input-sm" id="soal-modul" name="soal-modul" >
                                    <?php if(!empty($select_modul)){ echo $select_modul; } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Topik</label>
                            <div class="col-sm-9">
                                <select style="width: 100%" class="form-control input-sm" id="soal-topik" name="soal-topik" >
                                    <div id="soal-topik-option">
                                     <option value="kosong">Pilih Topik</option>
                                    </div>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipe Soal</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" id="soal-tipe" name="soal-tipe" >
                                    <option value="1" selected>Pilihan Ganda</option>
                                    <option value="0">Semua</option>
                                    <option value="2">Essay</option>
                                    <option value="3">Jawaban Singkat</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tingkat Kesulitan</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" id="soal-kesulitan" name="soal-kesulitan" >
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jml Soal</label>
                            <div class="col-sm-9">
                                <input type="text" name="soal-jml" id="soal-jml" class="form-control input-sm" value="40" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jml Jawaban</label>
                            <div class="col-sm-9">
                                <input type="text" name="soal-jml-jawaban" id="soal-jml-jawaban" class="form-control input-sm" value="5" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Acak Soal</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="soal-acak-soal" id="soal-acak-soal" class="input-sm" value="1" checked="checked">
                                <p class="help-block">Mengacak urutan Soal Tes (Default: Aktif)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Acak Jawaban</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="soal-acak-jawaban" id="soal-acak-jawaban" class="input-sm" value="1">
                                <p class="help-block">Mengacak opsi pilihan Jawaban (Default: Tidak aktif)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" id="btn-tambah-soal" class="btn btn-primary pull-right">Tambah Soal</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="col-xs-6">
                        <table id="table-soal" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Topik</th>
                                    <th></th>
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
                <div class="box-footer">
                    <button type="button" id="btn-tambah-daftar" class="btn btn-default">Daftar Tes</button>
                    <button type="button" id="btn-tambah-selesai" class="btn btn-primary pull-right">Selesai</button>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-soal').dataTable().fnReloadAjax();
    }

    function reset_soal(){
        $('#soal-tipe').val('1');
        $('#soal-kesulitan').val('1');
        $('#soal-jml').val('40');
        $('#soal-jml-jawaban').val('5');
        $('#soal-acak-soal').prop('checked', true);
        $('#soal-acak-jawaban').prop('checked', false);
    }

    function applyPresetJadwal() {
        var tanggalStr = $('#preset-tanggal').val(); // YYYY-MM-DD
        var hari = $('#tambah-hari').val();
        var shift = $('#tambah-shift').val();
        var jamKe = $('#tambah-jam-ke').val();

        if (tanggalStr) {
            var dParts = tanggalStr.split('-');
            if (dParts.length === 3) {
                var dt = new Date(parseInt(dParts[0], 10), parseInt(dParts[1], 10) - 1, parseInt(dParts[2], 10));
                var namaHariArr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                var hariOtomatis = namaHariArr[dt.getDay()];
                if (hariOtomatis && (!hari || hari === '')) {
                    hari = hariOtomatis;
                    $('#tambah-hari').val(hari);
                }
            }
        }

        if (!tanggalStr) {
            var now = new Date();
            var y = now.getFullYear();
            var m = String(now.getMonth() + 1).padStart(2, '0');
            var d = String(now.getDate()).padStart(2, '0');
            tanggalStr = y + '-' + m + '-' + d;
            $('#preset-tanggal').val(tanggalStr);
        }

        if (!shift || !jamKe) {
            return;
        }

        var startTime = '';
        var endTime = '';
        var durasi = 90;

        var hLower = (hari || '').toLowerCase();

        if (hLower === 'rabu') {
            if (shift === 'Pagi') {
                if (jamKe === 'Jam Ke-1') { startTime = '07:30'; endTime = '09:00'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '09:00'; endTime = '10:00'; durasi = 60; }
                else if (jamKe === 'Jam Ke-3') { startTime = '10:30'; endTime = '11:30'; durasi = 60; }
            } else if (shift === 'Siang') {
                if (jamKe === 'Jam Ke-1') { startTime = '13:00'; endTime = '14:30'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '14:30'; endTime = '15:30'; durasi = 60; }
                else if (jamKe === 'Jam Ke-3') { startTime = '16:00'; endTime = '17:00'; durasi = 60; }
            }
        } else if (hLower === 'jumat') {
            if (shift === 'Pagi') {
                if (jamKe === 'Jam Ke-1') { startTime = '07:30'; endTime = '09:00'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '09:30'; endTime = '10:30'; durasi = 60; }
                else if (jamKe === 'Jam Ke-3') { startTime = '10:30'; endTime = '11:30'; durasi = 60; }
            } else if (shift === 'Siang') {
                if (jamKe === 'Jam Ke-1') { startTime = '13:30'; endTime = '15:00'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '15:30'; endTime = '16:30'; durasi = 60; }
                else if (jamKe === 'Jam Ke-3') { startTime = '16:30'; endTime = '17:30'; durasi = 60; }
            }
        } else {
            // Hari Senin, Selasa, Kamis, Sabtu, Minggu
            if (shift === 'Pagi') {
                if (jamKe === 'Jam Ke-1') { startTime = '07:30'; endTime = '09:00'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '09:30'; endTime = '11:00'; durasi = 90; }
                else if (jamKe === 'Jam Ke-3') { startTime = '11:15'; endTime = '12:45'; durasi = 90; }
            } else if (shift === 'Siang') {
                if (jamKe === 'Jam Ke-1') { startTime = '13:00'; endTime = '14:30'; durasi = 90; }
                else if (jamKe === 'Jam Ke-2') { startTime = '15:00'; endTime = '16:30'; durasi = 90; }
                else if (jamKe === 'Jam Ke-3') { startTime = '16:45'; endTime = '18:15'; durasi = 90; }
            }
        }

        if (startTime && endTime) {
            var rentangStr = tanggalStr + ' ' + startTime + ' - ' + tanggalStr + ' ' + endTime;
            $('#tambah-rentang-waktu').val(rentangStr);
            $('#tambah-waktu').val(durasi);

            var picker = $('#tambah-rentang-waktu').data('daterangepicker');
            if (picker) {
                picker.setStartDate(tanggalStr + ' ' + startTime);
                picker.setEndDate(tanggalStr + ' ' + endTime);
            }
        }
    }

    function refresh_topik(){
        $("#modal-proses").modal('show');
        var modul = $('#soal-modul').val();
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_topik_by_modul/'+modul, function(data){
            if(data.data==1){
                $('#soal-topik').html(data.select_topik).select2({
                    width: '100%',
                    placeholder: "🔍 Ketik untuk mencari topik ulangan..."
                });
                reset_soal();
                $('#soal-topik').trigger('change');
            }
            $("#modal-proses").modal('hide');
        });
    }

    function edit(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#tambah-id').val(data.id);
                $('#soal-tes-id').val(data.id);

                $('#tambah-nama').val(data.nama);
                $('#tambah-nama-lama').val(data.nama);
                $('#tambah-deskripsi').val(data.deskripsi);
                $('#tambah-waktu').val(data.waktu);
                $('#tambah-poin').val(data.poin);
                $('#tambah-poin-kosong').val(data.poin_kosong);
                $('#tambah-poin-salah').val(data.poin_salah);
                $('#tambah-rentang-waktu').val(data.rentang_waktu);
                if(data.rentang_waktu && data.rentang_waktu.length >= 10){
                    $('#preset-tanggal').val(data.rentang_waktu.substring(0, 10));
                }
                $('#tambah-hari').val(data.hari ? data.hari : '');
                $('#tambah-shift').val(data.shift ? data.shift : '');
                $('#tambah-jam-ke').val(data.jam_ke ? data.jam_ke : '');
                if(data.tunjukkan_hasil==1){
                    $('#tambah-tunjukkan-hasil').prop("checked", true);
                }else{
                    $('#tambah-tunjukkan-hasil').prop("checked", false);
                }
                if(data.detail_hasil==1){
                    $('#tambah-detail-hasil').prop("checked", true);
                }else{
                    $('#tambah-detail-hasil').prop("checked", false);
                }
                if(data.token==1){
                    $('#tambah-token').prop("checked", true);
                }else{
                    $('#tambah-token').prop("checked", false);
                }

                // Restore grup yang dipilih pada saat edit
                if(data.group_ids && data.group_ids.length > 0){
                    $('.check-group').prop('checked', false);
                    $.each(data.group_ids, function(i, gid){
                        $('.check-group[value="' + gid + '"]').prop('checked', true);
                    });
                }
                updateGroupSummary();

                refresh_topik();
                refresh_table();

                $('#kolom-soal').removeClass('hide');
            }
            $("#modal-proses").modal('hide');
        });
    }

    function hapus_soal(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/hapus_soal_by_id/'+id+'', function(data){
            if(data.data==1){
                notify_success(data.pesan);

                refresh_table();
            }else{
                notify_error(data.pesan);                
            }
            $("#modal-proses").modal('hide');
        });
    }

    var currentTingkatFilter = 'ALL';
    var currentJurusanFilter = 'ALL';

    function applyGroupFilters() {
        var query = ($('#filter-grup-search').val() || '').toLowerCase().trim();
        var visibleCount = 0;
        var totalCount = $('.group-item').length;

        $('.group-item').each(function() {
            var item = $(this);
            var nama = (item.data('nama') || '').toString().toLowerCase();
            var tingkat = (item.data('tingkat') || '').toString().toUpperCase();
            var jurusan = (item.data('jurusan') || '').toString().toUpperCase();

            var matchSearch = (query === '' || nama.indexOf(query) !== -1);
            var matchTingkat = (currentTingkatFilter === 'ALL' || tingkat === currentTingkatFilter);
            var matchJurusan = (currentJurusanFilter === 'ALL' || jurusan === currentJurusanFilter);

            if (matchSearch && matchTingkat && matchJurusan) {
                item.show();
                visibleCount++;
            } else {
                item.hide();
            }
        });

        $('#stat-grup-visible').text(visibleCount);
        $('#stat-grup-total').text(totalCount);
        if (visibleCount === 0 && totalCount > 0) {
            $('#group-empty-search').show();
        } else {
            $('#group-empty-search').hide();
        }
    }

    function updateGroupSummary() {
        var selectedCount = $('.check-group:checked').length;
        $('#stat-grup-selected').text(selectedCount + ' Kelas Terpilih');
        if(selectedCount > 0){
            $('#stat-grup-selected').removeClass('bg-gray').addClass('bg-green');
        } else {
            $('#stat-grup-selected').removeClass('bg-green').addClass('bg-gray');
        }

        // Sinkronisasi styling kartu
        $('.check-group').each(function() {
            var card = $(this).closest('.group-card');
            if ($(this).is(':checked')) {
                card.addClass('item-checked');
            } else {
                card.removeClass('item-checked');
            }
        });
    }

    function selesai(){
        $('#tambah-id').val('');
        $('#tambah-nama').val('');
        $('#tambah-nama-lama').val('');
        $('#tambah-deskripsi').val('');
        $('#tambah-waktu').val('90');
        $('#tambah-poin').val('2.5');
        $('#tambah-poin-kosong').val('0.00');
        $('#tambah-poin-salah').val('0.00');
        $('#tambah-token').prop("checked", false);
        $('#tambah-tunjukkan-hasil').prop("checked", true);
        $('#tambah-detail-hasil').prop("checked", false);
        $('#preset-tanggal').val('<?php echo date('Y-m-d'); ?>');
        $('#tambah-rentang-waktu').val('<?php if(!empty($rentang_waktu)){ echo $rentang_waktu; } ?>');
        $('#tambah-hari').val('');
        $('#tambah-shift').val('');
        $('#tambah-jam-ke').val('');
        
        // Reset pilihan group & filter
        $('.check-group').prop('checked', false);
        currentTingkatFilter = 'ALL';
        currentJurusanFilter = 'ALL';
        $('.btn-filter-tingkat').removeClass('btn-primary active').addClass('btn-default');
        $('.btn-filter-tingkat[data-tingkat="ALL"]').removeClass('btn-default').addClass('btn-primary active');
        $('.btn-filter-jurusan').removeClass('btn-primary active').addClass('btn-default');
        $('.btn-filter-jurusan[data-jurusan="ALL"]').removeClass('btn-default').addClass('btn-primary active');
        $('#filter-grup-search').val('');
        applyGroupFilters();
        updateGroupSummary();

        $('#soal-tes-id').val('');
        reset_soal();

        $('#kolom-soal').addClass('hide');
        $('#tambah-nama').focus();
    }

    $(function(){
        $('#tambah-rentang-waktu').daterangepicker({timePicker: true, timePicker12Hour: false, timePicker24Hour: true, timePickerIncrement: 10, format: 'YYYY-MM-DD HH:mm'});
        
        // Auto set hari & tanggal saat daterangepicker diubah manual
        $('#tambah-rentang-waktu').on('apply.daterangepicker', function(ev, picker) {
            var namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var hariTerpilih = namaHari[picker.startDate.day()];
            if(!$('#tambah-hari').val()){
                $('#tambah-hari').val(hariTerpilih);
            }
            $('#preset-tanggal').val(picker.startDate.format('YYYY-MM-DD'));
        });

        // Event listener preset penjadwalan otomatis
        $('#preset-tanggal').on('change input', function() {
            var tanggalStr = $(this).val();
            if (tanggalStr) {
                var dParts = tanggalStr.split('-');
                if (dParts.length === 3) {
                    var dt = new Date(parseInt(dParts[0], 10), parseInt(dParts[1], 10) - 1, parseInt(dParts[2], 10));
                    var namaHariArr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var hariOtomatis = namaHariArr[dt.getDay()];
                    if (hariOtomatis) {
                        $('#tambah-hari').val(hariOtomatis);
                    }
                }
            }
            applyPresetJadwal();
        });

        $('#tambah-hari, #tambah-shift, #tambah-jam-ke').on('change', function() {
            applyPresetJadwal();
        });

        // Inisialisasi tampilan Group Selector
        applyGroupFilters();
        updateGroupSummary();

        // Event Filter Tingkat
        $('.btn-filter-tingkat').click(function() {
            $('.btn-filter-tingkat').removeClass('btn-primary active').addClass('btn-default');
            $(this).removeClass('btn-default').addClass('btn-primary active');
            currentTingkatFilter = $(this).data('tingkat');
            applyGroupFilters();
        });

        // Event Filter Jurusan
        $('.btn-filter-jurusan').click(function() {
            $('.btn-filter-jurusan').removeClass('btn-primary active').addClass('btn-default');
            $(this).removeClass('btn-default').addClass('btn-primary active');
            currentJurusanFilter = $(this).data('jurusan');
            applyGroupFilters();
        });

        // Event Live Search
        $('#filter-grup-search').on('input propertychange', function() {
            applyGroupFilters();
        });

        // Event Checkbox Group Perubahan
        $(document).on('change', '.check-group', function() {
            updateGroupSummary();
        });

        // Tombol Pilih Semua yang Tampil
        $('#btn-select-all-filtered').click(function() {
            $('.group-item:visible .check-group').prop('checked', true);
            updateGroupSummary();
        });

        // Tombol Batal Pilih yang Tampil
        $('#btn-deselect-all-filtered').click(function() {
            $('.group-item:visible .check-group').prop('checked', false);
            updateGroupSummary();
        });

        $('#btn-tambah-selesai').click(function(){
            window.open("<?php echo site_url(); ?>/manager/tes_tambah", "_self");
        });

        $('#btn-tambah-daftar').click(function(){
            window.open("<?php echo site_url(); ?>/manager/tes_daftar", "_self");
        });

        $("#soal-modul").change(function(){
            refresh_topik();
        });

        $('#soal-topik').change(function(){
            var text = $('#soal-topik option:selected').text();
            var match = text.match(/\[(\d+)\s*soal\]/i);
            if(match && match[1]){
                var total = parseInt(match[1]);
                if(total > 0 && total < 40){
                    $('#soal-jml').val(total);
                } else {
                    $('#soal-jml').val('40');
                }
            } else {
                $('#soal-jml').val('40');
            }
        });

        $('#form-tambah-tes').submit(function(){
            if($('.check-group:checked').length === 0){
                notify_error('Pilih minimal satu Group / Kelas untuk tes ini!');
                return false;
            }
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambah_tes",
                    type:"POST",
                    data:$('#form-tambah-tes').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $('#form-pesan-tes').html('');
                            $("#tambah-id").val(obj.tes_id);
                            $("#tambah-nama-lama").val(obj.tes_nama);
                            // menampilkan tambah soal
                            refresh_topik();
                            $("#soal-tes-id").val(obj.tes_id);
                            $('#kolom-soal').removeClass('hide');
                            $("#modal-proses").modal('hide');
                            
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-tes').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#form-tambah-soal').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambah_soal",
                    type:"POST",
                    data:$('#form-tambah-soal').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-soal').html('');
                            reset_soal();
                            $('#soal-topik').trigger('change');
                            refresh_table();                            
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-soal').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#table-soal').DataTable({
                  "paging": false,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": false,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable_soal/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "tes-id", "value": $('#soal-tes-id').val()} );
                  }
         });

        reset_soal();

        <?php if(!empty($data_tes)){ echo $data_tes; } ?>
    });
</script>