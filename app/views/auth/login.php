<?php require __DIR__.'/../layout/header.php'; ?>

<style>
/* ===== BODY ===== */
html, body {
    height: 100%;
    margin: 0;
}

body {
    background: linear-gradient(145deg, #4f46e5, #0ea5e9, #8b5cf6);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    flex-direction: column; /* penting untuk footer */
}

/* ===== PAGE WRAPPER ===== */
.page-wrapper {
    flex: 1;                     /* dorong footer ke bawah */
    display: flex;
    justify-content: center;      /* horizontal center login */
    align-items: center;          /* vertical center login */
}

/* ===== LOGIN CARD ===== */
.login-card {
    background-color: #fff;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
    animation: fadeInCard 1s ease-in;
}

@keyframes fadeInCard { 
    from {transform:translateY(-20px); opacity:0;} 
    to {transform:translateY(0); opacity:1;} 
}

h3 { margin-bottom:25px; color:#333; }

.form-group { position: relative; margin-bottom: 20px; }
.form-group input { 
    width:100%; 
    padding:12px 12px 12px 40px; 
    border:1px solid #ccc; 
    border-radius:10px; 
    transition: border-color 0.3s, box-shadow 0.3s; 
}
.form-group input:focus { 
    border-color:#007bff; 
    box-shadow:0 0 8px rgba(0,123,255,0.3); 
    outline:none; 
}
.form-group i { position:absolute; top:50%; left:12px; transform:translateY(-50%); color:#999; }

.btn-login {
    width: 100%; 
    padding: 12px; 
    border:none; 
    border-radius:10px;
    font-size:16px; 
    color:#fff; 
    background:linear-gradient(90deg, #ff7e5f, #feb47b);
    cursor:pointer; 
    transition: background 0.4s, transform 0.2s;
}
.btn-login:hover { background: linear-gradient(90deg, #feb47b, #ff7e5f); transform: translateY(-2px); }

.alert { padding:12px 15px; border-radius:8px; margin-bottom:20px; font-size:14px; }
.alert-danger { background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

/* ===== SYSTEM STATUS ===== */
.system-status{
  margin-top:20px;
  font-size:13px;
  color:#555;
  display:flex;
  justify-content:center;
  align-items:center;
  gap:8px;
}

.dot{
  width:10px;
  height:10px;
  border-radius:50%;
}

.online{ background:#22c55e; animation:pulse 1.2s infinite; }
.offline{ background:#ef4444; }

@keyframes pulse{
  0%{box-shadow:0 0 0 0 rgba(34,197,94,.6)}
  100%{box-shadow:0 0 0 8px rgba(34,197,94,0)}
}

.divider{ opacity:.4; }

/* ===== AI ASSISTANT ===== */
#aiButton{ position:fixed; bottom:20px; right:20px; width:56px; height:56px;
border-radius:50%; background:#001b94; color:#fff; display:flex; align-items:center; justify-content:center;
font-size:1.5rem; cursor:pointer; box-shadow:0 6px 16px rgba(0,0,0,.3); z-index:9999; }
#aiChat{ position:fixed; bottom:90px; right:20px; width:350px; background:#fff;
border-radius:14px; box-shadow:0 12px 30px rgba(0,0,0,.35);
display:none; flex-direction:column; overflow:hidden; z-index:9999; }
.ai-header{ background:#001b94; color:#fff; padding:10px 14px; display:flex; justify-content:space-between; }
.ai-body{ padding:12px; height:300px; overflow-y:auto; background:#f8f9fa; font-size:0.9rem; }
.ai-msg{ margin-bottom:10px; padding:8px 12px; border-radius:12px; max-width:85%; }
.ai-msg.ai{ background:#dee2e6; }
.ai-msg.user{ background:#001b94; color:#fff; margin-left:auto; }
.ai-input{ display:flex; border-top:1px solid #dee2e6; }
.ai-input input{ flex:1; border:none; padding:10px; outline:none; }
.ai-input button{ background:#001b94; color:#fff; border:none; padding:0 16px; cursor:pointer; }

.ai-typing{ font-size:12px; color:#666; font-style:italic; }

/* ===== FOOTER ===== */
.footer{
  margin-top:auto;
  background:rgba(0,0,0,0.25);
  backdrop-filter:blur(6px);
  color:#fff;
  font-size:13px;
  text-align:left;
  padding:15px 20px;
}

.footer a{
  color:#ffeb3b;
  text-decoration:none;
}

.footer a:hover{ text-decoration:underline; }

</style>

<div class="page-wrapper">

    <div class="login-card">
        <h3>Login</h3>
        <?php if(isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="?url=login">
            <div class="form-group">
                <i class="fa fa-envelope"></i>
                <input class="form-control" type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input class="form-control" type="password" name="password" placeholder="Password" required>
            </div>

            <button class="btn-login" type="submit" id="loginBtn">Login</button>
        </form>

        <div class="system-status">
            <span class="dot online"></span>
            <span id="serverText">Server Online</span>
            <span class="divider">|</span>
            <span id="clock"></span>
        </div>

    </div>

</div>

<!-- AI Assistant Popup -->
<div id="aiButton">🤖</div>
<div id="aiChat">
  <div class="ai-header">
    <span>AI Assistant</span>
    <button onclick="toggleAI()">✖</button>
  </div>
  <div class="ai-body" id="aiBody">
    <div class="ai-msg ai">
      👋 Halo! Saya asisten virtual. Tanyakan tentang akun demo, fitur, alur Admin atau Karyawan.
    </div>
  </div>
  <div style="padding:6px; background:#eee; display:flex; gap:6px; flex-wrap:wrap;">
    <button onclick="addMsg('akun demo','user');addMsg(getAIResponse('akun demo'),'ai')">Akun Demo</button>
    <button onclick="addMsg('fitur','user');addMsg(getAIResponse('fitur'),'ai')">Fitur</button>
    <button onclick="addMsg('login','user');addMsg(getAIResponse('login'),'ai')">Login</button>
  </div>

  <div class="ai-input">
    <input id="aiInput" placeholder="Tanya sesuatu..." onkeydown="if(event.key==='Enter')sendAI()">
    <button onclick="sendAI()">➤</button>
  </div>
</div>



<script>
// ===== AI Assistant =====
const aiButton = document.getElementById('aiButton');
const aiChat = document.getElementById('aiChat');
const aiBody = document.getElementById('aiBody');
const aiInput = document.getElementById('aiInput');
const loginBtn = document.getElementById('loginBtn');

aiButton.onclick = toggleAI;
function toggleAI(){ aiChat.style.display = aiChat.style.display==='flex'?'none':'flex'; }

function sendAI(){
    const text = aiInput.value.trim();
    if(!text) return;

    addMsg(text,'user');
    aiInput.value='';

    const typing = document.createElement('div');
    typing.className = 'ai-typing';
    typing.textContent = 'AI sedang mengetik...';
    aiBody.appendChild(typing);
    aiBody.scrollTop = aiBody.scrollHeight;

    setTimeout(()=>{
        typing.remove();
        addMsg(getAIResponse(text),'ai');
    },700);
}

function addMsg(text,type){
    const div = document.createElement('div');
    div.className = 'ai-msg '+type;
    div.textContent = text;
    aiBody.appendChild(div);
    aiBody.scrollTop = aiBody.scrollHeight;
}

function highlightElement(selector,message){
    const el = document.querySelector(selector);
    if(!el) return;
    el.classList.add('highlight-guide');

    const tooltip = document.createElement('div');
    tooltip.textContent = message;
    tooltip.style.position = 'absolute';
    tooltip.style.background = '#ffcc00';
    tooltip.style.color = '#000';
    tooltip.style.padding = '4px 8px';
    tooltip.style.borderRadius = '6px';
    tooltip.style.top = '-30px';
    tooltip.style.left = '0';
    el.style.position='relative';
    el.appendChild(tooltip);

    setTimeout(()=>{
        el.classList.remove('highlight-guide');
        tooltip.remove();
    },5000);
}

function getAIResponse(q){
    q = q.toLowerCase();

    if(/halo|hai|hi|helo/.test(q)) return "👋 Halo! Aku siap bantu. Mau tanya apa?";
    if(q.includes('akun demo') || q.includes('demo')) return `🧪 Akun Demo:
Admin → admin@gmail.com | PW 123
Karyawan → alex@gmail.com | 123`;
    if(q.includes('login') || q.includes('masuk')){
        highlightElement('#loginBtn','Klik Login setelah isi data');
        return "✉️ Isi email & password lalu klik Login ya.";
    }
    if(q.includes('lupa') || q.includes('password')) return "🔐 Jika lupa password, hubungi Admin atau gunakan akun demo.";
    if(q.includes('fitur')) return `✨ Fitur Sistem:
• Login role Admin & Karyawan
• Kelola Barang & Kategori
• Peminjaman & Pengembalian
• Validasi Admin`;
    if(q.includes('admin')) return `🧑‍💼 Alur Admin:
1️⃣ Buat kategori
2️⃣ Tambah barang
3️⃣ Buat akun karyawan
4️⃣ Validasi peminjaman`;
    if(q.includes('karyawan')) return `👷 Alur Karyawan:
1️⃣ Lihat barang
2️⃣ Ajukan pinjam
3️⃣ Tunggu validasi
4️⃣ Kembalikan barang`;
    if(q.includes('bingung') || q.includes('tidak bisa')) return "😅 Tenang! Coba tanya: akun demo, login, fitur, admin, atau karyawan.";
    return "🤔 Aku belum paham. Coba ketik: *akun demo*, *fitur*, atau *login*.";
}

aiButton.onclick = ()=>{
    toggleAI();
    if(aiBody.children.length < 2){
        setTimeout(()=>{ addMsg("💡 Tips: Gunakan *akun demo* untuk mencoba sistem.","ai"); },800);
    }
};

// ===== CLOCK =====
function updateClock(){
    const now = new Date();
    document.getElementById('clock').textContent =
        now.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
}
setInterval(updateClock,1000);
updateClock();

// ===== SERVER STATUS =====
const serverOnline = true; // ganti false kalau mau test offline
const dot = document.querySelector('.dot');
const serverText = document.getElementById('serverText');

if(!serverOnline){
    dot.classList.remove('online');
    dot.classList.add('offline');
    serverText.textContent = 'Server Offline';
}

</script>

<?php require __DIR__.'/../layout/footer.php'; ?>
