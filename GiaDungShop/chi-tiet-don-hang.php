<?php require_once __DIR__ . '/autoload/autoload.php';

$id = intval(getInput('id'));
$sql = "SELECT product.name,product.thundar,orders.price,orders.qty,orders.size as size, orders.color as color FROM orders LEFT JOIN product ON orders.product_id = product.id WHERE orders.transaction_id = $id";
$order = $db->fetchsql($sql);
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<section class="breadcrumb-option">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb__text">
					<h4>Chi tiết đơn hàng</h4>
					<div class="breadcrumb__links">
						<a href="index.php">Trang chủ</a>
						<span>Chi tiết đơn hàng</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<section class="shoping-cart spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="shoping__cart__table">
					<table class="table text-nowrap mb-0 align-middle">
						<thead>
							<tr>
								<th>Stt</th>
								<th>Sản phẩm</th>
								<th>Kích thước</th>
								<th>Màu sắc</th>
								<th>Số lượng</th>
								<th>Thành tiền</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($order) > 0) : ?>
								<?php $stt = 1;
								$sum = 0;
								foreach ($order as $item) : ?>
									<tr>
										<td class="" style="width:100px">
											<?= $stt ?>
										</td>
										<td class="shoping__cart__item">
											<h5><?= $item['name'] ?></h5>
										</td>
										<td class="">
											<?= $item['size'] ?>
										</td>
										<td class="">
											<?= $item['color'] ?>
										</td>
										<td class="">
											<?= $item['qty'] ?>
										</td>
										<td class="">
											<?= formatPrice($item['price']) ?> đ
										</td>
									</tr>
								<?php $stt += 1;
									$sum += $item['price'];
								endforeach;
								$_SESSION['amount'] = $sum ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" style="text-align: center">Tổng số tiền</th>
								<th scope="col" style="color: red"><?= formatPrice($sum) ?> đ</th>
							</tr>
						</tfoot>
					<?php else : ?>
						<tr>
							<td colspan="7" style="color:#4caf50; text-align:center; font-size: 30px; padding: 0">
								Bạn chưa mua sản phẩm nào!!!!!!!
							</td>
						<tr>
						<?php endif ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
