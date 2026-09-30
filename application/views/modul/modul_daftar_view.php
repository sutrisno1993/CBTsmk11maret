<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo !empty($judul_halaman) ? $judul_halaman : 'Daftar Soal'; ?>
		<small><?php echo !empty($subjudul_halaman) ? $subjudul_halaman : 'Daftar soal dan jawaban berdasarkan Modul dan Topik'; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"><?php echo !empty($judul_halaman) ? $judul_halaman : 'Daftar Soal'; ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Pilih Topik</div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Pilih Topik</label>
                            <div id="data-kelas">
                                <select name="topik" id="topik" class="form-control input-sm" style="width: 100%;">
                                    <?php if(!empty($select_topik)){ echo $select_topik; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3"></div>
                </div>
                <div class="box-footer">
                    <?php if(!empty($mode) && $mode == 'panitia'){ ?>
                        <p class="text-muted"><i class="fa fa-info-circle text-blue"></i> Pilih naskah soal yang telah disiapkan oleh Panitia SAS/PAS untuk melakukan preview dan verifikasi kunci jawaban.</p>
                    <?php } else { ?>
                        <p class="text-muted"><i class="fa fa-info-circle text-green"></i> Menampilkan bank soal Ulangan Harian mandiri Anda. Soal resmi dari panitia tidak ditampilkan di sini.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="box-title">Daftar Soal <span id="judul-daftar-soal"></span></div>
                        <div class="box-tools pull-right">
                            <?php if(empty($mode) || $mode != 'panitia'){ ?>
                            <a class="btn btn-sm btn-warning" href="<?php echo site_url('manager/modul_topik'); ?>" style="margin-right: 5px; font-weight: 600;" title="Tambah Topik atau Mata Pelajaran Baru">
                                <i class="fa fa-plus-circle"></i> + Topik UH Baru
                            </a>
                            <a class="btn btn-sm btn-primary" href="<?php echo site_url('manager/modul_soal'); ?>" style="margin-right: 5px; font-weight: 600;" title="Tulis atau tambah butir soal baru">
                                <i class="fa fa-pencil"></i> Tulis Soal
                            </a>
                            <a class="btn btn-sm btn-info" href="<?php echo site_url('manager/modul_import_word'); ?>" style="margin-right: 8px; font-weight: 600;" title="Upload naskah soal dari Microsoft Word">
                                <i class="fa fa-file-word-o"></i> Import Word
                            </a>
                            <?php } ?>
                            <a class="btn btn-sm btn-success" style="cursor: pointer; margin-right: 5px; font-weight: 600;" onclick="preview_soal()" title="Periksa redaksi soal dan validasi kunci jawaban sebelum ujian">
                                <i class="fa fa-eye"></i> Preview & Cek Soal (QC Guru)
                            </a>
                            <a class="btn btn-sm btn-default" style="cursor: pointer;" onclick="cetak_soal()">
                                <i class="fa fa-print"></i> Cetak Soal
                            </a>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table id="table-soal" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tipe Soal</th>
                                    <th>Soal</th>
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

    <div class="modal" id="modal-tambah" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/tambah','id="form-tambah"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Tambah Topik</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="form-group">
                                <label>Nama Topik</label>
                                <input type="hidden" name="tambah-modul-id" id="tambah-modul-id">
                                <input type="text" class="form-control" id="tambah-topik" name="tambah-topik" placeholder="Nama Topik">
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" id="tambah-deskripsi" name="tambah-deskripsi" placeholder="Deskripsi Topik" >
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" id="tambah-status" name="tambah-status" value="AKTIF" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="tambah-simpan" class="btn btn-primary">Tambah</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>

    <div class="modal" id="modal-edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/edit','id="form-edit"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Edit Topik</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-edit"></div>
                            <div class="form-group">
                                <label>Nama Topik</label>
                                <input type="hidden" name="edit-id" id="edit-id">
                                <input type="hidden" name="edit-pilihan" id="edit-pilihan">
                                <input type="hidden" name="edit-topik-asli" id="edit-topik-asli">
                                <input type="text" class="form-control" id="edit-topik" name="edit-topik" placeholder="Nama Topik">
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" id="edit-deskripsi" name="edit-deskripsi" placeholder="Deskripsi Topik" >
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" id="edit-status" name="edit-status" value="AKTIF" readonly>
                            </div>
                            <p>NB : Topik yang dihapus, maka semua bank soal akan ikut terhapus !</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="edit-hapus" class="btn btn-default pull-left">Hapus</button>
                    <button type="button" id="edit-simpan" class="btn btn-primary">Simpan</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>
</section><!-- /.content -->



<script lang="javascript">
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

        window.open('<?php echo site_url(); ?>/manager/modul_daftar/cetak_soal/'+topik_id,'_blank');
    }

    function refresh_topik(){
        var judul = $('#topik option:selected').text();
        $('#judul-daftar-soal').html(judul);
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

        $('#form-tambah').submit(function(){
            $('#tambah-modul-id').val($('#modul').val());
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambah",
                    type:"POST",
                    data:$('#form-tambah').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-tambah").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#table-soal').DataTable({
                  "paging": true,
                  "iDisplayLength":10,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false, "sWidth":"80px"},
    					{"bSearchable": false, "bSortable": false}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "topik", "value": $('#topik').val()} );
                  }
         });
		 
		$( document ).ready(function() {
			refresh_topik();
		});
    });
</script>