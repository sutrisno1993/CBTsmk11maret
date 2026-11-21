<?php
$conn = mysqli_connect('localhost', 'root', '', 'zyacbtpublic');
if(!$conn){
    die("Database connection failed: " . mysqli_connect_error() . "\n");
}
mysqli_set_charset($conn, 'utf8');

echo "=== MEMBUAT DATA SIMULASI UJIAN LOKAL ===\n";

// 1. BUAT ATAU AMBIL GRUP SIMULASI
$grup_nama = "SIMULASI CBT";
$q_grup = mysqli_query($conn, "SELECT grup_id FROM cbt_user_grup WHERE grup_nama = '$grup_nama' LIMIT 1");
if(mysqli_num_rows($q_grup) > 0){
    $grup_id = mysqli_fetch_assoc($q_grup)['grup_id'];
    echo "[OK] Grup '$grup_nama' sudah ada (ID: $grup_id)\n";
} else {
    mysqli_query($conn, "INSERT INTO cbt_user_grup (grup_nama) VALUES ('$grup_nama')");
    $grup_id = mysqli_insert_id($conn);
    echo "[+] Grup '$grup_nama' berhasil dibuat (ID: $grup_id)\n";
}

// 2. BUAT ATAU UPDATE USER simulasi01
$username = "simulasi01";
$password = "simulasi01";
$nama_lengkap = "Peserta Simulasi 01";

