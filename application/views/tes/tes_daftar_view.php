<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Daftar Tes
		<small>Melihat daftar tes, mengubah dan menghapus tes</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Daftar Tes</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
						<div class="box-title">Daftar Tes</div>
    					<div class="box-tools pull-right">
                            <button type="button" onclick="normalisasi_semua_skala_100()" class="btn btn-warning btn-xs" style="margin-right: 10px; font-weight: 700;" title="Set otomatis Poin Dasar = 100 / Jumlah Soal & Hitung Ulang Nilai Siswa ke Skala 100">
                                <i class="fa fa-calculator"></i> ⚡ Normalisasi Semua Tes &amp; Nilai ke Skala 100
                            </button>
							<div class="dropdown pull-right">
								<a href="<?php echo site_url(); ?>/manager/tes_tambah" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Tambah Tes</a>
    						</div>
    					</div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <?php echo form_open($url.'/hapus_daftar_tes','id="form-hapus-pilih"'); ?>
                        <input type="hidden" name="check" id="check" value="0">
                        <input type="hidden" name="centang" id="centang" value="0">
                        <div id="form-pesan"><?php if(!empty($pesan_hapus)){ echo $pesan_hapus; } ?></div>

                        <!-- Filter Hari, Shift & Jam Ke -->
                        <div class="row" style="margin-bottom: 15px; padding: 12px 15px; background: #f9fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label style="font-size: 13px; font-weight: 600;"><i class="fa fa-calendar"></i> Filter Hari:</label>
                                <select id="filter-hari" class="form-control input-sm">
                                    <option value="semua">- Semua Hari -</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label style="font-size: 13px; font-weight: 600;"><i class="fa fa-adjust"></i> Filter Shift:</label>
                                <select id="filter-shift" class="form-control input-sm">
                                    <option value="semua">- Semua Shift -</option>
                                    <option value="Pagi">Shift Pagi</option>
                                    <option value="Siang">Shift Siang</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label style="font-size: 13px; font-weight: 600;"><i class="fa fa-clock-o"></i> Filter Jam Ke:</label>
                                <select id="filter-jam-ke" class="form-control input-sm">
                                    <option value="semua">- Semua Jam Ke -</option>
                                    <option value="Jam Ke-1">Jam Ke-1</option>
                                    <option value="Jam Ke-2">Jam Ke-2</option>
                                    <option value="Jam Ke-3">Jam Ke-3</option>
                                    <option value="Jam Ke-4">Jam Ke-4</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label style="display: block; font-size: 13px;">&nbsp;</label>
                                <button type="button" id="btn-reset-filter" class="btn btn-default btn-sm btn-block"><i class="fa fa-undo"></i> Reset Filter</button>
                            </div>
                        </div>

                        <table id="table-tes" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="all">Nama Tes</th>
                                    <th class="all">Hari</th>
                                    <th class="all">Shift</th>
                                    <th class="all">Jam Ke</th>
                                    <th>Max Score</th>
                                    <th class="all">Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th class="none">Waktu Tes</th>
                                    <th class="none">Poin Dasar</th>
                                    <th class="none">Tunjukkan Hasil</th>
                                    <th class="none">Token</th>
									<th class="none">Soal</th>
									<th class="none">Grup Peserta</th>
                                    <th class="all"></th>
                                    <th class="all"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
									<td> </td>
									<td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
									<td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>   
                        </form>                     
                    </div>
                    <div class="box-footer">
                        <button type="button" id="btn-edit-hapus" class="btn btn-primary" title="Hapus Siswa yang dipilih">Hapus</button>
                        <button type="button" id="btn-edit-pilih" class="btn btn-default pull-right">Pilih Semua</button>
                    </div>
                </div>
        </div>
    </div>

    <div class="modal" id="modal-duplikat" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/duplikat_tes','id="form-duplikat"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #00c0ef; color: #fff;">
                    <button class="close" type="button" data-dismiss="modal" style="color: #fff; opacity: 0.9;">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-copy"></i> Duplikat / Gandakan Tes (Shift Lain / Susulan)</h4>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-duplikat"></div>
                            <input type="hidden" name="duplikat-id" id="duplikat-id">
                            <div class="form-group">
                                <label>Nama Tes Baru</label>
                                <input type="text" class="form-control" id="duplikat-nama" name="duplikat-nama" placeholder="Masukkan nama tes baru...">
                                <p class="help-block" style="font-size: 11px; margin-bottom: 0;">Komposisi soal, poin, dan daftar kelas peserta akan otomatis disalin.</p>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" id="duplikat-deskripsi" name="duplikat-deskripsi">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Hari</label>
                                        <select name="duplikat-hari" id="duplikat-hari" class="form-control input-sm">
                                            <option value="">- Pilih Hari -</option>
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                            <option value="Minggu">Minggu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Shift</label>
                                        <select name="duplikat-shift" id="duplikat-shift" class="form-control input-sm">
                                            <option value="">- Pilih Shift -</option>
                                            <option value="Pagi">Shift Pagi</option>
                                            <option value="Siang">Shift Siang</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Jam Ke</label>
                                        <select name="duplikat-jam-ke" id="duplikat-jam-ke" class="form-control input-sm">
                                            <option value="">- Pilih Jam Ke -</option>
                                            <option value="Jam Ke-1">Jam Ke-1</option>
                                            <option value="Jam Ke-2">Jam Ke-2</option>
                                            <option value="Jam Ke-3">Jam Ke-3</option>
                                            <option value="Jam Ke-4">Jam Ke-4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Rentang Waktu Pelaksanaan</label>
                                <input type="text" class="form-control" id="duplikat-rentang-waktu" name="duplikat-rentang-waktu">
                                <p class="help-block" style="font-size: 11px; margin-bottom: 0;">Format: <code>YYYY-MM-DD HH:mm - YYYY-MM-DD HH:mm</code></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-duplikat-simpan" class="btn btn-info"><i class="fa fa-copy"></i> Buat Duplikat Tes</button>
                    <a href="#" class="btn btn-default" data-dismiss="modal">Batal</a>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="modal" id="modal-hapus" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/hapus_tes','id="form-hapus"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Hapus Tes</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-hapus"></div>
                            <div class="form-group">
                                <label>Nama Tes</label>
                                <input type="hidden" name="hapus-id" id="hapus-id">
                                <input type="text" class="form-control" id="hapus-nama" name="hapus-nama" readonly>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <input type="text" class="form-control" id="hapus-deskripsi" name="hapus-deskripsi" readonly>
                            </div>
                            <p>Tes yang dihapus akan membuat data nilai user juga akan ikut terhapus</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-hapus" class="btn btn-default">Hapus</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>

    <div class="modal" id="modal-hapus-pilih" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Hapus Tes</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <strong>Peringatan</strong>
                            Data Tes yang sudah dipilih akan dihapus beserta hasil tes tersebut.
                            <br /><br />
                            Apakah anda yakin untuk menghapus data Topik ?
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="edit-hapus-centang" name="edit-hapus-centang" value="1"> Ya, saya yakin Menghapus Tes yang telah dipilih.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-hapus-pilih" class="btn btn-default pull-left">Hapus</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>

