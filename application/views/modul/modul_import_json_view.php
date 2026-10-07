<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Import Soal JSON / AI Generator
		<small>Unggah naskah soal instan dengan format JSON (ChatGPT, DeepSeek, Claude)</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo site_url('manager/modul_daftar'); ?>">Data Modul</a></li>
		<li class="active">Import JSON</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- 1. BANTUAN TEMPLATE PROMPT AI -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info collapsed-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="cursor: pointer;" data-widget="collapse">
                    <h3 class="box-title" style="font-weight: 700; font-size: 15px; color: #0984e3;">
                        <i class="fa fa-magic"></i> Ingin Buat Soal Otomatis Menggunakan AI (ChatGPT / DeepSeek)? Klik di sini!
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body" style="padding: 20px;">
                    <p class="text-muted">
                        Anda dapat meminta AI (ChatGPT, DeepSeek, Claude, Gemini) membuatkan 40 butir soal pilihan ganda lengkap dengan 5 opsi (A–E) dan kunci jawaban dalam hitungan detik. Cukup salin template perintah di bawah ini:
                    </p>
                    <div style="position: relative;">
                        <pre id="prompt-template-text" style="background: #2d3436; color: #dfe6e9; padding: 15px; border-radius: 6px; font-family: Consolas, monospace; font-size: 12px; max-height: 200px; overflow-y: auto;">Buatkan 40 butir soal pilihan ganda untuk mata pelajaran [NAMA MATA PELAJARAN] tingkat SMK kelas [KELAS X / XI / XII] materi [NAMA MATERI].

Ketentuan format keluaran:
1. Setiap soal memiliki 5 pilihan jawaban (A, B, C, D, E) dan 1 kunci jawaban benar.
2. WAJIB keluaran HANYA dalam format JSON MURNI tanpa kata pengantar, penjelasan, atau penutup.

Struktur JSON yang diinginkan:
[
  {
    "soal": "Tuliskan pertanyaan nomor 1 di sini...",
    "A": "Teks pilihan jawaban A",
    "B": "Teks pilihan jawaban B",
    "C": "Teks pilihan jawaban C",
    "D": "Teks pilihan jawaban D",
    "E": "Teks pilihan jawaban E",
    "kunci": "A"
  }
]</pre>
                        <button type="button" class="btn btn-success btn-sm" onclick="salin_prompt_ai()" style="position: absolute; top: 10px; right: 15px; font-weight: 700;">
                            <i class="fa fa-copy"></i> Salin Template Prompt AI
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. FORM INPUT IMPORT SOAL JSON -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary" style="border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700; font-size: 16px;">
                        <i class="fa fa-code text-primary"></i> Formulir Import Soal JSON
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-sm" onclick="isi_contoh_json()" style="font-weight: 600;">
                            <i class="fa fa-lightbulb-o text-yellow"></i> Isi Contoh JSON Demo
                        </button>
                    </div>
                </div>

                <div class="box-body" style="padding: 20px;">
                    <!-- Filter Bantu Pemilihan Topik -->
                    <div class="row" style="background: #f8fafc; padding: 15px 10px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
                        <div class="col-md-3 col-xs-6">
                            <label style="font-size: 11px; text-transform: uppercase; color: #64748b;">Filter Hari Ujian:</label>
                            <select id="filter-hari" class="form-control input-sm">
                                <option value="">-- Semua Hari --</option>
                                <option value="SENIN">Senin</option>
                                <option value="SELASA">Selasa</option>
                                <option value="RABU">Rabu</option>
                                <option value="KAMIS">Kamis</option>
                                <option value="JUMAT">Jumat</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <label style="font-size: 11px; text-transform: uppercase; color: #64748b;">Filter Tingkat Kelas:</label>
                            <select id="filter-grade" class="form-control input-sm">
                                <option value="">-- Semua Tingkat --</option>
                                <option value="X">Kelas X</option>
                                <option value="XI">Kelas XI</option>
                                <option value="XII">Kelas XII</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12" style="margin-top: 5px;">
                            <label style="font-weight: 700; color: #1e293b;">
                                <i class="fa fa-folder-open text-primary"></i> Pilih Topik Mata Pelajaran Tujuan: <span class="text-danger">*</span>
                            </label>
                            <select name="topik" id="topik" class="form-control input-sm" style="width: 100%;">
                                <?php if(!empty($select_topik)){ echo $select_topik; } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Pilihan Tab Metode Input JSON -->
                    <div class="nav-tabs-custom" style="box-shadow: none; margin-bottom: 0;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab-paste" data-toggle="tab" style="font-weight: 700;"><i class="fa fa-paste text-blue"></i> Tempel Teks JSON (Paste)</a></li>
                            <li><a href="#tab-upload" data-toggle="tab" style="font-weight: 700;"><i class="fa fa-upload text-green"></i> Unggah Berkas .json</a></li>
                        </ul>
                        <div class="tab-content" style="padding: 20px 0;">
                            <!-- TAB 1: PASTE TEXT -->
                            <div class="tab-pane active" id="tab-paste">
                                <div class="form-group" style="margin-bottom: 5px;">
                                    <label style="font-weight: 600;">Tempelkan Kode JSON Soal di Sini:</label>
                                    <textarea id="json-input" class="form-control" rows="12" placeholder='Tempelkan JSON di sini, contoh:
