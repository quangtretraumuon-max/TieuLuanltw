<?php if (isset($_SESSION['name_user'])) : ?>
  <a href="ls-mua-hang.php"><i class="fa fa-history" title="Lịch sử mua hàng"></i></a>
<?php endif ?>

<?php if (isset($_SESSION['name_user'])) : ?>
  <a href="dang-xuat.php"><i class="fa fa-user"></i>Log out</a>
<?php else : ?>
  <a href="dang-nhap.php?path=<?php echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] ?>"><i class="fa fa-user"></i> Login</a>
<?php endif ?>
<img src="<?php echo base_url() ?>public/frontend/img/logo.png" alt="">