</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-tes').dataTable().fnReloadAjax();
    }

    function normalisasi_semua_skala_100(tes_id){
        var url_target = '<?php echo site_url().'/'.$url; ?>/normalisasi_skala_100' + (tes_id ? '/' + tes_id : '');
        var msg = tes_id ? 'Normalisasi Poin tes ini ke Skala 100 (Poin = 100 / Jumlah Soal) dan hitung ulang nilai peserta?' : 'Normalisasi SELURUH Jadwal Tes ke Skala 100 (Poin = 100 / Jumlah Soal) sekaligus hitung ulang nilai siswa yang sudah mengerjakan?';
        if(confirm(msg)){
            $("#modal-proses").modal('show');
            $.getJSON(url_target, function(res){
                $("#modal-proses").modal('hide');
                if(res.status == 1){
                    refresh_table();
                    notify_success(res.pesan);
                }else{
                    notify_error('Gagal menormalisasi skor.');
                }
            });
        }
    }

    function edit(id){
        window.open("<?php echo site_url(); ?>/manager/tes_tambah/index/"+id, "_self");
    }

    function duplikat(id){
        $("#modal-proses").modal('show');
        $('#form-pesan-duplikat').html('');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#duplikat-id').val(data.id);
                $('#duplikat-nama').val(data.nama + ' (SUSULAN / SHIFT 2)');
                $('#duplikat-deskripsi').val(data.deskripsi);
                $('#duplikat-hari').val(data.hari);
                $('#duplikat-shift').val(data.shift);
                $('#duplikat-jam-ke').val(data.jam_ke);
                $('#duplikat-rentang-waktu').val(data.rentang_waktu);

                $("#modal-duplikat").modal('show');
            }
            $("#modal-proses").modal('hide');
        });
    }

    function hapus(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#hapus-id').val(data.id);
                $('#hapus-nama').val(data.nama);
                $('#hapus-deskripsi').val(data.deskripsi);


                $("#modal-hapus").modal('show');
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
        $('#btn-edit-pilih').click(function(event) {
            if($('#check').val()==0) {
                $(':checkbox').each(function() {
                    this.checked = true;
                });
                $('#check').val('1');
            }else{
                $(':checkbox').each(function() {
                    this.checked = false;
                });
                $('#check').val('0');
            }
        });
        $('#btn-edit-hapus').click(function(){
            $('#centang').val('0');
            $('#edit-hapus-centang').removeAttr("checked");;
            $("#modal-hapus-pilih").modal('show');
        });
        $('#btn-hapus-pilih').click(function(){
            $("#modal-proses").modal('show');
            $("#form-hapus-pilih").submit();
        });
        $("#edit-hapus-centang").change(function() {
            if(this.checked) {
                $('#centang').val('1');
            }else{
                $('#centang').val('0');
            }
        });

        $('#form-duplikat').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/duplikat_tes",
                    type:"POST",
                    data:$('#form-duplikat').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#modal-duplikat").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-duplikat').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        $('#form-hapus').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/hapus_tes",
                    type:"POST",
                    data:$('#form-hapus').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table()
                            $("#modal-proses").modal('hide');
                            $("#modal-hapus").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });

        // Event listener saat filter diubah
        $('#filter-hari, #filter-shift, #filter-jam-ke').change(function(){
            refresh_table();
        });

        $('#btn-reset-filter').click(function(){
            $('#filter-hari').val('semua');
            $('#filter-shift').val('semua');
            $('#filter-jam-ke').val('semua');
            refresh_table();
        });

        $('#table-tes').DataTable({
                  "paging": true,
                  "iDisplayLength":50,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
    					{"bSearchable": false, "bSortable": false, "sWidth":"20px"},
    					{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"75px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"75px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"85px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"150px"},
    					{"bSearchable": false, "bSortable": false, "sWidth":"150px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false},
						{"bSearchable": false, "bSortable": false},
						{"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"80px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "responsive": true,
                  "fnServerParams": function ( aoData ) {
                      aoData.push( { "name": "hari", "value": $('#filter-hari').val() } );
                      aoData.push( { "name": "shift", "value": $('#filter-shift').val() } );
                      aoData.push( { "name": "jam_ke", "value": $('#filter-jam-ke').val() } );
                  }
         });          
    });
</script>