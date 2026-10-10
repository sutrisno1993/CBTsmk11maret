<div class="container">
	<!-- Content Header (Page header) -->
    <section class="content-header" style="padding: 15px 0 12px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h1 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa fa-pencil-square-o" style="color: #2563eb; margin-right: 6px;"></i> Mata Uji: <?php if(!empty($tes_name)){ echo htmlspecialchars($tes_name); } ?>
            </h1>
            <div class="breadcrumb" style="position: static; float: none; background: transparent; padding: 0; margin: 0; display: flex; align-items: center; gap: 6px;">
                <span style="font-size: 12px; color: #64748b; font-weight: 600;">Font:</span>
                <button type="button" class="btn btn-xs btn-default" onclick="zoomnormal()" title="Ukuran Font Normal" style="border-radius: 6px; font-weight: bold; padding: 3px 10px;">A</button>
                <button type="button" class="btn btn-xs btn-primary" onclick="zoombesar()" title="Ukuran Font Lebih Besar" style="border-radius: 6px; font-weight: bold; padding: 3px 10px; font-size: 13px;">A+</button>
            </div>
        </div>
    </section>

	<!-- Main content -->
    <section class="content" style="padding: 0;">
    	<div class="row">
        <?php echo form_open('tes_kerjakan/simpan_jawaban','id="form-kerjakan"')?>
            <input type="hidden" name="tes-id" id="tes-id" value="<?php if(!empty($tes_id)){ echo $tes_id; } ?>">
            <input type="hidden" name="tes-user-id" id="tes-user-id" value="<?php if(!empty($tes_user_id)){ echo $tes_user_id; } ?>">
            <input type="hidden" name="tes-soal-id" id="tes-soal-id" value="<?php if(!empty($tes_soal_id)){ echo $tes_soal_id; } ?>">
            <input type="hidden" name="tes-soal-nomor" id="tes-soal-nomor"  value="<?php if(!empty($tes_soal_nomor)){ echo $tes_soal_nomor; } ?>">
            <input type="hidden" name="tes-soal-jml" id="tes-soal-jml" value="<?php if(!empty($tes_soal_jml)){ echo $tes_soal_jml; } ?>">
            <input type="hidden" name="tes-soal-ragu" id="tes-soal-ragu" value="<?php if(!empty($tes_ragu)){ echo $tes_ragu; } ?>">
    		<div class="box box-success box-solid" style="border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                <div class="box-header with-border" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 18px;">
                    <h3 class="box-title" style="font-size: 16px; font-weight: 700; margin: 0;">
                        <i class="fa fa-question-circle" style="margin-right: 6px;"></i> Soal <span id="judul-soal"><?php if(!empty($tes_soal_nomor)){ echo 'Nomor '.$tes_soal_nomor; } ?></span>
                    </h3>
                    <div class="box-tools pull-right" style="position: static; margin: 0;">
                        <div id="sisa-waktu"></div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 24px 20px;">
                    <div id="isi-tes-soal" style="font-size: 15.5px; line-height: 1.7; color: #1e293b;">
                        <?php if(!empty($tes_soal)){ echo $tes_soal; } ?>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer" style="padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <button type="button" class="btn btn-default hide" id="btn-sebelumnya" style="border-radius: 8px; padding: 8px 18px; font-weight: 600;">
                            <i class="fa fa-chevron-left" style="margin-right: 5px;"></i> Soal Sebelumnya
                        </button>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <div class="btn btn-warning" id="btn-ragu" onclick="ragu()" style="border-radius: 8px; padding: 8px 18px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                            <input type="checkbox" style="width: 15px; height: 15px; margin: 0;" name="btn-ragu-checkbox" id="btn-ragu-checkbox" <?php if(!empty($tes_ragu)){ echo "checked"; } ?> /> 
                            <span>Ragu-ragu</span>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn-selanjutnya" style="border-radius: 8px; padding: 8px 22px; font-weight: 700;">
                            Soal Selanjutnya <i class="fa fa-chevron-right" style="margin-left: 5px;"></i>
                        </button>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    	</div>
        <div class="row">
            <div class="box box-success box-solid" style="border-radius: 12px; overflow: hidden; margin-bottom: 30px;">
                <div class="box-header with-border" style="padding: 12px 18px;">
                    <h3 class="box-title" style="font-size: 15px; font-weight: 700;">
                        <i class="fa fa-th" style="margin-right: 6px;"></i> Lembar Jawaban &amp; Navigasi Nomor Soal
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 18px;">
                    <div style="line-height: 2.2;">
                        <?php if(!empty($tes_daftar_soal)){ echo $tes_daftar_soal; } ?>
                    </div>
                    <div style="margin-top: 14px; font-size: 12px; color: #64748b; display: flex; gap: 16px; flex-wrap: wrap; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 12px;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="display:inline-block; width:13px; height:13px; background:#2563eb; border-radius:3px;"></span> Sudah Dijawab
                        </span>
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="display:inline-block; width:13px; height:13px; background:#f59e0b; border-radius:3px;"></span> Ragu-ragu
                        </span>
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="display:inline-block; width:13px; height:13px; background:#ffffff; border:1px solid #cbd5e1; border-radius:3px;"></span> Belum Dijawab
                        </span>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer" style="padding: 14px 18px; text-align: right;">
                    <button class="btn btn-default" id="btn-hentikan" style="border-radius: 8px; font-weight: 600; padding: 8px 20px; border-color: #cbd5e1;">
                        <i class="fa fa-flag-checkered" style="color: #ef4444; margin-right: 5px;"></i> Selesaikan Ujian
                    </button>
                </div>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->

    <div class="modal" style="max-height: 100%;overflow-y: auto;" id="modal-hentikan" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <?php echo form_open($url.'/hentikan_tes','id="form-hentikan"'); ?>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <div id="trx-judul">Konfirmasi Hentikan Tes</div>
                </div>
                <div class="modal-body" >
                    <div class="row-fluid">
                        <div class="box-body">
                            <div id="form-pesan"></div>
                            <div class="callout callout-info">
                                <p>Apakah anda yakin mengakhiri mata uji ini ?
								<br />Jawaban Tes yang sudah selesai tidak dapat diubah.
								</p>
								
                            </div>
                            <div class="form-group">
                                <label>Nama Tes</label>
                                <input type="hidden" name="hentikan-tes-id" id="hentikan-tes-id" >
                                <input type="hidden" name="hentikan-tes-user-id" id="hentikan-tes-user-id" >
                                <input type="text" class="form-control" id="hentikan-tes-nama" name="hentikan-tes-nama" readonly>
                            </div>

                            <div class="form-group">
                                <label>Keterangan Soal</label>
                                <input type="text" class="form-control" id="hentikan-dijawab" name="hentikan-dijawab" readonly>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="hentikan-centang" name="hentikan-centang" value="1"> Centang dan klik tombol Hentikan Tes.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="box-footer">
					<button type="submit" id="tambah-simpan" class="btn btn-primary">Hentikan Tes</button>
					<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
				</div>
            </div>
        </div>

    </form>
    </div>

