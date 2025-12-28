<?php require __DIR__.'/../layout/header.php'; ?>

<style>
/* ====== PAGE HEADER ====== */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 40px auto 20px;
  max-width: 1100px;
}

.page-header h3 {
  margin: 0;
  color: var(--primary);
  font-size: 1.6rem;
  font-weight: 700;
}

/* ====== TABLE WRAPPER ====== */
.table-wrapper {
  max-width: 1100px;
  margin: 0 auto 60px;
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  overflow-x: auto;
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-family: inherit;
}

thead {
  background-color: var(--primary);
  color: #fff;
}

th, td {
  padding: 14px 16px;
  text-align: left;
  border-bottom: 1px solid var(--border);
  font-size: 0.95rem;
  vertical-align: middle;
}

tr:hover {
  background-color: #0ec1afff;
}

/* ====== STATUS BADGE ====== */
.status {
  padding: 4px 10px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.85rem;
  text-transform: capitalize;
  display: inline-block;
}

.status.pending { background-color: #fff3cd; color: #856404; }
.status.approved { background-color: #d1e7dd; color: #0f5132; }
.status.rejected { background-color: #f8d7da; color: #842029; }

/* ====== BUTTONS ====== */
.btn-sm {
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 0.85rem;
  text-decoration: none;
  color: #fff;
  font-weight: 500;
  margin-right: 4px;
  display: inline-block;
  transition: background-color 0.2s ease, transform 0.1s ease;
  border: none;
  cursor: pointer;
}

.btn-success { background-color: var(--primary); }
.btn-success:hover { background-color: var(--primary-dark); transform: translateY(-1px); }

.btn-danger { background-color: #dc3545; }
.btn-danger:hover { background-color: #bb2d3b; transform: translateY(-1px); }

/* ====== RESPONSIVE ====== */
@media (max-width: 768px) {
  .page-header { flex-direction: column; align-items: flex-start; gap: 10px; margin: 20px; }
  .table-wrapper { margin: 10px 20px 40px; }
  th, td { padding: 10px 12px; font-size: 0.9rem; }
}

/* ====== PAGINATION ====== */
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
  margin: -30px auto 40px;
  max-width: 1100px;
}

.pagination a, .pagination span {
  padding: 8px 14px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: #fff;
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--primary);
  transition: all 0.2s ease;
}

.pagination a:hover {
  background-color: var(--primary);
  color: #fff;
  border-color: var(--primary);
  transform: translateY(-1px);
}

.pagination .active { background-color: var(--primary); color: #fff; border-color: var(--primary); pointer-events: none; }
.pagination .disabled { color: #aaa; background-color: #f5f5f5; pointer-events: none; }

@media (max-width: 768px) {
  .pagination { flex-wrap: wrap; gap: 4px; margin: -20px 20px 30px; }
  .pagination a, .pagination span { padding: 6px 10px; font-size: 0.85rem; }
}

/* ====== CHART ====== */
#loanChart { max-width: 700px; margin: 0 auto 40px; }
</style>

<div class="page-header">
  <h3>Peminjaman</h3>
</div>


<a href="?url=admin/loansPrint" target="_blank" class="btn-sm btn-danger" style="margin-left:215px; margin-bottom:20px;">Cetak PDF</a>

<!-- Chart.js -->
<div class="table-wrapper">
  <canvas id="loanChart"></canvas>
</div>

<?php
// Hitung jumlah status
$statuses = ['pending'=>0, 'approved'=>0, 'rejected'=>0];
foreach ($loans as $l) {
    $status = strtolower($l['status']);
    if(isset($statuses[$status])) $statuses[$status]++;
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('loanChart').getContext('2d');
const loanChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Pending', 'Approved', 'Rejected'],
        datasets: [{
            data: [
                <?= $statuses['pending'] ?>,
                <?= $statuses['approved'] ?>,
                <?= $statuses['rejected'] ?>
            ],
            backgroundColor: ['#fff3cd','#d1e7dd','#f8d7da'],
            borderColor: ['#856404','#0f5132','#842029'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: { display: true, text: 'Jumlah Peminjaman per Status' },
            legend: { position: 'bottom' }
        }
    }
});
</script>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Karyawan</th>
        <th>Barang</th>
        <th>Qty</th>
        <th>Status</th>
        <th>Waktu</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($loans as $l): ?>
        <tr>
          <td><?= $l['id'] ?></td>
          <td><?= htmlspecialchars($l['employee_name']) ?></td>
          <td><?= htmlspecialchars($l['item_name']) ?></td>
          <td><?= $l['quantity'] ?></td>
          <td><span class="status <?= strtolower($l['status']) ?>"><?= htmlspecialchars($l['status']) ?></span></td>
          <td><?= htmlspecialchars($l['requested_at']) ?></td>
          <td>
            <?php if ($l['status'] === 'pending'): ?>
              <form method="post" style="display:inline" action="?url=admin/validateLoan">
                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                <button name="action" value="approve" class="btn-sm btn-success">Approve</button>
                <button name="action" value="reject" class="btn-sm btn-danger">Reject</button>
              </form>
            <?php else: ?>
              -
            <?php endif; ?>
            <a class="btn-sm btn-danger" href="?url=admin/loanDelete&id=<?= $l['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="pagination">
  <?php if ($page > 1): ?>
    <a href="?url=admin/loans&page=<?= $page - 1 ?>">« Prev</a>
  <?php else: ?>
    <span class="disabled">« Prev</span>
  <?php endif; ?>

  <?php for ($i=1; $i<=$totalPages; $i++): ?>
    <?php if ($i==$page): ?>
      <span class="active"><?= $i ?></span>
    <?php else: ?>
      <a href="?url=admin/loans&page=<?= $i ?>"><?= $i ?></a>
    <?php endif; ?>
  <?php endfor; ?>

  <?php if ($page < $totalPages): ?>
    <a href="?url=admin/loans&page=<?= $page + 1 ?>">Next »</a>
  <?php else: ?>
    <span class="disabled">Next »</span>
  <?php endif; ?>
</div>

<?php require __DIR__.'/../layout/footer.php'; ?>
