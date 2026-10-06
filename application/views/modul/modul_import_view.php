<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Mengimport Soal dari Spreadsheet
		<small>Melakukan Import Soal dari Spreadsheet berdasarkan modul dan topik</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Import Soal</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
		<?php echo form_open_multipart($url.'/import','id="form-importsoal"'); ?>
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
					</div>

                    <div id="box-topik-info" style="display: none; background: #e8f4f8; border: 1px solid #d2e8f1; border-left: 3px solid #3c8dbc; padding: 8px 10px; border-radius: 3px; font-size: 12px; margin-top: 10px;">
                        <b style="color: #286090;"><i class="fa fa-info-circle"></i> Topik Terpilih:</b><br>
                        <span id="info-nama-topik" style="font-weight: 600; color: #222;"></span>
                    </div>
                </div>
                <div class="box-footer">
                    <p class="text-muted" style="font-size: 11px; margin: 0;"><i class="fa fa-lightbulb-o text-yellow"></i> Gunakan filter Hari, Grade, atau Mapel untuk mempercepat pencarian, atau ketik kata kunci langsung di kotak topik.</p>
                </div>
            </div>
        </div>
		<div class="col-md-8">
			<div class="box box-success">
                <div class="box-header with-border">
                    <div class="box-title"><i class="fa fa-file-excel-o text-green"></i> Upload Spreadsheet Soal</div>
					<div class="box-tools pull-right">
						<div class="dropdown pull-right">
							<a href="<?php echo base_url(); ?>public/form/form-soal-ganda.xlsx" class="btn btn-default btn-xs">
                                <i class="fa fa-download text-green"></i> Download Form Excel Pilihan Ganda
                            </a>
    					</div>
    				</div>
                </div><!-- /.box-header -->

                <div class="box-body">
					<span id="form-pesan"></span>
                    <div class="form-group">
                        <label>Pilih File Excel (.xlsx / .xls)</label>
                        <input type="file" id="userfile" name="userfile" class="form-control" accept=".xlsx, .xls">
						<p class="help-block" style="font-size: 12px; margin-top: 8px;">
                            <i class="fa fa-info-circle text-primary"></i> Soal yang dapat diimport adalah soal jenis <b>Pilihan Ganda</b>. Pastikan format kolom sesuai dengan template Excel yang disediakan.
                        </p>
					</div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right" id="import">
                        <i class="fa fa-upload"></i> Proses Import Soal
                    </button>
                </div>
            </div>
        </div>
		</form>
    </div>
</section><!-- /.content -->

<script type="text/javascript">
    var originalTopikList = [];

    function batal_tambah(){
        $("#form-pesan").html('');
        $('#userfile').val('');
    }

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

            // Ekstrak hari jika belum terisi
            if(!hari){
                var mHari = text.match(/\[(SENIN|SELASA|RABU|KAMIS|JUMAT)/i);
                if(mHari) hari = mHari[1].toUpperCase();
            }

            // Ekstrak grade jika belum terisi
            if(!grade){
                if(/\bXII\b/i.test(text)){
                    grade = 'XII';
                }else if(/\bXI\b/i.test(text)){
                    grade = 'XI';
                }else if(/\bX\b/i.test(text)){
                    grade = 'X';
                }
            }

            // Ekstrak modul dari optgroup jika belum ada
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

        // Isi dropdown filter Mapel secara alfabetis
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

        // Update badge total
        if(filtered.length === originalTopikList.length){
            $('#badge-count').text(filtered.length + ' Topik');
        }else{
            $('#badge-count').text(filtered.length + ' dari ' + originalTopikList.length);
        }

        // Kelompokkan hasil berdasarkan modul
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

        // Simpan state select2
        if($('#topik').data('select2')){
            $('#topik').select2('destroy');
        }

        $('#topik').html(html);

        // Jika hanya 1 item cocok dan bukan inisialisasi awal, pilih otomatis
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

        /**
         * Submit form import soal
         */
        $('#form-importsoal').submit(function(e){
            var topikVal = $('#topik').val();
            if(!topikVal || topikVal === '' || topikVal === 'kosong'){
                notify_error('Silahkan pilih Topik Soal terlebih dahulu!');
                $('#topik').select2('open');
                return false;
            }

            var fileVal = $('#userfile').val();
            if(!fileVal){
                notify_error('Silahkan pilih file Spreadsheet Excel (.xlsx / .xls) yang akan diimport!');
                $('#userfile').focus();
                return false;
            }

            $("#modal-proses").modal('show');
            $.ajax({
                url: "<?php echo site_url().'/'.$url; ?>/import",
                type: "POST",
                timeout: 300000,
                data: new FormData(this),
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function(respon){
                    var obj = $.parseJSON(respon);
                    $("#modal-proses").modal('hide');
                    if(obj.status==1){
                        batal_tambah();
                        $('#form-pesan').html(obj.pesan);
                        notify_success('Import soal berhasil diproses!');
                    }else{
                        $('#form-pesan').html(pesan_err(obj.pesan));
                    }
                },
                statusCode: {
                    500: function(respon) {
                        $("#modal-proses").modal('hide');
                        $('#form-pesan').html(pesan_err('Terjadi kesalahan pada File yang di Upload. Silahkan cek terlebih dahulu file yang anda upload.'));
                    }
                },
                error: function(xmlhttprequest, textstatus, message) {
                    $("#modal-proses").modal('hide');
                    if(textstatus==="timeout") {
                        notify_error("Gagal mengimport Soal, batas waktu habis. Silahkan coba lagi.");
                    }else{
                        notify_error(textstatus);
                    }
                }
            });
            return false;
        });
    });
</script>