<?php if(!empty($cbt_anti_cheating) && $cbt_anti_cheating == 'ya'){ ?>
    <div class="modal" id="modal-cheating-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-top: 4px solid #dd4b39;">
                <div class="modal-header" style="color: #fff; background-color: #dd4b39;">
                    <h4 class="modal-title"><i class="fa fa-exclamation-triangle"></i> PERINGATAN PELANGGARAN UJIAN</h4>
                </div>
                <div class="modal-body text-center" style="padding: 25px;">
                    <i class="fa fa-ban" style="font-size: 55px; color: #dd4b39; margin-bottom: 15px;"></i>
                    <h3 style="margin-top: 0; color: #dd4b39; font-weight: bold;">Terdeteksi Meninggalkan Layar Ujian!</h3>
                    <p style="font-size: 15px;">
                        Anda terdeteksi berpindah tab, membuka aplikasi lain, atau meminimalkan browser ujian.
                    </p>
                    <div class="alert alert-danger" style="margin-top: 15px; text-align: left;">
                        <strong>Catatan Pelanggaran:</strong>
                        <p style="margin: 5px 0 0 0; font-size: 16px;">
                            Pelanggaran ke- <strong id="cheating-count" style="font-size: 22px;">1</strong> dari <strong>3</strong> batas maksimal.
                        </p>
                        <small>Peringatan: Jika Anda melanggar sebanyak 3 kali, ujian Anda akan otomatis <strong>dihentikan dan dinilai apa adanya</strong>.</small>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-danger btn-lg" id="btn-tutup-cheating-warning">Saya Mengerti &amp; Kembali ke Ujian</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-offline-warning" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-top: 4px solid #f39c12;">
                <div class="modal-header" style="color: #fff; background-color: #f39c12;">
                    <h4 class="modal-title"><i class="fa fa-wifi"></i> KONEKSI JARINGAN TERPUTUS</h4>
                </div>
                <div class="modal-body text-center" style="padding: 25px;">
                    <i class="fa fa-chain-broken" style="font-size: 55px; color: #f39c12; margin-bottom: 15px;"></i>
                    <h3 style="margin-top: 0; color: #f39c12; font-weight: bold;">Sambungan Wi-Fi Terputus</h3>
                    <p style="font-size: 15px;">
                        Perangkat Anda kehilangan koneksi ke server ujian. Silakan sambungkan kembali Wi-Fi Anda.
                    </p>
                    <div class="alert alert-warning" style="margin-top: 15px; text-align: left;">
                        <i class="fa fa-info-circle"></i> <strong>Penghitungan pelanggaran ditangguhkan sementara</strong> saat Wi-Fi Anda terputus. Silakan hubungkan kembali ke Wi-Fi lab / sekolah.
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-warning btn-lg" id="btn-reconnect-wifi">Periksa Ulang Koneksi</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /.container -->

<script type="text/javascript">
    function zoombesar(){
        $('#isi-tes-soal').css("font-size", "140%");
        $('#isi-tes-soal').css("line-height", "140%");
    }

    function zoomnormal(){
        $('#isi-tes-soal').css("font-size", "15px");
        $('#isi-tes-soal').css("line-height", "110%");
    }

    function ragu(){
        $("#modal-proses").modal('show');

        $.ajax({
            url:'<?php echo site_url().'/'.$url; ?>/get_tes_soal_by_tessoal/'+$('#tes-soal-id').val(),
            type:"POST",
            cache: false,
            timeout: 10000,
            success:function(respon){
                var data = $.parseJSON(respon);
                if(data.data==1){
                    // Mengubah nilai ragu-ragu di database
                    if($('#tes-soal-ragu').val()==0){
                        var ragu=1;
                    }else{
                        var ragu=0;
                    }
                    $.ajax({
                            url:'<?php echo site_url().'/'.$url; ?>/update_tes_soal_ragu/'+$('#tes-soal-id').val()+'/'+ragu,
                            type:"POST",
                            cache: false,
                            timeout: 5000,
                            success:function(respon){
                                var data = $.parseJSON(respon);
                                if(data.data==1){
                                    notify_success('Jawaban Ragu-ragu berhasil diubah');
                                }
                            },
                            error: function(xmlhttprequest, textstatus, message) {
                                if(textstatus==="timeout") {
                                    $("#modal-proses").modal('hide');
                                    notify_error("Gagal mengubah Soal, Silahkan Refresh Halaman");
                                }else{
                                    $("#modal-proses").modal('hide');
                                    notify_error(textstatus);
                                }
                            }
                    });

                    // Mengubah warna daftar soal dan checkbox pada tombol ragu-ragu
                    if(data.tessoal_dikerjakan==1){
                        if($('#tes-soal-ragu').val()==0){
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-primary');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        }else{
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-primary');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    }else{
                        if($('#tes-soal-ragu').val()==0){
                            // Membuat menjadi ragu-ragu
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-default');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-warning');
                            $('#btn-ragu-checkbox').prop("checked", true);
                            $('#tes-soal-ragu').val(1);
                        }else{
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning');
                            $('#btn-soal-'+$('#tes-soal-nomor').val()).addClass('btn-default');
                            $('#btn-ragu-checkbox').prop("checked", false);
                            $('#tes-soal-ragu').val(0);
                        }
                    }
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal mengubah soal, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
    }

    function soal(tessoal_id){
        $("#modal-proses").modal('show');
        $.ajax({
            url:'<?php echo site_url().'/'.$url; ?>/get_soal_by_tessoal/'+tessoal_id+'/'+$('#tes-user-id').val(),
            type:"POST",
            cache: false,
            timeout: 10000,
            success:function(respon){
                var data = $.parseJSON(respon);
                if(data.data==1){
                    $('#tes-soal-id').val(data.tes_soal_id);
                    $('#tes-soal-nomor').val(data.tes_soal_nomor);
                    $('#isi-tes-soal').html(data.tes_soal);
                    $('#tes-soal-ragu').val(data.tes_ragu);
                    $('#judul-soal').html('ke '+data.tes_soal_nomor);

                    if(data.tes_ragu==0){
                        // Menghilangkan checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", false);
                    }else{
                        // Menambah checkbox ragu-ragu
                        $('#btn-ragu-checkbox').prop("checked", true);
                    }

                    // menghilangkan tombol sebelum jika soal di nomor1
                    // dan menghilangkan tombol selanjutnya jika disoal terakhir
                    var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
                    var tes_soal_jml = parseInt($('#tes-soal-jml').val());
                    var tes_soal_tujuan = data.tes_soal_nomor;
                    if(tes_soal_tujuan==1){
                        $('#btn-sebelumnya').addClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    }else if(tes_soal_tujuan==tes_soal_jml){
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').addClass('hide');
                    }else{
                        $('#btn-sebelumnya').removeClass('hide');
                        $('#btn-selanjutnya').removeClass('hide');
                    }

                }else if(data.data==2){
                    window.location.reload();
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                if(textstatus==="timeout") {
                    $("#modal-proses").modal('hide');
                    notify_error("Gagal mengambil Soal, Silahkan Refresh Halaman");
                }else{
                    $("#modal-proses").modal('hide');
                    notify_error(textstatus);
                }
            }
        });
    }

    function audio(status){
        var audio_player_status = $('#audio-player-status').val();
        var audio_player_update = $('#audio-player-update').val();
        if(status==1){
            if(audio_player_update==0){
                $('#audio-player-update').val('1');
                /**
                 * Update status audio jika pemutaran audio dibatasi
                 */
                $.getJSON('<?php echo site_url().'/'.$url; ?>/update_status_audio/'+$('#tes-soal-id').val(), function(data){
                    if(data.data==1){
                        notify_success(data.pesan);
                    }
                });
            }
        }
        
        if(audio_player_status==0){
            $('#audio-player-status').val('1');
            $('#audio-player').trigger('play');
            $('#audio-player-judul').html('Pause');
            $('#audio-player-judul-logo').removeClass('fa-play');
            $('#audio-player-judul-logo').addClass('fa-pause');
        }else{
            $('#audio-player-status').val('0');
            $('#audio-player').trigger('pause');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function audio_ended(status){
        if(status==1){
            $('#audio-control').addClass('hide');
        }else{
            $('#audio-player-status').val('0');
            $('#audio-player-judul').html('Play');
            $('#audio-player-judul-logo').removeClass('fa-pause');
            $('#audio-player-judul-logo').addClass('fa-play');
        }
    }

    function jawab(){
        $('#form-kerjakan').submit();
    }

    function hentikan_tes(){
        $("#modal-proses").modal('show');
        $('#hentikan-centang').prop("checked", false);
        $.getJSON('<?php echo site_url().'/'.$url; ?>/get_tes_info/'+$('#tes-id').val(), function(data){
            if(data.data==1){
                $('#hentikan-tes-id').val(data.tes_id);
                $('#hentikan-tes-user-id').val(data.tes_user_id);
                $('#hentikan-tes-nama').val(data.tes_nama);
                $('#hentikan-dijawab').val(data.tes_dijawab+" dijawab. "+data.tes_blum_dijawab+" belum dijawab.");
                $('#hentikan-belum-dijawab').val(data.tes_blum_dijawab);


                $("#modal-hentikan").modal('show');
            }else{
                window.location.reload();
            }
            $("#modal-proses").modal('hide');
        });
    }

    function soal_navigasi(navigasi){
        var tes_soal_nomor = parseInt($('#tes-soal-nomor').val());
        var tes_soal_jml = parseInt($('#tes-soal-jml').val());
        var tes_soal_tujuan = tes_soal_nomor+navigasi;

        if((tes_soal_tujuan>=1 && tes_soal_tujuan<=tes_soal_jml)){
            $('#btn-soal-'+tes_soal_tujuan).trigger('click');
        }
    }

    $(function () {
        var sisa_detik = <?php if(!empty($detik_sisa)){ echo $detik_sisa; } ?>;
        setInterval(function() {
            var sisa_menit = Math.round(sisa_detik/60);
            sisa_detik = sisa_detik-1;
            $("#sisa-waktu").html("Sisa Waktu : "+sisa_menit+" menit");

            if(sisa_detik<1){
                window.location.reload();
            }
        }, 1000);

        $('#btn-sebelumnya').click(function(){
            soal_navigasi(-1);
        });

        $('#btn-selanjutnya').click(function(){
            soal_navigasi(1);
        });

        $('#btn-hentikan').click(function(){
            hentikan_tes();
        });
        /**
         * Submit form soal saat sudah menjawab
         */
        $('#form-kerjakan').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/simpan_jawaban",
                    type:"POST",
                    data:$('#form-kerjakan').serialize(),
                    cache: false,
                    timeout: 10000,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            notify_success(obj.pesan);
                            $('#btn-soal-'+obj.nomor_soal).removeClass('btn-default');
                            $('#btn-soal-'+obj.nomor_soal).removeClass('btn-warning');
                            $('#btn-soal-'+obj.nomor_soal).addClass('btn-primary');
                        }else if(obj.status==2){
                            window.location.reload();
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(obj.pesan);
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal menyimpan jawaban, Silahkan Refresh Halaman");
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(textstatus);
                        }
                    }
            });
            return false;
        });

        /**
         * Submit form hentikan tes
         */
        $('#form-hentikan').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/hentikan_tes",
                    type:"POST",
                    data:$('#form-hentikan').serialize(),
                    cache: false,
                    timeout: 10000,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            window.location.reload();
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(obj.pesan);
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal menghentikan Tes, Silahkan Refresh Halaman");
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(textstatus);
                        }
                    }
            });
            return false;
        });

        $( document ).ready(function() {
            
        });