[
  {
    "soal": "Komponen utama komputer pemroses data adalah...",
    "A": "Harddisk",
    "B": "CPU",
    "C": "Power Supply",
    "D": "RAM",
    "E": "Motherboard",
    "kunci": "B"
  }
]' style="font-family: Consolas, monospace; font-size: 13px; border-radius: 6px;"></textarea>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 5px;">
                                    <span class="text-muted" style="font-size: 12px;" id="json-char-count">0 karakter</span>
                                    <div>
                                        <button type="button" class="btn btn-default btn-xs" onclick="format_json()"><i class="fa fa-indent"></i> Rapikan Format JSON</button>
                                        <button type="button" class="btn btn-default btn-xs" onclick="$('#json-input').val(''); update_char_count();"><i class="fa fa-trash"></i> Bersihkan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: UPLOAD FILE -->
                            <div class="tab-pane" id="tab-upload">
                                <div class="form-group">
                                    <label style="font-weight: 600;">Pilih File JSON (.json):</label>
                                    <input type="file" id="file-json" class="form-control" accept=".json,application/json" style="padding: 5px; height: auto;">
                                    <p class="help-block">Pastikan file berformat <code>.json</code> dengan ukuran maksimal 5 MB.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px;">
                        <button type="button" id="btn-validasi" class="btn btn-primary btn-flat" style="font-weight: 700; padding: 10px 24px; border-radius: 4px;">
                            <i class="fa fa-search"></i> 1. Cek & Validasi JSON
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. PANEL PRATINJAU SOAL HASIL VALIDASI -->
    <div class="row" id="panel-preview" style="display: none;">
        <div class="col-xs-12">
            <div class="box box-success" style="border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
                <div class="box-header with-border" style="padding: 15px 20px;">
                    <h3 class="box-title" style="font-weight: 700; font-size: 16px; color: #27ae60;">
                        <i class="fa fa-check-circle"></i> Pratinjau Soal Terdeteksi (<span id="preview-count">0</span> Butir Soal)
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" id="btn-simpan" class="btn btn-success btn-sm btn-flat" style="font-weight: 700; padding: 6px 16px; border-radius: 4px;">
                            <i class="fa fa-save"></i> 2. Simpan Semua Soal ke Bank Soal
                        </button>
                    </div>
                </div>

                <div class="box-body" style="padding: 20px;">
                    <div class="alert alert-info" style="border-radius: 6px; margin-bottom: 15px;">
                        <i class="fa fa-info-circle"></i> Kunci jawaban yang ditandai hijau <strong>[KUNCI]</strong> adalah jawaban yang akan dinilai benar oleh sistem ZYA CBT. Periksa kembali sebelum menyimpan.
                    </div>

                    <div id="preview-container"></div>

                    <div class="text-right" style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 15px;">
                        <button type="button" class="btn btn-default" onclick="$('#panel-preview').slideUp();" style="margin-right: 5px;">
                            Batal
                        </button>
                        <button type="button" id="btn-simpan-bawah" class="btn btn-success btn-lg btn-flat" style="font-weight: 700; padding: 10px 28px; border-radius: 4px;">
                            <i class="fa fa-save"></i> Simpan <span class="badge-total-save"></span> Butir Soal Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section><!-- /.content -->

