<?php
require_once __DIR__ . "/autoload/autoload.php";
if (isset($_GET["id"]) && isset($_GET["return_url"]) && isset($_SESSION["cart"])) {
	$index = md5($_GET['id'] . $_GET['color'] . $_GET['size']);
	$return_url = base64_decode($_GET["return_url"]);
	foreach ($_SESSION['cart'] as $key => $cart) {
		if ($cart['session_id'] == $index) {
			unset($_SESSION['cart'][$key]);
		}
	}
	header('Location:' . $return_url);
}
