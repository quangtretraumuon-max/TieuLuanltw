<?php
require_once __DIR__ . "/autoload/autoload.php";
$cart = "<script>document.write(localStorage.getItem('cart'));</script>";
// var_dump($carts);
$carts = $cart;
if (!isset($_SESSION['name_id'])) {
  echo "<script>alert('Bạn phải đăng nhập mới thực hiện được chức năng này !!!');location.href='dang-ki.php'</script>";
}
$users = $db->fetchID("users", intval($_SESSION['name_id']));
?>

<?php require_once __DIR__ . "/layouts/header.php"; ?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcrumb__text">
          <h4>Thanh toán</h4>
          <div class="breadcrumb__links">
            <a href="index.php">Trang chủ</a>
            <a href="timkiem.php">Cửa hàng</a>
            <span>Thanh toán</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Section End -->
<section class="checkout spad">
  <div class="container">
    <div class="checkout__form">
      <h4>Chi tiết hoá đơn</h4>
      <form action="#" method="POST">
        <div class="row">
          <div class="col-lg-8 col-md-6" id="form__checkout">
            <div class="checkout__input">
              <p>Họ tên<span>*</span></p>
              <input type="hidden" name="id" value="<?= $users ? $users['id'] : '' ?>" class="checkout__id">
              <input type="text" name="name" value="<?= $users ? $users['name'] : '' ?>" class="checkout__input__add checkout__name">
            </div>
            <div class="checkout__input">
              <p>Địa chỉ<span>*</span></p>
              <input type="text" placeholder="Street Address" name="address" value="<?= $users ?  $users['address'] : '' ?>" class="checkout__input__add checkout__address">
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="checkout__input">
                  <p>Điện thoại<span>*</span></p>
                  <input type="tel" name="phone" value="<?= $users ? $users['phone'] : '' ?>" class="checkout__input__add checkout__phone">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="checkout__input">
                  <p>Email<span>*</span></p>
                  <input type="email" name="email" value="<?= $users ? $users['email'] : '' ?>" class="checkout__input__add checkout__email">
                </div>
              </div>
            </div>
            <!-- <div class="checkout__input">
              <p>Order notes<span>*</span></p>
              <input type="text" placeholder="Notes about your order, e.g. special notes for delivery." name="status">
            </div> -->
          </div>
          <div class="col-lg-4 col-md-6">
            <div class="checkout__order">
              <h4 class="order__title">Đơn của bạn</h4>
              <div class="checkout__order__products">Sản phẩm <span>Đơn giá</span></div>
              <ul class="checkout__total__products" data-total="" id="checkout__total_products">
              </ul>
              <ul class="checkout__total__all">
                <li>Tổng <span class="total-money"></span></li>
                <li>Tổng tiền <span class="total-money"></span></li>
              </ul>
              <button type="button" id="thanhtoan" class="site-btn">Xác nhận</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
