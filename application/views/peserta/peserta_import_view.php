<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Import Data Peserta
		<small>Penambahan data melalui Import data dari file Excel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url(); ?>/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Import Peserta</li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <div class="col-md-12">
            <div class="callout callout-info" style="margin-bottom: 15px;">
                <h4><i class="fa fa-shield"></i> Smart Screening Kelas &amp; Jurusan SMK (Anti-Salah Rombel)</h4>
                <p style="font-size: 13px; margin-bottom: 6px;">
                    Sistem ini dilengkapi <b>Screening Ketat &amp; Penyesuaian Sinonim Kelas Otomatis</b> agar tidak terjadi kasus soal ujian tidak muncul karena perbedaan singkatan kelas di Excel:
                </p>
                <ul style="font-size: 12.5px; margin-bottom: 0;">
                    <li><b>Otomatis Menyamakan Sinonim Jurusan &amp; Tingkat:</b> Jika di database terdaftar <code>X TBSM 1</code> namun di Excel tertulis <code>X TSM 1</code> atau <code>10 TSM 1</code>, siswa akan <b>otomatis dimasukkan ke kelas resmi <code>X TBSM 1</code></b> (begitu pula <code>TKR ↔ TKRO</code>, <code>MP/MPLB ↔ OTKP</code>, <code>AK ↔ AKL</code>, <code>TJKT ↔ TKJ</code>).</li>
                    <li><b>Proteksi Kelas Tidak Dikenal:</b> Jika ada nama kelas di Excel yang tidak ada di Daftar Kelas Resmi di bawah, sistem <b>tidak akan membuat kelas liar baru</b> melainkan menahannya dan menampilkan pilihan <b>Pemetaan Kelas</b> di layar ini.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Referensi Daftar Kelas Resmi yang Sudah Terdaftar di Database -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default collapsed-box" style="margin-bottom: 15px;">
                <div class="box-header with-border" style="cursor: pointer;" data-widget="collapse">
                    <h3 class="box-title" style="font-size: 14px; font-weight: 700;">
                        <i class="fa fa-check-circle text-green"></i> Acuan Daftar Kelas Resmi di Database Saat Ini (<?php echo !empty($kelas_resmi) ? count($kelas_resmi) : 0; ?> Rombel Terdaftar) — <small class="text-primary">Klik untuk lihat detail</small>
                    </h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="box-body" style="background: #f8fafc;">
                    <p style="font-size: 12px; color: #475569; margin-bottom: 8px;">
                        Gunakan salah satu nama kelas resmi berikut pada kolom <b>Group (Kolom E)</b> di Excel (atau gunakan sinonim jurusannya seperti <code>TSM</code>, <code>TKR</code>, <code>MP</code>, <code>AK</code> yang akan otomatis dipetakan ke kelas di bawah ini):
                    </p>
                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                        <?php if(!empty($kelas_resmi)){ foreach($kelas_resmi as $kr){ ?>
                            <span class="label label-default" style="font-size: 11.5px; padding: 5px 9px; background: #fff; color: #1e293b; border: 1px solid #cbd5e1; border-radius: 4px; font-weight: 600;">
                                <i class="fa fa-users text-primary"></i> <?php echo htmlspecialchars($kr->grup_nama); ?>
                                <small style="color: #00a65a; font-weight: normal;">(<?php echo $kr->jml_siswa; ?> siswa | <?php echo $kr->jml_tes; ?> tes)</small>
                            </span>
                        <?php } } else { ?>
                            <span class="text-red">Belum ada kelas terdaftar di menu Daftar Group!</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="row">
        <div class="col-md-12">
			<?php echo form_open_multipart($url.'/import','id="form-importsiswa"'); ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
    					<div class="box-title"><i class="fa fa-file-excel-o text-green"></i> Upload &amp; Screening File Excel Peserta</div>
    					<div class="box-tools pull-right">
							<div class="dropdown pull-right">
								<a href="<?php echo base_url(); ?>public/form/form-data-siswa.xlsx" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download Template Excel Siswa</a>
    						</div>
    					</div>
                    </div><!-- /.box-header -->

                    <div class="box-body">
						<label>
                            <?php if(!empty($error_upload)){ echo $error_upload; } ?>
                            <?php if(!empty($filename)){ echo '<span class="text-green"><i class="fa fa-check"></i> '.$filename.'</span>'; } ?>
                        </label>
                        <span id="form-pesan">
                            <?php if(!empty($error)){ echo $error; } ?>
                        </span>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pilih File Excel Peserta (<code>.xlsx</code>)</label>
                                    <input type="file" id="userfile" name="userfile" class="form-control">
                                    <p class="help-block" style="font-size: 11.5px;">Kolom Excel: <b>B</b>=Username, <b>C</b>=Password, <b>D</b>=Nama Lengkap, <b>E</b>=Email, <b>F</b>=Group/Kelas, <b>G</b>=Keterangan (Ruang/Sesi).</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Perlakuan Jika Username Siswa Sudah Ada di Database</label>
                                    <select name="mode_update" class="form-control">
                                        <option value="ya" selected>🔄 Perbarui Otomatis Data Kelas, Ruang/Sesi, Nama &amp; Password Siswa</option>
                                        <option value="skip">⏭️ Lewati (Jangan Ubah Data Siswa yang Sudah Terdaftar)</option>
                                    </select>
                                    <p class="help-block" style="font-size: 11.5px;">Pilih "Perbarui Otomatis" jika Anda ingin memperbaiki kelas atau ruang siswa yang salah dari import sebelumnya.</p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(!empty($hasil)){ echo $hasil; } ?>
                    </div>
					
					<div class="box-footer">
                        <button type="submit" class="btn btn-primary" id="import"><i class="fa fa-search-plus"></i> Jalankan Screening &amp; Import Peserta</button>
                    </div>
                </div>
			<?php echo form_close(); ?> 
        </div>
    </div>
</section><!-- /.content -->



<script lang="javascript">
    function refresh_table(){
        $('#table-peserta').dataTable().fnReloadAjax();
    }

    function tambah(){
        $('#form-pesan').html('');
        $('#tambah-username').val('');
        $('#tambah-password').val('');
        $('#tambah-nama').val('');
        $('#tambah-email').val('');

        $("#modal-tambah").modal("show");
        $('#tambah-username').focus();
    }

    function edit(id){
        $("#modal-proses").modal('show');
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_by_id/'+id+'', function(data){
            if(data.data==1){
                $('#edit-id').val(data.id);
                $('#edit-username').val(data.username);
                $('#edit-password').val(data.password);
                $('#edit-nama').val(data.nama);
                $('#edit-email').val(data.email);
                $('#edit-group').val(data.group);
                
                $("#modal-edit").modal("show");
            }
            $("#modal-proses").modal('hide');
        });
    }

    $(function(){
        $("#group").change(function(){
            refresh_table();
        });

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
    });
</script>