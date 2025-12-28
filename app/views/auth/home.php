<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Sistem Inventaris Profesional</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font & Icon -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(145deg, #4f46e5, #0ea5e9, #8b5cf6);
    background-size: 300% 300%;
    animation: gradientFlow 12s ease infinite;
    color: #fff;
}

@keyframes gradientFlow {
    0% { background-position: 0% 30%; }
    50% { background-position: 100% 70%; }
    100% { background-position: 0% 30%; }
}

/* NAVBAR */
.navbar-custom {
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.15);
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.navbar-brand {
    font-weight: 700;
    font-size: 22px;
    color: #fff !important;
}

.nav-link {
    font-weight: 500;
    color: #e0e7ff !important;
}

/* GLASS CARD */
.glass-card {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(16px);
    border-radius: 22px;
    padding: 45px;
    border: 1px solid rgba(255,255,255,0.25);
    box-shadow: 0 12px 40px rgba(0,0,0,0.25);
}

/* HERO */
.hero-title {
    font-size: 36px;
    font-weight: 700;
}

.hero-sub {
    font-size: 16px;
    opacity: .9;
}

/* BUTTON */
.btn-modern {
    background: linear-gradient(135deg, #6366f1, #0ea5e9);
    border: none;
    padding: 12px 28px;
    border-radius: 14px;
    font-weight: 600;
    color: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,.3);
    transition: .3s;
    text-decoration: none;
}

.btn-modern:hover {
    transform: translateY(-3px);
}

/* CAROUSEL */
.carousel-item {
    min-height: 260px;
}

.feature-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

/* FOOTER */
.footer {
    margin-top: 80px;
    padding: 40px 0;
    text-align: center;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(12px);
    font-size: 14px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top">
<div class="container">
    <a class="navbar-brand" href="#">
        <i class="fa-solid fa-boxes-stacked"></i> InventarisX
    </a>

    <button class="navbar-toggler bg-light" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
            <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
            <li class="nav-item"><a class="nav-link" href="?url=login">Login</a></li>
        </ul>
    </div>
</div>
</nav>

<!-- HERO -->
<div class="container" style="padding-top:130px;">
<div class="row justify-content-center">
<div class="col-lg-8">
    <div class="glass-card text-center">
        <h2 class="hero-title">Sistem Inventaris Barang Kantor</h2>
        <p class="hero-sub mt-2">
            Aplikasi modern untuk mengelola peminjaman barang secara cepat,
            aman, dan terintegrasi.
        </p>

        <div class="mt-4">
            <a href="?url=login" class="btn-modern">Masuk ke Sistem</a>
        </div>
    </div>
</div>
</div>
</div>

<!-- TENTANG + CAROUSEL -->
<div class="container mt-5" id="tentang">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="glass-card">
<h3 class="fw-bold text-center mb-4">Tentang Aplikasi</h3>

<div id="aboutCarousel" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-indicators">
    <button data-bs-target="#aboutCarousel" data-bs-slide-to="0" class="active"></button>
    <button data-bs-target="#aboutCarousel" data-bs-slide-to="1"></button>
    <button data-bs-target="#aboutCarousel" data-bs-slide-to="2"></button>
</div>

<div class="carousel-inner text-center">

<div class="carousel-item active">
    <i class="feature-icon fa-solid fa-box"></i>
    <h5>Manajemen Inventaris</h5>
    <p>
        Kelola stok barang kantor secara terpusat, rapi,
        dan selalu terupdate.
    </p>
</div>

<div class="carousel-item">
    <i class="feature-icon fa-solid fa-handshake"></i>
    <h5>Peminjaman Terkontrol</h5>
    <p>
        Proses peminjaman dengan persetujuan admin
        untuk mencegah kehilangan barang.
    </p>
</div>

<div class="carousel-item">
    <i class="feature-icon fa-solid fa-chart-line"></i>
    <h5>Laporan & Monitoring</h5>
    <p>
        Pantau riwayat peminjaman dan cetak laporan
        secara otomatis.
    </p>
</div>

</div>

<button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
</button>
</div>

</div>
</div>
</div>
</div>

<!-- FITUR LIST -->
<div class="container mt-5" id="fitur">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="glass-card">
<h3 class="fw-bold text-center mb-3">Fitur Unggulan</h3>
<ul>
    <li>Peminjaman barang real-time</li>
    <li>Validasi admin</li>
    <li>Role Admin & Karyawan</li>
    <li>Manajemen kategori & kondisi barang</li>
    <li>Riwayat peminjaman lengkap</li>
    <li>Cetak laporan PDF</li>
    <li>Mini AI</li>
    <li>Dark Mode</li>
</ul>
</div>

</div>
</div>
</div>

<!-- FOOTER -->
<footer class="footer">
© 2025 InventarisX — Sistem Inventaris Barang Kantor  
<br>
<a href="https://www.instagram.com/_cndrx/" style="color:#fff;">Follow me</a>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