$q_user = mysqli_query($conn, "SELECT user_id FROM cbt_user WHERE user_name = '$username' LIMIT 1");
if(mysqli_num_rows($q_user) > 0){
    $u_id = mysqli_fetch_assoc($q_user)['user_id'];
    mysqli_query($conn, "UPDATE cbt_user SET 
        user_password = '$password', 
        user_firstname = '$nama_lengkap', 
        user_grup_id = '$grup_id',
        user_login = 0,
        user_level = 1
        WHERE user_id = $u_id");
    echo "[OK] User '$username' diperbarui (ID: $u_id | Pass: $password | Grup ID: $grup_id)\n";
} else {
    mysqli_query($conn, "INSERT INTO cbt_user (
        user_name, user_password, user_firstname, user_grup_id, user_login, user_level, user_regdate
    ) VALUES (
        '$username', '$password', '$nama_lengkap', '$grup_id', 0, 1, NOW()
    )");
    $u_id = mysqli_insert_id($conn);
    echo "[+] User '$username' berhasil dibuat (ID: $u_id | Pass: $password | Grup ID: $grup_id)\n";
}

// 3. BUAT ATAU AMBIL MODUL SIMULASI
$modul_nama = "Simulasi Ujian";
$q_modul = mysqli_query($conn, "SELECT modul_id FROM cbt_modul WHERE modul_nama = '$modul_nama' LIMIT 1");
if(mysqli_num_rows($q_modul) > 0){
    $modul_id = mysqli_fetch_assoc($q_modul)['modul_id'];
    echo "[OK] Modul '$modul_nama' sudah ada (ID: $modul_id)\n";
} else {
    mysqli_query($conn, "INSERT INTO cbt_modul (modul_nama, modul_aktif) VALUES ('$modul_nama', 1)");
    $modul_id = mysqli_insert_id($conn);
    echo "[+] Modul '$modul_nama' berhasil dibuat (ID: $modul_id)\n";
}

// 4. BUAT ATAU AMBIL TOPIK SIMULASI
$topik_nama = "Latihan & Simulasi SMART-CBT";
$q_topik = mysqli_query($conn, "SELECT topik_id FROM cbt_topik WHERE topik_modul_id = $modul_id AND topik_nama = '$topik_nama' LIMIT 1");
if(mysqli_num_rows($q_topik) > 0){
    $topik_id = mysqli_fetch_assoc($q_topik)['topik_id'];
    echo "[OK] Topik '$topik_nama' sudah ada (ID: $topik_id)\n";
} else {
    mysqli_query($conn, "INSERT INTO cbt_topik (topik_modul_id, topik_nama, topik_detail, topik_aktif, topik_tipe) 
        VALUES ($modul_id, '$topik_nama', 'Bank Soal Simulasi Ujian Berbasis Komputer SMK 11 MARET', 1, 'panitia')");
    $topik_id = mysqli_insert_id($conn);
    echo "[+] Topik '$topik_nama' berhasil dibuat (ID: $topik_id)\n";
}

// 5. BUAT SOAL DAN JAWABAN PILIHAN GANDA (5 SOAL)
$soal_list = array(
    array(
        'tanya' => '<p>Apa kepanjangan dari singkatan <b>CBT</b> dalam konteks pelaksanaan ujian sekolah modern?</p>',
        'opsi' => array(
            array('Computer Based Test', 1),
            array('Computer Basic Training', 0),
            array('Central Board Testing', 0),
            array('Connection Broad Terminal', 0),
            array('Class Based Tutorial', 0),
        )
    ),
    array(
        'tanya' => '<p>SMK 11 MARET berkomitmen mencetak lulusan berakhlak mulia dan kompeten. Sikap utama yang harus dijunjung tinggi peserta saat mengikuti ujian CBT adalah...</p>',
        'opsi' => array(
            array('Kecepatan menjawab tanpa membaca soal dengan teliti', 0),
            array('Kejujuran, kedisiplinan, dan integritas mandiri', 1),
            array('Bekerja sama dan saling mencontek dengan teman', 0),
            array('Membuka browser lain untuk mencari kunci jawaban', 0),
            array('Menunggu teman selesai untuk meniru jawaban', 0),
        )
    ),
    array(
        'tanya' => '<p>Perangkat keras (hardware) komputer yang berfungsi sebagai papan tombol untuk memasukkan data karakter atau teks adalah...</p>',
        'opsi' => array(
            array('Monitor', 0),
            array('Keyboard', 1),
            array('Mouse', 0),
            array('Printer', 0),
            array('Scanner', 0),
        )
    ),
    array(
        'tanya' => '<p>Protokol jaringan yang digunakan untuk mengamankan transmisi data melalui enkripsi pada situs web dengan simbol gembok hijau/aman adalah...</p>',
        'opsi' => array(
            array('HTTP', 0),
            array('HTTPS', 1),
            array('FTP', 0),
            array('SMTP', 0),
            array('Telnet', 0),
        )
    ),
    array(
        'tanya' => '<p>Dalam sistem ujian <b>SMART-CBT</b>, jika peserta merasa belum yakin dengan pilihan jawaban yang dipilih pada suatu nomor soal, tombol apa yang dapat digunakan untuk menandai nomor tersebut?</p>',
        'opsi' => array(
            array('Tombol Hentikan Tes', 0),
            array('Tombol Selesai Ujian', 0),
            array('Tombol Ragu-ragu (Warna Kuning)', 1),
            array('Tombol Batal Ujian', 0),
            array('Tombol Refresh Browser', 0),
        )
    )
);

// Hapus soal lama di topik ini agar tidak duplikat saat dijalankan ulang
$q_old_soal = mysqli_query($conn, "SELECT soal_id FROM cbt_soal WHERE soal_topik_id = $topik_id");
while($r_old = mysqli_fetch_assoc($q_old_soal)){
    $old_sid = $r_old['soal_id'];
    // Bersihkan referensi di cbt_tes_soal_jawaban dan cbt_tes_soal terlebih dahulu (Foreign Key)
    $q_old_tsoal = mysqli_query($conn, "SELECT tessoal_id FROM cbt_tes_soal WHERE tessoal_soal_id = $old_sid");
    while($r_ots = mysqli_fetch_assoc($q_old_tsoal)){
        mysqli_query($conn, "DELETE FROM cbt_tes_soal_jawaban WHERE soaljawaban_tessoal_id = {$r_ots['tessoal_id']}");
    }
    mysqli_query($conn, "DELETE FROM cbt_tes_soal WHERE tessoal_soal_id = $old_sid");
    mysqli_query($conn, "DELETE FROM cbt_jawaban WHERE jawaban_soal_id = $old_sid");
}
mysqli_query($conn, "DELETE FROM cbt_soal WHERE soal_topik_id = $topik_id");

$soal_count = 0;
foreach($soal_list as $item){
    $tanya_esc = mysqli_real_escape_string($conn, $item['tanya']);
    mysqli_query($conn, "INSERT INTO cbt_soal (soal_topik_id, soal_detail, soal_tipe, soal_difficulty, soal_aktif) 
        VALUES ($topik_id, '$tanya_esc', 1, 1, 1)");
    $soal_id = mysqli_insert_id($conn);
    $soal_count++;

    foreach($item['opsi'] as $opsi){
        $opsi_esc = mysqli_real_escape_string($conn, "<p>{$opsi[0]}</p>");
        $benar = $opsi[1];
        mysqli_query($conn, "INSERT INTO cbt_jawaban (jawaban_soal_id, jawaban_detail, jawaban_benar, jawaban_aktif) 
            VALUES ($soal_id, '$opsi_esc', $benar, 1)");
    }
}
echo "[+] Berhasil membuat $soal_count Soal beserta pilihan jawaban A, B, C, D, E\n";

// 6. BUAT ATAU UPDATE TES SIMULASI
$tes_nama = "[SIMULASI] Simulasi Ujian SMART-CBT SMK 11 MARET";
$tes_detail = "Simulasi Ujian Berbasis Komputer SMK 11 MARET. Silakan jawab 5 soal berikut dengan teliti.";
$waktu_mulai = date('Y-m-d 00:00:00');
$waktu_selesai = date('Y-m-d 23:59:59', strtotime('+365 days')); // Aktif 1 tahun ke depan

$q_tes = mysqli_query($conn, "SELECT tes_id FROM cbt_tes WHERE tes_nama = '$tes_nama' LIMIT 1");
if(mysqli_num_rows($q_tes) > 0){
    $tes_id = mysqli_fetch_assoc($q_tes)['tes_id'];
    mysqli_query($conn, "UPDATE cbt_tes SET
        tes_detail = '$tes_detail',
        tes_begin_time = '$waktu_mulai',
        tes_end_time = '$waktu_selesai',
        tes_duration_time = 60,
        tes_ip_range = '*.*.*.*',
        tes_results_to_users = 1,
        tes_detail_to_users = 1,
        tes_score_right = 20.00,
        tes_score_wrong = 0.00,
        tes_score_unanswered = 0.00,
        tes_max_score = 100.00,
        tes_token = 0
        WHERE tes_id = $tes_id");
    echo "[OK] Tes '$tes_nama' sudah ada dan diperbarui (ID: $tes_id)\n";
} else {
    mysqli_query($conn, "INSERT INTO cbt_tes (
        tes_nama, tes_detail, tes_begin_time, tes_end_time, tes_duration_time,
        tes_ip_range, tes_results_to_users, tes_detail_to_users,
        tes_score_right, tes_score_wrong, tes_score_unanswered, tes_max_score,
        tes_token, tes_user_id
    ) VALUES (
        '$tes_nama', '$tes_detail', '$waktu_mulai', '$waktu_selesai', 60,
        '*.*.*.*', 1, 1,
        20.00, 0.00, 0.00, 100.00,
        0, 1
    )");
    $tes_id = mysqli_insert_id($conn);
    echo "[+] Tes '$tes_nama' berhasil dibuat (ID: $tes_id)\n";
}

// 7. HUBUNGKAN TES KE GRUP (cbt_tesgrup)
// Hubungkan ke grup simulasi
mysqli_query($conn, "DELETE FROM cbt_tesgrup WHERE tstgrp_tes_id = $tes_id");
mysqli_query($conn, "INSERT INTO cbt_tesgrup (tstgrp_tes_id, tstgrp_grup_id) VALUES ($tes_id, $grup_id)");

// Opsional: Hubungkan juga ke semua grup agar siswa lain bisa mencoba simulasi jika mau
$q_all_grup = mysqli_query($conn, "SELECT grup_id FROM cbt_user_grup WHERE grup_id != $grup_id");
while($rg = mysqli_fetch_assoc($q_all_grup)){
    mysqli_query($conn, "INSERT INTO cbt_tesgrup (tstgrp_tes_id, tstgrp_grup_id) VALUES ($tes_id, {$rg['grup_id']})");
}
echo "[+] Tes berhasil dihubungkan ke Grup Peserta Tes\n";

// 8. HUBUNGKAN TOPIK SET KE TES (cbt_tes_topik_set)
mysqli_query($conn, "DELETE FROM cbt_tes_topik_set WHERE tset_tes_id = $tes_id");
mysqli_query($conn, "INSERT INTO cbt_tes_topik_set (
    tset_tes_id, tset_topik_id, tset_tipe, tset_difficulty,
    tset_jumlah, tset_jawaban, tset_acak_jawaban, tset_acak_soal
) VALUES (
    $tes_id, $topik_id, 1, 1,
    5, 5, 1, 1
)");
echo "[+] Komposisi Soal (Topik Set) berhasil dihubungkan ke Tes (5 Soal Pilihan Ganda)\n";

// 9. RESET RIWAYAT TES SEBELUMNYA UNTUK USER simulasi01 (JIKA PERNAH ADA)
$q_old_tesuser = mysqli_query($conn, "SELECT tesuser_id FROM cbt_tes_user WHERE tesuser_user_id = $u_id AND tesuser_tes_id = $tes_id");
while($rtu = mysqli_fetch_assoc($q_old_tesuser)){
    $tuid = $rtu['tesuser_id'];
    $q_tsoal = mysqli_query($conn, "SELECT tessoal_id FROM cbt_tes_soal WHERE tessoal_tesuser_id = $tuid");
    while($rts = mysqli_fetch_assoc($q_tsoal)){
        mysqli_query($conn, "DELETE FROM cbt_tes_soal_jawaban WHERE soaljawaban_tessoal_id = {$rts['tessoal_id']}");
    }
    mysqli_query($conn, "DELETE FROM cbt_tes_soal WHERE tessoal_tesuser_id = $tuid");
    mysqli_query($conn, "DELETE FROM cbt_tes_user WHERE tesuser_id = $tuid");
}
echo "[+] Status riwayat ujian user '$username' dibersihkan (siap mulai fresh)\n";

echo "\n============================================\n";
echo ">>> SIMULASI BERHASIL DISIAPKAN DI LOKAL! <<<\n";
echo "Username : $username\n";
echo "Password : $password\n";
echo "Grup     : $grup_nama\n";
echo "Mata Uji : $tes_nama\n";
echo "Jumlah   : 5 Soal (Durasi: 60 Menit)\n";
echo "Token    : Tidak Perlu Token (Langsung Mulai)\n";
echo "============================================\n";