<!-- MODAL PROSES LOADING -->
<div class="modal fade" id="modal-proses-import" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="margin-top: 15%;">
        <div class="modal-content" style="border-radius: 8px; text-align: center; padding: 25px;">
            <i class="fa fa-spinner fa-spin fa-3x text-primary" style="margin-bottom: 15px;"></i>
            <h4 style="font-weight: 700; margin-bottom: 5px;" id="modal-proses-title">Memproses...</h4>
            <p class="text-muted" style="margin-bottom: 0;" id="modal-proses-desc">Mohon tunggu sebentar...</p>
        </div>
    </div>
</div>

<script lang="javascript">
    function salin_prompt_ai(){
        var text = document.getElementById('prompt-template-text').innerText;
        navigator.clipboard.writeText(text).then(function() {
            notify_success('Template Prompt AI berhasil disalin! Silakan paste ke ChatGPT / DeepSeek.');
        }, function() {
            alert('Gagal menyalin otomatis. Silakan pilih dan salin teks secara manual.');
        });
    }

    function isi_contoh_json(){
        var contoh = [
            {
                "soal": "Perangkat keras komputer yang berfungsi sebagai otak utama dalam memproses instruksi aritmatika dan logika adalah...",
                "A": "Harddisk Drive (HDD)",
                "B": "Central Processing Unit (CPU)",
                "C": "Random Access Memory (RAM)",
                "D": "Power Supply Unit (PSU)",
                "E": "Video Graphic Array (VGA)",
                "kunci": "B"
            },
            {
                "soal": "Protokol jaringan internet yang berfungsi secara aman (terenkripsi) untuk mengakses halaman web adalah...",
                "A": "HTTP",
                "B": "FTP",
                "C": "HTTPS",
                "D": "SMTP",
                "E": "DHCP",
                "kunci": "C"
            },
            {
                "soal": "Berapakah hasil perhitungan dari nilai biner 1010 dalam sistem bilangan desimal?",
                "A": "8",
                "B": "9",
                "C": "10",
                "D": "12",
                "E": "14",
                "kunci": "C"
            }
        ];

        $('#json-input').val(JSON.stringify(contoh, null, 2));
        update_char_count();
        notify_info('Contoh 3 butir soal JSON berhasil dimuat ke kotak input.');
    }

    function format_json(){
        var val = $('#json-input').val().trim();
        if(!val) return;
        try {
            var obj = JSON.parse(val);
            $('#json-input').val(JSON.stringify(obj, null, 2));
            notify_success('JSON berhasil dirapikan!');
        } catch(e) {
            notify_error('Gagal merapikan: format JSON belum valid (' + e.message + ')');
        }
    }

    function update_char_count(){
        var len = $('#json-input').val().length;
        $('#json-char-count').text(len.toLocaleString() + ' karakter');
    }

    $(function(){
        $('#topik').select2({
            width: '100%',
            placeholder: "🔍 Ketik untuk mencari topik mata pelajaran..."
        });

        $('#json-input').on('input propertychange', function(){
            update_char_count();
        });

        // Filter Dropdown Topik
        $('#filter-hari, #filter-grade').on('change', function(){
            var hari = $('#filter-hari').val().toUpperCase();
            var grade = $('#filter-grade').val().toUpperCase();

            $('#topik option').each(function(){
                var opt_hari = ($(this).attr('data-hari') || '').toUpperCase();
                var opt_grade = ($(this).attr('data-grade') || '').toUpperCase();

                var match_hari = (hari === '' || opt_hari === hari);
                var match_grade = (grade === '' || opt_grade === grade);

                if(match_hari && match_grade){
                    $(this).removeAttr('disabled');
                } else {
                    $(this).attr('disabled', 'disabled');
                }
            });

            $('#topik').select2();
        });

        // 1. AJAX Validasi & Pratinjau
        $('#btn-validasi').click(function(){
            var topik = $('#topik').val();
            if(!topik || topik === 'kosong'){
                notify_error('Silakan pilih topik mata pelajaran tujuan terlebih dahulu!');
                return;
            }

            var formData = new FormData();
            formData.append('topik_id', topik);
            formData.append('json_data', $('#json-input').val());

            var fileInput = document.getElementById('file-json');
            if(fileInput.files.length > 0){
                formData.append('file_json', fileInput.files[0]);
            }

            $('#modal-proses-title').text('Memvalidasi JSON...');
            $('#modal-proses-desc').text('Mengecek struktur soal dan kunci jawaban...');
            $('#modal-proses-import').modal('show');

            $.ajax({
                url: '<?php echo site_url($url."/validasi_json"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res){
                    $('#modal-proses-import').modal('hide');
                    if(res.status === 1){
                        $('#preview-count').text(res.total_soal);
                        $('.badge-total-save').text(res.total_soal);
                        $('#preview-container').html(res.preview_html);
                        $('#panel-preview').slideDown(400);

                        $('html, body').animate({
                            scrollTop: $("#panel-preview").offset().top - 30
                        }, 500);

                        notify_success('Berhasil memvalidasi ' + res.total_soal + ' butir soal!');
                    } else {
                        $('#panel-preview').slideUp();
                        notify_error(res.pesan);
                    }
                },
                error: function(xhr, status, error){
                    $('#modal-proses-import').modal('hide');
                    notify_error('Terjadi kesalahan koneksi server: ' + error);
                }
            });
        });

        // 2. AJAX Simpan ke Database
        $('#btn-simpan, #btn-simpan-bawah').click(function(){
            var topik = $('#topik').val();
            if(!topik || topik === 'kosong'){
                notify_error('Topik mata pelajaran belum dipilih!');
                return;
            }

            if(!confirm('Apakah Anda yakin ingin menyimpan seluruh butir soal ini ke topik yang dipilih?')){
                return;
            }

            var formData = new FormData();
            formData.append('topik_id', topik);
            formData.append('json_data', $('#json-input').val());

            var fileInput = document.getElementById('file-json');
            if(fileInput.files.length > 0){
                formData.append('file_json', fileInput.files[0]);
            }

            $('#modal-proses-title').text('Menyimpan ke Database...');
            $('#modal-proses-desc').text('Sedang memasukkan butir soal dan pilihan jawaban...');
            $('#modal-proses-import').modal('show');

            $.ajax({
                url: '<?php echo site_url($url."/simpan_json"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res){
                    $('#modal-proses-import').modal('hide');
                    if(res.status === 1){
                        alert(res.pesan);
                        window.location.href = '<?php echo site_url("manager/modul_daftar?topik_id="); ?>' + topik;
                    } else {
                        notify_error(res.pesan);
                    }
                },
                error: function(xhr, status, error){
                    $('#modal-proses-import').modal('hide');
                    notify_error('Gagal menyimpan: ' + error);
                }
            });
        });

        // Auto select jika ada selected_topik_id
        <?php if(!empty($selected_topik_id)){ ?>
            $('#topik').val('<?php echo $selected_topik_id; ?>').trigger('change');
        <?php } ?>
    });
</script>
