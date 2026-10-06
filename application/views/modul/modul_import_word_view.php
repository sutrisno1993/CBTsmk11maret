<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Mengimport Soal dari Word
		<small>Melakukan Import Soal pilihan ganda berdasarkan modul dan topik</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Import Soal Word</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row" id="box-awal">
		<?php echo form_open($url.'/import','id="form-importsoal"'); ?>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="box-title"><i class="fa fa-filter text-primary"></i> Filter & Pilih Topik</div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-xs" id="btn-reset-filter" title="Reset Semua Filter">
                            <i class="fa fa-refresh text-blue"></i> Reset Filter
                        </button>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <!-- Filter Hari -->
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-calendar text-blue"></i> Filter Hari:</label>
                        <select id="filter-hari" class="form-control input-sm">
                            <option value="">-- Semua Hari --</option>
                            <option value="SENIN">Senin</option>
                            <option value="SELASA">Selasa</option>
                            <option value="RABU">Rabu</option>
                            <option value="KAMIS">Kamis</option>
                            <option value="JUMAT">Jumat</option>
                        </select>
                    </div>

                    <!-- Filter Tingkat / Grade -->
                    <div class="form-group" style="margin-bottom: 8px;">
                        <label style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-graduation-cap text-green"></i> Filter Tingkat / Grade:</label>
                        <select id="filter-grade" class="form-control input-sm">
                            <option value="">-- Semua Tingkat --</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>

                    <!-- Filter Mata Pelajaran / Modul -->
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label style="font-size: 12px; margin-bottom: 2px;"><i class="fa fa-book text-yellow"></i> Filter Mata Pelajaran:</label>
                        <select id="filter-mapel" class="form-control input-sm">
                            <option value="">-- Semua Mata Pelajaran --</option>
                        </select>
                    </div>

                    <div style="border-top: 1px dashed #d2d6de; margin: 10px 0 12px 0;"></div>

					<div class="form-group">
                        <label style="font-size: 12px; margin-bottom: 4px;">
                            <i class="fa fa-check-circle text-green"></i> Pilih Topik Soal:
                            <span id="badge-count" class="badge bg-aqua pull-right" style="font-size: 10px;"></span>
                        </label>
						<select name="topik" id="topik" class="form-control input-sm" style="width: 100%;">
							<?php if(!empty($select_topik)){ echo $select_topik; } ?>
                        </select>
                        <div style="margin-top: 8px;">
                            <a href="<?php echo site_url('manager/modul_topik'); ?>" class="btn btn-warning btn-xs" style="font-weight: 600;">
                                <i class="fa fa-plus-circle"></i> + Buat Topik / Mapel Baru
                            </a>
                        </div>
					</div>

                    <div id="box-topik-info" style="display: none; background: #e8f4f8; border: 1px solid #d2e8f1; border-left: 3px solid #3c8dbc; padding: 8px 10px; border-radius: 3px; font-size: 12px; margin-top: 10px;">
                        <b style="color: #286090;"><i class="fa fa-info-circle"></i> Topik Terpilih:</b><br>
                        <span id="info-nama-topik" style="font-weight: 600; color: #222;"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <p class="text-muted" style="font-size: 11px; margin: 0;"><i class="fa fa-lightbulb-o text-yellow"></i> Gunakan filter Hari, Grade, atau Mapel untuk mempercepat pencarian.</p>
                </div>
            </div>
        </div>
		<div class="col-md-8">
			<div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Import Soal dari Word</div>
					<div class="box-tools pull-right">
						<div class="dropdown pull-right">
							<a href="<?php echo base_url(); ?>public/form/form-soal-ganda.docx">Form Word Soal Pilihan Ganda</a>
    					</div>
    				</div>
                </div><!-- /.box-header -->

                <div class="box-body">
					<span id="form-pesan"></span>
                    <div class="form-group">
                        <label>Data Soal sesuai Format Pilihan Ganda</label>
                        <input type="hidden" name="import-soal" id="import-soal" >
                        <textarea class="textarea" id="import_soal" name="import_soal" style="width: 100%; height: 150px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        <p class="help-block">
							Paste Tabel pada file Word sesuai format yang telah ditentukan untuk proses import.<br/>
							Jangan sertakan baris kosong dalam format import soal yang akan dicopy, karena akan mengganggu hasil import soal.<br />
							Buat tampilan menjadi Fullscreen untuk mempermudah dalam melakukan paste ke layar.
						</p>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" id="import">Import</button>
                </div>
            </div>
        </div>
		</form>
    </div>
	
	<div class="row hide" id="box-konfirmasi">
		<div class="col-md-12">
			<?php echo form_open($url.'/konfirmasi','id="form-konfirmasi"'); ?>
			<div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Konfirmasi Daftar Soal <span id="judul-daftar-soal"></span></div>
                </div><!-- /.box-header -->

                <div class="box-body">
					<div class="callout callout-info">
						<h4>Konfirmasi</h4>
						<p>Silahkan cek soal pilihan ganda yang telah dikirim. Jika soal sudah sesuai, silahkan klik tombol Simpan dibawah ini.</p>
						<input type="hidden" name="konfirmasi-import-soal" id="konfirmasi-import-soal" >
						<input type="hidden" name="konfirmasi-topik" id="konfirmasi-topik" >
					</div>
					<span id="form-pesan-konfirmasi"></span>
                    <div id="daftar-soal" style="overflow-y: auto;height: 500px;">
					
					</div>
                </div>
                <div class="box-footer">
					<button type="button" class="btn btn-default" id="batal">Batal</button>
                    <button type="submit" class="btn btn-primary pull-right" id="btn-konfirmasi">Simpan</button>
                </div>
            </div>
			</form>
		</div>
	</div>
