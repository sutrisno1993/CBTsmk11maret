<div class="container" style="max-width: 540px; padding-top: 35px; padding-bottom: 40px;">
    <section class="content">
        <div style="background: #ffffff; border-radius: 16px; border-top: 5px solid #2563eb; box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.12); padding: 28px 24px; text-align: center;">
            <div style="width: 68px; height: 68px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; margin-bottom: 16px;">
                <i class="fa fa-shield"></i>
            </div>
            <h3 style="margin: 0 0 8px 0; font-size: 21px; font-weight: 800; color: #0f172a;">
                Wajib Menggunakan Exam Browser
            </h3>
            <p style="font-size: 13.5px; color: #475569; line-height: 1.6; margin-bottom: 20px;">
                Demi keamanan dan integritas pelaksanaan ujian <b>SMART-CBT SMK 11 MARET</b>, akses melalui browser biasa dibatasi. Silakan buka ujian menggunakan aplikasi resmi <b>Exam Browser (APK)</b>.
            </p>

            <?php if(!empty($scanned_qr_code)): ?>
            <div style="background: #ecfdf5; border: 1.5px dashed #10b981; border-radius: 12px; padding: 14px 16px; margin-bottom: 20px; text-align: center;">
                <div style="font-size: 12px; font-weight: 700; color: #047857; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="fa fa-check-circle"></i> QR Code Berhasil Terbaca!
                </div>
                <div style="font-size: 12.5px; color: #065f46; margin-top: 4px;">
                    Catat &amp; ketik <b>6 Digit Kode Akses Ruang</b> ini saat Anda membuka aplikasi <b>Exam Browser APK</b>:
                </div>
                <div style="font-size: 28px; font-weight: 900; letter-spacing: 4px; color: #064e3b; background: #ffffff; display: inline-block; padding: 6px 20px; border-radius: 8px; border: 1px solid #a7f3d0; margin-top: 8px; font-family: monospace;">
                    <?php echo htmlspecialchars($scanned_qr_code); ?>
                </div>
            </div>
            <?php endif; ?>

            <div style="margin-bottom: 18px;">
                <a href="<?php echo base_url(); ?>public/apk/aplikasi-ujian-online-zyacbt.apk" class="btn btn-primary btn-block" style="height: 46px; font-size: 15px; font-weight: 700; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa fa-android" style="font-size: 18px;"></i> Download Exam Browser (Android APK)
                </a>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; text-align: left; font-size: 12.5px; color: #475569; line-height: 1.6;">
                <div style="font-weight: 700; color: #1e293b; margin-bottom: 6px;">
                    <i class="fa fa-info-circle" style="color: #2563eb;"></i> Langkah Mengikuti Ujian via APK:
                </div>
                <ol style="margin: 0; padding-left: 18px;">
                    <li>Unduh dan instal aplikasi <b>Exam Browser APK</b> melalui tombol di atas.</li>
                    <li>Buka aplikasi Exam Browser dan masukkan alamat server ujian sekolah.</li>
                    <li>Jika memakai kuota seluler pribadi, ketik <b>6 Digit Kode Akses Ruang</b> yang tampil di layar proyektor kelas pada halaman login APK.</li>
                </ol>
            </div>
        </div>
    </section>
</div>