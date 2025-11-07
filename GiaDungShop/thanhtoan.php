<?php
require_once __DIR__ . "/autoload/autoload.php";
$data =
  [
    // 'amount' => $_SESSION['total'],
    'users_id' => $_POST['id'],
    'name' => $_POST['name'],
    'phone' => $_POST['phone'],
    'email' => $_POST['email'],
    'address' => $_POST['address'],
    'payment_method' => 1 // 1 thanh toán khi nhận hàng
  ];
$idtran = $db->insert("transaction", $data);

if ($idtran > 0) {
  $price = 0;
  foreach (json_decode($_POST['carts'], true) as $key => $value) {
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

echo json_encode(['code' => 200]);
