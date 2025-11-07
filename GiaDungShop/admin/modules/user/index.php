<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if (isset($_GET['page'])) {
    $p = $_GET['page'];
    if ($p == 0) $p = 1;
} else {
    $p = 1;
}

$sql = "SELECT users.* FROM users";

$users = $db->fetchJone('users', $sql, $p, 10, true);

if (isset($users['page'])) {
    $sotrang = $users['page'];
    unset($users['page']);
}
if ($sotrang < $p) $p = $sotrang;
?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="d-flex mb-3 justify-content-between align-items-center">
                        <h5 class="card-title fw-semibold">Thành viên</h5>
                        <a href="add.php" class="btn btn-outline-primary m-1">Thêm mới</a>
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
                                        <h6 class="fw-semibold mb-0">Stt</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Email</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thông tin</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0"></h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $item) : ?>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0"><?= $item['id'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"><?= $item['name'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"><?= $item['email'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <ul>
                                                <li>
                                                    <p class="mb-0">Điện thoại: <span class="ml-2"> <?= $item['phone'] ?></span></p>
                                                </li>
                                                <li>
                                                    <p class="mb-0">Địa chỉ:<span class="ml-2"> <?= $item['address'] ?></span></p>
                                                </li>
                                            </ul>
                                        </td>
                                        <td class="border-bottom-0">
                                            <a class="btn btn-outline-primary m-1" href="edit.php?id=<?= $item['id'] ?>"><i class="fa fa-edit"></i>Sửa</a>
                                            <a class="btn btn-outline-danger m-1" href="delete.php?id=<?= $item['id'] ?>"><i class="fa fa-times"></i>Xóa</a>
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
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
