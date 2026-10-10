<div class="container" style="max-width: 720px; padding-top: 25px;">
	<!-- Content Header (Page header) -->
    <section class="content-header" style="text-align: center; margin-bottom: 20px;">
    	<h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">
    		<i class="fa fa-refresh" style="color: #2563eb; margin-right: 8px;"></i> Lanjutkan Ujian
        </h2>
        <p style="font-size: 13.5px; color: #64748b; margin-top: 6px;">
            Silakan periksa kembali data ujian yang akan Anda lanjutkan.
        </p>
	</section>

	<!-- Main content -->
    <section class="content" style="padding: 0;">
        <?php echo form_open($url.'/lanjutkan_tes','id="form-lanjutkan-tes" class="form-horizontal"'); ?>
        <div class="box box-success box-solid" style="border-radius: 14px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);">
            <div class="box-header with-border" style="padding: 15px 22px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);">
                <h3 class="box-title" style="font-size: 16px; font-weight: 700;">
                    <i class="fa fa-info-circle"></i> Konfirmasi Lanjutkan Tes
                </h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 24px;">
                <div id="form-pesan"></div>
                <input type="hidden" name="tes-id" id="tes-id" value="<?php if(!empty($tes_id)){ echo $tes_id; } ?>">
                
                <table class="table" style="margin-bottom: 0; font-size: 14px;">
                    <tr style="border-top: none;">
                        <td style="width: 35%; color: #64748b; font-weight: 600; padding: 12px 8px; border-top: none;">Nama Peserta</td>
                        <td style="border-top: none; font-weight: 700; color: #0f172a; padding: 12px 8px;">
                            <?php if(!empty($nama)){ echo htmlspecialchars($nama); } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 600; padding: 12px 8px;">Mata Uji / Tes</td>
                        <td style="font-weight: 800; color: #1e40af; font-size: 15px; padding: 12px 8px;">
                            <?php if(!empty($tes_nama)){ echo htmlspecialchars($tes_nama); } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 600; padding: 12px 8px;">Deskripsi</td>
                        <td style="font-weight: 600; color: #0f172a; padding: 12px 8px;">
                            <?php if(!empty($tes_detail)){ echo htmlspecialchars($tes_detail); } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 600; padding: 12px 8px;">Token Ujian</td>
                        <td style="padding: 12px 8px;">
                            <input type="text" name="token" id="token" class="form-control" placeholder="Masukkan token jika diminta" autocomplete="off" style="max-width: 240px; border-radius: 6px; font-weight: bold; text-transform: uppercase;">
                        </td>
                    </tr>
                </table>
            </div><!-- /.box-body -->
            <div class="box-footer" style="padding: 18px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; text-align: right;">
                <a href="<?php echo site_url('tes_dashboard'); ?>" class="btn btn-default" style="margin-right: 10px; border-radius: 8px; padding: 9px 20px;">
                    <i class="fa fa-arrow-left"></i> Batal
                </a>
                <button type="submit" id="btn-tambah-simpan" class="btn btn-primary" style="font-size: 14px; font-weight: 700; border-radius: 8px; padding: 9px 26px;">
                    <i class="fa fa-play"></i> Lanjutkan Ujian Sekarang
                </button>
            </div>
        </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.container -->

<script type="text/javascript">
    $(function () {
        $('#form-lanjutkan-tes').submit(function(){
            $("#modal-proses").modal('show');
            $.ajax({
                    url:"<?php echo site_url().'/'.$url; ?>/lanjutkan_tes",
                    type:"POST",
                    data:$('#form-lanjutkan-tes').serialize(),
                    cache: false,
                    timeout: 10000,
                    success:function(respon){
                        var obj = $.parseJSON(respon);
                        if(obj.status==1){
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html('');
                            window.location.reload();
                        }else{
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err(obj.pesan));
                        }
                    },
                    statusCode: {
                        500: function(respon) {
                            $("#modal-proses").modal('hide');
                            $('#form-pesan').html(pesan_err('Terjadi kesalahan pada Tes. Silahkan hubungi petugas.'));
                        }
                    },
                    error: function(xmlhttprequest, textstatus, message) {
                        if(textstatus==="timeout") {
                            $("#modal-proses").modal('hide');
                            notify_error("Gagal melanjutkan Tes, Halaman akan di Refresh !");
                            setInterval(function() {
                                window.location.reload();
                            }, 4000);
                        }else{
                            $("#modal-proses").modal('hide');
                            notify_error(textstatus);
							setInterval(function() {
                                window.location.reload();
                            }, 1000);
                        }
                    }
            });
            return false;
        });
    });
</script>