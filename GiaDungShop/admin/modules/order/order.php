<?php require_once __DIR__ . '/../../autoload/autoload.php';

$id = intval(getInput('id'));
$trans = $db->fetchId("transaction", $id);
$sql = "SELECT users.*,transaction.created_at as date, transaction.payment_method as payment FROM users LEFT JOIN transaction ON transaction.users_id = users.id WHERE transaction.id = $id LIMIT 1";
$sql1 = "SELECT * FROM orders LEFT JOIN product ON orders.product_id = product.id WHERE orders.transaction_id = $id";
$user = $db->fetchsql($sql);
$transaction = $db->fetchsql($sql1);
?>

<?php require_once __DIR__ . "/../../layouts/header.php"; ?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex mb-3 justify-content-between align-items-center">
            <h5 class="card-title fw-semibold">Chi tiết đơn hàng</h5>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Họ tên</th>
                  <th scope="col">Số điện thoại</th>
                  <th scope="col">Địa chỉ</th>
                  <th scope="col">Ngày đặt</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th><?= $user[0]['name'] ?></th>
                  <td><?= $user[0]['phone'] ?></td>
                  <td><?= $user[0]['address'] ?></td>
                  <td><?= $user[0]['date'] ?></td>
                </tr>
              </tbody>
            </table>
            <table class="table table-bordered mt-3">
              <thead>
                <tr>
                  <th scope="col">Tên</th>
                  <th scope="col">Đơn giá</th>
                  <th scope="col">Size</th>
                  <th scope="col">Màu sắc</th>
                  <th scope="col">Số lượng</th>
                  <th scope="col">Thành tiền</th>
                  <th scope="col">Thanh toán</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($transaction as $order) : ?>
                  <tr>
                    <th><?= $order['name'] ?></th>
                    <th><?= formatPrice($order['price']) ?>đ</th>
                    <th><?= $order['size'] ?></th>
                    <th><?= $order['color'] ?></th>
                    <th><?= $order['qty'] ?></th>
                    <th><?= formatPrice($order['qty'] * $order['price']) ?>đ</th>
                    <th>
                      <?php if ($user[0]['payment'] == 1) : ?>
                        Thanh toán khi nhận hàng
                      <?php elseif ($user[0]['payment'] == 2) : ?>
                        Thanh toán Momo
                      <?php endif ?>
                    </th>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
            <a target="_blank" class="btn btn-xs btn-success me-3" href="hoadon.php?id=<?= $id ?>"> <i class="fa fa-print me-2"></i>In đơn</a>
            <?php if ($trans['status'] == 0) : ?>
              <a href="status.php?id=<?= $id ?>" class="me-2 btn btn-xs <?= $trans['status'] == 0 ? 'btn-danger' : 'btn-info' ?>"><?= $trans['status'] == 0 ? 'Đang chờ duyệt ...' : 'Đã duyệt' ?></a>
              <a href="cancel.php?id=<?= $id ?>" class="me-2 btn btn-xs btn-danger">Hủy đơn</a>
            <?php endif ?>
            <a class="btn btn-xs btn-dark " href="index.php"> <i class="fa fa-sign-out me-2"></i>Trở lại</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . "/../../layouts/footer.php"; ?>
