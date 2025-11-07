<?php
require_once __DIR__ . "/autoload/autoload.php";
// add wishlist
if (isset($_GET['product_id'])) {
  $product_id = $_GET['product_id'];
  $user_id = $_SESSION['name_id'];
  $data = [
    'user_id' => $user_id,
    'product_id' => $product_id,
  ];
  $sql = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
  $result = $db->fetchsql($sql);
  // $count = mysqli_num_rows($result);
  $count = count($result);
  if ($count == 0) {
    $db->insert('wishlist', $data);
  } else {
    $sql = "SELECT * FROM wishlist WHERE user_id = $user_id AND product_id = $product_id";
    $result = $db->fetchsql($sql);
    $db->delete('wishlist', $result[0]['id']);
  }
  header('location: index.php');
}
