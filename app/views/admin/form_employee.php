<?php require __DIR__.'/../layout/header.php'; ?>

<style>
/* ====== EMPLOYEE FORM (LIGHT / DARK MODE) ====== */

.page-wrapper {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 60px;
}

/* Title */
.page-title {
    text-align: center;
    color: var(--bs-success);
    font-weight: 600;
    margin-bottom: 30px;
}

/* Form card */
.employee-form {
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
    padding: 30px 25px;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
    animation: fadeIn 0.7s ease-out;
    border: 1px solid var(--bs-border-color);
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Label */
.form-label {
    font-weight: 600;
    color: var(--bs-body-color);
}

/* Input & Select */
.form-control,
.form-select {
    border-radius: 8px;
    padding: 10px 12px;
    border: 1.5px solid #000; /* BORDER HITAM SESUAI REQUEST SEBELUMNYA */
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
    transition: all 0.3s ease;
}

/* Placeholder */
.form-control::placeholder {
    color: var(--bs-secondary-color);
}

/* Focus */
.form-control:focus,
.form-select:focus {
    border-color: #000;
    box-shadow: none;
    background-color: var(--bs-body-bg);
    color: var(--bs-body-color);
    outline: none;
}

/* Button */
.btn-success {
    width: 100%;
    border-radius: 8px;
    padding: 10px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    color: white;
    background: linear-gradient(90deg, #43cea2, #2ecc71);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    background: linear-gradient(90deg, #2ecc71, #43cea2);
}

/* Spacing */
.mb-3 {
    margin-bottom: 20px !important;
}

/* Cursor */
select.form-select {
    cursor: pointer;
}
</style>

<div class="page-wrapper">
    <div>
        <h3 class="page-title">
            <?= isset($emp) ? 'Edit' : 'Tambah' ?> Karyawan
        </h3>

        <form class="employee-form" method="post" action="?url=admin/employeeSave">
            <?php if (isset($emp)): ?>
                <input type="hidden" name="id" value="<?= $emp['id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input
                    class="form-control"
                    name="name"
                    value="<?= isset($emp) ? htmlspecialchars($emp['name']) : '' ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    class="form-control"
                    name="email"
                    value="<?= isset($emp) ? htmlspecialchars($emp['email']) : '' ?>"
                    required
                >
            </div>

            <?php if (!isset($emp)): ?>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input
                        class="form-control"
                        name="password"
                        type="password"
                        required
                    >
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="karyawan">Karyawan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>

<?php require __DIR__.'/../layout/footer.php'; ?>
