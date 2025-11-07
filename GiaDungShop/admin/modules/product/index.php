<?php
require_once __DIR__ . '/../../autoload/autoload.php';

if (isset($_GET['page'])) {
  $p = $_GET['page'];
  if ($p == 0) $p = 1;
} else {
  $p = 1;
}

$sql = "SELECT product.*,category.name as namecate, product_images.image as images FROM product LEFT JOIN category on category.id = product.category_id LEFT JOIN product_images on product_images.product_id = product.id GROUP BY product.id";
$total = count($db->fetchsql($sql));

$product = $db->fetchJones('product', $sql, $total, $p, 9, true);
if (isset($product['page'])) {
  $sotrang = $product['page'];
  unset($product['page']);
}
if ($sotrang < $p) $p = $sotrang;

$name = getInput('keywork');
if (getInput('keywork') != '') {
  $name = to_slug($name);
  $item = $db->fetchOne('product', "slug LIKE '%" . $name . "%' ");
  if (isset($item) && count($item) > 0) {
    $cate = $db->fetchOne('category', "id ='" . $item['category_id'] . "'");
    if ($cate['level'] == 0) {
      header("location:index.php?the=" . $name);
    }
  } else {
    $_SESSION['error_s'] = "Không tìm thấy sản phẩm!";
  }
}
?>
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<!--  Header End -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex mb-3 justify-content-between align-items-center">
            <h5 class="card-title fw-semibold">Sản phẩm</h5>
            <a href="add.php" class="btn btn-outline-primary m-1">Thêm mới</a>
          </div>
          <div class="table-responsive">
            <?php if (isset($_SESSION['success'])) : ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error'];
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
                    <h6 class="fw-semibold mb-0">Ảnh</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Thông tin</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Trạng thái</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0"></h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($product as $item) : ?>
                  <tr>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-0"><?= $item['id'] ?></h6>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-1"><?php echo $item['name'] ?></h6>
                      <span class="fw-normal"><?php echo $item['namecate'] ?></span>
                    </td>
                    <td class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 fs-4"><img src="<?php echo uploads() ?>product/<?php echo $item['images'] ?>" width="100px" height="120px"></h6>
                    </td>
                    <td class="border-bottom-0">
                      <ul>
                        <li>
                          <p class="mb-0">Giá: <span class="ml-2"><?php echo number_format($item['price']) ?>đ</span></p>
                        </li>
                        <li>
                          <p class="mb-0">Số lượng:<span class="ml-2"><?php echo number_format($item['number']) ?></span></p>
                        </li>
                      </ul>
                    </td>
                    <td class="border-bottom-0">
                      <a href="status.php?id=<?= $item['id'] ?>" class="me-2 btn btn-xs <?= $item['status'] == 0 ? 'btn-danger' : 'btn-info' ?>"><?= $item['status'] == 0 ? 'Đang ẩn' : 'Đang hiện' ?></a>
                    </td>
                    <td class="border-bottom-0">
                      <a class="btn btn-outline-primary m-1" href="edit.php?id=<?php echo $item['id'] ?>"><i class="fa fa-edit me-1"></i>Sửa</a>
                      <a class="btn btn-outline-danger m-1" href="delete.php?id=<?php echo $item['id'] ?>"><i class="fa fa-times me-1"></i>Xóa</a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
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
