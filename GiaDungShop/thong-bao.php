<?php require_once __DIR__ . "/autoload/autoload.php";
unset($_SESSION['cart']);
unset($_SESSION['total']);
?>
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<!--noi dung-->
<?php if (isset($_SESSION['success'])) : ?>
	<div class="alert alert-success">
		<script>
			alert('Success!<?php echo $_SESSION['success'];unset($_SESSION['success']) ?>');
			location.href = 'index.php'
		</script>";
	</div>
<?php endif ?>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
