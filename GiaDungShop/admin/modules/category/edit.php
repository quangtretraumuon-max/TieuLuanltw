<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1) {
    $_SESSION['error'] = "Bạn không có quyền thay đổi thông tin này!";
    redirectAdmin("category");
}

$id = intval(getInput('id'));

$EditCategory = $db->fetchID("category", $id);
if (empty($EditCategory)) {
    $_SESSION['error'] = "Dữ liệu không tồn tại";
    redirectAdmin("category");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data =
        [
            "name" => postInput('name'),
            "slug" => to_slug(postInput("name"))
        ];

    $error = [];
    if (postInput('name') == '') {
        $error['name'] = "Mời nhập đầy đủ họ và tên";
    }

    if (!isset($_FILES['images'])) {
        $error['images'] = "Mời nhập hình ảnh";
    }

    if (empty($error)) {

        $file_name = $_FILES['images']['name'];
        $file_tmp = $_FILES['images']['tmp_name'];
        $file_type = $_FILES['images']['type'];
        $file_error = $_FILES['images']['error'];

        if ($file_error == 0) {
            $part = ROOT . "/category/";
            $data['images'] = $file_name;
        }

        $isset = $db->fetchOne("category", "name = '" . $data['name'] . "' ");
        if (is_null($isset)) {
            $id_update = $db->update("category", $data, array("id" => $id));
            if ($id_update > 0) {
                move_uploaded_file($file_tmp, $part . $file_name);
                $_SESSION['success'] = "Cập nhật thành công!";
                redirectAdmin("category");
            } else {
                $_SESSION['error'] = "Dữ liệu không thay đổi!";
                redirectAdmin("category");
            }
        }
        if (!is_null($isset)) {
            if (count($isset) > 0) {
                $_SESSION['error'] = "Tên danh mục đã tồn tại!";
            }
        }
    }
}

?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Danh mục: <?= $EditCategory['name'] ?></h5>
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
                                <label for="name" class="form-label">Tên danh mục</label>
                                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?php echo $EditCategory['name'] ?>">
                                <?php if (isset($error['name'])) : ?>
                                    <div id="name" class="form-text"><?php echo $error['name']; ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="images" name="images" value="<?= $EditCategory['images'] ?>">
                                <img src="<?= uploads(); ?>product/<?= $EditCategory['images'] ?>" width="3.125rem" height="3.125rem">
                                <?php if (isset($error['images'])) : ?>
                                    <div id="images" class="form-text"><?= $error['images']; ?> </div>
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
