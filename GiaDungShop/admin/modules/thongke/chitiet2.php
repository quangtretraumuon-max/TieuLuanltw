<?php
require_once __DIR__ . '/../../autoload/autoload.php';

$sql = "SELECT transaction.amount, transaction.name as nameuser, transaction.updated_at as time,
product.name as nameproduct, product.price as priceproduct, orders.*
 FROM orders JOIN transaction on transaction.id = orders.transaction_id
 JOIN product on orders.product_id = product.id";

$order = $db->fetchsql($sql);

$sql2 = "SELECT SUM(`amount`) FROM transaction";
$dem2 = $db->total($sql2);

if (isset($_GET['page'])) {
    $p = $_GET['page'];
} else {
    $p = 1;
}
$sql = "SELECT transaction.* FROM transaction ORDER BY ID DESC ";

$admin = $db->fetchJone("transaction", $sql, $p, 5, true);

if (isset($admin['page'])) {
    $sotrang = $admin['page'];
    unset($admin['page']);
}

?>

<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex mb-3 justify-content-between align-items-center">
                        <h5 class="card-title fw-semibold">Thống kê</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Stt</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên sản phẩm</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thông tin</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = 1;
                                foreach ($order as $item) : ?>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0"><?= $stt ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4"><?= $item['nameproduct'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <ul>
                                                <li>Giá: <?= formatPrice($item['priceproduct'] * $item['qty']) ?> đ</li>
                                                <li>Số lượng đã bán: <?= $item['qty'] ?></li>
                                                <li>Ngày đặt: <?= $item['time'] ?></li>
                                                <li>Người nhận: <?= $item['nameuser'] ?></li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php $stt++;
                                endforeach ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: center; width: 100%">Tổng số tiền thu được: <span style="color: red"><?= formatPrice($dem2['SUM(`amount`)']) ?> đ</span></th>
                                </tr>

                            </tfoot>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo --$p ?>" aria-label="<<">
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
                                    <li class="page-item <?php echo ($i == $p) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page= <?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ++$p ?>" aria-label=">>">
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
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
