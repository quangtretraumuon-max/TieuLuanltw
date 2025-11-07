<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1) {
    $_SESSION['error'] = "Bạn không có quyền thêm thông tin này!";
    redirectAdmin("admin");
}

$data =
    [
        "name" => postInput('name'),
        "address" => postInput("address"),
        "email" => postInput('email'),
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
    if (postInput('email') == '') {
        $error['email'] = "Mời nhập email";
    }
    if (postInput('phone') == '') {
        $error['phone'] = "Mời nhập số điện thoại";
    }

    if (postInput('password') == '') {
        $error['password'] = "Mời nhập mật khẩu";
    }

    if (postInput('password') != postInput('re_password')) {
        $error['password'] = "Mật khẩu không khớp";
    } else {
        $data['password'] = MD5(postInput('password'));
    }
    //dang nhap thanh cong

    if (empty($error)) {

        $isset = $db->fetchOne("admin", "email = '" . $data['email'] . "' ");
        $id_insert = $db->insert("admin", $data);
        if ($id_insert > 0) {
            $_SESSION['success'] = "Thêm mới thành công!";
            redirectAdmin("admin");
        } else {
            $_SESSION['error'] = "Thêm mới thất bại!";
            redirectAdmin("admin");
        }
    }
}

?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Thêm quản trị viên</h5>
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
                                <input type="text" class="form-control" id="name" aria-describedby="name" name="name">
                                <?php if (isset($error['name'])) : ?>
                                    <div id="name" class="form-text"><?php echo $error['name']; ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <?php if (isset($error['email'])) : ?>
                                    <div id="email" class="form-text"><?= $error['email']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address">
                                <?php if (isset($error['address'])) : ?>
                                    <div id="address" class="form-text"><?= $error['address']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="number" class="form-control" id="phone" name="phone">
                                <?php if (isset($error['phone'])) : ?>
                                    <div id="phone" class="form-text"><?= $error['phone']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <?php if (isset($error['password'])) : ?>
                                    <div id="password" class="form-text"><?= $error['password']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="re_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="re_password" name="re_password">
                                <?php if (isset($error['re_password'])) : ?>
                                    <div id="re_password" class="form-text"><?= $error['re_password']; ?> </div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="disabledSelect" class="form-label">Chức vụ</label>
                                <select id="disabledSelect" class="form-select" aria-describedby="level" name="level">
                                    <option value="1" <?php echo isset($data['level']) && $data['level'] == 1 ? "selected = 'selected'" : "" ?>>CTV</option>
                                    <option value="2" <?php echo isset($data['level']) && $data['level'] == 2 ? "selected = 'selected'" : "" ?>>Admin</option>
                                </select>
                                <?php if (isset($error['level'])) : ?>
                                    <p class="text-danger"> </p>
                                    <div id="level" class="form-text"><?= $error['level']; ?> </div>
                                <?php endif ?>
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
