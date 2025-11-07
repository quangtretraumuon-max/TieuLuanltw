<?php
require_once __DIR__ . '/autoload/autoload.php';

$data =
    [
        "name" =>  $_POST['name'],
        "address" => $_POST['address'],
        "email" => $_POST['email'],
        "phone" => $_POST['phone'],
        "password" => $_POST['password']
    ];

if ($data['name'] == '') {
    $message = "Tên không được để trống!!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}
if ($data['address'] == '') {
    $message = "Địa chỉ không được để trống!!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}
if ($data['email'] == '') {
    $message = "Email không được để trống!!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}
if ($data['phone'] == '') {
    $message = "Điện thoại không được để trống!!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}

if ($data['password'] == '') {
    $message = "Mật khẩu không được để trống!!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
} else {
    $data['password'] = MD5($data['password']);
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $message = "Email không đúng định dạng !!!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}

$isset = $db->fetchOne("users", "email = '" . $data['email'] . "' ");
if ($isset > 0) {
    $message = "Email đăng ký đã đã tồn tại!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}

$isset = $db->fetchOne("users", "phone = '" . $data['phone'] . "' ");
if ($isset > 0) {
    $message = "Điện thoại đăng ký đã đã tồn tại!";
    echo json_encode(['message' => $message, 'code' => 404]);
    return;
}

if ($isset <= 0) {
    $id_insert = $db->insert("users", $data);
    if ($id_insert > 0) {
        $message = "Đăng kí thành công, hãy đăng nhập !!!";
        echo json_encode(['message' => $message, 'code' => 200]);
        return;
    } else {
        $message = "Đăng ký thất bại !!!";
        echo json_encode(['message' => $message, 'code' => 404]);
        return;
    }
}