</section><!-- /.content -->

<div class="modal" id="modal-sukses" data-backdrop="static" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Informasi Import Soal</h4>
            </div>
            <div class="modal-body">
                <div class="callout callout-info">
                    <p>
						Import Soal pilihan ganda berhasil.<br />
						Berikut informasi soal yang berhasil di import :<br/>
						Jumlah Soal : <span id="info-jml-soal"></span><br/>
						Jumlah Jawaban : <span id="info-jml-jawaban"></span><br/>
					</p>
					
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="refresh">OK</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

	<div class="modal" id="modal-image" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 950px">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Insert Image</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?php echo form_open_multipart($url.'/upload_file','id="form-upload-image" class="form-horizontal"'); ?>
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <div class="box-title">Upload File</div>
                                            </div><!-- /.box-header -->

                                            <div class="box-body">
                                                <div class="row-fluid">
                                                    <div class="box-body">
                                                        <div id="form-pesan-upload-image"></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label">File</label>
                                                            <div class="col-sm-10">
                                                                <input type="hidden" id="image-topik-id" name="image-topik-id" >
                                                                <input type="file" id="image-file" name="image-file" >
                                                                <p class="help-block">File yang didukung adalah jpg, jpeg, png</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" id="image-upload" class="btn btn-primary">Upload File</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-xs-6">
                                        <div class="box hide" id="box-preview" >
                                            <div class="box-body">
                                                <div class="row-fluid">
                                                    <div class="box-body" style="height: 132px;">
                                                        <input type="hidden" name="image-isi" id="image-isi">
                                                        <div id="image-preview" style="text-align: center;vertical-align: middle;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="btn-image-insert" class="btn btn-primary">Masukkan Gambar</button>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body" style="max-height: 230px;overflow: auto;">
                                            <table id="table-image" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Nama File</th>
                                                        <th>Preview</th>
                                                        <th>Tanggal</th>
                                                        <th> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> </td>
                                                        <td> </td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script lang="javascript">

    function batal_tambah(){
        $("#form-pesan").html('');
    }
	
	/**
     * Fungsi untuk upload image dari editor text
     */
    function imageUpload(){
        $('#box-preview').addClass('hide');
        $('#image-preview').html('');
        $('#form-pesan-upload-image').html('');
        $('#image-isi').val('');
        $('#image-file').val('');

        refresh_table_image();

        $("#modal-image").modal("show");
    }
	
	function refresh_table_image(){
        $('#table-image').dataTable().fnReloadAjax();
    }

    function image_preview(posisi, image){
        $('#image-preview').html('<img src="<?php echo base_url(); ?>'+posisi+'/'+image+'" style="max-height: 110px;" />');
        $('#image-isi').val('<img src="<?php echo base_url(); ?>'+posisi+'/'+image+'" style="max-width: 600px;" />');
        $('#box-preview').removeClass('hide');
    }

    var originalTopikList = [];

    function initFilterTopik(){
        originalTopikList = [];
        var mapelMap = {};

        $('#topik option').each(function(){
            var val = $(this).val();
            if(!val || val === 'kosong') return;
            var text = $(this).text().trim();
            var modul = $(this).attr('data-modul') || '';
            var hari = $(this).attr('data-hari') || '';
            var grade = $(this).attr('data-grade') || '';

            if(!hari){
                var mHari = text.match(/\[(SENIN|SELASA|RABU|KAMIS|JUMAT)/i);
                if(mHari) hari = mHari[1].toUpperCase();
            }

            if(!grade){
                if(/\bXII\b/i.test(text)){
                    grade = 'XII';
                }else if(/\bXI\b/i.test(text)){
                    grade = 'XI';
                }else if(/\bX\b/i.test(text)){
                    grade = 'X';
                }
            }

            if(!modul){
                var optgroup = $(this).closest('optgroup');
                if(optgroup.length){
                    modul = optgroup.attr('label').replace(/^Modul\s+/i, '').trim();
                }else{
                    var parts = text.split(' - ');
                    if(parts.length > 1) modul = parts[0].trim();
                }
            }

            if(modul){
                mapelMap[modul] = true;
            }

            originalTopikList.push({
                id: val,
                text: text,
                modul: modul,
                hari: hari,
                grade: grade
            });
        });

        var mapelKeys = Object.keys(mapelMap).sort();
        $('#filter-mapel').html('<option value="">-- Semua Mata Pelajaran (' + mapelKeys.length + ') --</option>');
        for(var i = 0; i < mapelKeys.length; i++){
            $('#filter-mapel').append('<option value="' + escapeHtml(mapelKeys[i]) + '">' + mapelKeys[i] + '</option>');
        }

        applyFilterTopik(true);
    }

    function escapeHtml(text) {
        return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }

    function applyFilterTopik(isInitial){
        var selectedHari = $('#filter-hari').val();
        var selectedGrade = $('#filter-grade').val();
        var selectedMapel = $('#filter-mapel').val();
        var currentSelectedVal = $('#topik').val();

        var filtered = originalTopikList.filter(function(item){
            if(selectedHari && item.hari !== selectedHari) return false;
            if(selectedGrade && item.grade !== selectedGrade) return false;
            if(selectedMapel && item.modul !== selectedMapel) return false;
            return true;
        });

        if(filtered.length === originalTopikList.length){
            $('#badge-count').text(filtered.length + ' Topik');
        }else{
            $('#badge-count').text(filtered.length + ' dari ' + originalTopikList.length);
        }

        var groups = {};
        for(var i = 0; i < filtered.length; i++){
            var item = filtered[i];
            var mName = item.modul || 'Lainnya';
            if(!groups[mName]) groups[mName] = [];
            groups[mName].push(item);
        }

        var html = '<option value="">-- Pilih Topik Soal --</option>';
        var stillExists = false;

        var groupKeys = Object.keys(groups).sort();
        for(var g = 0; g < groupKeys.length; g++){
            var grpName = groupKeys[g];
            html += '<optgroup label="Modul ' + escapeHtml(grpName) + '">';
            var items = groups[grpName];
            for(var k = 0; k < items.length; k++){
                var it = items[k];
                var isSel = (it.id === currentSelectedVal);
                if(isSel) stillExists = true;
                html += '<option value="' + it.id + '"' + (isSel ? ' selected' : '') + '>' + escapeHtml(it.text) + '</option>';
            }
            html += '</optgroup>';
        }

        if(filtered.length === 0){
            html = '<option value="">(Tidak ada topik yang sesuai dengan filter)</option>';
        }

        if($('#topik').data('select2')){
            $('#topik').select2('destroy');
        }

        $('#topik').html(html);

        if(filtered.length === 1 && !isInitial){
            $('#topik').val(filtered[0].id);
        }else if(!stillExists){
            $('#topik').val('');
        }

        $('#topik').select2({
            width: '100%',
            placeholder: "🔍 Ketik untuk mencari topik / mata pelajaran..."
        });

        updateInfoTopik();
    }

    function updateInfoTopik(){
        var val = $('#topik').val();
        var text = $('#topik option:selected').text();
        if(val && val !== '' && text && !text.startsWith('--') && !text.startsWith('(')){
            $('#info-nama-topik').text(text);
            $('#box-topik-info').fadeIn(150);
        }else{
            $('#box-topik-info').fadeOut(150);
        }
    }

    $(function(){
        initFilterTopik();

        $('#filter-hari, #filter-grade, #filter-mapel').change(function(){
            applyFilterTopik(false);
        });

        $('#topik').change(function(){
            updateInfoTopik();
        });

        $('#btn-reset-filter').click(function(){
            $('#filter-hari').val('');
            $('#filter-grade').val('');
            $('#filter-mapel').val('');
            applyFilterTopik(false);
        });
		
		$('#batal').click(function(){
			location.reload(); 
		});
		
		$('#refresh').click(function(){
			location.reload(); 
		});

        /**
         * Submit form import soal
         */
        $('#form-importsoal').submit(function(){
			$('#import-soal').val(CKEDITOR.instances.import_soal.getData());
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/import",
                    type:"POST",
                    timeout: 300000,
                    data:$('#form-importsoal').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            batal_tambah();
							$('#konfirmasi-import-soal').val($('#import-soal').val());
							$('#konfirmasi-topik').val($('#topik').val());
							$('#daftar-soal').html(obj.soal);
                            $('#box-awal').addClass('hide');
							$('#box-konfirmasi').removeClass('hide');
							
							var judul = $('#topik option:selected').text();
							$('#judul-daftar-soal').html(" : "+judul);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    },
                    statusCode: {
                        500: function(respon) {
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err('Terjadi kesalahan saat import soal. Silahkan cek terlebih dahulu format yang di upload.'));
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal mengimport Soal, Silahkan Refresh Halaman");
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(message);
                        }
                    }
            });
            return false;
        });
		
		/**
         * Submit form import soal
         */
        $('#form-konfirmasi').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/konfirmasi",
                    type:"POST",
                    timeout: 300000,
                    data:$('#form-konfirmasi').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            // Menampilkan modal konfirmasi berhasil import soal
							$("#info-jml-soal").html(obj.counter_soal)
							$("#info-jml-jawaban").html(obj.counter_jawaban)
							$("#modal-sukses").modal('show');
							// Tombol informasi akan me refresh halaman 
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    },
                    statusCode: {
                        500: function(respon) {
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err('Terjadi kesalahan saat import soal. Silahkan cek terlebih dahulu format yang di upload.'));
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal mengimport Soal, Silahkan Refresh Halaman");
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(textstatus);
                        }
                    }
            });
            return false;
        });
		
		
		$('#btn-image-insert').click(function(){
            var image = $('#image-isi').val();
            CKEDITOR.instances.import_soal.insertHtml(image);
            $("#modal-image").modal("hide");
        });
		/**
         * Submit form upload pada image browser
         */
        $('#form-upload-image').submit(function(){
            $('#image-topik-id').val($('#topik').val());
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/upload_file",
                    type:"POST",
                    data:new FormData(this),
                    mimeType: "multipart/form-data",
                    contentType:false,
                    cache: false,
                    processData: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $('#image-preview').html(obj.image);
                            $('#image-isi').val(obj.image_isi);
                            $('#box-preview').removeClass('hide');
                            $("#modal-proses").modal('hide');
                            $("#form-pesan-upload-image").html('');
                            $('#image-file').val('');
                            refresh_table_image();
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-upload-image').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
        });
		
		$('#table-image').DataTable({
                  "bPaginate": false,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": false,
                  "aoColumns": [
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"100px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"90px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"50px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable_image/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "topik", "value": $('#topik').val()} );
                  }
            });
		 
		$( document ).ready(function() {
            CKEDITOR.replace('import_soal');
		});
    });
</script>