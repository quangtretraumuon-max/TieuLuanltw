<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1 && $_SESSION['admin_id'] != getInput('id')) {
    $_SESSION['error'] = "Bạn không có quyền thay đổi thông tin này!";
    redirectAdmin("admin");
}

$id = intval(getInput('id'));

$Editadmin = $db->fetchID("admin", $id);
if (empty($Editadmin)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    redirectAdmin("admin");
}

$data =
    [
        "name" => postInput('name'),
        "address" => postInput("address"),
        "phone" => postInput('phone'),
        "password" => postInput('password'),
        "level" => postInput('level')
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

    if (postInput('password') == '') {
        $error['password'] = "Mời nhập mật khẩu";
    }


    //dang nhap thanh cong

    if (empty($error)) {

        $isset = $db->fetchOne("admin", "email = '" . $Editadmin['email'] . "' AND password = '" . MD5(postInput('re_password')) . "' ");
        if ($isset > 0) {
            if ($data['password'] != MD5(postInput('re_password'))) {
                $data['password'] = MD5(postInput('password'));
            }
            $id_update = $db->update("admin", $data, array("id" => $id));
            if ($id_update > 0) {
                $_SESSION['success'] = "Cập nhật thành công!";
                redirectAdmin("admin");
            } else {
                $_SESSION['error'] = "Dữ liệu không đổi!";
                redirectAdmin("admin");
            }
        } else {
            $error['re_password'] = "Sai mật khẩu";
        }
    }
}

?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Quản trị viên: <?= $Editadmin['name'] ?></h5>
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
                                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?php echo $Editadmin['name'] ?>">
                                <?php if (isset($error['name'])) : ?>
                                    <div id="name" class="form-text"><?php echo $error['name']; ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= $Editadmin['address'] ?>">
                                <?php if (isset($error['address'])) : ?>
                                    <div id="address" class="form-text"><?= $error['address']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Điện thoại</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="<?= $Editadmin['phone'] ?>">
                                <?php if (isset($error['phone'])) : ?>
                                    <div id="phone" class="form-text"><?= $error['phone']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?= $Editadmin['password'] ?>">
                                <?php if (isset($error['password'])) : ?>
                                    <div id="password" class="form-text"><?= $error['password']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="re_password" class="form-label">Mật khẩu cũ</label>
                                <input type="password" class="form-control" id="re_password" name="re_password">
                                <?php if (isset($error['re_password'])) : ?>
                                    <div id="re_password" class="form-text"><?= $error['re_password']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="disabledSelect" class="form-label">Level</label>
                                <select id="disabledSelect" class="form-select" aria-describedby="category" name="level">
                                    <option value="1" <?php echo isset($data['level']) && $Editadmin['level'] == 1 ? "selected = 'selected'" : "" ?>>CTV</option>
                                    <?php if ($_SESSION['admin_lv'] == 2) : ?>
                                        <option value="2" <?php echo isset($data['level']) && $Editadmin['level'] == 2 ? "selected = 'selected'" : "" ?>>Admin</option>
                                    <?php endif ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
