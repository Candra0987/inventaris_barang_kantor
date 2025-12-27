<?php if(!session_id()) session_start(); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Inventaris Barang Kantor</title>
<style>
:root { --primary:#001b94ff; --danger:#dc3545; --bg:#f8f9fa; --white:#fff; --text:#212529; --text-light:#6c757d; --border:#dee2e6; }
body.dark { --bg:#121212; --white:#1e1e1e; --text:#eaeaea; --text-light:#b0b0b0; --border:#2c2c2c; }
*{box-sizing:border-box;}
body{margin:0; font-family:'Segoe UI',Arial,sans-serif; background-color:var(--bg); color:var(--text); padding-top:70px; transition:background-color 0.3s,color 0.3s;}
a{text-decoration:none;color:var(--text);}
a:hover{color:var(--primary);}
.navbar{position:fixed;top:0;width:100%;background-color:var(--white);border-bottom:1px solid var(--border);z-index:1000;transition:background-color 0.3s,color 0.3s;}
body.dark .navbar{background-color:#1e1e1e;border-color:#2c2c2c;}
.navbar-container{max-width:1200px;margin:auto;padding:0.75rem 1rem;display:flex;justify-content:space-between;align-items:center;}
.navbar-brand{font-weight:700;font-size:1.4rem;color:var(--primary);}
.nav-links{display:flex;align-items:center;gap:1.5rem;}
.nav-user{color:var(--text-light);}
.text-danger{color:var(--danger);}
.dark-toggle{background:none;border:1px solid var(--border);border-radius:6px;padding:4px 8px;cursor:pointer;color:var(--text);}
.navbar-toggle{display:none;background:none;border:none;font-size:1.5rem;cursor:pointer;}
@media(max-width:768px){.navbar-container{flex-wrap:wrap;}.nav-links{width:100%;flex-direction:column;display:none;padding-top:1rem;}.nav-links.active{display:flex;}.navbar-toggle{display:block;}}
.container{max-width:1200px;margin:2rem auto;padding:0 1rem;}
footer{text-align:center;padding:20px;color:var(--text-light);border-top:1px solid var(--border);transition:color 0.3s,border-color 0.3s;}

/* AI Assistant */
#aiButton{position:fixed;bottom:20px;right:20px;width:56px;height:56px;border-radius:50%;background:#001b94;color:#fff;display:flex;align-items:center;justify-content:center;font-size:1.5rem;cursor:pointer;box-shadow:0 6px 16px rgba(0,0,0,.3);z-index:9999;}
#aiChat{position:fixed;bottom:90px;right:20px;width:350px;background:#fff;border-radius:14px;box-shadow:0 12px 30px rgba(0,0,0,.35);display:none;flex-direction:column;overflow:hidden;z-index:9999;transition:background-color 0.3s,color 0.3s;}
body.dark #aiChat{background:#1e1e1e;color:#eaeaea;}
.ai-header{background:#001b94;color:#fff;padding:10px 14px;display:flex;justify-content:space-between;}
.ai-body{padding:12px;height:300px;overflow-y:auto;background:#f8f9fa;font-size:0.9rem;}
body.dark .ai-body{background:#2c2c2c;color:#eaeaea;}
.ai-msg{margin-bottom:10px;padding:8px 12px;border-radius:12px;max-width:85%;}
.ai-msg.ai{background:#dee2e6;}
body.dark .ai-msg.ai{background:#333;color:#fff;}
.ai-msg.user{background:#001b94;color:#fff;margin-left:auto;}
.ai-input{display:flex;border-top:1px solid #dee2e6;}
body.dark .ai-input{border-top:1px solid #444;}
.ai-input input{flex:1;border:none;padding:10px;outline:none;background:transparent;color:inherit;}
.ai-input button{background:#001b94;color:#fff;border:none;padding:0 16px;cursor:pointer;}
.highlight-guide{animation:highlightAnim 1s infinite alternate;border-radius:8px;}
@keyframes highlightAnim{0%{box-shadow:0 0 0 0 rgba(255,200,0,0.7);}100%{box-shadow:0 0 10px 6px rgba(255,200,0,0.9);}}
</style>
</head>
<body>

<nav class="navbar">
<div class="navbar-container">
<a class="navbar-brand" href="?url=dashboard">Inventaris Barang Kantor</a>
<button class="navbar-toggle" onclick="toggleMenu()">☰</button>
<div class="nav-links" id="navLinks">
<?php if(isset($_SESSION['user'])): ?>
<?php if($_SESSION['user']['role']==='admin'): ?>
<a href="?url=admin/items">Barang</a>
<a href="?url=admin/categories">Kategori</a>
<a href="?url=admin/employees">Karyawan</a>
<a href="?url=admin/loans">Peminjaman</a>
<?php else: ?>
<a href="?url=karyawan/items">Barang</a>
<a href="?url=karyawan/loans">Peminjaman</a>
<?php endif; ?>
<span class="nav-user">Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
<button class="dark-toggle" id="darkToggle">🌙</button>
<a href="?url=logout" class="text-danger">Logout</a>
<?php endif; ?>
</div>
</div>
</nav>

<div class="container">
<!-- Konten halaman disini -->
</div>


<script>
document.addEventListener('DOMContentLoaded', function(){
  // Navbar
  window.toggleMenu=function(){ document.getElementById('navLinks').classList.toggle('active'); }

  // Dark mode
  const darkBtn=document.getElementById('darkToggle');
  window.toggleDark=function(){ 
    document.body.classList.toggle('dark'); 
    localStorage.setItem('darkMode', document.body.classList.contains('dark')?'on':'off'); 
  }
  darkBtn.addEventListener('click', toggleDark);
  if(localStorage.getItem('darkMode')==='on'){ document.body.classList.add('dark'); }

  
});
</script>
</body>
</html>
