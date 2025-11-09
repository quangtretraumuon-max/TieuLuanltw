<?php
require_once __DIR__ . '/../autoload/autoload.php';
$categories = $db->fetchsql("SELECT * FROM category WHERE level = 0 AND status = 1 AND home = 0 LIMIT 10");
$name = getInput('keywork');

if (getInput('keywork') != '') {
	$name = to_slug($name);
	$item = $db->fetchOne('product', "slug LIKE '%" . $name . "%' ");
	if (isset($item) && count($item) > 0) {
		$cate = $db->fetchOne('category', "id ='" . $item['category_id'] . "'");
		if ($cate['level'] == 0) {
			header("location:timkiem.php?the=" . $name);
		}
	} else {
		$_SESSION['error_s'] = "Không tìm thấy sản phẩm!";
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="description" content="Ogani Template">
	<meta name="keywords" content="Ogani, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>MiMi shop</title>
	

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">

	<!-- Css Styles -->
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/elegant-icons.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/magnific-popup.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/nice-select.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url() ?>public/frontend/css/style.css" type="text/css">
</head>

<body>
	<div id="preloder">
		<div class="loader"></div>
	</div>
	<!-- Offcanvas Menu Begin -->
	<div class="offcanvas-menu-overlay"></div>
	<div class="offcanvas-menu-wrapper">
		<div class="offcanvas__option">
			<div class="offcanvas__links">
				<?php if (isset($_SESSION['name_user'])) : ?>
					<a href="dang-xuat.php">Đăng xuất</a>
					<a href="ls-mua-hang.php">Lịch sử mua hàng</a>
				<?php else : ?>
					<a href="dang-nhap.php?path=<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>">Đăng nhập</a>
				<?php endif ?>
				<a href="#">FAQs</a>
			</div>
		</div>
		<div class="offcanvas__nav__option">
			<a href="#" class="search-switch"><img src="<?php echo base_url() ?>public/frontend/img/icon/search.png" alt=""></a>
			<!-- <a href="wishlist.php"><img src="<?php echo base_url() ?>public/frontend/img/icon/heart.png" alt=""></a> -->
			<a href="#"><img src="<?php echo base_url() ?>public/frontend/img/icon/cart.png" alt=""> <span>0</span></a>
			<div class="total-money price"></div>
		</div>
		<div id="mobile-menu-wrap"></div>
		<div class="offcanvas__text">
			<p>Miễn phí giao hàng</p>
		</div>
	</div>
	<!-- Offcanvas Menu End -->

	<!-- Header Section Begin -->
	<header class="header">
		<div class="header__top">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-7">
						<div class="header__top__left">
							<p>Miễn phí giao hàng</p>
						</div>
					</div>
					<div class="col-lg-6 col-md-5">
						<div class="header__top__right">
							<div class="header__top__links">
								<?php if (isset($_SESSION['name_user'])) : ?>
									<a href="dang-xuat.php">Đăng xuất</a>
									<a href="ls-mua-hang.php">Lịch sử mua hàng</a>
								<?php else : ?>
									<a href="dang-nhap.php?path=<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>">Đăng nhập</a>
								<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="header__logo">
						<a href="index.php"><img src="<?php echo base_url() ?>public/frontend/img/logo.png" alt=""></a>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<nav class="header__menu mobile-menu">
						<ul>
							<li class="active"><a href="index.php">Trang chủ</a></li>
							<li><a href="timkiem.php?keyword=">Cửa hàng</a></li>
							<!-- <li><a href="./blog.html">Bài vết</a></li> -->
							<li><a href="feedback.php">Phản hồi</a></li>
						</ul>
					</nav>
				</div>
				<div class="col-lg-3 col-md-3">
					<div class="header__nav__option">
						<a href="#" class="search-switch"><img src="<?php echo base_url() ?>public/frontend/img/icon/search.png" alt=""></a>
						<a href="wishlist.php"><img src="<?php echo base_url() ?>public/frontend/img/icon/heart.png" alt=""></a>
						<a class="giohang cursor" href="giohang.php"><img src="<?php echo base_url() ?>public/frontend/img/icon/cart.png" alt=""> <span class="cart-total"></span></a>
						<div class="total-money price"></div>
					</div>
				</div>
			</div>
			<div class="canvas__open"><i class="fa fa-bars"></i></div>
		</div>
	</header>
	<!-- Header Section End -->
