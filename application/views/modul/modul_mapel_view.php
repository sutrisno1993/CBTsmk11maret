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
	<div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-title"><i class="fa fa-book text-primary"></i> Daftar Mata Pelajaran (Modul)</div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-sm" onclick="sync_jadwal()" title="Sinkronkan data modul, topik STS, dan kelas">
                            <i class="fa fa-refresh text-blue"></i> Sinkronkan Data Jadwal
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="tambah()">
                            <i class="fa fa-plus"></i> Tambah Mata Pelajaran Baru
                        </button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="callout callout-info" style="margin-bottom: 15px; padding: 10px 15px;">
                        <h4><i class="fa fa-info-circle"></i> Informasi Modul:</h4>
                        <p style="font-size: 13px;">Modul berfungsi sebagai induk Mata Pelajaran. Setiap Modul dapat memiliki banyak Topik (Bank Soal) untuk berbagai tingkat dan jurusan.</p>
                    </div>

                    <table id="table-modul" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 30px;">No.</th>
                                <th>Nama Mata Pelajaran / Modul</th>
                                <th style="width: 130px;">Durasi Ujian</th>
                                <th style="width: 120px;">Jumlah Topik</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 80px;">Aksi</th>
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
</section>

<script type="text/javascript">
    function refresh_table(){
        $('#table-modul').dataTable().fnReloadAjax();
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

        $('#table-modul').DataTable({
            "paging": true,
            "iDisplayLength": 15,
            "aLengthMenu": [[10, 15, 25, 50, -1], [10, 15, 25, 50, "Semua"]],
            "bProcessing": false,
            "bServerSide": true, 
            "searching": true,
            "aoColumns": [
                {"bSearchable": false, "bSortable": false, "sWidth":"30px"},
                {"bSearchable": true, "bSortable": true},
                {"bSearchable": false, "bSortable": false, "sWidth":"130px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"120px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"100px"},
                {"bSearchable": false, "bSortable": false, "sWidth":"80px"}
            ],
            "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
            "autoWidth": false,
            "fnServerParams": function ( aoData ) {
            }
        });
    });
</script>
