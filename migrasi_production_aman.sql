-- ============================================================================
-- MIGRASI PRODUCTION AMAN (TANPA MENGHAPUS DATA SISWA / SOAL / HASIL UJIAN)
-- SMART-CBT SMK 11 MARET
-- Jalankan file ini di phpMyAdmin atau MySQL CLI server Production jika di
-- server Production sudah ada data siswa/soal/ujian yang sedang berjalan.
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Upgrade presisi kolom skor menjadi DECIMAL(10,4) agar pembagian 100 / jumlah_soal presisi
ALTER TABLE `cbt_tes`
  MODIFY COLUMN `tes_score_right` DECIMAL(10,4) DEFAULT 1.0000,
  MODIFY COLUMN `tes_score_wrong` DECIMAL(10,4) DEFAULT 0.0000,
  MODIFY COLUMN `tes_score_unanswered` DECIMAL(10,4) DEFAULT 0.0000,
  MODIFY COLUMN `tes_max_score` DECIMAL(10,2) NOT NULL DEFAULT 100.00;

ALTER TABLE `cbt_tes_soal`
  MODIFY COLUMN `tessoal_nilai` DECIMAL(10,4) NOT NULL DEFAULT 0.0000;

-- 2. Tambahkan kolom tesuser_pelanggaran pada cbt_tes_user (jika belum ada)
SET @dbname = DATABASE();
SET @tablename = 'cbt_tes_user';
SET @columnname = 'tesuser_pelanggaran';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  'ALTER TABLE `cbt_tes_user` ADD COLUMN `tesuser_pelanggaran` INT(11) NOT NULL DEFAULT 0;'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 3. Normalisasi otomatis seluruh jadwal tes di cbt_tes ke Skala Nilai 100
UPDATE `cbt_tes` t
JOIN (
    SELECT `tset_tes_id`, SUM(`tset_jumlah`) AS `total_soal`
    FROM `cbt_tes_topik_set`
    GROUP BY `tset_tes_id`
    HAVING `total_soal` > 0
) s ON t.`tes_id` = s.`tset_tes_id`
SET
    t.`tes_score_right` = ROUND(100 / s.`total_soal`, 4),
    t.`tes_max_score` = 100.00;

-- 4. Rekalkulasi nilai lembar jawaban siswa yang sudah terlanjur ujian dengan poin lama (misal 1.00 / maks 40)
UPDATE `cbt_tes_soal` ts
JOIN `cbt_tes_user` tu ON ts.`tessoal_tesuser_id` = tu.`tesuser_id`
JOIN `cbt_tes` t ON tu.`tesuser_tes_id` = t.`tes_id`
SET ts.`tessoal_nilai` = t.`tes_score_right`
WHERE ts.`tessoal_nilai` > 0;

-- 5. Bersihkan duplikasi menu Mata Pelajaran (Modul) pada user_akses
DELETE a1 FROM `user_akses` a1
INNER JOIN `user_akses` a2
WHERE a1.`id` > a2.`id`
  AND a1.`level` = a2.`level`
  AND a1.`kode_menu` = a2.`kode_menu`;

SET FOREIGN_KEY_CHECKS = 1;
