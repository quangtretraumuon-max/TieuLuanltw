<?php
require_once __DIR__ . "/autoload/autoload.php";
//show wishlist
$user_id = $_SESSION['name_id'];
//if isset user_id
if (isset($user_id)) {
  $sql = "SELECT * FROM wishlist WHERE user_id = $user_id";
  $wishlist = $db->fetchsql($sql);
} else {
  header('location: index.php');
}
// sql show product and get images by product_images and group by product_id to get one image wíhlist
$sql = "SELECT p.*, pi.image, c.slug as cateSlug FROM product p LEFT JOIN product_images pi ON p.id = pi.product_id LEFT JOIN category c ON p.category_id = c.id WHERE p.id IN (SELECT product_id FROM wishlist WHERE user_id = $user_id) GROUP BY p.id";
$products = $db->fetchsql($sql);
// get id product in wishlist
$arr = [];
foreach ($wishlist as $item) {
  $arr[] = $item['product_id'];
}
?>
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<!-- Product Section Begin -->
<section class="product spad">
  <div class="container">
    <div class="row product__filter">
      <?php foreach ($products as $item) : ?>
        <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix <?= $item['cateSlug'] ?>">
          <div class="product__item">
            <div class="product__item__pic set-bg" data-setbg="<?= uploads() ?>product/<?= $item['image'] ?>">
              <ul class="product__hover">
                <li><a href="san_pham.php?id=<?= $item['id'] ?>"><img src="<?= base_url() ?>public/frontend/img/icon/search.png" alt=""></a></li>
                <?php if (!isset($_SESSION['name_id'])) : ?>
                  <li><a href="dang-nhap.php"><img src="<?= base_url() ?>public/frontend/img/icon/heart.png" alt=""></a></li>
                <?php elseif (isset($_SESSION['name_id'])) : ?>
                  <?php if (in_array($item['id'], $arr)) : ?>
                    <li><a href="them_yeu_thich.php?product_id=<?= $item['id'] ?>">
                        <img src="<?= base_url() ?>public/frontend/img/icon/heart_o.png" alt="">
                      </a>
                    </li>
                  <?php else : ?>
                    <li><a href="them_yeu_thich.php?product_id=<?= $item['id'] ?>">
                        <img src="<?= base_url() ?>public/frontend/img/icon/heart.png" alt="">
                      </a>
                    </li>
                  <?php endif ?>
                <?php endif ?>
              </ul>
            </div>
            <h6 class="pt-2 text-danger"><a href="san_pham.php?id=<?= $item['id'] ?>" class="position-relative text-danger text-bold font-bold bold"><?= $item['name'] ?></a></h6>
            <div class="product__item__text pt-1">
              <h5><?= number_format($item['price']) ?> VNĐ</h5>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>
<!-- Product Section End -->
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
