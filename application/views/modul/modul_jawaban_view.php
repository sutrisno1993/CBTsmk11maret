<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Mengelola Jawaban
		<small>Mengelola jawaban berdasarkan soal yang dipilih</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Jawaban</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">Data Soal <?php if(!empty($topik)){ echo $topik; } ?></div>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="col-xs-12">
                        <input type="hidden" name="topik" id="topik" value="<?php if(!empty($id_topik)){ echo $id_topik; } ?>" />
                        <?php if(!empty($soal)){ echo $soal; } ?>
                    </div>
                </div>
                <div class="box-footer">
                    <p>Mengelola jawaban berdasarkan soal yang dipilih. Jika sudah selesai, silahkan kembali ke halaman Soal dengan menutup jendela ini atau memilih menu Soal</p>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-xs-12">
                <div class="box">
                    <?php echo form_open_multipart($url.'/tambah','id="form-tambah" class="form-horizontal"'); ?>
                        <div class="box-header with-border">
                            <div class="box-title">Mengelola Jawaban</div>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jawaban</label>
                                <div class="col-sm-10">
                                    <div style="margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                                        <button type="button" class="btn btn-info btn-sm btn-flat" onclick="imageUpload()" style="font-weight: 600;">
                                            <i class="fa fa-picture-o"></i> Tambah / Kelola Gambar
                                        </button>
                                        <span class="label label-default" style="font-size: 11px; padding: 5px 10px; font-weight: normal; background-color: #f4f6f9; color: #333; border: 1px solid #d2d6de;">
                                            <i class="fa fa-keyboard-o text-primary"></i> <b>Bisa Langsung Ctrl + V:</b> Paste screenshot/gambar clipboard langsung ke dalam editor!
                                        </span>
                                    </div>
                                    <input type="hidden" name="tambah-soal-id" id="tambah-soal-id" value="<?php if(!empty($id_soal)){ echo $id_soal; } ?>">
                                    <input type="hidden" name="tambah-jawaban-id" id="tambah-jawaban-id" >
                                    <input type="hidden" name="tambah-jawaban" id="tambah-jawaban" >
                                    <textarea class="textarea" id="tambah_jawaban" name="tambah_jawaban" style="width: 100%; height: 100px; font-size: 13px; line-height: 25px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                    <p class="help-block">File gambar dapat di copy langsung (Ctrl+V) atau di upload melalui tombol Tambah / Kelola Gambar. Format yang didukung: JPG, PNG, GIF.</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jawaban</label>
                                <div class="col-sm-4">
                                    <select class="form-control input-sm" id="tambah-benar" name="tambah-benar">
                                        <option value="0">Salah</option>
                                        <option value="1">Benar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" id="btn-tambah-simpan" class="btn btn-primary"><span id="judul-tambah-simpan">Simpan</span></button>
                            <button type="button" id="btn-tambah-batal" class="btn btn-default"><span>Batal</span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                            <div class="box-title">Daftar Soal</div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
                        <table id="table-jawaban" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Soal</th>
                                    <th>Jawaban</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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

    <div class="modal" id="modal-hapus-jawaban" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/hapus_jawaban','id="form-hapus-jawaban"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Hapus Jawaban</div>
                </div>
                <div class="modal-body">
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan-hapus"></div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <input type="hidden" name="hapus-id" id="hapus-id">
                                <div id="hapus-jawaban"  style="max-height: 250px;overflow: auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn-hapus-jawaban" class="btn btn-primary">Hapus</button>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
                </div>
            </div>
        </div>

    </form>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-jawaban').dataTable().fnReloadAjax();
    }

    function refresh_table_image(){
        $('#table-image').dataTable().fnReloadAjax();
    }

    function edit(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $("#form-pesan").html('');
                $("#tambah-jawaban").val('');
                CKEDITOR.instances.tambah_jawaban.setData(data.jawaban)
                $('#tambah-benar').val(data.benar);
                $('#tambah-jawaban-id').val(data.id);

                $('html, body').animate({
                    scrollTop: $("#form-tambah").offset().top
                }, 500);
            }
            $("#modal-proses").modal('hide');
        });
    }

    function hapus(id){
        $('#hapus-id').val('');
        $('#hapus-jawaban').html('');
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#hapus-id').val(data.id);
                $('#hapus-jawaban').html(data.jawaban);
                
                $("#modal-hapus-jawaban").modal("show");
            }
            $("#modal-proses").modal('hide');
        });
    }

    /**
     * Fungsi untuk upload image dari editor
     */
    function imageUpload(){
        var topikVal = $('#topik').val();
        $('#image-topik-id').val(topikVal);
        $('#box-preview').addClass('hide');
        $('#image-preview').html('');
        $('#form-pesan-upload-image').html('');
        $('#image-isi').val('');
        $('#image-file').val('');

        refresh_table_image();

        $("#modal-image").modal("show");
    }

    function image_preview(posisi, image){
        $('#image-preview').html('<img src="<?php echo base_url(); ?>'+posisi+'/'+image+'" style="max-height: 110px;" />');
        $('#image-isi').val('<img src="<?php echo base_url(); ?>'+posisi+'/'+image+'" style="max-width: 600px;" />');
        $('#box-preview').removeClass('hide');
    }

    function batal_tambah(){
        $("#form-pesan").html('');
        $("#tambah-jawaban").val('');
        CKEDITOR.instances.tambah_jawaban.setData('')
        $('#tambah-benar').val('0');
        $('#tambah-jawaban-id').val('');
        $('#tambah-putar').val('1');
    }

    $(function(){
        $('#btn-image-insert').click(function(){
            var image = $('#image-isi').val();
            CKEDITOR.instances.tambah_jawaban.insertHtml(image);
            $("#modal-image").modal("hide");
        });

        $('#btn-tambah-batal').click(function(){
            batal_tambah();
        });

        /**
         * Submit form tambah soal
         */
        $('#form-tambah').submit(function(){
            $('#tambah-jawaban').val(CKEDITOR.instances.tambah_jawaban.getData());
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/tambah",
                    type:"POST",
                    timeout: 60000,
                    data:$('#form-tambah').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            batal_tambah();
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal menyimpan Jawaban, Silahkan Refresh Halaman");
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(textstatus);
                        }
                    }
            });
            return false;
        });

        /**
         * Submit form hapus soal
         */
        $('#form-hapus-jawaban').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/hapus_jawaban",
                    type:"POST",
                    data:$('#form-hapus-jawaban').serialize(),
                    cache: false,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            refresh_table();
                            $("#modal-proses").modal('hide');
                            $("#form-pesan-hapus").html('');
                            $("#modal-hapus-jawaban").modal('hide');
                            notify_success(obj.pesan);
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan-hapus').html(pesan_err(obj.pesan));
                        }
                    }
            });
            return false;
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
                            refresh_table();
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
		 
		$( document ).ready(function() {
            $('#table-jawaban').DataTable({
                  "bPaginate": false,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": true,
                  "aoColumns": [
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"90px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"50px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "soal", "value": $('#tambah-soal-id').val()} );
                  }
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

            var editorJawaban = CKEDITOR.replace('tambah_jawaban');
            setupPasteImage(editorJawaban, function(){
                return $('#topik').val();
            }, function(){
                return $('#tambah-soal-id').val();
            }, "<?php echo site_url().'/'.$url; ?>/upload_paste_image");

            <?php if(!empty($data_jawaban)){ echo $data_jawaban; } ?>
		});
    });

    /**
     * Helper untuk menangani Paste (Ctrl+V) langsung pada CKEditor Jawaban
     */
    function setupPasteImage(editorInstance, getTopikId, getSoalId, uploadUrl) {
        var isUploading = false;

        function uploadBlob(file) {
            if (isUploading) return;
            var topikId = getTopikId ? getTopikId() : '';
            var soalId = getSoalId ? getSoalId() : '';

            isUploading = true;
            var tempId = 'paste_img_' + new Date().getTime();
            var placeholderHtml = '<span id="' + tempId + '" class="label label-info" style="display:inline-block; padding:3px 8px; margin:2px; font-size:12px;"><i class="fa fa-spinner fa-spin"></i> Menempelkan gambar...</span>';
            editorInstance.insertHtml(placeholderHtml);

            var formData = new FormData();
            var filename = file.name || ('clipboard_' + new Date().getTime() + '.png');
            formData.append('upload_file', file, filename);
            formData.append('topik_id', topikId);
            formData.append('soal_id', soalId);

            $.ajax({
                url: uploadUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    isUploading = false;
                    var res = (typeof response === 'object') ? response : $.parseJSON(response);
                    var el = editorInstance.document ? editorInstance.document.getById(tempId) : null;
                    if (res.status == 1) {
                        if (el) {
                            el.$.outerHTML = res.image_tag;
                        } else {
                            editorInstance.insertHtml(res.image_tag);
                        }
                        notify_success(res.pesan);
                    } else {
                        if (el) {
                            el.remove();
                        }
                        notify_error(res.pesan);
                    }
                },
                error: function(xhr, status, error) {
                    isUploading = false;
                    var el = editorInstance.document ? editorInstance.document.getById(tempId) : null;
                    if (el) {
                        el.remove();
                    }
                    notify_error('Gagal mengunggah gambar paste: ' + error);
                }
            });
        }

        editorInstance.on('contentDom', function() {
            var doc = editorInstance.document;
            if (doc && doc.$) {
                doc.$.addEventListener('paste', function(e) {
                    var items = (e.clipboardData || window.clipboardData) ? (e.clipboardData || window.clipboardData).items : null;
                    if (items) {
                        for (var i = 0; i < items.length; i++) {
                            if (items[i].type.indexOf('image') !== -1) {
                                var blob = items[i].getAsFile();
                                if (blob) {
                                    e.preventDefault();
                                    e.stopPropagation();
                                    uploadBlob(blob);
                                    return false;
                                }
                            }
                        }
                    }
                });
            }
        });

        editorInstance.on('paste', function(evt) {
            if (evt.data && evt.data.dataTransfer && typeof evt.data.dataTransfer.getFilesCount === 'function' && evt.data.dataTransfer.getFilesCount() > 0) {
                var file = evt.data.dataTransfer.getFile(0);
                if (file && file.type && file.type.indexOf('image') !== -1) {
                    evt.cancel();
                    uploadBlob(file);
                }
            }
        });
    }
</script>