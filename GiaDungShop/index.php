<?php require_once __DIR__ . '/autoload/autoload.php';
//_debug($_SESSION['cart']);
// unset($_SESSION['cart']);
$sqlRated = "SELECT product.*, category.slug as cateSlug, product_images.image as images FROM product LEFT JOIN category ON category.id = product.category_id LEFT JOIN product_images on product_images.product_id = product.id WHERE category.home = 0 AND product.status = 1 GROUP BY product.id ORDER BY rated DESC";
$productRated = $db->fetchsql($sqlRated);
$sqlNew = "SELECT product.* FROM product LEFT JOIN category ON category.id = product.category_id WHERE category.home = 0 AND product.status = 1 ORDER BY id DESC LIMIT 3";
$productNew = $db->fetchsql($sqlNew);
$sqlSale = "SELECT product.* FROM product LEFT JOIN category ON category.id = product.category_id WHERE category.home = 0 AND product.status = 1 ORDER BY sale DESC LIMIT 3";
$productSale = $db->fetchsql($sqlSale);
$sqlCheap = "SELECT product.* FROM product LEFT JOIN category ON category.id = product.category_id WHERE category.home = 0 AND product.status = 1 ORDER BY price LIMIT 3";
$productCheap = $db->fetchsql($sqlCheap);

if (isset($_SESSION['name_id'])) {
    $user_id = $_SESSION['name_id'];
    $sql = "SELECT * FROM wishlist WHERE user_id = $user_id";
    $result = $db->fetchsql($sql);
    $arr = [];
    foreach ($result as $val) {
        array_push($arr, $val['product_id']);
    }
}
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php require_once __DIR__ . '/layouts/banner.php'; ?>
<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Tất cả</li>
                    <?php foreach ($categories as $cate) : ?>
                        <li data-filter=".<?= $cate['slug'] ?>"><?= $cate['name'] ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
        <div class="row product__filter">
            <?php foreach ($productRated as $item) : ?>
                <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix <?= $item['cateSlug'] ?>">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="<?= uploads() ?>product/<?= $item['images'] ?>">
                            <ul class="product__hover">
                                <!-- <li><a href="#"><img src="<?= base_url() ?>public/frontend/img/icon/heart.png" alt=""></a></li> -->
                                <!-- <li><a href="#"><img src="<?= base_url() ?>public/frontend/img/icon/compare.png" alt=""> <span>Compare</span></a></li> -->
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
                        <div class="product__item__text">
                            <h6><?= $item['name'] ?></h6>
                            <a href="san_pham.php?id=<?= $item['id'] ?>" class="add-cart"><?= $item['name'] ?></a>
                            <span class="d-flex justify-content-center" style="padding-block:5px">
                                <?php if ($item['sale'] > 0) : ?>
                                    <strike class="sale"><?= formatPrice($item['price']) ?> đ</strike>
                                <?php endif ?>
                                <h5 class="ml-2"><?= formatPrice(formatSale($item['price'], $item['sale'])) ?> đ</h5>
                            </span>
                            <div class="rating">
                                <i class="fa fa-star<?php if ($item['rated'] < 1) : ?>-o<?php endif ?>"></i>
                                <i class="fa fa-star<?php if ($item['rated'] < 2) : ?>-o<?php endif ?>"></i>
                                <i class="fa fa-star<?php if ($item['rated'] < 3) : ?>-o<?php endif ?>"></i>
                                <i class="fa fa-star<?php if ($item['rated'] < 4) : ?>-o<?php endif ?>"></i>
                                <i class="fa fa-star<?php if ($item['rated'] < 5) : ?>-o<?php endif ?>"></i>
                                <span class="chu ml-2"><?= $item['comment'] ?> reviews </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<!-- Product Section End -->

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
