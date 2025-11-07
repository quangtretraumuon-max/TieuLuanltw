<?php require_once __DIR__ . '/autoload/autoload.php';
if (!isset($_SESSION['name_id'])) {
  header("location:index.php");
} ?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<section class="shoping-cart spad">
  <div class="container">
    <h2 class="text-center mt-5 pt-5">Cảm ơn bạn đã mua hàng !!!</h2>

    <div class="text-center mt-5 pt-5">
      <a href="index.php" class="primary-btn">Trở lại</a>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
