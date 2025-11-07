<?php
require_once __DIR__ . '/../../autoload/autoload.php';

$id = intval(getInput('id'));

$data =
    [
        "password" => postInput('password'),
    ];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = [];
    if (postInput('password') == '') {
        $error['password'] = "Mật khẩu không được để trống";
    } else {
        $data['password'] = MD5(postInput('password'));
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
                <h5 class="card-title fw-semibold mb-4">Thay đổi mật khẩu</h5>
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
                                <label for="password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <?php if (isset($error['password'])) : ?>
                                    <div id="password" class="form-text"><?= $error['password']; ?> </div>
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
