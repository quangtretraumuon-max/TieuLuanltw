<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1 && $_SESSION['admin_id'] != getInput('id')) {
    $_SESSION['error'] = "Bạn không có quyền thay đổi thông tin này!";
    redirectAdmin("user");
}

$id = intval(getInput('id'));

$Edituser = $db->fetchID("users", $id);
if (empty($Edituser)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    redirectAdmin("user");
}

$data =
    [
        "name" => postInput('name'),
        "address" => postInput("address"),
        "phone" => postInput('phone'),
    ];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = [];
    if (postInput('name') == '') {
        $error['name'] = "Mời nhập đầy đủ họ tên";
    }
    if (postInput('address') == '') {
        $error['address'] = "Mời địa chỉ";
    }
    if (postInput('phone') == '') {
        $error['phone'] = "Mời nhập số điện thoại";
    }

    //dang nhap thanh cong

    if (empty($error)) {
        $id_update = $db->update("users", $data, array("id" => $id));
        if ($id_update > 0) {
            $_SESSION['success'] = "Cập nhật thành công!";
            redirectAdmin("user");
        } else {
            $_SESSION['error'] = "Dữ liệu không đổi!";
            redirectAdmin("user");
        }
    }
}

?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Thành viên: <?= $Edituser['name'] ?></h5>
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['error'];
                                unset($_SESSION['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?php echo $Edituser['name'] ?>">
                                <?php if (isset($error['name'])) : ?>
                                    <div id="name" class="form-text"><?php echo $error['name']; ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= $Edituser['address'] ?>">
                                <?php if (isset($error['address'])) : ?>
                                    <div id="address" class="form-text"><?= $error['address']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Điện thoại</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="<?= $Edituser['phone'] ?>">
                                <?php if (isset($error['phone'])) : ?>
                                    <div id="phone" class="form-text"><?= $error['phone']; ?> </div>
                                <?php endif ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="edit2.php?id=<?php echo $Edituser['id'] ?>" class="btn btn-info" ?>
                                Đổi mật khẩu
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
