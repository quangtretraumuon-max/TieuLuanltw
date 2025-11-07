<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if ($_SESSION['admin_lv'] == 1) {
  $_SESSION['error'] = "Bạn không có quyền thay đổi thông tin này!";
  redirectAdmin("product");
}

$category = $db->fetchsql("SELECT * FROM category WHERE level = 0");

$id = intval(getInput('id'));

$EditProduct = $db->fetchID("product", $id);
if (empty($EditProduct)) {
  $_SESSION['error'] = "Dữ liệu không tồn tại";
  redirectAdmin("product");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

  if (empty($error)) {
    $file_name = $_FILES['thundar']['name'];
    $file_tmp = $_FILES['thundar']['tmp_name'];
    $file_type = $_FILES['thundar']['type'];
    $file_error = $_FILES['thundar']['error'];

    if ($file_error == 0) {
      $part = ROOT . "/product/";
      $data['thundar'] = $file_name;
    }
    $isset = $db->fetchOne("product", "name = '" . $data['name'] . "' ");
    $id_update = $db->update("product", $data, array("id" => $id));
    if ($id_update > 0 || $id_update2 > 0) {
      move_uploaded_file($file_tmp, $part . $file_name);
      $_SESSION['success'] = "Cập nhật thành công!";
      redirectAdmin("product");
    } else {
      $_SESSION['error'] = "Dữ liệu không đổi!";
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
        <h5 class="card-title fw-semibold mb-4">Sản phẩm: <?= $EditProduct['name'] ?></h5>
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
                <label for="disabledSelect" class="form-label">Disabled select menu</label>
                <select id="disabledSelect" class="form-select" aria-describedby="category" name="category_id">
                  <option value="">-Chọn danh mục sản phẩm-</option>
                  <?php foreach ($category as $item) : ?>
                    <option value="<?php echo $item['id'] ?>" <?php echo $EditProduct['category_id'] == $item['id'] ? "selected = 'selected'" : "" ?>><?php echo $item['name'] ?></potion>
                    <?php endforeach ?>
                </select>
                <?php if (isset($error['category_id'])) : ?>
                  <p class="text-danger"> </p>
                  <div id="category" class="form-text"><?= $error['category_id']; ?> </div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?php echo $EditProduct['name'] ?>">
                <?php if (isset($error['name'])) : ?>
                  <div id="name" class="form-text"><?php echo $error['name']; ?></div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" value="<?= $EditProduct['price'] ?>">
                <?php if (isset($error['price'])) : ?>
                  <div id="price" class="form-text"><?= $error['price']; ?> </div>
                <?php endif ?>
              </div>
              <div class="row">
                <div class="mb-3 col-lg-6">
                  <label for="number" class="form-label">Số lượng</label>
                  <input type="number" class="form-control" id="number" name="number" value="<?= $EditProduct['number'] ?>">
                  <?php if (isset($error['number'])) : ?>
                    <div id="number" class="form-text"><?= $error['number']; ?> </div>
                  <?php endif ?>
                </div>
                <div class="mb-3 col-lg-6">
                  <label for="sale" class="form-label">Giảm giá</label>
                  <input type="number" class="form-control" id="sale" name="sale" value="<?= $EditProduct['sale'] ?>">
                </div>
              </div>
              <div class="mb-3">
                <label for="thundar" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="thundar" name="thundar" value="<?= $EditProduct['thundar'] ?>">
                <img src="<?= uploads(); ?>product/<?= $EditProduct['thundar'] ?>" width="3.125rem" height="3.125rem">
                <?php if (isset($error['thundar'])) : ?>
                  <div id="thundar" class="form-text"><?= $error['thundar']; ?> </div>
                <?php endif ?>
              </div>
              <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea class="form-control" id="content" name="content" value="" rows='20'><?= $EditProduct['content'] ?></textarea>
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
