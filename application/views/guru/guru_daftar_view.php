<div class="container">
    <div class="row" style="margin-top: 30px; margin-bottom: 40px;">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="box box-primary" style="border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.18); overflow: hidden; border-top: 4px solid #1e3c72;">
                <div class="box-header with-border" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #fff; padding: 22px 25px;">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h3 class="box-title" style="font-size: 20px; font-weight: 700; color: #fff; margin: 0;">
                                <i class="fa fa-graduation-cap" style="margin-right: 8px;"></i> Pendaftaran Akun Guru
                            </h3>
                            <div style="font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 4px;">
                                Registrasi Mandiri Pengajar <?php if(!empty($site_name)){ echo htmlspecialchars($site_name); } ?>
                            </div>
                        </div>
                        <a href="<?php echo site_url('admin'); ?>" class="btn btn-sm btn-outline" style="color: #fff; border: 1px solid rgba(255,255,255,0.5); border-radius: 20px; font-size: 12px; padding: 5px 14px;">
                            <i class="fa fa-sign-in"></i> Login
                        </a>
                    </div>
                </div>

                <div class="box-body" style="padding: 28px 30px;">
                    <!-- Informasi Ketentuan Singkat -->
                    <div class="alert alert-info" style="border-radius: 8px; border-left: 5px solid #0097a7; background-color: #e0f7fa; color: #006064; font-size: 13px; line-height: 1.6;">
                        <i class="fa fa-info-circle" style="font-size: 15px; margin-right: 5px;"></i>
                        <strong>Petunjuk Pendaftaran:</strong>
                        <ul style="margin: 6px 0 0 16px; padding: 0;">
                            <li>Gunakan <strong>Nomor WhatsApp aktif</strong> Anda. Nomor WhatsApp ini akan menjadi <strong>Username</strong> sekaligus <strong>Password Awal</strong> untuk login.</li>
                            <li>Pemilihan mata pelajaran yang Anda ampu dapat ditentukan nanti setelah akun dibuat.</li>
                        </ul>
                    </div>

                    <div id="form-pesan"></div>

                    <?php echo form_open('guru_daftar/simpan', 'id="form-daftar-guru"'); ?>
                        <!-- Nama Lengkap -->
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="font-weight: 600; color: #333; font-size: 14px;">
                                Nama Lengkap & Gelar Guru <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: #f7f9fc;"><i class="fa fa-user text-primary"></i></span>
                                <input type="text" class="form-control input-lg" id="nama" name="nama" placeholder="Contoh: Dra. Hj. Siti Aminah, M.Pd" required style="border-radius: 0 6px 6px 0; font-size: 15px;">
                            </div>
                            <span class="help-block" style="font-size: 12px; color: #777;">Tuliskan nama lengkap beserta gelar pendidik.</span>
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div class="form-group" style="margin-bottom: 25px;">
                            <label style="font-weight: 600; color: #333; font-size: 14px;">
                                Nomor WhatsApp Aktif <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: #f7f9fc;"><i class="fa fa-whatsapp text-success" style="font-size: 18px;"></i></span>
                                <input type="text" class="form-control input-lg" id="no_wa" name="no_wa" placeholder="Contoh: 081234567890" maxlength="16" required style="border-radius: 0 6px 6px 0; font-size: 15px;">
                            </div>
                            <div style="margin-top: 8px; font-size: 12px; color: #2e7d32; background: #e8f5e9; padding: 7px 12px; border-radius: 6px; display: block;">
                                <i class="fa fa-key"></i> <strong>Username & Password Login:</strong> Sama dengan Nomor WhatsApp di atas.
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div style="margin-top: 25px;">
                            <button type="submit" id="btn-daftar" class="btn btn-primary btn-block btn-lg" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none; font-weight: 700; border-radius: 8px; padding: 12px; box-shadow: 0 4px 12px rgba(30,60,114,0.3); letter-spacing: 0.5px;">
                                <i class="fa fa-user-plus" style="margin-right: 6px;"></i> DAFTAR SEBAGAI GURU SEKARANG
                            </button>
                        </div>
                    <?php echo form_close(); ?>

                    <div style="text-align: center; margin-top: 20px; font-size: 13px;">
                        Sudah punya akun? <a href="<?php echo site_url('admin'); ?>" style="font-weight: 700; color: #1e3c72;">Login di sini &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses Pendaftaran -->
