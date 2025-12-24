<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Cetak Peminjaman</title>

<style>
body{
  font-family: Arial, sans-serif;
  font-size: 12px;
  color: #000;
}

h2{
  text-align: center;
  margin-bottom: 20px;
}

table{
  width:100%;
  border-collapse: collapse;
}

th, td{
  border:1px solid #000;
  padding:6px 8px;
  text-align:left;
}

th{
  background:#eee;
}

/* sembunyikan saat print jika perlu */
@media print{
  @page{
    size:A4;
    margin:15mm;
  }
}
</style>
</head>

<body onload="window.print()">

<h2>Laporan Peminjaman Barang</h2>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Karyawan</th>
      <th>Barang</th>
      <th>Qty</th>
      <th>Status</th>
      <th>Waktu</th>
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

</body>
</html>
