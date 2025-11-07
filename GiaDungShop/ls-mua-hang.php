<?php require_once __DIR__ . '/autoload/autoload.php';
$id = $_SESSION['name_id'];
$sql = "SELECT * FROM transaction WHERE users_id = $id";
$trans = $db->fetchsql($sql);

?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>

<section class="breadcrumb-option">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb__text">
					<h4>Lịch sử mua hàng</h4>
					<div class="breadcrumb__links">
						<a href="index.php">Trang chủ</a>
						<span>Lịch sử mua hàng</span>
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
								<th>Tên người nhận</th>
								<th>Số điện thoại</th>
								<th>Địa chỉ</th>
								<th>Ngày mua</th>
								<th>Số tiền</th>
								<th>Chi tiết</th>
							</tr>
						</thead>
						<tbody>
							<?php if (count($trans) > 0) : ?>
								<?php $stt = 1;
								$sum = 0;
								foreach ($trans as $tran) : ?>
									<tr>
										<td class="" style="width:100px">
											<?php echo $stt ?>
										</td>
										<td class="">
											<?php echo $tran['name'] ?>
										</td>
										<td class="">
											<?php echo $tran['phone'] ?>
										</td>
										<td class="">
											<?php echo $tran['address'] ?>
										</td>
										<td class="">
											<?php echo $tran['created_at'] ?>
										</td>
										<td class="">
											<?php echo formatPrice($tran['amount']) ?> đ
										</td>
										<td class="shoping__cart__item__close">
											<a href="chi-tiet-don-hang.php?id=<?php echo $tran['id'] ?>" title="Chi tiết đơn hàng"><span class="icon_table"></span></a>
										</td>
									</tr>
								<?php $stt += 1;
								endforeach ?>

							<?php else : ?>
								<tr>
									<td colspan="7" style="color:#4caf50; text-align:center; font-size: 30px; padding: 0">
										Bạn chưa mua sản phẩm nào!!!!!!!
									</td>
								<tr>
								<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
