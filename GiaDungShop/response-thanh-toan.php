<?php
require_once __DIR__ . "/autoload/autoload.php";

if ($_REQUEST['resultCode'] == 0) {
  $data =
    [
      // 'amount' => $_SESSION['total'],
      'users_id' => $_SESSION['name_id'],
      'name' => $_SESSION['name_user'],
      'phone' => $_SESSION['name_phone'],
      'email' => $_SESSION['name_email'],
      'address' => $_SESSION['name_address'],
      'payment_method' => 2 // 2 thanh toán momo
    ];
  $idtran = $db->insert("transaction", $data);

  if ($idtran > 0) {
    $price = 0;
    foreach ($_SESSION['carts'] as $key => $value) {
      $data2 =
        [
          'transaction_id' => $idtran,
          'product_id' => $value['id'],
          'qty' => $value['qty'],
          'price' => $value['qty'] * $value['price'],
          'size' => $value['size'],
          'color' => $value['color'],
        ];
      $id_insert = $db->insert("orders", $data2);
      $price += $value['qty'] * $value['price'];
    }
    // $_SESSION['success'] = "Xác nhận mua hàng thành công! Đơn hàng của bạn sẽ được giao đến bạn trong thời gian sớm nhất !!!";
    // header("location: thong-bao.php");
  }
  $isset = $db->fetchOne("transaction", "id = '" . $idtran . "' ");
  $db->update("transaction", ['amount' => $price], array("id" => $idtran));
  unset($_SESSION['carts']);
  header("location:thanks.php");
}

if ($_REQUEST['resultCode'] == 1006) {
}
