<div class="container" style="padding-top: 15px;">
    <!-- Banner Sambutan Peserta Ujian -->
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); border-radius: 14px; padding: 22px 26px; color: #fff; margin-bottom: 22px; box-shadow: 0 4px 16px rgba(30, 58, 138, 0.22);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
                <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #93c5fd; font-weight: 700; background: rgba(255,255,255,0.12); padding: 3px 10px; border-radius: 20px;">
                    Peserta Ujian SMART-CBT
                </span>
                <h2 style="margin: 8px 0 0 0; font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: -0.3px;">
                    <?php if(!empty($nama)){ echo htmlspecialchars($nama); }else{ echo 'Peserta Ujian'; } ?>
                </h2>
                <div style="font-size: 13px; color: #cbd5e1; margin-top: 4px; font-weight: 500;">
                    <i class="fa fa-users" style="margin-right: 5px; color: #93c5fd;"></i> <?php if(!empty($group)){ echo htmlspecialchars($group); }else{ echo 'Peserta'; } ?>
                </div>
            </div>
            <div>
                <span class="badge" style="background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.3); font-size: 13px; padding: 8px 16px; border-radius: 20px; font-weight: 600;">
                    <i class="fa fa-check-circle" style="color: #4ade80; margin-right: 5px;"></i> Status: Siap Mengikuti Ujian
                </span>
            </div>
        </div>
    </div>

	<!-- Main content -->
    <section class="content" style="padding: 0;">
		<?php
			if(!empty($informasi)){
				?>
				<div class="callout callout-info" style="border-radius: 10px; margin-bottom: 20px;">
                    <h4 style="margin-top: 0; font-weight: 700;"><i class="fa fa-info-circle"></i> Pengumuman Ujian</h4>
                    <?php echo $informasi; ?>
                </div>
				<?php
			}else{
				?>
				<div class="callout callout-info" style="border-radius: 10px; margin-bottom: 20px;">
					<h4 style="margin-top: 0; font-weight: 700;"><i class="fa fa-info-circle"></i> Petunjuk Ujian</h4>
					<p style="margin: 0; font-size: 13.5px;">Silahkan pilih Tes yang akan diikuti pada tabel di bawah ini. Jika tes belum muncul, silakan tunggu pengawas mengaktifkan jadwal atau klik tombol Refresh pada browser.</p>
				</div>
				<?php
			}
		?>
        <div class="box box-success box-solid" style="border-radius: 12px; overflow: hidden;">
            <div class="box-header with-border" style="padding: 14px 20px;">
                <h3 class="box-title" style="font-size: 16px; font-weight: 700;">
                    <i class="fa fa-list-alt" style="margin-right: 6px;"></i> Daftar Tes yang Tersedia
                </h3>
            </div><!-- /.box-header -->
            <div class="box-body" style="padding: 18px 20px;">
                <table id="table-tes" class="table table-bordered table-hover" style="font-size: 13.5px;">
                    <thead>
                        <tr style="background: #f8fafc; color: #1e293b;">
                            <th style="width: 35px; text-align: center;">No.</th>
                            <th class="all">Nama Tes</th>
                            <th>Mulai Tes</th>
                            <th>Selesai Tes</th>
                            <th style="text-align: center;">Status</th>
                            <th class="all" style="text-align: center; width: 90px;">Aksi</th>
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
                        </tr>
                    </tbody>
                </table>   
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->

    <!-- Modal Maklumat Kejujuran & Pakta Integritas -->
    <div class="modal fade" id="modal-integritas" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 8px; border-top: 5px solid #d9534f; box-shadow: 0 8px 30px rgba(0,0,0,0.5);">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #fff; border-radius: 6px 6px 0 0; padding: 18px 25px;">
                    <h4 class="modal-title" style="font-weight: bold; letter-spacing: 0.5px;">
                        <i class="fa fa-shield"></i> MAKLUMAT KEJUJURAN &amp; PAKTA INTEGRITAS UJIAN
                    </h4>
                </div>
                <div class="modal-body" style="padding: 25px 30px; font-size: 14px; line-height: 1.7; color: #333;">
                    
                    <!-- Renungan & Nilai Moral -->
                    <div style="text-align: center; margin-bottom: 20px;">
                        <span style="font-size: 42px;">⚖️</span>
                        <h3 style="margin-top: 8px; margin-bottom: 5px; font-weight: bold; color: #1e3c72;">"Prestasi Itu Penting, Tapi Jujur yang Paling Utama"</h3>
                        <p style="font-style: italic; color: #666; font-size: 13.5px; max-width: 650px; margin: 0 auto;">
                            Nilai setinggi apa pun yang didapat dari hasil kecurangan adalah kehancuran karakter dan masa depanmu. Nilai murni dari hasil keringat dan kerja kerasmu sendiri adalah kehormatan dan kebanggaan sejati bagi kedua orang tuamu.
                        </p>
                    </div>

                    <!-- Informasi Sistem Pengawasan Cerdas -->
                    <div class="callout callout-warning" style="background-color: #fffdf5 !important; border-left: 4px solid #f39c12 !important; color: #8a6d3b; margin-bottom: 18px; padding: 12px 18px;">
                        <h5 style="font-weight: bold; margin-top: 0; color: #b77900;"><i class="fa fa-cogs"></i> Sistem Pengawasan Digital Cerdas Aktif</h5>
                        <p style="margin: 0; font-size: 13px;">
                            Aplikasi ujian ini terhubung dengan <strong>Sistem Deteksi Pelanggaran Otomatis</strong> yang memantau perpindahan tab, penutupan browser, pembagian layar (split-screen), serta upaya akses aplikasi atau data di luar halaman ujian secara <em>real-time</em>.
                        </p>
                    </div>

                    <!-- Ketentuan Sanksi Tegas -->
                    <div style="background: #fff5f5; border: 1px solid #f5c6cb; border-radius: 6px; padding: 15px 20px; margin-bottom: 18px;">
                        <h5 style="color: #721c24; font-weight: bold; margin-top: 0; margin-bottom: 10px;">
                            <i class="fa fa-gavel"></i> KETENTUAN SANKSI TEGAS PELANGGARAN SISTEM:
                        </h5>
                        <ul style="margin: 0; padding-left: 20px; color: #721c24; font-size: 13.5px;">
                            <li style="margin-bottom: 8px;">
                                <strong>⚠️ Peringatan Pertama:</strong> Jika sistem mendeteksi Anda keluar dari browser, meminimalkan layar, atau mencoba mengakses data dari luar, <strong>seluruh progres pengerjaan ujian Anda akan langsung di-RESET oleh sistem</strong>.
                            </li>
                            <li>
                                <strong>🚫 Peringatan Kedua:</strong> Jika pelanggaran terulang untuk kedua kalinya, ujian Anda akan <strong>langsung DIHENTIKAN SECARA PERMANEN, sesi dikunci, dan Anda dianggap SELESAI dengan NILAI POIN 0</strong>.
                            </li>
                        </ul>
                    </div>

                    <!-- Pesan Penutup & Motivasi -->
                    <p style="text-align: center; margin-bottom: 10px; font-weight: bold; color: #2c3e50;">
                        Tatap masa depanmu dengan kepala tegak. Percayalah pada kemampuan dirimu sendiri dan kerjakan dengan penuh rasa tanggung jawab.
                    </p>

                    <!-- Checkbox Persetujuan -->
                    <div class="checkbox text-center" style="margin-top: 15px; background: #eef2f7; padding: 12px; border-radius: 6px; border: 1px solid #d2dbe5;">
                        <label style="font-weight: bold; color: #1e3c72; cursor: pointer; font-size: 13.5px;">
                            <input type="checkbox" id="check-pakta-integritas" style="width: 18px; height: 18px; vertical-align: middle;"> 
                            &nbsp; Saya telah membaca, memahami maklumat ini, dan berjanji akan mengerjakan ujian dengan jujur.
                        </label>
                    </div>

                </div>
                <div class="modal-footer" style="text-align: center; background: #f8f9fa; padding: 15px 25px;">
                    <button type="button" class="btn btn-primary btn-lg" id="btn-setuju-integritas" disabled style="min-width: 280px; font-weight: bold; border-radius: 25px;">
                        <i class="fa fa-check-circle"></i> Mulai Ujian dengan Jujur
                    </button>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.container -->

