<div class="container">
	<!-- Content Header (Page header) -->
    <section class="content-header" style="padding: 15px 0 12px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <h1 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                <i class="fa fa-pencil-square-o" style="color: #2563eb; margin-right: 6px;"></i> Mata Uji: <?php if(!empty($tes_name)){ echo htmlspecialchars($tes_name); } ?>
            </h1>
            <div class="breadcrumb" style="position: static; float: none; background: transparent; padding: 0; margin: 0; display: flex; align-items: center; gap: 6px;">
                <button type="button" class="btn btn-xs btn-default" id="btn-toggle-fullscreen" onclick="toggleExamFullscreen()" title="Mode Layar Penuh (Kiosk)" style="border-radius: 6px; font-weight: 700; padding: 3px 10px;">
                    <i class="fa fa-arrows-alt"></i> <span class="hidden-xs">Layar Penuh</span>
                </button>
                <span style="font-size: 12px; color: #64748b; font-weight: 600; margin-left: 4px;">Font:</span>
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
                <div class="box-header with-border" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; padding: 12px 18px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; margin: 0;">
                            <i class="fa fa-question-circle" style="margin-right: 6px;"></i> Soal <span id="judul-soal"><?php if(!empty($tes_soal_nomor)){ echo 'ke '.$tes_soal_nomor; } ?></span>
                        </h3>
                        <span id="save-status-badge" style="display: none; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 12px; background: rgba(16, 185, 129, 0.2); color: #6ee7b7; border: 1px solid rgba(110, 231, 183, 0.35);">
                            <i class="fa fa-check"></i> Tersimpan
                        </span>
                    </div>
                    <div class="box-tools pull-right" style="position: static; margin: 0;">
                        <div id="sisa-waktu"></div>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 24px 20px;">
                    <div id="isi-tes-soal" style="font-size: 15.5px; line-height: 1.7; color: #1e293b;">
                        <?php if(!empty($tes_soal)){ echo $tes_soal; } ?>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer cbt-nav-footer-mobile" style="padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
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
                                <input type="hidden" name="hentikan-tes-id" id="hentikan-tes-id" value="<?php if(!empty($tes_id)){ echo $tes_id; } ?>" >
                                <input type="hidden" name="hentikan-tes-user-id" id="hentikan-tes-user-id" value="<?php if(!empty($tes_user_id)){ echo $tes_user_id; } ?>" >
                                <input type="text" class="form-control" id="hentikan-tes-nama" name="hentikan-tes-nama" value="<?php if(!empty($tes_name)){ echo htmlspecialchars($tes_name); } ?>" readonly>
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

    function pilihOpsiRadio(el){
        $('.cbt-option-card').removeClass('cbt-option-selected');
        $(el).closest('.cbt-option-card').addClass('cbt-option-selected');
    }

    function toggleExamFullscreen(){
        var doc = window.document;
        var docEl = doc.documentElement;
        var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
        var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

        if(!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
            if(requestFullScreen){
                requestFullScreen.call(docEl);
            }
        } else {
            if(cancelFullScreen){
                cancelFullScreen.call(doc);
            }
        }
    }

    function ragu(){
        $("#modal-proses").modal('show');

        $.ajax({
            url:'<?php echo site_url().'/'.$url; ?>/get_tes_soal_by_tessoal/'+$('#tes-soal-id').val(),
            type:"POST",
            cache: false,
            timeout: 10000,
            success:function(respon){
                try {
                    var data = typeof respon === 'object' ? respon : $.parseJSON(respon);
                    if(data.data==1){
                        // Mengubah nilai ragu-ragu di database
                        var ragu = ($('#tes-soal-ragu').val()==0) ? 1 : 0;
                        $.ajax({
                                url:'<?php echo site_url().'/'.$url; ?>/update_tes_soal_ragu/'+$('#tes-soal-id').val()+'/'+ragu,
                                type:"POST",
                                cache: false,
                                timeout: 8000,
                                success:function(respon2){
                                    try {
                                        var data2 = typeof respon2 === 'object' ? respon2 : $.parseJSON(respon2);
                                        if(data2.data==1){
                                            notify_success('Jawaban Ragu-ragu berhasil diubah');
                                        }
                                    } catch(e) {}
                                },
                                error: function(xmlhttprequest, textstatus, message) {
                                    $("#modal-proses").modal('hide');
                                    notify_error(textstatus==="timeout" ? "Koneksi lambat, silakan coba lagi." : textstatus);
                                }
                        });

                        // Mengubah warna daftar soal dan checkbox pada tombol ragu-ragu
                        if(data.tessoal_dikerjakan==1){
                            if($('#tes-soal-ragu').val()==0){
                                $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-primary').addClass('btn-warning');
                                $('#btn-ragu-checkbox').prop("checked", true);
                                $('#tes-soal-ragu').val(1);
                            }else{
                                $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning').addClass('btn-primary');
                                $('#btn-ragu-checkbox').prop("checked", false);
                                $('#tes-soal-ragu').val(0);
                            }
                        }else{
                            if($('#tes-soal-ragu').val()==0){
                                $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-default').addClass('btn-warning');
                                $('#btn-ragu-checkbox').prop("checked", true);
                                $('#tes-soal-ragu').val(1);
                            }else{
                                $('#btn-soal-'+$('#tes-soal-nomor').val()).removeClass('btn-warning').addClass('btn-default');
                                $('#btn-ragu-checkbox').prop("checked", false);
                                $('#tes-soal-ragu').val(0);
                            }
                        }
                    }
                } catch(e) {
                    notify_error("Gagal memproses data ragu-ragu.");
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                $("#modal-proses").modal('hide');
                notify_error(textstatus==="timeout" ? "Koneksi lambat, silakan ulangi klik ragu-ragu." : textstatus);
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
                try {
                    var data = typeof respon === 'object' ? respon : $.parseJSON(respon);
                    if(data.data==1){
                        $('#tes-soal-id').val(data.tes_soal_id);
                        $('#tes-soal-nomor').val(data.tes_soal_nomor);
                        $('#isi-tes-soal').html(data.tes_soal);
                        $('#tes-soal-ragu').val(data.tes_ragu);
                        $('#judul-soal').html('ke '+data.tes_soal_nomor);

                        if(data.tes_ragu==0){
                            $('#btn-ragu-checkbox').prop("checked", false);
                        }else{
                            $('#btn-ragu-checkbox').prop("checked", true);
                        }

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
                } catch(e) {
                    notify_error("Gagal memuat soal, silakan coba klik nomor soal lagi.");
                }
                $("#modal-proses").modal('hide');
            },
            error: function(xmlhttprequest, textstatus, message) {
                $("#modal-proses").modal('hide');
                notify_error(textstatus==="timeout" ? "Koneksi lambat saat memuat soal. Silakan klik nomor soal lagi." : textstatus);
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
        var sisa_detik = <?php echo !empty($detik_sisa) ? intval($detik_sisa) : 0; ?>;
        function renderSisaWaktu() {
            if (sisa_detik < 0) sisa_detik = 0;
            var hrs = Math.floor(sisa_detik / 3600);
            var mins = Math.floor((sisa_detik % 3600) / 60);
            var secs = sisa_detik % 60;
            var strTime = (hrs > 0 ? (hrs < 10 ? "0" + hrs : hrs) + ":" : "") +
                          (mins < 10 ? "0" + mins : mins) + ":" +
                          (secs < 10 ? "0" + secs : secs);
            $("#sisa-waktu").html('<i class="fa fa-clock-o"></i> ' + strTime);
            if (sisa_detik <= 300) {
                $("#sisa-waktu").addClass("cbt-timer-urgent");
            } else {
                $("#sisa-waktu").removeClass("cbt-timer-urgent");
            }
        }
        renderSisaWaktu();
        setInterval(function() {
            sisa_detik = sisa_detik - 1;
            renderSisaWaktu();

            if(sisa_detik < 1){
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
         * Submit form soal saat sudah menjawab (Non-blocking di HP dengan indikator status real-time)
         */
        $('#form-kerjakan').submit(function(){
            $('#save-status-badge').stop(true, true).show().css({
                'background': 'rgba(245, 158, 11, 0.25)',
                'color': '#fde68a',
                'border-color': 'rgba(253, 230, 138, 0.4)'
            }).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/simpan_jawaban",
                    type:"POST",
                    data:$('#form-kerjakan').serialize(),
                    cache: false,
                    timeout: 10000,
                    success:function(respon){
                        $("#modal-proses").modal('hide');
                        try {
                            var obj = typeof respon === 'object' ? respon : $.parseJSON(respon);
                            if(obj.status==1){
                                $('#save-status-badge').css({
                                    'background': 'rgba(16, 185, 129, 0.25)',
                                    'color': '#6ee7b7',
                                    'border-color': 'rgba(110, 231, 183, 0.45)'
                                }).html('<i class="fa fa-check-circle"></i> Tersimpan');
                                $('#btn-soal-'+obj.nomor_soal).removeClass('btn-default');
                                $('#btn-soal-'+obj.nomor_soal).removeClass('btn-warning');
                                $('#btn-soal-'+obj.nomor_soal).addClass('btn-primary');
                            }else if(obj.status==2){
                                window.location.reload();
                            }else{
                                $('#save-status-badge').css({
                                    'background': 'rgba(239, 68, 68, 0.3)',
                                    'color': '#fca5a5',
                                    'border-color': '#f87171'
                                }).html('<i class="fa fa-warning"></i> Gagal Simpan');
                                notify_error(obj.pesan);
                            }
                        } catch(e) {
                            notify_error("Jawaban belum terverifikasi oleh server, silakan klik pilihan lagi.");
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        $("#modal-proses").modal('hide');
                        $('#save-status-badge').css({
                            'background': 'rgba(239, 68, 68, 0.3)',
                            'color': '#fca5a5',
                            'border-color': '#f87171'
                        }).html('<i class="fa fa-warning"></i> Koneksi Lambat');
                        if(textstatus==="timeout") {
                            notify_error("Koneksi lambat (timeout). Silakan klik ulang pilihan jawaban Anda.");
                        }else{
                            notify_error("Koneksi terputus (" + textstatus + "). Silakan klik ulang pilihan jawaban Anda.");
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
                        $("#modal-proses").modal('hide');
                        try {
                            var obj = typeof respon === 'object' ? respon : $.parseJSON(respon);
                            if(obj.status==1){
                                window.location.reload();
                            }else{
                                notify_error(obj.pesan);
                            }
                        } catch(e) {
                            window.location.reload();
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        $("#modal-proses").modal('hide');
                        if(textstatus==="timeout") {
                            notify_error("Koneksi lambat saat menghentikan tes. Silakan klik tombol kembali.");
                        }else{
                            notify_error("Gagal menghentikan tes: " + textstatus);
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

        // 2. Anti-Cheating Monitoring & State (Sinkron dengan Database Server)
        var storage_key = 'cbt_cheat_count_' + $('#tes-id').val() + '_' + $('#tes-user-id').val();
        var max_pelanggaran = 3;
        var leave_time = null;
        var leave_type = null;
        var is_user_away = false;
        var is_offline_mode = false;
        var original_title = document.title;

        // Sinkronisasi jumlah pelanggaran dari database server (agar jika di-reset Proktor, localStorage ikut ter-reset ke 0)
        var server_violation = <?php echo isset($tes_pelanggaran) ? intval($tes_pelanggaran) : 0; ?>;
        var cur_violation = server_violation;
        sessionStorage.setItem(storage_key, cur_violation);
        localStorage.setItem(storage_key, cur_violation);
        if(cur_violation > 0){
            $('#cheating-count').text(cur_violation);
        }

        // Minta izin Notifikasi Desktop jika browser mendukung
        if('Notification' in window && Notification.permission === 'default'){
            try {
                Notification.requestPermission();
            } catch(e){}
        }

        function play_warning_beep(){
            try {
                var AudioContext = window.AudioContext || window.webkitAudioContext;
                if(AudioContext){
                    var ctx = new AudioContext();
                    var osc = ctx.createOscillator();
                    var gain = ctx.createGain();
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(880, ctx.currentTime);
                    osc.frequency.setValueAtTime(440, ctx.currentTime + 0.15);
                    gain.gain.setValueAtTime(0.3, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.35);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start();
                    osc.stop(ctx.currentTime + 0.35);
                }
            } catch(e) {}
        }

        $('#btn-tutup-cheating-warning').click(function(){
            $('#modal-cheating-warning').modal('hide');
        });

        function record_leave(type){
            if(!is_user_away){
                is_user_away = true;
                leave_time = new Date().getTime();
                leave_type = type || 'tab';
                document.title = '⚠️ [PERINGATAN] KEMBALI KE UJIAN!';

                if('Notification' in window && Notification.permission === 'granted'){
                    try {
                        new Notification('SMART-CBT SMK 11 MARET', {
                            body: 'PERINGATAN: Segera kembali ke layar ujian! Meninggalkan ujian terhitung pelanggaran.',
                            icon: '<?php echo base_url(); ?>public/images/avatar.png'
                        });
                    } catch(e){}
                }
            }
        }

        function record_return(){
            if(is_user_away && leave_time !== null){
                var duration = (new Date().getTime() - leave_time) / 1000;
                var current_leave_type = leave_type;
                is_user_away = false;
                leave_time = null;
                leave_type = null;
                document.title = original_title;

                if(is_offline_mode){
                    return;
                }

                // Pindah tab terdeteksi seketika sebagai pelanggaran.
                // Jika blur jendela, toleransi 0.4 detik untuk menghindari false positive klik minor.
                if(current_leave_type === 'tab' || duration >= 0.4){
                    cur_violation++;
                    sessionStorage.setItem(storage_key, cur_violation);
                    localStorage.setItem(storage_key, cur_violation);
                    $('#cheating-count').text(cur_violation);

                    play_warning_beep();
                    notify_error('PERINGATAN: Terdeteksi meninggalkan layar ujian! (Pelanggaran ke-' + cur_violation + ' dari ' + max_pelanggaran + ')');

                    // Kirim catatan pelanggaran secara real-time ke server agar terlihat di layar Pengawas/Proktor
                    $.ajax({
                        url: "<?php echo site_url().'/'.$url; ?>/catat_pelanggaran",
                        type: "POST",
                        data: {
                            'tes-id': $('#tes-id').val(),
                            'tes-user-id': $('#tes-user-id').val()
                        },
                        cache: false,
                        success: function(res){
                            try {
                                var rObj = typeof res === 'object' ? res : $.parseJSON(res);
                                if(rObj && rObj.status == 1){
                                    cur_violation = parseInt(rObj.pelanggaran);
                                    sessionStorage.setItem(storage_key, cur_violation);
                                    localStorage.setItem(storage_key, cur_violation);
                                    $('#cheating-count').text(cur_violation);
                                    if(rObj.terkunci == 1){
                                        alert('PERINGATAN TERAKHIR: Anda telah mencapai batas maksimal meninggalkan layar ujian (' + cur_violation + '/' + max_pelanggaran + '). Ujian Anda dikunci secara otomatis! Silakan lapor ke Pengawas Ruang.');
                                        window.location.reload();
                                    }
                                }
                            } catch(e){}
                        }
                    });

                    if(cur_violation >= max_pelanggaran){
                        alert('PERINGATAN TERAKHIR: Anda telah mencapai batas maksimal meninggalkan layar ujian (' + cur_violation + '/' + max_pelanggaran + '). Ujian Anda dikunci secara otomatis! Silakan lapor ke Pengawas Ruang.');
                        window.location.reload();
                    } else {
                        $('#modal-cheating-warning').modal('show');
                    }
                }
            }
        }

        // Event Deteksi Tab Pindah / Layar Blur
        document.addEventListener('visibilitychange', function(){
            if(document.visibilityState === 'hidden'){
                record_leave('tab');
            } else if(document.visibilityState === 'visible'){
                record_return();
            }
        });

        window.addEventListener('blur', function(){
            record_leave('window');
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