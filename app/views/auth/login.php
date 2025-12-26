    <?php require __DIR__.'/../layout/header.php'; ?>

    <style>
    /* ===== Login & Body ===== */
    body {
        background: linear-gradient(145deg, #4f46e5, #0ea5e9, #8b5cf6);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0; /* hilangkan margin besar */
        min-height: 100vh;
        display: flex;
        justify-content: center; /* horizontal */
        align-items: center;     /* vertical */
        animation: fadeInBody 1s ease-in;
    }

    @keyframes fadeInBody { from {opacity:0;} to {opacity:1;} }

    .login-card {
        background-color: #fff;
        padding: 40px 30px;
        margin-right: 520px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 400px;
        text-align: center;
        animation: fadeInCard 1s ease-in;
    }
    @keyframes fadeInCard { from {transform:translateY(-20px); opacity:0;} to {transform:translateY(0); opacity:1;} }

    h3 { margin-bottom:25px; color:#333; }
    .form-group { position: relative; margin-bottom: 20px; }
    .form-group input { width:100%; padding:12px 12px 12px 40px; border:1px solid #ccc; border-radius:10px; transition: border-color 0.3s, box-shadow 0.3s; }
    .form-group input:focus { border-color:#007bff; box-shadow:0 0 8px rgba(0,123,255,0.3); outline:none; }
    .form-group i { position:absolute; top:50%; left:12px; transform:translateY(-50%); color:#999; }

    .btn-login {
        width: 100%; padding: 12px; border:none; border-radius:10px;
        font-size:16px; color:#fff; background:linear-gradient(90deg, #ff7e5f, #feb47b);
        cursor:pointer; transition: background 0.4s, transform 0.2s;
    }
    .btn-login:hover { background: linear-gradient(90deg, #feb47b, #ff7e5f); transform: translateY(-2px); }

    .alert { padding:12px 15px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .alert-danger { background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

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

    /* Highlight interaktif */
    .highlight-guide{ animation: highlightAnim 1s infinite alternate; border-radius:8px; }
    @keyframes highlightAnim{
    0%{ box-shadow: 0 0 0 0 rgba(255,200,0,0.7); }
    100%{ box-shadow: 0 0 10px 6px rgba(255,200,0,0.9); }
    }
    </style>

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
    <div class="ai-input">
        <input id="aiInput" placeholder="Tanya sesuatu..." onkeydown="if(event.key==='Enter')sendAI()">
        <button onclick="sendAI()">➤</button>
    </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
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
    setTimeout(()=>addMsg(getAIResponse(text),'ai'),400);
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
    const currentPage = window.location.href;

    // ===== AKUN DEMO =====
    if(q.includes('akun demo')||q.includes('demo')) return 'Akun Demo:\n1. Admin | admin00@gmail.com / admin00\n2. Karyawan | mrx@gmail.com / mrx';

    // ===== FITUR =====
    if(q.includes('fitur')||q.includes('apa saja')) return `
    Fitur:
    1. User login berdasarkan role
    2. Admin kelola barang
    3. Admin kelola kategori
    4. Admin kelola karyawan
    5. Admin validasi peminjaman
    6. Karyawan meminjam sesuai stok
    7. Karyawan mengembalikan barang
    `;

    // ===== ALUR ADMIN =====
    if(q.includes('alur admin')||q.includes('admin')) return `
    Alur Admin:
    1. Buat kategori
    2. Masukkan barang
    3. Buat akun karyawan
    4. Lihat peminjaman
    5. Validasi peminjaman
    `;

    // ===== ALUR KARYAWAN =====
    if(q.includes('alur karyawan')||q.includes('karyawan')) return `
    Alur Karyawan:
    1. Lihat barang tersedia
    2. Pinjam barang
    3. Tunggu validasi admin
    4. Barang dapat dipinjam jika sudah divalidasi
    5. Kembalikan barang jika selesai
    6. Klik kembalikan
    `;

    // ===== LOGIN =====
    if(q.includes('login')){
        highlightElement('#loginBtn','Klik tombol Login setelah mengisi email & password');
        return 'Gunakan akun demo atau akun yang sudah terdaftar untuk login.';
    }

    // ===== HALAMAN AKTIF =====
    if(currentPage.includes('admin/items')) return 'Kamu sedang di halaman Barang. Tambah/Edit/Hapus barang di sini.';
    if(currentPage.includes('admin/categories')) return 'Kamu sedang di halaman Kategori. Tambah/Edit kategori di sini.';
    if(currentPage.includes('karyawan/loans')) return 'Kamu sedang di halaman Peminjaman. Bisa pinjam atau kembalikan barang di sini.';

    return '🤔 Maaf, saya belum paham. Coba tanya tentang "akun demo", "fitur", "alur admin", "alur karyawan" atau "login".';
    }
    </script>

    <?php require __DIR__.'/../layout/footer.php'; ?>
