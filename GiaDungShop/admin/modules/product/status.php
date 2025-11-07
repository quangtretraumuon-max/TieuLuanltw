<?php
require_once __DIR__ . "/../../autoload/autoload.php";


$id = intval(getInput('id'));

$status = $db->fetchID("product", $id);
if (empty($status)) {
  $_SESSION['error'] = "Dữ liệu không tồn tại";
  redirectAdmin("product");
}
if ($status['status'] == 1) {
  $update = $db->update("product", array("status" => 0), array("id" => $id));
  if ($update > 0) {
    $_SESSION['success'] = "Đã ẩn sản phẩm";
    redirectAdmin("product");
  } else {
    $_SESSION['error'] = "Dữ liệu không thay đổi ";   // Thêm thất bại
    redirectAdmin("product");
  }
}
if ($status['status'] == 0) {
  $update = $db->update("product", array("status" => 1), array("id" => $id));
  if ($update > 0) {
    $_SESSION['success'] = "Đã hiện sản phẩm";
    redirectAdmin("product");
  } else {
    $_SESSION['error'] = "Dữ liệu không thay đổi ";   // Thêm thất bại
    redirectAdmin("product");
  }
}
