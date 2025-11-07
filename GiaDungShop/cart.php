<?php
require_once __DIR__ . "/autoload/autoload.php";
// unset($_SESSION['cart']);
$index = md5($_POST['id'] . $_POST['color'] . $_POST['size']);
if (isset($_SESSION['cart'][$index]) && isset($_SESSION['cart'][$index]['options']['color']) && $_SESSION['cart'][$index]['options']['color'] == $_POST['color'] && isset($_SESSION['cart'][$index]['options']['size']) && $_SESSION['cart'][$index]['options']['size'] == $_POST['size']) {
	$_SESSION['cart'][$index]['qty'] += $_POST['qty'];
} else {
	$_SESSION['cart'][$index] = array('session_id' => $index, 'qty' => $_POST['qty'], 'price' => $_POST['price'], 'category' => $_POST['category'], 'id' => $_POST['id'], 'options' => ['size' => $_POST['size'], 'color' => $_POST['color']], 'name' => $_POST['name']);
}
$message = $_POST['name'];
echo json_encode($message);
// if (!isset($_SESSION['cart'][$_POST['id']])) {
// 	$_SESSION['cart'][$_POST['id']]['id'] = $_POST['id'];
// 	$_SESSION['cart'][$_POST['id']]['name'] = $_POST['name'];
// 	// $_SESSION['cart'][$_POST['id']]['thundar'] = base_url() . 'public/uploads/product/' . $_POST['thundar'];
// 	$_SESSION['cart'][$_POST['id']]['qty'] = $_POST['qty'];
// 	$_SESSION['cart'][$_POST['id']]['price'] = $_POST['price'];
// 	$_SESSION['cart'][$_POST['id']]['options'] = [
// 		'size' => $_POST['size'],
// 		'color' => $_POST['color'],
// 	];
// }
// if (isset($_SESSION['cart'][$_POST['id']])) {
// 	if ($_SESSION['cart'][$_POST['id']]['options']['size'] == $_POST['size'] && $_SESSION['cart'][$_POST['id']]['options']['color'] == $_POST['color']) {
// 		$_SESSION['cart'][$_POST['id']]['qty'] += 1;
// 	} else {
// 		$id = $_POST['id'] . chr(rand(97, 122));
// 		$_SESSION['cart'][$id]['id'] = $_POST['id'];
// 		$_SESSION['cart'][$id]['name'] = $_POST['name'];
// 		// $_SESSION['cart'][$_POST['id']]['thundar'] = base_url() . 'public/uploads/product/' . $_POST['thundar'];
// 		$_SESSION['cart'][$id]['qty'] = $_POST['qty'];
// 		$_SESSION['cart'][$id]['price'] = $_POST['price'];
// 		$_SESSION['cart'][$id]['options'] = [
// 			'size' => $_POST['size'],
			// 'color' => $_POST['color'],
		// ];
	// }
// }
// var_dump($_SESSION['cart']);
// die;
// echo "<script>alert('Thêm vào giỏ hàng thành công');location.href='giohang.php'</script>";
