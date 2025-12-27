<?php require __DIR__.'/../layout/header.php'; ?>

<h3>Status Peminjaman</h3>

<?php 
if(isset($_SESSION['success'])){
    echo '<div class="alert alert-success">'.htmlspecialchars($_SESSION['success']).'</div>';
    unset($_SESSION['success']);
} 
if(isset($_SESSION['error'])){
    echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['error']).'</div>';
    unset($_SESSION['error']);
} 
?>

<!-- Tambahkan CSS -->
<style>
    h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        font-family: Arial, sans-serif;
    }

    table.table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }

    table.table th, table.table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    table.table th {
        background-color: #007bff;
        color: white;
    }



    table.table tr:hover {
        background-color: green;
    }

    .btn {
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .pagination {
    display: flex;
    justify-content: center;
    gap: 6px;
    margin-bottom: 30px;
}

.pagination a,
.pagination span {
    padding: 6px 12px;
    border-radius: 5px;
    text-decoration: none;
    border: 1px solid #ddd;
    font-size: 14px;
}

.pagination a {
    color: #007bff;
    background: #fff;
}

.pagination a:hover {
    background: #007bff;
    color: #fff;
}

.pagination .active {
    background: #007bff;
    color: #fff;
    font-weight: bold;
}

.pagination .disabled {
    color: #aaa;
    background: #f2f2f2;
}

</style>

<table class='table'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($loans as $l): ?>
        <tr>
            <td><?=$l['id']?></td>
            <td><?=htmlspecialchars($l['item_name'])?></td>
            <td><?=$l['quantity']?></td>
            <td><?=$l['status']?></td>
            <td>
                <?php if($l['status']=='approved'): ?>
                    <a class='btn btn-sm btn-primary' href='?url=karyawan/returnLoan/<?=$l['id']?>' onclick="return confirm('Kembalikan?')">Kembalikan</a>
                <?php else: ?> 
                    - 
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="pagination">
    <!-- Prev -->
    <?php if ($page > 1): ?>
        <a href="?url=karyawan/loans&page=<?= $page - 1 ?>">« Prev</a>
    <?php else: ?>
        <span class="disabled">« Prev</span>
    <?php endif; ?>

    <!-- Numbers -->
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php if ($i == $page): ?>
            <span class="active"><?= $i ?></span>
        <?php else: ?>
            <a href="?url=karyawan/loans&page=<?= $i ?>"><?= $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- Next -->
    <?php if ($page < $totalPages): ?>
        <a href="?url=karyawan/loans&page=<?= $page + 1 ?>">Next »</a>
    <?php else: ?>
        <span class="disabled">Next »</span>
    <?php endif; ?>
</div>


<?php require __DIR__.'/../layout/footer.php'; ?>
