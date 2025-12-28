<?php require __DIR__.'/../layout/header.php'; ?>

<style>


.container-category {
    max-width: 640px;
    margin: 60px auto;
}

/* Card */
.category-card {
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.category-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
}

/* Header */
.category-header {
    background: linear-gradient(90deg, #198754, #20c997);
    color: #fff;
    text-align: center;
    padding: 20px 15px;
    font-size: 1.3rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Body */
.category-body {
    padding: 30px 70px;
}

/* Spacing */
.mb-3 {
    margin-bottom: 5rem;
}

/* Label */
.form-label {
    font-weight: 600;
    color: var(--bs-body-color);
    margin-bottom: 6px;
}

/* Input (BLACK BORDER) */
.form-control {
    border-radius: 10px;
    border: 1.5px solid #000; /* BORDER HITAM */
    padding: 10px 12px;
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
}

/* Placeholder */
.form-control::placeholder {
    color: var(--bs-secondary-color);
    opacity: 1;
}

/* Focus */
.form-control:focus {
    border-color: #000;   /* TETAP HITAM */
    box-shadow: none;     /* HILANGKAN RING BOOTSTRAP */
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
}

/* Button */
.btn-success {
    width: 100%;
    border-radius: 10px;
    font-weight: 600;
    padding: 10px 0;
    background: linear-gradient(90deg, #198754, #20c997);
    border: none;
    transition: all 0.25s ease;
}

.btn-success:hover {
    background: linear-gradient(90deg, #157347, #17a98b);
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(25, 135, 84, 0.25);
}

/* Responsive */
@media (max-width: 576px) {
    .category-body {
        padding: 25px;
    }
}
</style>

<div class="container-category">
    <div class="category-card">
        <div class="category-header">
            <?= isset($cat) ? 'Edit Kategori' : 'Tambah Kategori' ?>
        </div>
        <div class="category-body">
            <form method="post" action="?url=admin/categorySave">
                <?php if (isset($cat)): ?>
                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input 
                        class="form-control" 
                        name="name" 
                        value="<?= isset($cat) ? htmlspecialchars($cat['name']) : '' ?>" 
                        placeholder="Masukkan nama kategori"
                        required
                    >
                </div>

                <button class="btn btn-success">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>

<?php require __DIR__.'/../layout/footer.php'; ?>
