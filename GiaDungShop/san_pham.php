<?php
require_once __DIR__ . '/autoload/autoload.php';
$id = intval(getInput('id'));
$item = $db->fetchId("product", $id);
if ($item['status'] == 0) {
   header("location:index.php");
}
$ca = $db->fetchId("category", $item['category_id']);
$sql = "SELECT users.name,rated.comment,rated.rated,rated.created_at FROM rated LEFT JOIN users ON rated.id_users = users.id WHERE id_product = $id";
$sql2 = "SELECT product_images.image, product_images.id from product_images where product_images.product_id = $id LIMIT 4";
$images = $db->fetchsql($sql2);
$rated = $db->fetchsql($sql);

$star = 0;
$count = 0;
foreach ($rated as $item2) {
   $star += $item2['rated'];
   $count += 1;
}
if ($count > 0) {
   $star /= $count;
   $data =
      [
         'rated' => $star,
         'comment' => $count
      ];
   $id_update = $db->update("product", $data, array("id" => $id));
}
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<!-- Shop Details Section Begin -->
<section class="shop-details">
   <div class="product__details__pic">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="product__details__breadcrumb">
                  <a href="index.php">Home</a>
                  <a href="timkiem.php">Cửa hàng</a>
                  <span>Chi tiết sản phẩm</span>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-3 col-md-3">
               <ul class="nav nav-tabs" role="tablist">
                  <?php $i = 0;
                  foreach ($images as $key => $image) : ?>
                     <li class="nav-item">
                        <a class="nav-link <?= $i == 0 ? 'active' : '' ?>" data-toggle="tab" href="#tabs-<?= $image['id'] ?>" role="tab">
                           <div class="product__thumb__pic set-bg" data-setbg="<?php echo uploads() ?>product/<?php echo $image['image'] ?>">
                           </div>
                        </a>
                     </li>
                  <?php $i++;
                  endforeach; ?>
               </ul>
            </div>
            <div class="col-lg-6 col-md-9">
               <div class="tab-content">
                  <?php $i = 0;
                  foreach ($images as $key => $image) : ?>
                     <div class="tab-pane <?= $i == 0 ? 'active' : '' ?>" id="tabs-<?= $image['id'] ?>" role="tabpanel">
                        <div class="product__details__pic__item">
                           <img src="<?php echo uploads() ?>product/<?php echo $image['image'] ?>" alt="">
                        </div>
                     </div>
                  <?php $i++;
                  endforeach;  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="product__details__content">
      <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
               <div class="product__details__text">
                  <h4><?= $item['name'] ?></h4>
                  <div class="rating">
                     <i class="fa fa-star<?php if ($star < 1) : ?>-o<?php endif ?>"></i>
                     <i class="fa fa-star<?php if ($star < 2) : ?>-o<?php endif ?>"></i>
                     <i class="fa fa-star<?php if ($star < 3) : ?>-o<?php endif ?>"></i>
                     <i class="fa fa-star<?php if ($star < 4) : ?>-o<?php endif ?>"></i>
                     <i class="fa fa-star<?php if ($star < 5) : ?>-o<?php endif ?>"></i>
                     <span> - <?= $count ?> Bình luận</span>
                  </div>
                  <h3><?= formatPrice(formatSale($item['price'], $item['sale'])) ?> đ<?php if ($item['sale'] > 0) : ?><span><?= formatPrice($item['price']) ?> đ</span><?php endif ?></h3>
                  <div class="product__details__option">
                     <div class="product__details__option__size">
                        <span>Kích thước:</span>
                        <label for="XXL">XXL
                           <input type="radio" id="XXL" name="size" class="size" value="XXL">
                        </label>
                        <label for="XL">XL
                           <input type="radio" id="XL" name="size" class="size" value="XL">
                        </label>
                        <label for="L">L
                           <input type="radio" id="L" name="size" class="size" value="L">
                        </label>
                        <label for="M">M
                           <input type="radio" id="M" name="size" class="size" value="M">
                        </label>
                        <label for="S">S
                           <input type="radio" id="S" naSe="size" class="size" value="S">
                        </label>
                     </div>
                     <div class="product__details__option__color">
                        <span>Màu:</span>
                        <label class="c-1" for="sp-1">
                           <input type="radio" id="sp-1" name="color" class="color" value="Đen">
                        </label>
                        <label class="c-2" for="sp-2">
                           <input type="radio" id="sp-2" name="color" class="color" value="Xanh">
                        </label>
                        <label class="c-3" for="sp-3">
                           <input type="radio" id="sp-3" name="color" class="color" value="Vàng">
                        </label>
                        <label class="c-4" for="sp-4">
                           <input type="radio" id="sp-4" name="color" class="color" value="Đỏ">
                        </label>
                        <label class="c-9" for="sp-9">
                           <input type="radio" id="sp-9" name="color" class="color" value="Trắng">
                        </label>
                     </div>
                  </div>
                  <div class="product__details__cart__option">
                     <div class="quantity">
                        <div class="pro-qty">
                           <input type="number" onkeypress="return isNumberKey(event)" value="1" class="cart-qty">
                        </div>
                     </div>
                     <input type="hidden" class="id" name="id" value="<?= $item['id'] ?>">
                     <input type="hidden" class="product-number" name="product-number" value="<?= $item['number'] ?>">
                     <input type="hidden" class="name" name="name" value="<?= $item['name'] ?>">
                     <input type="hidden" class="category" name="category" value="<?= $ca['name'] ?>">
                     <input type="hidden" class="price-cart" name="price" value="<?= formatSale($item['price'], $item['sale']) ?>">
                     <span class="primary-btn addToCart cursor">Thêm vào giỏ hàng</span>
                  </div>
                  <div class="product__details__last__option">
                     <ul class="pt-0">
                        <li><span>Danh mục:</span> <?= $ca['name'] ?></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-lg-12">
               <div class="product__details__tab">
                  <ul class="nav nav-tabs" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Nội dung</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Đánh giá khách hàng(<?= $count ?>)</a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div class="tab-pane active" id="tabs-5" role="tabpanel">
                        <div class="product__details__tab__content">
                           <div class="product__details__tab__content__item">
                              <p><?= $item['content'] ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane" id="tabs-6" role="tabpanel">
                        <div class="product__details__tab__content">
                           <div class="product__details__tab__desc">
                              <h6>Xếp hạng</h6>
                              <div class="comment-area">
                                 <?php if (isset($_SESSION['name_user'])) : ?>
                                    <div class="guiBinhLuan">
                                       <form action="danh-gia.php?" class="d-flex justify-content-center align-items-start flex-column">
                                          <div class="rate">
                                             <input type="hidden" name="id" value="<?= $id ?>">
                                             <input type="radio" id="star5" value="5" name="star">
                                             <label for="star5" title="Tuyệt vời"></label>
                                             <input type="radio" id="star4" value="4" name="star">
                                             <label for="star4" title="Tốt"></label>
                                             <input type="radio" id="star3" value="3" name="star">
                                             <label for="star3" title="Tạm"></label>
                                             <input type="radio" id="star2" value="2" name="star">
                                             <label for="star2" title="Khá"></label>
                                             <input type="radio" id="star1" value="1" name="star">
                                             <label for="star1" title="Tệ"></label>
                                          </div>
                                          <textarea maxlength="250" id="inpBinhLuan" name="comment" placeholder="Viết gì đó" rows="5" class="w-100 p-3 mb-3"></textarea>
                                          <input class="site-btn" id="btnBinhLuan" type="submit" value="Submit">
                                       </form>
                                    </div>
                                 <?php endif; ?>
                                 <div class="rating mt-3">
                                    <i class="fa fa-star<?php if ($star < 1) : ?>-o<?php endif ?>"></i>
                                    <i class="fa fa-star<?php if ($star < 2) : ?>-o<?php endif ?>"></i>
                                    <i class="fa fa-star<?php if ($star < 3) : ?>-o<?php endif ?>"></i>
                                    <i class="fa fa-star<?php if ($star < 4) : ?>-o<?php endif ?>"></i>
                                    <i class="fa fa-star<?php if ($star < 5) : ?>-o<?php endif ?>"></i>
                                    <span> <?= $count ?> đánh giá </span>
                                 </div>
                                 <div class="comment-content">
                                    <?php foreach ($rated as $it) : ?>
                                       <div class="comment mt-2">
                                          <div class="d-flex align-items-center">
                                             <i class="fa fa-user-circle" style="font-size:30px"> </i>
                                             <p class="mb-0 ml-2 h4"><?= $it['name'] ?></p>
                                          </div>
                                          <div class="ml-2">
                                             <span>
                                                <i class="fa fa-star<?php if ($it['rated'] < 1) : ?>-o<?php endif ?>"></i>
                                                <i class="fa fa-star<?php if ($it['rated'] < 2) : ?>-o<?php endif ?>"></i>
                                                <i class="fa fa-star<?php if ($it['rated'] < 3) : ?>-o<?php endif ?>"></i>
                                                <i class="fa fa-star<?php if ($it['rated'] < 4) : ?>-o<?php endif ?>"></i>
                                                <i class="fa fa-star<?php if ($it['rated'] < 5) : ?>-o<?php endif ?>"></i>
                                             </span>
                                             <p class="mb-0"><?= $it['comment'] ?></p>
                                             <span class="time"><?= $it['created_at'] ?></span>
                                          </div>
                                       </div>
                                    <?php endforeach ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Related Section End -->
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
