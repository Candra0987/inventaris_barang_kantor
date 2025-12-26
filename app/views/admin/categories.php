<?php require __DIR__ . '/../layout/header.php'; ?>

<style>
/* ================== THEME VARIABLE ================== */
:root {
    --bg: #ffffff;
    --card: #f9f9f9;
    --text: #222;
    --border: #ddd;
    --table-head: #f2f2f2;
}

body.dark {
    --bg: #121212;
    --card: #1e1e1e;
    --text: #eaeaea;
    --border: #333;
    --table-head: #2a2a2a;
}

/* ================== PAGE ================== */
.page-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: var(--card);
    color: var(--text);
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* ================== BUTTON ================== */
.btn {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
}

.btn-success { background-color: #28a745; }
.btn-primary { background-color: #007bff; }
.btn-danger  { background-color: #dc3545; }

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

/* ================== SEARCH ================== */
.search-input {
    padding: 6px 10px;
    font-size: 14px;
    width: 250px;
    margin-bottom: 15px;
    border-radius: 4px;
    background-color: var(--bg);
    color: var(--text);
    border: 1px solid var(--border);
}

/* ================== TABLE ================== */
table.table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--bg);
    color: var(--text);
}

table.table th,
table.table td {
    padding: 8px;
    border: 1px solid var(--border);
}

table.table th {
    background-color: var(--table-head);
}

/* ================== PAGINATION ================== */
.pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin: 20px 0;
}

.pagination a,
.pagination span {
    padding: 8px 14px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background-color: var(--bg);
    color: var(--text);
    text-decoration: none;
}

.pagination .active {
    background-color: #007bff;
    color: #fff;
    border-color: #007bff;
}

.pagination .disabled {
    opacity: .5;
    pointer-events: none;
}
</style>

<div class="page-container">
    <div class="page-header">
        <h3>Kategori</h3>
        <a class="btn btn-success" href="?url=admin/categoryForm">+ Tambah Kategori</a>
    </div>

    <input type="text" id="searchInput" class="search-input" placeholder="Cari kategori...">

    <table class="table" id="categoryTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td>
                    <a class="btn btn-primary btn-sm" href="?url=admin/categoryForm&id=<?= $c['id'] ?>">Edit</a>
                    <a class="btn btn-danger btn-sm" 
                       href="?url=admin/categoryDelete&id=<?= $c['id'] ?>"
                       onclick="return confirm('Hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?url=admin/categories&page=<?= $page - 1 ?>">« Prev</a>
    <?php else: ?>
        <span class="disabled">« Prev</span>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="?url=admin/categories&page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="?url=admin/categories&page=<?= $page + 1 ?>">Next »</a>
    <?php else: ?>
        <span class="disabled">Next »</span>
    <?php endif; ?>
</div>

<script>
const searchInput = document.getElementById('searchInput');
const tbody = document.querySelector('#categoryTable tbody');

searchInput.addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    let found = false;

    [...tbody.rows].forEach(row => {
        const text = row.cells[1].textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
        if (text.includes(filter)) found = true;
    });

    let noResult = document.getElementById('noResult');
    if (!found) {
        if (!noResult) {
            const row = tbody.insertRow();
            row.id = 'noResult';
            const cell = row.insertCell();
            cell.colSpan = 3;
            cell.textContent = 'Kategori tidak ditemukan';
            cell.style.textAlign = 'center';
        }
    } else if (noResult) {
        noResult.remove();
    }
});
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
