-- =========================================================
-- Database Portofolio — Chevron Sonie Fahrezy
-- Cara pakai: buka phpMyAdmin (http://localhost/phpmyadmin)
-- -> tab "Import" -> pilih file ini -> klik "Go"
-- (Database dan tabelnya akan otomatis dibuat)
-- =========================================================

CREATE DATABASE IF NOT EXISTS portfolio_chevron;
USE portfolio_chevron;

CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  description TEXT NOT NULL,
  tech VARCHAR(150),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO projects (title, description, tech) VALUES
('Sistem Inventori Toko', 'Aplikasi manajemen stok barang dengan fitur laporan otomatis dan notifikasi stok menipis.', 'PHP, MySQL, Bootstrap'),
('Aplikasi Kasir (POS)', 'Point of Sale sederhana untuk UMKM, mendukung cetak struk dan rekap penjualan harian.', 'PHP, MySQL, JavaScript'),
('Landing Page UMKM', 'Landing page promosi untuk usaha kecil, fokus pada kecepatan loading dan tampilan rapi.', 'HTML, CSS, JavaScript');