<script type="text/javascript">
    $(function () {
        // Tampilkan modal integritas saat pertama kali siswa masuk ke dashboard
        if(!sessionStorage.getItem('cbt_integritas_agreed')){
            $('#modal-integritas').modal('show');
        }

        // Aktifkan tombol hanya jika siswa sudah mencentang pakta integritas
        $('#check-pakta-integritas').change(function(){
            if($(this).is(':checked')){
                $('#btn-setuju-integritas').prop('disabled', false).removeClass('btn-primary').addClass('btn-success');
            } else {
                $('#btn-setuju-integritas').prop('disabled', true).removeClass('btn-success').addClass('btn-primary');
            }
        });

        // Simpan konfirmasi persetujuan ke sessionStorage agar tidak muncul berulang di sesi yang sama
        $('#btn-setuju-integritas').click(function(){
            sessionStorage.setItem('cbt_integritas_agreed', '1');
            $('#modal-integritas').modal('hide');
        });

        $('#table-tes').DataTable({
                  "paging": true,
                  "iDisplayLength":25,
                  "bProcessing": false,
                  "bServerSide": true, 
                  "searching": false,
                  "aoColumns": [
                        {"bSearchable": false, "bSortable": false, "sWidth":"20px"},
                        {"bSearchable": false, "bSortable": false},
                        {"bSearchable": false, "bSortable": false, "sWidth":"150px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"150px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"100px"},
                        {"bSearchable": false, "bSortable": false, "sWidth":"30px"}],
                  "sAjaxSource": "<?php echo site_url().'/'.$url; ?>/get_datatable/",
                  "autoWidth": false,
                  "responsive": true
         });   
    });
</script>