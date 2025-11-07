<?php
require_once __DIR__ . "/autoload/autoload.php";
if (isset($_GET['page'])) {
    $p = $_GET['page'];
    if ($p == 0) $p = 1;
} else {
    $p = 1;
}

$sql = "SELECT transaction.*, users.name as nameuser, users.phone as phoneuser,users.address as addressuser FROM transaction LEFT JOIN users ON users.id = transaction.users_id ORDER BY ID DESC ";
$sql1 = "SELECT transaction.*, product.name as nameproduct,product.price as priceproduct FROM transaction LEFT JOIN product ON product.id = transaction.product_id ORDER BY ID DESC ";
$transaction = $db->fetchJone("transaction", $sql, $p, 5, true);

if (isset($transaction['page'])) {
    $sotrang = $transaction['page'];
    unset($transaction['page']);
}
if ($sotrang < $p) $p = $sotrang;
?>

<?php require_once __DIR__ . "/layouts/header.php"; ?>


<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid container">
            <h1 class="mt-4">Trạng thái giao hàng
            </h1>
            <div class="card mb-4">
                <div class="clearfix"></div>
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['success'];
                        unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 10%;">Stt</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 20%;">Tên</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 30%;">Điện thoại</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 20%;">Địa chỉ</th>
                            <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 20%;">Trạng thái</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1;
                        foreach ($transaction as $item) : ?>
                            <tr role="row" class="odd">
                                <td><?php echo $stt ?></td>
                                <td><?php echo $item['nameuser'] ?></td>
                                <td><?php echo $item['phoneuser'] ?></td>
                                <td><?php echo $item['addressuser'] ?></td>
                                <td> <a href="status.php?id=<?php echo $item['id'] ?>" class="btn btn-xs <?php echo $item['status'] == 0 ? 'btn-danger' : 'btn-info' ?>"><?php echo $item['status'] == 0 ? 'Chưa xử lý ...' : 'Đã nhận' ?></a> </td>

                            </tr>
                        <?php $stt++;
                        endforeach ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination pullright">
                        <li class="page-item"><a class="page-link" href="?page=<?php echo --$p ?>">Previous</a></li>
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
                        <li class="page-item"><a class="page-link" href="?page=<?php echo ++$p ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
            <?php require_once __DIR__ . "/layouts/footer.php"; ?>
