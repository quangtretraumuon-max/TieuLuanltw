<?php require_once __DIR__ . '/../../autoload/autoload.php';
if (isset($_GET['page'])) {
    $p = $_GET['page'];
    if ($p == 0) $p = 1;
} else {
    $p = 1;
}

$sql = "SELECT transaction.*, users.name as nameuser, users.phone as phoneuser,users.address as addressuser FROM transaction LEFT JOIN users ON users.id = transaction.users_id ORDER BY ID DESC ";
$sql1 = "SELECT transaction.*, product.name as nameproduct,product.price as priceproduct FROM transaction LEFT JOIN product ON product.id = transaction.product_id ORDER BY ID DESC ";
$transaction = $db->fetchJone("transaction", $sql, $p, 10, true);

if (isset($transaction['page'])) {
    $sotrang = $transaction['page'];
    unset($transaction['page']);
}
if ($sotrang < $p) $p = $sotrang;

?>
<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex mb-3 justify-content-between align-items-center">
                        <h5 class="card-title fw-semibold">Danh sách đơn hàng</h5>
                    </div>
                    <div class="table-responsive">
                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $_SESSION['success'];
                                unset($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thông tin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0"></h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="accordion-item">
                                <?php foreach ($transaction as $item) : ?>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0"><?= $item['id'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"><?= $item['nameuser'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <ul>
                                                <li>
                                                    <h6 class="mb-0">Điện thoại: <span class="ml-2"><?= $item['phoneuser'] ?></span></h6>
                                                </li>
                                                <li>
                                                    <h6 class="mb-0">Địa chỉ: <span class="ml-2"><?= $item['addressuser'] ?></span></h6>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="border-bottom-0">
                                            <?php if ($item['status'] == 0) : ?>
                                                <span class="badge bg-warning rounded-3 fw-semibold">Chưa xử lý</span>
                                            <?php elseif ($item['status'] == 1) : ?>
                                                <span class="badge bg-success rounded-3 fw-semibold">Đã xử lý</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger rounded-3 fw-semibold">Đã hủy</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="border-bottom-0">
                                            <a class="btn btn-outline-primary m-1" href="order.php?id=<?= $item['id'] ?>"><i class="fa fa-edit me-2"></i>Chi tiết đơn hàng</a>
                                            <a class="btn btn-outline-danger m-1" href="delete.php?id=<?= $item['id'] ?>"><i class="fa fa-times me-2"></i>Xóa</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= --$p ?>" aria-label="<<">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $sotrang; $i++) : ?>
                                    <?php
                                    if (isset($_GET['page'])) {
                                        $p = $_GET['page'];
                                        if ($p == 0) $p = 1;
                                    } else {
                                        $p = 1;
                                    }
                                    if ($sotrang < $p) $p = $sotrang;

                                    ?>
                                    <li class="page-item <?= ($i == $p) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page= <?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= ++$p ?>" aria-label=">>">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