<?php if(!empty($cbt_anti_cheating) && $cbt_anti_cheating == 'ya'){ ?>
        // --- ANTI-CHEATING BROWSER ENGINE ---
        // 1. Blokir Seleksi Teks, Klik Kanan, Copy-Paste, dan F12
        $('body').css({
            '-webkit-user-select': 'none',
            '-moz-user-select': 'none',
            '-ms-user-select': 'none',
            'user-select': 'none',
            '-webkit-touch-callout': 'none'
        });

        $(document).on('contextmenu', function(e) {
            e.preventDefault();
            notify_error('Klik kanan dinonaktifkan demi integritas ujian.');
            return false;
        });

        $(document).on('keydown', function(e) {
            if((e.ctrlKey || e.metaKey) && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 65 || e.keyCode === 83)) {
                e.preventDefault();
                return false;
            }
            if(e.keyCode === 123) { // F12
                e.preventDefault();
                return false;
            }
        });

        // 2. State & Toleransi Waktu (Grace Period 7 Detik)
        var storage_key = 'cbt_cheat_count_' + $('#tes-id').val() + '_' + $('#tes-user-id').val();
        var max_pelanggaran = 3;
        var toleransi_detik = 7;
        var leave_time = null;
        var is_offline_mode = false;

        var cur_violation = parseInt(sessionStorage.getItem(storage_key)) || 0;

        $('#btn-tutup-cheating-warning').click(function(){
            $('#modal-cheating-warning').modal('hide');
        });

        function record_leave(){
            if(leave_time === null){
                leave_time = new Date().getTime();
            }
        }

        function record_return(){
            if(leave_time !== null){
                var duration = (new Date().getTime() - leave_time) / 1000;
                leave_time = null;

                if(is_offline_mode){
                    return;
                }

                if(duration > toleransi_detik){
                    cur_violation++;
                    sessionStorage.setItem(storage_key, cur_violation);
                    $('#cheating-count').text(cur_violation);

                    if(cur_violation >= max_pelanggaran){
                        alert('PERINGATAN TERAKHIR: Anda telah melanggar batas maksimal meninggalkan layar ujian (' + cur_violation + '/' + max_pelanggaran + '). Ujian Anda dihentikan secara otomatis!');
                        $('#hentikan-centang').prop('checked', true);
                        $('#form-hentikan').submit();
                    } else {
                        $('#modal-cheating-warning').modal('show');
                    }
                } else {
                    notify_success('Kembali ke lembar ujian.');
                }
            }
        }

        // Event Deteksi Tab Pindah / Layar Blur
        document.addEventListener('visibilitychange', function(){
            if(document.visibilityState === 'hidden'){
                record_leave();
            } else if(document.visibilityState === 'visible'){
                record_return();
            }
        });

        window.addEventListener('blur', function(){
            record_leave();
        });

        window.addEventListener('focus', function(){
            record_return();
        });

        // Event Deteksi Wi-Fi Offline / Online
        window.addEventListener('offline', function(){
            is_offline_mode = true;
            $('#modal-offline-warning').modal('show');
        });

        window.addEventListener('online', function(){
            is_offline_mode = false;
            $('#modal-offline-warning').modal('hide');
            notify_success('Koneksi Wi-Fi terhubung kembali.');
        });

        $('#btn-reconnect-wifi').click(function(){
            if(navigator.onLine){
                is_offline_mode = false;
                $('#modal-offline-warning').modal('hide');
                notify_success('Koneksi normal.');
            } else {
                notify_error('Perangkat masih belum terhubung ke jaringan.');
            }
        });
<?php } ?>
    });
</script>