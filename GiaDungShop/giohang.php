<?php
require_once __DIR__ . "/autoload/autoload.php";
?>

<?php require_once __DIR__ . "/layouts/header.php"; ?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="breadcrumb__text">
          <h4>Giỏ hàng</h4>
          <div class="breadcrumb__links">
            <a href="index.php">Trang chủ</a>
            <a href="timkiem.php">Cửa hàng</a>
            <span>Giỏ hàng</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="shopping__cart__table">
          <table>
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="cart-local">
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="continue__btn">
              <a href="index.php">Tiếp tục mua sắm</a>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="cart__total">
          <h6>Tổng giỏ hàng</h6>
          <ul>
            <li>Tổng <span class="total-money"></span></li>
            <li>Tổng tiền <span class="total-money"></span></li>
          </ul>
          <a href="thanh-toan.php" class="primary-btn">Thanh toán khi nhận hàng</a>
          <button type="button" class="primary-btn mt-2 w-100" id="momo">Thanh toán trực tuyến</button>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Shopping Cart Section End -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
