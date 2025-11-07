<?php
require_once __DIR__ . '/autoload/autoload.php';
if(isset($_SESSION['name_id'])){
    header("location:index.php");
}
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Login</h4>
            <form action="#">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="checkout__input">
                            <p>Email<span>*</span></p>
                            <input type="email" name="email" class="email">
                        </div>
                        <div class="checkout__input">
                            <p>Password<span>*</span></p>
                            <input type="password" class="checkout__input__add password" name="password">
                            <p>Bạn chưa có tài khoản ??? <a class="text-decoration-underline" style="text-decoration: underline;" href="dang-ki.php">Đăng ký</a> ngay</p>
                        </div>
                        <button type="button" class="site-btn" id="login">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
