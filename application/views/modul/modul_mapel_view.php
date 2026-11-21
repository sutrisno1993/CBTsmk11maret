<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Mata Pelajaran (Modul)
		<small>Kelola data mata pelajaran / modul bank soal secara dinamis</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Mata Pelajaran (Modul)</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Executive Summary Cards untuk Monitoring Kelengkapan Topik & Bank Soal -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="min-height: 75px; margin-bottom: 10px;">
                <span class="info-box-icon bg-aqua" style="height: 75px; line-height: 75px; width: 70px;"><i class="fa fa-book"></i></span>
                <div class="info-box-content" style="margin-left: 70px; padding: 8px 10px;">
                    <span class="info-box-text" style="font-size: 12px; font-weight: 600;">Total Mapel &amp; Topik</span>
                    <span class="info-box-number" style="font-size: 18px;">
                        <?php echo isset($summary['total_modul']) ? $summary['total_modul'] : 0; ?> Mapel <small style="font-weight:normal;">(<?php echo isset($summary['total_topik']) ? $summary['total_topik'] : 0; ?> Topik)</small>
                    </span>
                    <span class="text-muted" style="font-size: 11px;">Total <?php echo isset($summary['total_soal']) ? $summary['total_soal'] : 0; ?> Butir Soal</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="min-height: 75px; margin-bottom: 10px; cursor: pointer;" onclick="set_filter_status('lengkap')">
                <span class="info-box-icon bg-green" style="height: 75px; line-height: 75px; width: 70px;"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content" style="margin-left: 70px; padding: 8px 10px;">
                    <span class="info-box-text" style="font-size: 12px; font-weight: 600;">Mapel Topik Lengkap</span>
                    <span class="info-box-number" style="font-size: 18px; color: #00a65a;">
                        <?php echo isset($summary['modul_lengkap']) ? $summary['modul_lengkap'] : 0; ?> Mapel Siap
                    </span>
                    <span class="text-muted" style="font-size: 11px;">Klik untuk filter yang lengkap</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="min-height: 75px; margin-bottom: 10px; cursor: pointer;" onclick="set_filter_status('perhatian')">
                <span class="info-box-icon bg-yellow" style="height: 75px; line-height: 75px; width: 70px;"><i class="fa fa-exclamation-triangle"></i></span>
                <div class="info-box-content" style="margin-left: 70px; padding: 8px 10px;">
                    <span class="info-box-text" style="font-size: 12px; font-weight: 600;">Perlu Cek Topik / Soal</span>
                    <span class="info-box-number" style="font-size: 18px; color: #f39c12;">
                        <?php echo isset($summary['modul_perlu_perhatian']) ? $summary['modul_perlu_perhatian'] : 0; ?> Mapel
                    </span>
                    <span class="text-muted" style="font-size: 11px;">Kurang tingkat/jurusan atau 0 soal</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="min-height: 75px; margin-bottom: 10px; cursor: pointer;" onclick="set_filter_status('perhatian')">
                <span class="info-box-icon bg-red" style="height: 75px; line-height: 75px; width: 70px;"><i class="fa fa-file-text-o"></i></span>
                <div class="info-box-content" style="margin-left: 70px; padding: 8px 10px;">
                    <span class="info-box-text" style="font-size: 12px; font-weight: 600;">Topik Masih 0 Soal</span>
                    <span class="info-box-number" style="font-size: 18px; color: #dd4b39;">
                        <?php echo isset($summary['topik_kosong']) ? $summary['topik_kosong'] : 0; ?> Topik Kosong
                    </span>
                    <span class="text-muted" style="font-size: 11px;">Perlu segera diisi bank soal</span>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-title"><i class="fa fa-book text-primary"></i> Daftar Mata Pelajaran (Modul) &amp; Monitoring Topik</div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-info btn-sm" onclick="expand_all_topik()" title="Buka seluruh daftar topik di semua mata pelajaran">
                            <i class="fa fa-expand"></i> Buka Semua Topik
                        </button>
                        <button type="button" class="btn btn-default btn-sm" onclick="collapse_all_topik()" title="Tutup seluruh ekspansi topik">
                            <i class="fa fa-compress"></i> Tutup Semua
                        </button>
                        <button type="button" class="btn btn-default btn-sm" onclick="sync_jadwal()" title="Sinkronkan data modul, topik STS, dan kelas">
                            <i class="fa fa-refresh text-blue"></i> Sinkronkan Data Jadwal
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="tambah()">
                            <i class="fa fa-plus"></i> Tambah Mata Pelajaran Baru
                        </button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <!-- Filter Toolbar Monitoring Kelengkapan -->
                    <div style="margin-bottom: 14px; padding: 10px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <span style="font-size: 12.5px; font-weight: 700; color: #334155; margin-right: 8px;"><i class="fa fa-filter text-primary"></i> Filter Monitoring:</span>
                            <button type="button" class="btn btn-primary btn-xs btn-filter-modul" id="filter-btn-semua" onclick="set_filter_status('semua')">Semua Mapel</button>
                            <button type="button" class="btn btn-default btn-xs btn-filter-modul" id="filter-btn-perhatian" onclick="set_filter_status('perhatian')"><i class="fa fa-exclamation-triangle text-yellow"></i> Perlu Perhatian (Kurang Topik / 0 Soal)</button>
                            <button type="button" class="btn btn-default btn-xs btn-filter-modul" id="filter-btn-lengkap" onclick="set_filter_status('lengkap')"><i class="fa fa-check-circle text-green"></i> Topik &amp; Soal Lengkap</button>
                            <input type="hidden" id="filter-status-modul" value="semua">
                        </div>
                        <div style="font-size: 12px; color: #475569;">
                            <i class="fa fa-hand-pointer-o text-primary"></i> <b>Tips:</b> Klik pada <b>Nama Mata Pelajaran</b> atau badge <b>Jumlah Topik</b> untuk membuka daftar rincian topik di bawahnya.
                        </div>
                    </div>

                    <table id="table-modul" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 30px;">No.</th>
                                <th>Nama Mata Pelajaran / Modul &amp; Cakupan Topik (Klik untuk Ekspansi)</th>
                                <th style="width: 115px;">Durasi Ujian</th>
                                <th style="width: 125px;">Jumlah Topik</th>
                                <th style="width: 110px;">Status</th>
                                <th style="width: 90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>                        
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Modul -->
    <div class="modal fade" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <?php echo form_open($url.'/tambah','id="form-tambah"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Mata Pelajaran Baru</h4>
                </div>
                <div class="modal-body">
                    <div id="form-pesan-tambah"></div>
                    <div class="form-group">
                        <label>Nama Mata Pelajaran / Modul <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="tambah-nama" name="tambah-nama" placeholder="Contoh: Bahasa Indonesia, Matematika, Keahlian TKJ" required autocomplete="off">
                        <p class="help-block" style="font-size: 11px;">Masukkan nama mapel secara jelas. Setelah dibuat, Anda dapat menambahkan topik soal ke dalamnya.</p>
                    </div>
                    <div class="form-group">
                        <label>Durasi Pengerjaan Ujian (Menit) <span class="text-red">*</span></label>
                        <input type="number" class="form-control" id="tambah-durasi" name="tambah-durasi" value="90" min="10" max="300" required>
                        <p class="help-block" style="font-size: 11px;">Durasi standar ujian untuk mapel ini (misal: 90 menit atau 60 menit).</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="tambah-simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Mata Pelajaran</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- Modal Edit Modul -->
    <div class="modal fade" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <?php echo form_open($url.'/edit','id="form-edit"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Mata Pelajaran</h4>
                </div>
                <div class="modal-body">
                    <div id="form-pesan-edit"></div>
                    <input type="hidden" name="edit-id" id="edit-id">
                    <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                    <input type="hidden" name="edit-nama-asli" id="edit-nama-asli">

                    <div class="form-group">
                        <label>Nama Mata Pelajaran / Modul <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="edit-nama" name="edit-nama" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Durasi Pengerjaan Ujian (Menit) <span class="text-red">*</span></label>
                        <input type="number" class="form-control" id="edit-durasi" name="edit-durasi" value="90" min="10" max="300" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="edit-aktif" name="edit-aktif">
                            <option value="1">Aktif (Bisa Dipilih)</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="edit-hapus" class="btn btn-danger pull-left"><i class="fa fa-trash"></i> Hapus Modul</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="edit-simpan" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- Modal Tambah Topik Cepat Langsung dari Baris Modul -->
    <div class="modal fade" id="modal-topik-cepat" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <?php echo form_open($url.'/tambah_topik_cepat','id="form-topik-cepat"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-green">
                    <button class="close" type="button" data-dismiss="modal" style="color:#fff;">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-folder-plus"></i> Tambah Topik Baru ke Mata Pelajaran</h4>
                </div>
                <div class="modal-body">
                    <div id="form-pesan-topik-cepat"></div>
                    <input type="hidden" name="cepat-modul-id" id="cepat-modul-id">
                    <div class="form-group">
                        <label>Mata Pelajaran (Modul)</label>
                        <input type="text" class="form-control" id="cepat-modul-nama" readonly>
                    </div>
                    <div class="form-group">
                        <label>Pilih Preset Tingkat / Jurusan (Opsional - Klik untuk isi cepat)</label>
                        <div style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:6px;">
                            <button type="button" class="btn btn-default btn-xs" onclick="isi_preset_topik('Kelas X')">+ Kelas X</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="isi_preset_topik('Kelas XI')">+ Kelas XI</button>
                            <button type="button" class="btn btn-default btn-xs" onclick="isi_preset_topik('Kelas XII')">+ Kelas XII</button>
                            <button type="button" class="btn btn-info btn-xs" onclick="isi_preset_topik('Keahlian TKR')">+ TKR</button>
                            <button type="button" class="btn btn-info btn-xs" onclick="isi_preset_topik('Keahlian TSM')">+ TSM</button>
                            <button type="button" class="btn btn-info btn-xs" onclick="isi_preset_topik('Keahlian TKJ')">+ TKJ</button>
                            <button type="button" class="btn btn-info btn-xs" onclick="isi_preset_topik('Keahlian MP/OTKP')">+ OTKP/MP</button>
                            <button type="button" class="btn btn-info btn-xs" onclick="isi_preset_topik('Keahlian AKL')">+ AKL</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Topik <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="cepat-topik-nama" name="cepat-topik-nama" placeholder="Contoh: [JUMAT-1] STS XII - Keahlian TKR" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Topik <span class="text-red">*</span></label>
                        <input type="text" class="form-control" id="cepat-topik-detail" name="cepat-topik-detail" value="Bank Soal Ujian SMK 11 MARET" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Topik</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>

<script type="text/javascript">
    function refresh_table(){
        $('#table-modul').dataTable().fnReloadAjax();
    }

    function toggle_topik(modul_id){
        var panel = $('#panel-topik-' + modul_id);
        var icon = $('#icon-exp-' + modul_id);
        if(panel.is(':visible')){
            panel.slideUp(150);
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }else{
            panel.slideDown(180);
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }
    }

    function expand_all_topik(){
        $('.modul-topik-drawer').slideDown(180);
        $('[id^="icon-exp-"]').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    }

    function collapse_all_topik(){
        $('.modul-topik-drawer').slideUp(150);
        $('[id^="icon-exp-"]').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    }

    function set_filter_status(status){
        $('#filter-status-modul').val(status);
        $('.btn-filter-modul').removeClass('btn-primary').addClass('btn-default');
        $('#filter-btn-' + status).removeClass('btn-default').addClass('btn-primary');
        refresh_table();
    }

    function tambah_topik_cepat(modul_id, modul_nama){
        $('#form-pesan-topik-cepat').html('');
        $('#cepat-modul-id').val(modul_id);
        $('#cepat-modul-nama').val(modul_nama);
        $('#cepat-topik-nama').val(modul_nama + ' - ');
        $('#cepat-topik-detail').val('Bank Soal ' + modul_nama);
        $('#modal-topik-cepat').modal('show');
        setTimeout(function(){ $('#cepat-topik-nama').focus(); }, 400);
    }

    function isi_preset_topik(suffix){
        var mapel = $('#cepat-modul-nama').val();
        $('#cepat-topik-nama').val(mapel + ' - ' + suffix);
        $('#cepat-topik-nama').focus();
    }

    function sync_jadwal(){
        if(confirm('Apakah Anda yakin ingin memuat/sinkronkan data Modul, Topik STS, dan Kelas ke database?')){
            $("#modal-proses").modal('show');
            $.getJSON('<?php echo site_url().'/'.$url; ?>/sync_jadwal', function(res){
                $("#modal-proses").modal('hide');
                if(res.status == 1){
                    refresh_table();
                    notify_success(res.pesan);
                }else{
                    alert(res.pesan);
                }
            });
        }
    }

    function tambah(){
        $('#form-pesan-tambah').html('');
        $('#tambah-nama').val('');
        $('#tambah-durasi').val('90');
        $("#modal-tambah").modal('show');
        setTimeout(function(){ $('#tambah-nama').focus(); }, 400);
    }

    function edit(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id, function(data){
            if(data.data==1){
                $('#edit-id').val(data.id);
                $('#edit-nama').val(data.nama);
                $('#edit-nama-asli').val(data.nama);
                $('#edit-durasi').val(data.durasi ? data.durasi : 90);
                $('#edit-aktif').val(data.aktif);
                $('#form-pesan-edit').html('');
                $("#modal-edit").modal('show');
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
        $('#edit-simpan').click(function(){
            $('#edit-pilihan').val('simpan');
            $('#form-edit').submit();
        });

        $('#edit-hapus').click(function(){
            $('#edit-pilihan').val('hapus');
            $('#form-edit').submit();
        });

        $('#form-tambah').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url().'/'.$url; ?>/tambah",
                type: "POST",
                data: $('#form-tambah').serialize(),
                cache: false,
                success: function(respon){
                    var obj = $.parseJSON(respon);
                    if(obj.status==1){
                        refresh_table();
                        $("#modal-proses").modal('hide');
                        $("#modal-tambah").modal('hide');
                        notify_success(obj.pesan);
                    }else{
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-tambah').html(pesan_err(obj.pesan));
                    }
                }
            });
            return false;
        });

        $('#form-edit').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url().'/'.$url; ?>/edit",
                type: "POST",
                data: $('#form-edit').serialize(),
                cache: false,
                success: function(respon){
                    var obj = $.parseJSON(respon);
                    if(obj.status==1){
                        refresh_table();
                        $("#modal-proses").modal('hide');
                        $("#modal-edit").modal('hide');
                        notify_success(obj.pesan);
                    }else{
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-edit').html(pesan_err(obj.pesan));
                    }
                }
            });
            return false;
        });

        $('#form-topik-cepat').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url().'/'.$url; ?>/tambah_topik_cepat",
                type: "POST",
                data: $('#form-topik-cepat').serialize(),
                cache: false,
                success: function(respon){
                    var obj = $.parseJSON(respon);
                    if(obj.status==1){
                        refresh_table();
                        $("#modal-proses").modal('hide');
                        $("#modal-topik-cepat").modal('hide');
                        notify_success(obj.pesan);
                    }else{
                        $("#modal-proses").modal('hide');
                        $('#form-pesan-topik-cepat').html(pesan_err(obj.pesan));
                    }
                }
            });
            return false;
        });

        $('#table-modul').DataTable({
            "paging": true,
            "iDisplayLength": 25,
            "aLengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Semua"]],
            "bProcessing": false,
            "bServerSide": true, 
            "searching": true,
            "aoColumns": [
                {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
                {"bSearchable": true, "bSortable": false},
                {"bSearchable": false, "bSortable": false, "sWidth":"115px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"125px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"110px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"90px"}
            ],
            "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
            "autoWidth": false,
            "fnServerParams": function ( aoData ) {
                aoData.push({ "name": "filter_status", "value": $('#filter-status-modul').val() });
            }
        });
    });
</script>
