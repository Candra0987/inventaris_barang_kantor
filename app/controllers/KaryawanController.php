<?php

require_once __DIR__.'/../models/Item.php';
require_once __DIR__.'/../models/Loan.php';
class KaryawanController {
    protected $itemModel,$loanModel;
    public function __construct(){ $this->itemModel=new Item(); $this->loanModel=new Loan(); if(!isset($_SESSION['user'])){ header('Location:?url=login'); exit; } }
    public function dashboard(){ require __DIR__.'/../views/karyawan/dashboard.php'; }
    public function items(){ $items=$this->itemModel->all(); require __DIR__.'/../views/karyawan/items.php'; }
   public function loanForm()
{
    $itemId = $_GET['id'] ?? null;
    if (!$itemId) {
        header('Location: ?url=karyawan/items');
        exit;
    }

    $itemModel = new Item();
    $item = $itemModel->find($itemId);

    // ❌ CEGAT BARANG RUSAK
    if (!$item || strtolower($item['condition']) === 'rusak') {
        $_SESSION['error'] = 'Barang rusak tidak dapat dipinjam.';
        header('Location: ?url=karyawan/items');
        exit;
    }

    require __DIR__ . '/../views/karyawan/loan_form.php';
}

public function requestLoan()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location:?url=karyawan/items');
        exit;
    }

    $item_id = $_POST['item_id'] ?? null;
    $qty     = $_POST['quantity'] ?? 1;
    $user_id = $_SESSION['user']['id'];

    if (!$item_id || $qty <= 0) {
        $_SESSION['error'] = 'Data peminjaman tidak valid';
        header('Location:?url=karyawan/items');
        exit;
    }

    $item = $this->itemModel->find($item_id);

    // 🔒 VALIDASI BARANG
    if (!$item) {
        $_SESSION['error'] = 'Barang tidak ditemukan';
        header('Location:?url=karyawan/items');
        exit;
    }

    if (strtolower($item['condition']) === 'rusak') {
        $_SESSION['error'] = 'Barang rusak tidak dapat dipinjam';
        header('Location:?url=karyawan/items');
        exit;
    }

    if ($item['quantity'] < $qty) {
        $_SESSION['error'] = 'Stok barang tidak mencukupi';
        header('Location:?url=karyawan/items');
        exit;
    }

    // SIMPAN PEMINJAMAN
    $this->loanModel->create(
    $user_id,   // employee_id
    $item_id,   // item_id
    $qty        // quantity
);


    // KURANGI STOK
    $this->itemModel->decreaseQuantity($item_id, $qty);

    $_SESSION['success'] = 'Peminjaman berhasil diajukan';
    header('Location:?url=karyawan/loans');
    exit;
}

   public function loans()
{
    $employee_id = $_SESSION['user']['id'];

    // pagination config
    $limit = 10;
    $page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page  = max($page, 1);
    $offset = ($page - 1) * $limit;

    // data
    $loans = $this->loanModel->byEmployeePaginated($employee_id, $limit, $offset);
    $totalLoans = $this->loanModel->countByEmployee($employee_id);
    $totalPages = ceil($totalLoans / $limit);

    require __DIR__.'/../views/karyawan/loans.php';
}


    public function returnLoan($loan_id){ $loan=$this->loanModel->find($loan_id); if(!$loan){ $_SESSION['error']='Peminjaman tidak ditemukan'; header('Location:?url=karyawan/loans'); exit; } if($loan['employee_id']!=$_SESSION['user']['id']){ $_SESSION['error']='Anda tidak berhak'; header('Location:?url=karyawan/loans'); exit; } if($loan['status']!=='approved'){ $_SESSION['error']='Hanya peminjaman disetujui yang bisa dikembalikan'; header('Location:?url=karyawan/loans'); exit; } $this->loanModel->updateStatus($loan_id,'returned'); $this->itemModel->increaseQuantity($loan['item_id'],$loan['quantity']); $_SESSION['success']='Barang dikembalikan'; header('Location:?url=karyawan/loans'); }
}