<div class="modal fade" id="modal-sukses" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.3);">
            <div class="modal-header" style="background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%); color: #fff; text-align: center; padding: 25px 20px;">
                <div style="font-size: 48px; line-height: 1; margin-bottom: 10px;">
                    <i class="fa fa-check-circle"></i>
                </div>
                <h4 class="modal-title" style="font-weight: 700; font-size: 22px; color: #fff;">Pendaftaran Berhasil!</h4>
                <p style="margin: 5px 0 0; color: rgba(255,255,255,0.9); font-size: 13px;">Akun Guru CBT Anda telah aktif dan siap digunakan</p>
            </div>
            <div class="modal-body" style="padding: 25px 30px; font-size: 14px;">
                <div class="well" style="background: #f1f8e9; border: 1px solid #c8e6c9; border-radius: 8px; margin-bottom: 20px;">
                    <h5 style="margin-top: 0; font-weight: 700; color: #2e7d32;">
                        <i class="fa fa-id-card-o"></i> Informasi Kredensial Login Anda:
                    </h5>
                    <table class="table table-condensed" style="margin-bottom: 0;">
                        <tr>
                            <td width="35%" style="border-top: none; color: #555;"><strong>Username:</strong></td>
                            <td style="border-top: none; font-size: 16px; font-weight: 700; color: #1e3c72;" id="sukses-username">-</td>
                        </tr>
                        <tr>
                            <td style="color: #555;"><strong>Password Default:</strong></td>
                            <td style="font-size: 16px; font-weight: 700; color: #1e3c72;" id="sukses-password">-</td>
                        </tr>
                    </table>
                </div>
                <p style="color: #444; line-height: 1.6;">
                    Silakan gunakan nomor WhatsApp Anda untuk masuk ke Portal CBT Operator / Guru. Anda dapat segera melakukan <strong>Preview Soal</strong> dan <strong>Melihat Hasil Tes</strong> siswa.
                </p>
            </div>
            <div class="modal-footer" style="background: #f9f9f9; padding: 15px 25px; text-align: center;">
                <a href="<?php echo site_url('admin'); ?>" class="btn btn-success btn-lg btn-block" style="border-radius: 8px; font-weight: 700; background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%); border: none;">
                    <i class="fa fa-sign-in"></i> Menuju Halaman Login Guru Sekarang &rarr;
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        // Validasi input nomor whatsapp hanya angka
        $('#no_wa').on('input', function(){
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Submit form pendaftaran
        $('#form-daftar-guru').submit(function(e){
            e.preventDefault();

            var noWa = $('#no_wa').val();
            if(noWa.length < 10){
                alert('Nomor WhatsApp minimal 10 digit.');
                $('#no_wa').focus();
                return false;
            }

            $('#btn-daftar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan Pendaftaran...');

            $.ajax({
                url: "<?php echo site_url('guru_daftar/simpan'); ?>",
                type: "POST",
                data: $('#form-daftar-guru').serialize(),
                dataType: "json",
                success: function(resp){
                    $('#btn-daftar').prop('disabled', false).html('<i class="fa fa-user-plus"></i> DAFTAR SEBAGAI GURU SEKARANG');
                    if(resp.status == 1){
                        $('#sukses-username').text(noWa);
                        $('#sukses-password').text(noWa);
                        $('#modal-sukses').modal('show');
                    } else {
                        $('#form-pesan').html('<div class="alert alert-danger" style="border-radius: 6px;"><i class="fa fa-exclamation-triangle"></i> ' + resp.pesan + '</div>');
                        $('html, body').animate({ scrollTop: $('#form-pesan').offset().top - 20 }, 'fast');
                    }
                },
                error: function(){
                    $('#btn-daftar').prop('disabled', false).html('<i class="fa fa-user-plus"></i> DAFTAR SEBAGAI GURU SEKARANG');
                    alert('Terjadi kesalahan jaringan atau server saat memproses pendaftaran.');
                }
            });

            return false;
        });
    });
</script>
