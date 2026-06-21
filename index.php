<?php

require "config.php";

// DELETE — hapus proyek berdasarkan id di URL (?delete=id)
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM projects WHERE id = $id");
    header("Location: index.php");
    exit;
}

// CREATE / UPDATE — diproses saat form di-submit (method POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = mysqli_real_escape_string($conn, trim($_POST['title'] ?? ''));
    $description = mysqli_real_escape_string($conn, trim($_POST['description'] ?? ''));
    $tech        = mysqli_real_escape_string($conn, trim($_POST['tech'] ?? ''));
    $id          = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    if ($title !== '' && $description !== '') {
        if ($id > 0) {
            // UPDATE proyek yang sudah ada
            mysqli_query(
                $conn,
                "UPDATE projects SET title='$title', description='$description', tech='$tech' WHERE id=$id"
            );
        } else {
            // CREATE proyek baru
            mysqli_query(
                $conn,
                "INSERT INTO projects (title, description, tech) VALUES ('$title', '$description', '$tech')"
            );
        }
    }
    header("Location: index.php");
    exit;
}

// Siapkan data untuk form EDIT (kalau ada ?edit=id di URL)
$editing = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM projects WHERE id = $id");
    $editing = mysqli_fetch_assoc($result);
}

// READ — ambil semua proyek untuk ditampilkan
$projects = mysqli_query($conn, "SELECT * FROM projects ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Chevron Sonie Fahrezy — Portofolio</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- ============ NAV ============ -->
<header class="nav">
  <a href="#top" class="logo">CSF<span class="logo-chevron">›</span></a>
  <nav class="nav-links">
    <a href="#about">Tentang</a>
    <a href="#skills">Keahlian</a>
    <a href="#projects">Proyek</a>
    <a href="#contact">Kontak</a>
  </nav>
</header>

<!-- ============ HERO ============ -->
<section class="hero" id="top">
  <div class="chevron-rail" aria-hidden="true">
    <div class="chevron-row r1">›››› ›››› ›››› ›››› ›››› ›››› ›››› ››››</div>
    <div class="chevron-row r2">›››› ›››› ›››› ›››› ›››› ›››› ›››› ››››</div>
    <div class="chevron-row r3">›››› ›››› ›››› ›››› ›››› ›››› ›››› ››››</div>
  </div>

  <div class="hero-content">
    <p class="eyebrow">Portofolio &mdash; Pemrograman Web</p>
    <h1 class="hero-name">Chevron Sonie<br/>Fahrezy</h1>
    <p class="hero-tagline">
      Merancang antarmuka yang rapi dan membangun backend yang benar-benar
      bekerja &mdash; bukan sekadar tampilan.
    </p>
    <div class="hero-actions">
      <a href="#projects" class="btn btn-primary">Lihat Proyek</a>
      <a href="#contact" class="btn btn-ghost">Hubungi Saya</a>
    </div>
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="section" id="about">
  <div class="section-head">
    <span class="tag">› Tentang</span>
    <h2>Mengenal Saya</h2>
  </div>
  <div class="about-grid">
    <p class="about-text">
      Saya Chevron Sonie Fahrezy, mahasiswa yang fokus mempelajari
      pemrograman web dari sisi tampilan sampai logika di belakangnya.
      Bagi saya, desain yang bagus tidak ada artinya tanpa sistem yang
      jalan &mdash; karena itu saya selalu memastikan setiap proyek punya
      backend nyata, bukan cuma halaman statis.
    </p>
    <div class="about-card">
      <div class="about-row"><span>Fokus</span><strong>Full-Stack Web Development</strong></div>
      <div class="about-row"><span>Pendekatan</span><strong>Desain rapi, kode terstruktur</strong></div>
      <div class="about-row"><span>Status</span><strong>Terbuka untuk kolaborasi</strong></div>
    </div>
  </div>
</section>

<!-- ============ SKILLS ============ -->
<section class="section section-alt" id="skills">
  <div class="section-head">
    <span class="tag">› Keahlian</span>
    <h2>Tools &amp; Teknologi</h2>
  </div>
  <div class="skills-grid">
    <div class="skill-card">
      <h3>Frontend</h3>
      <p>HTML5, CSS3, JavaScript</p>
    </div>
    <div class="skill-card">
      <h3>Backend</h3>
      <p>PHP</p>
    </div>
    <div class="skill-card">
      <h3>Database</h3>
      <p>MySQL (phpMyAdmin)</p>
    </div>
    <div class="skill-card">
      <h3>Lainnya</h3>
      <p>XAMPP, CRUD</p>
    </div>
  </div>
</section>

<!-- ============ PROJECTS / CRUD ============ -->
<section class="section" id="projects">
  <div class="section-head">
    <span class="tag">› Proyek</span>
    <h2>Proyek Saya</h2>
    <p class="section-sub">
      Data di bawah diambil langsung dari database MySQL lewat PHP.
      Tambah, ubah, atau hapus proyek &mdash; semuanya tersimpan secara nyata.
    </p>
  </div>

  <!-- FORM CREATE / UPDATE -->
  <form class="project-form" method="POST" action="index.php">
    <input type="hidden" name="id" value="<?= $editing ? (int)$editing['id'] : '' ?>" />
    <div class="form-row">
      <div class="field">
        <label for="title">Judul Proyek</label>
        <input
          type="text" id="title" name="title"
          placeholder="Contoh: Aplikasi Kasir"
          value="<?= $editing ? htmlspecialchars($editing['title']) : '' ?>"
          required />
      </div>
      <div class="field">
        <label for="tech">Teknologi</label>
        <input
          type="text" id="tech" name="tech"
          placeholder="Contoh: PHP, MySQL"
          value="<?= $editing ? htmlspecialchars($editing['tech']) : '' ?>" />
      </div>
    </div>
    <div class="field">
      <label for="description">Deskripsi</label>
      <textarea
        id="description" name="description" rows="3"
        placeholder="Ceritakan singkat proyek ini..." required
      ><?= $editing ? htmlspecialchars($editing['description']) : '' ?></textarea>
    </div>
    <div class="form-actions">
      <button type="submit" class="btn btn-primary">
        <?= $editing ? 'Simpan Perubahan' : 'Tambah Proyek' ?>
      </button>
      <?php if ($editing): ?>
        <a href="index.php" class="btn btn-ghost">Batal</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- LIST -->
  <div class="project-list">
    <?php if (mysqli_num_rows($projects) === 0): ?>
      <p class="empty">Belum ada proyek. Tambahkan yang pertama di atas →</p>
    <?php else: ?>
      <?php while ($p = mysqli_fetch_assoc($projects)): ?>
        <article class="project-card">
          <h3><?= htmlspecialchars($p['title']) ?></h3>
          <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
          <?php if (!empty($p['tech'])): ?>
            <span class="project-tech"><?= htmlspecialchars($p['tech']) ?></span>
          <?php endif; ?>
          <div class="project-actions">
            <a class="icon-btn" href="index.php?edit=<?= (int)$p['id'] ?>#projects">Ubah</a>
            <a
              class="icon-btn danger"
              href="index.php?delete=<?= (int)$p['id'] ?>"
              onclick="return confirm('Hapus proyek ini? Tindakan ini tidak bisa dibatalkan.');"
            >Hapus</a>
          </div>
        </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="section section-alt" id="contact">
  <div class="section-head">
    <span class="tag">› Kontak</span>
    <h2>Mari Terhubung</h2>
  </div>
  <div class="contact-grid">
    <a href="mailto:chevronsonie@gmail.com" class="contact-card">
      <span>Email</span>
      <strong>chevronsonie@gmail.com</strong>
    </a>
    <a href="https://instagram.com" target="_blank" rel="noopener" class="contact-card">
      <span>Instagram</span>
      <strong>chevronsonie</strong>
    </a>
  </div>
</section>

<footer class="footer">
  <p>&copy; 2026 Chevron Sonie Fahrezy. Dibangun dengan HTML, CSS &amp; PHP.</p>
</footer>

</body>
</html>