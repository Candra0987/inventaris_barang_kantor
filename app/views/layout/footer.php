<?php
// Cek login, ganti sesuai sistemmu
$isLoggedIn = isset($_SESSION['user']); 
?>

<!-- Hanya tampilkan footer jika user BELUM login -->
<?php if(!$isLoggedIn): ?>

    <style>
/* ===== BODY & WRAPPER ===== */
html, body {
    height: 100%;
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column;
}

/* Konten utama */
.page-wrapper {
    flex: 1; /* dorong footer ke bawah */
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

/* ===== FOOTER ===== */
.footer{
  background: rgba(0,0,0,0.25);
  backdrop-filter: blur(6px);
  color: #fff;
  font-size: 13px;
  width: 100%;
  box-sizing: border-box;
}

.footer-content{
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 10px;
  padding: 20px;
  text-align: left;
}

.footer-col h4{
  margin-bottom: 8px;
  font-size: 14px;
  color: #ffeb3b;
}

.footer-col p,
.footer-col a{
  margin: 4px 0;
  color: #eee;
  text-decoration: none;
}

.footer-col a:hover{
  text-decoration: underline;
}

.social a{
  font-size: 18px;
  margin-right: 10px;
  color: #ffeb3b;
  transition: transform 0.2s;
}

.social a:hover{
  transform: scale(1.1);
}

.footer-bottom{
  text-align: center;
  padding: 10px;
  font-size: 12px;
  background: rgba(0,0,0,0.3);
  margin: 0;
}

/* Optional: responsive small devices */
@media(max-width: 480px){
  .footer-content{
    grid-template-columns: 1fr;
    text-align: center;
  }
  .social a{
    margin-right: 6px;
  }
}
</style>

<footer class="footer">
  <div class="footer-content">

    <div class="footer-col">
      <h4>InventarisX</h4>
      <p>Sistem Inventaris Barang Kantor<br>Solusi cepat & aman</p>
    </div>

    <div class="footer-col">
      <h4>Kontak</h4>
      <p>📞 CS: 0812-3456-7890</p>
      <p>✉️ Email: support@inventarisx.com</p>
    </div>

    <div class="footer-col">
      <h4>Alamat</h4>
      <p>📍 Jakarta, Indonesia</p>
      <a href="https://www.google.com/maps" target="_blank">Lihat di Maps</a>
    </div>

    <div class="footer-col">
      <h4>Sosial Media</h4>
      <div class="social">
        <a href="https://www.instagram.com/_cndrx/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-github"></i></a>
      </div>
    </div>

  </div>

  <div class="footer-bottom">
    © 2025 InventarisX • All rights reserved
  </div>
</footer>
<?php endif; ?>

<!-- CSS tetap sama -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
