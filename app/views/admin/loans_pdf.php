<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Laporan Peminjaman</title>

<style>
body{
  font-family: Helvetica, Arial, sans-serif;
  font-size: 11px;
  color: #000;
}

h2{
  text-align: center;
  margin-bottom: 10px;
}

hr{
  margin-bottom: 15px;
}

table{
  width: 100%;
  border-collapse: collapse;
}

th, td{
  border: 1px solid #000;
  padding: 6px 8px;
}

th{
  background: #f0f0f0;
  text-align: left;
}

.footer{
  margin-top: 20px;
  text-align: right;
  font-size: 10px;
}
</style>
</head>

<body>

<h2>LAPORAN PEMINJAMAN BARANG</h2>
<hr>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Karyawan</th>
      <th>Barang</th>
      <th>Qty</th>
      <th>Status</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($loans as $l): ?>
    <tr>
      <td><?= $l['id'] ?></td>
      <td><?= htmlspecialchars($l['employee_name']) ?></td>
      <td><?= htmlspecialchars($l['item_name']) ?></td>
      <td><?= $l['quantity'] ?></td>
      <td><?= htmlspecialchars($l['status']) ?></td>
      <td><?= htmlspecialchars($l['requested_at']) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="footer">
  Dicetak pada: <?= date('d-m-Y H:i') ?>
</div>

</body>
</html>
