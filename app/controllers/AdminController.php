<?php

require_once __DIR__.'/../models/Category.php';
require_once __DIR__.'/../models/Item.php';
require_once __DIR__.'/../models/Employee.php';
require_once __DIR__.'/../models/Loan.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class AdminController {
    protected $categoryModel, $itemModel, $employeeModel, $loanModel;

    public function __construct() {
        $this->categoryModel = new Category();
        $this->itemModel = new Item();
        $this->employeeModel = new Employee();
        $this->loanModel = new Loan();

        if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location:?url=login');
            exit;
        }
    }

    public function dashboard() {
        require __DIR__.'/../views/admin/dashboard.php';
    }

    public function categories() {
        $categories = $this->categoryModel->all();
           $categoryModel = new Category();

    // pagination
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    $offset = ($page - 1) * $limit;

    // data
    $totalCategories = $categoryModel->countAll();
    $totalPages = ceil($totalCategories / $limit);
    $categories = $categoryModel->getPaginated($limit, $offset);

    require __DIR__ . '/../views/admin/categories.php';
        
    }

    public function categoryForm() {
        $id = $_GET['id'] ?? null;
        $cat = $id ? $this->categoryModel->find($id) : null;
        require __DIR__.'/../views/admin/form_category.php';
    }

    public function categorySave() {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? '';
        if($id) $this->categoryModel->update($id, $name);
        else $this->categoryModel->create($name);
        header('Location:?url=admin/categories');
    }

    public function categoryDelete() {
        $id = $_GET['id'];
        $this->categoryModel->delete($id);
        header('Location:?url=admin/categories');
    }

   public function items()
{
    $itemModel = new Item();

    // filter kondisi
    $condition = $_GET['condition'] ?? null;

    // pagination
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    $offset = ($page - 1) * $limit;

    // total data
    $totalItems = $itemModel->countAll($condition);
    $totalPages = ceil($totalItems / $limit);

    // data paginated
    $items = $itemModel->getPaginated($limit, $offset, $condition);

    require __DIR__ . '/../views/admin/items.php';
}


    public function itemForm() {
        $id = $_GET['id'] ?? null;
        $item = $id ? $this->itemModel->find($id) : null;
        $categories = $this->categoryModel->all();
        require __DIR__.'/../views/admin/form_item.php';
    }

    // ======= BAGIAN UTAMA ITEM SAVE =======
    public function itemSave() {
        $id = $_POST['id'] ?? null;

        // Ambil data dari form, termasuk condition
        $data = [
            'category_id' => $_POST['category_id'],
            'name' => $_POST['name'],
            'quantity' => intval($_POST['quantity']),
            'condition' => $_POST['condition'],  // <<< PENTING: tambahkan ini
            'description' => $_POST['description']
        ];

        if ($id) {
            $this->itemModel->update($id, $data);
        } else {
            $this->itemModel->create($data);
        }

        header('Location:?url=admin/items');
        exit;
    }

    public function itemDelete() {
        $id = $_GET['id'];
        $this->itemModel->delete($id);
        header('Location:?url=admin/items');
    }

   public function employees()
{
    $employeeModel = new Employee();

    // pagination
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);
    $offset = ($page - 1) * $limit;

    // data
    $totalEmployees = $employeeModel->countAll();
    $totalPages = ceil($totalEmployees / $limit);
    $emps = $employeeModel->getPaginated($limit, $offset);

    require __DIR__ . '/../views/admin/employees.php';
}

    public function employeeForm() {
        $id = $_GET['id'] ?? null;
        $emp = $id ? $this->employeeModel->find($id) : null;
        require __DIR__.'/../views/admin/form_employee.php';
    }

    public function employeeSave() {
        $id = $_POST['id'] ?? null;
        if($id) {
            $this->employeeModel->update($id, [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'role' => $_POST['role']
            ]);
        } else {
            $this->employeeModel->create([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'role' => $_POST['role']
            ]);
        }
        header('Location:?url=admin/employees');
    }

    public function employeeDelete() {
        $id = $_GET['id'];
        $this->employeeModel->delete($id);
        header('Location:?url=admin/employees');
    }

   public function loans()
{
    // model
    $loanModel = new loan();

    // jumlah data per halaman
    $limit = 10;

    // halaman saat ini
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max($page, 1);

    // offset
    $offset = ($page - 1) * $limit;

    // total data
    $totalLoans = $loanModel->countAll();
    $totalPages = ceil($totalLoans / $limit);

    // data sesuai halaman
    $loans = $loanModel->getPaginated($limit, $offset);

    // kirim ke view
    require __DIR__ . '/../views/admin/loans.php';
}

    public function validateLoan() {
        $id = $_POST['id'];
        $action = $_POST['action'];
        $loan = $this->loanModel->find($id);

        if(!$loan) {
            header('Location:?url=admin/loans');
            exit;
        }

        if($action === 'approve') {
            $item = $this->itemModel->find($loan['item_id']);
            if($item['quantity'] >= $loan['quantity']) {
                $this->loanModel->updateStatus($id,'approved');
                $this->itemModel->decreaseQuantity($loan['item_id'], $loan['quantity']);
            } else {
                $this->loanModel->updateStatus($id,'rejected');
            }
        } else {
            $this->loanModel->updateStatus($id,'rejected');
        }

        header('Location:?url=admin/loans');
    }

    public function loanDelete() {
        $id = $_GET['id'];
        $this->loanModel->delete($id);
        header('Location:?url=admin/loans');
    }

 public function recapLoans() {
    $loan = new Loan();

    // Ambil filter tanggal dari GET jika ada
    $start = $_GET['start'] ?? null;
    $end   = $_GET['end'] ?? null;

    // Ambil data recap
    $recap = $loan->getRecap($start, $end);

    // Load view
    require __DIR__ . '/../views/admin/recaploans.php';
    
}


    public function updateCondition() {
        $item = new Item();
        $item->updateCondition($_POST['id'], $_POST['kondisi']);
        header('Location:?url=admin/items');
        exit;
    }

public function loansPdf()
{
    // ambil data peminjaman (samakan dengan model kamu)
    $loans = $this->loanModel->getAll();

    // konfigurasi dompdf
    $options = new Options();
    $options->set('defaultFont', 'Helvetica');
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    // load view khusus pdf
    ob_start();
    require __DIR__ . '/../views/admin/loans_pdf.php';
    $html = ob_get_clean();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape'); // atau 'portrait'
    $dompdf->render();

    $dompdf->stream(
        "laporan_peminjaman.pdf",
        ["Attachment" => false] // false = buka di browser
    );
}




}
