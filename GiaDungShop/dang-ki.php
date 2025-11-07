<?php
require_once __DIR__ . '/autoload/autoload.php';
if (isset($_SESSION['name_id'])) {
    header("location:index.php");
}
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Register</h4>
            <form action="#" method="POST">
                <div class="row">
                    <div class="col-lg-12 col-md-12 register">
                        <div class="checkout__input">
                            <p>Name<span>*</span></p>
                            <input type="text" name="name" class="register_name">
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" placeholder="Street Address" class="checkout__input__add register_address" name="address">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="tel" name="phone" class="register_phone">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" class="register_email">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Password<span>*</span></p>
                            <input type="password" name="password" class="register_password">
                        </div>
                        <button type="button" class="site-btn" id="register">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
