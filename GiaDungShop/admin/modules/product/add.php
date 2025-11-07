<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1) {
  $_SESSION['error'] = "Bạn không có quyền thêm thông tin này!";
  redirectAdmin("product");
}

$category = $db->fetchsql("SELECT * FROM category WHERE level = 0");

$data =
  [
    "name" => postInput('name'),
    "slug" => to_slug(postInput("name")),
    "category_id" => postInput('category_id'),
    "price" => postInput('price'),
    "content" => postInput('content'),
    "number" => postInput('number'),
    "sale" => postInput('sale'),
  ];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $error = [];
  if (postInput('name') == '') {
    $error['name'] = "Mời nhập đầy đủ tên";
  }
  if (postInput('category_id') == '') {
    $error['category_id'] = "Mời chọn tên danh mục";
  }
  if (postInput('price') == '') {
    $error['price'] = "Mời nhập giá sản phẩm";
  }
  if (postInput('content') == '') {
    $error['content'] = "Mời nhập nội dung sản phẩm";
  }

  if (postInput('number') == '') {
    $error['number'] = "Mời nhập số lượng sản phẩm";
  }

  if (!isset($_FILES['files'])) {
    $error['files'] = "Vui lòng chọn ít nhất 1 ảnh";
  }

  if (empty($error)) {
    $isset = $db->fetchOne("product", "name = '" . $data['name'] . "' ");
    $id_insert = $db->insert("product", $data);
    if ($id_insert > 0) {
      $upload_dir = ROOT . "/product/";
      $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
      $dataImage = [];
      if (!empty(array_filter($_FILES['files']['name']))) {
        foreach ($_FILES['files']['tmp_name'] as $key => $value) {
          $file_tmpname = $_FILES['files']['tmp_name'][$key];
          $file_name = $_FILES['files']['name'][$key];
          $file_size = $_FILES['files']['size'][$key];
          $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
          $filepath = $upload_dir . $file_name;
          $dataImage = [
            'image' => $file_name,
            'product_id' => $id_insert
          ];
          $db->insert("product_images", $dataImage);
          if (in_array(strtolower($file_ext), $allowed_types)) {
            if (move_uploaded_file($file_tmpname, $filepath)) {
              $_SESSION['success'] = "Thêm mới thành công!";
            }
          }
        }
      }
      redirectAdmin("product");
    } else {
      $_SESSION['error'] = "Thêm mới thất bại!";
      redirectAdmin("product");
    }
  }
}

?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Thêm sản phẩm</h5>
        <div class="card">
          <div class="card-body">
            <?php if (isset($_SESSION['error'])) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'];
                unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="disabledSelect" class="form-label">Danh mục</label>
                <select id="disabledSelect" class="form-select" aria-describedby="category" name="category_id">
                  <option value="">-Chọn danh mục sản phẩm-</option>
                  <?php foreach ($category as $item) : ?>
                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                  <?php endforeach ?>
                </select>
                <?php if (isset($error['category_id'])) : ?>
                  <p class="text-danger"> </p>
                  <div id="category" class="form-text"><?= $error['category_id']; ?> </div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name">
                <?php if (isset($error['name'])) : ?>
                  <div id="name" class="form-text"><?= $error['name']; ?></div>
                <?php endif ?>
              </div>
              <div class="row">
                <div class="mb-3 col-lg-4">
                  <label for="number" class="form-label">Số lượng</label>
                  <input type="number" class="form-control" id="number" name="number">
                  <?php if (isset($error['number'])) : ?>
                    <div id="number" class="form-text"><?= $error['number']; ?> </div>
                  <?php endif ?>
                </div>
                <div class="mb-3 col-lg-4">
                  <label for="price" class="form-label">Giá</label>
                  <input type="number" class="form-control" id="price" name="price">
                  <?php if (isset($error['price'])) : ?>
                    <div id="price" class="form-text"><?= $error['price']; ?> </div>
                  <?php endif ?>
                </div>
                <div class="mb-3 col-lg-4">
                  <label for="sale" class="form-label">Giảm giá</label>
                  <input type="number" class="form-control" id="sale" name="sale">
                </div>
              </div>
              <div class="mb-3">
                <label for="thundar" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="thundar" name="files[]" multiple>
                <?php if (isset($error['files'])) : ?>
                  <div id="files" class="form-text"><?= $error['files']; ?> </div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea class="form-control" id="content" name="content" rows='20'></textarea>
                <?php if (isset($error['content'])) : ?>
                  <div id="content" class="form-text"><?= $error['content']; ?> </div>
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
