<?php
require_once __DIR__ . '/autoload/autoload.php';

$id = intval(getInput('id'));
$cate = $db->fetchID("category", $id);
$sql = "SELECT *, product_images.image as images FROM product LEFT JOIN product_images ON product_images.product_id = product.id WHERE product.category_id = $id GROUP BY product.id ORDER BY product.id DESC";

$total = count($db->fetchsql($sql));

if (isset($_GET['page'])) {
  $p = $_GET['page'];
} else {
  $p = 1;
}

$product = $db->fetchJones("product", $sql, $total, $p, 12, true);

if (isset($product)) {
  $sotrang = $product['page'];
  unset($product['page']);
}
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<section class="shop spad">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="shop__sidebar">
          <div class="shop__sidebar__accordion">
            <div class="accordion" id="accordionExample">
              <div class="card">
                <div class="card-heading">
                  <a data-toggle="collapse" data-target="#collapseOne">Danh mục</a>
                </div>
                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                  <div class="card-body">
                    <div class="shop__sidebar__categories">
                      <ul class="nice-scroll" tabindex="1" style="overflow-y: hidden; outline: none;">
                        <?php foreach ($categories as $cate) : ?>
                          <li><a href="danh-muc.php?id=<?= $cate['id'] ?>"><?= $cate['name'] ?></a></li>
                        <?php endforeach ?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="row">
          <?php foreach ($product as $item) : ?>
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="product__item">
                <div class="product__item__pic set-bg" data-setbg="<?= uploads() ?>product/<?= $item['images'] ?>" style="background-image: url('<?= uploads() ?>product/<?= $item['images'] ?>');">
                  <ul class="product__hover">
                    <li><a href="san_pham.php?id=<?= $item['id'] ?>"><img src="<?= base_url() ?>public/frontend/img/icon/search.png" alt=""></a></li>
                  </ul>
                </div>
                <h6 class="pt-3"><a href="san_pham.php?id=<?= $item['id'] ?>" class="text-dark position-relative opacity-100 visible" style="opacity: 1;"><?= $item['name'] ?></a></h6>
                <div class="product__item__text pt-1">
                  <div class="rating">
                    <i class="fa fa-star<?php if ($item['rated'] < 1) : ?>-o<?php endif ?>"></i>
                    <i class="fa fa-star<?php if ($item['rated'] < 2) : ?>-o<?php endif ?>"></i>
                    <i class="fa fa-star<?php if ($item['rated'] < 3) : ?>-o<?php endif ?>"></i>
                    <i class="fa fa-star<?php if ($item['rated'] < 4) : ?>-o<?php endif ?>"></i>
                    <i class="fa fa-star<?php if ($item['rated'] < 5) : ?>-o<?php endif ?>"></i>
                    <span class="ml-2"> <?= $item['comment'] ?> đánh giá </span>
                  </div>
                  <?php if ($item['sale'] > 0) : ?>
                    <span class="mr-2">
                      <strike class="sale"><?= formatPrice($item['price']) ?> đ</strike>
                    </span>
                  <?php endif ?>
                  <h5 class="price"><?= formatPrice(formatSale($item['price'], $item['sale'])) ?> đ</h5>
                </div>
              </div>
            </div>
          <?php endforeach ?>
        </div>
        <div class="row justify-content-center">
          <div class="product__pagination d-flex justify-content-center">
            <?php for ($i = 1; $i <= $sotrang; $i++) : ?>
              <?php
              if (isset($_GET['page'])) {
                $p = $_GET['page'];
              } else {
                $p = 1;
              }
              ?>
              <a class="<?= ($i == $p) ? 'active' : '' ?>" href="?keyword=<?= $the ?>&&sx=<?= $sx ?>&&f=<?= $f ?>&&l=<?= $l ?>&&page=<?= $i; ?>"><?= $i; ?></a>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
