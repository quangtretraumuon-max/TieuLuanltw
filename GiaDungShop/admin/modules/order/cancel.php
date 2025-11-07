
<?php
require_once __DIR__ . "/../../autoload/autoload.php";

$id = intval(getInput('id'));

$EditTransaction = $db->fetchID("transaction", $id);

if (empty($EditTransaction)) {
  $_SESSION['error'] = " Dữ liệu không tồn tại";
  redirectAdmin("order");
}
if ($EditTransaction['status'] == 2) {
  $_SESSION['error'] = " Đơn hàng đã được xử lý";
  redirectAdmin("order");
}

if ($EditTransaction['status'] == 0) {
  $status = 2;

  $update = $db->update("transaction", array("status" => $status), array("id" => $id));
  if ($update > 0) {
    $_SESSION['success'] = "Đơn hàng đã được huỷ thành công";
    redirectAdmin("order");
  } else {
    $_SESSION['error'] = "Dữ liệu không thay đổi ";   // Thêm thất bại
    redirectAdmin("order");
  }
}

if ($EditTransaction['status'] == 1) {
  $_SESSION['error'] = " Đơn hàng đã được xử lý";
  redirectAdmin("order");
}
