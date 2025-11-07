<?php
session_start();
$_SESSION["carts"] = json_decode($_POST['carts'], true);
echo json_encode(['code' => 200]);
