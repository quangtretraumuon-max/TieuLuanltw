<?php
require_once __DIR__ . '/autoload/autoload.php';

$email = $_POST['email'];
$password = $_POST['password'];

$message = [];
if ($email == '') {
    $message = "Email không được để trống!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}

if ($password == '') {
    $message = "Mật khẩu không được để trống!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
} else {
    $password = MD5(postInput('password'));
}

$isset = $db->fetchOne("users", "email = '" . $email . "' AND password = '" . $password . "' ");
if ($isset > 0) {
    $path = getInput("path");
    $_SESSION['name_user'] = $isset['name'];
    $_SESSION['name_id'] = $isset['id'];
    $_SESSION['name_address'] = $isset['address'];
    $_SESSION['name_phone'] = $isset['phone'];
    $_SESSION['name_email'] = $isset['email'];

    $message = "Đăng nhập thành công !!! Chúc bạn mua sắm vui vẻ";
    echo json_encode(['message' => $message, 'code' => 200]);
    return;
} else {
    $message = "Tài khoản hoặc mật khẩu không chính xác !!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}
