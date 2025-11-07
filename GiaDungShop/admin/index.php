<?php
require_once __DIR__ . '/autoload/autoload.php';
$category = $db->fetchAll("category");
$sql = "SELECT transaction.*, users.name as nameuser, users.phone as phoneuser,users.address as addressuser FROM transaction LEFT JOIN users ON users.id = transaction.users_id ORDER BY created_at DESC LIMIT 6";
$transactions = $db->fetchsql($sql);
$countProduct = $db->countTable("product");
// get transaction have status = 0 and count
$sql = "SELECT transaction.*FROM transaction WHERE transaction.status = 0";
$tran0 = $db->fetchsql($sql);
$counttran0 = count($tran0);
// get transaction have status = 1 and count
$sql = "SELECT transaction.*FROM transaction WHERE transaction.status = 1";
$tran1 = $db->fetchsql($sql);
$counttran1 = count($tran1);
// get transaction have status = 2 and count
$sql = "SELECT transaction.*FROM transaction WHERE transaction.status = 2";
$tran2 = $db->fetchsql($sql);
$counttran2 = count($tran2);
//count user
$countuser = $db->countTable("users");
// count category
$countcategory = $db->countTable("category");
// count product
$countproduct = $db->countTable("product");
//count feedback
$countfeedback = $db->countTable("feedback");
// get sales
$sql = "SELECT SUM(amount) as total FROM transaction WHERE transaction.status = 1";
$sales = $db->fetchsql($sql);
$total = $sales[0]['total'];
// Create a chart showing sales by day
$sql = "SELECT DATE_FORMAT(created_at, '%d-%m-%Y') as day, SUM(amount) as total FROM transaction WHERE transaction.status = 1 GROUP BY DATE_FORMAT(created_at, '%d-%m-%Y')";
$salesday = $db->fetchsql($sql);
// sql get transaction by format month-year
$sql = "SELECT SUM(amount) as total, DATE_FORMAT(created_at, '%m-%Y') as month FROM transaction WHERE transaction.status = 1 GROUP BY DATE_FORMAT(created_at, '%m-%Y')";
$salesmonth = $db->fetchsql($sql);
// sql get transaction by format year
$sql = "SELECT SUM(amount) as total, YEAR(created_at) as year FROM transaction WHERE transaction.status = 1 GROUP BY YEAR(created_at)";
$salesyear = $db->fetchsql($sql);
?>
<?php require_once __DIR__ . '/layouts/header.php'; ?>
<div class="container-fluid">
    <div class="row mb-5">
        <div class="col-md-3 bg-dark p-0 border">
            <div class="p-3 text-white text-center">
                Sản phẩm
            </div>
            <hr style="width:90%;margin: 1rem auto">
            <div class="p-4 bg-dark">
                <h1 class="text-center text-white"><?= $countProduct ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-warning p-0 border">
            <div class="p-3 text-white text-center">
                Đơn hàng đang chờ duyệt
            </div>
            <hr style="width:90%;margin: 1rem auto">
            <div class="p-4 bg-warning">
                <h1 class="text-center text-white"><?= $counttran0 ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-success p-0 border">
            <div class="p-3 text-white text-center">
                Đơn hàng đã duyệt
            </div>
            <hr style="width:90%;margin: 1rem auto">
            <div class="p-4 bg-success">
                <h1 class="text-center text-white"><?= $counttran1 ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-danger p-0 border">
            <div class="p-3 text-white text-center">
                Đơn hàng huỷ
            </div>
            <hr style="width:90%;margin: 1rem auto">
            <div class="p-4 bg-danger">
                <h1 class="text-center text-white"><?= $counttran2 ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-primary p-0 border">
            <div class="p-3 text-white text-center">
                Doanh số
            </div>
            <hr style="width:90%;margin: 1rem auto">
            <div class="p-4 bg-primary">
                <h1 class="text-center text-white"><?= number_format($total) ?> đ</h1>
            </div>
        </div>
        <div class="col-md-3 bg-muted p-0 border">
            <div class="p-3 text-white text-center">
                Khách hàng
            </div>
            <hr style="width:90%; margin:1rem auto; color:#fff">
            <div class="p-4 bg-muted">
                <h1 class="text-center text-white"><?= $countuser ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-info p-0 border">
            <div class="p-3 text-white text-center">
                Danh mục
            </div>
            <hr style="width:90%; margin:1rem auto; color:#fff">
            <div class="p-4 bg-info">
                <h1 class="text-center text-white"><?= $countcategory ?></h1>
            </div>
        </div>
        <div class="col-md-3 bg-light p-0 border">
            <div class="p-3 text-dark text-center">
                Phản hồi
            </div>
            <hr style="width:90%; margin:1rem auto; color:#000">
            <div class="p-4 bg-light">
                <h1 class="text-center text-dark"><?= $countfeedback ?></h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary" onclick="showChartDay()">Biểu đồ doanh số theo ngày</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" onclick="showChartMonth()">Biểu đồ doanh số theo tháng</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary" onclick="showChartYear()">Biểu đồ doanh số theo năm</button>
        </div>
        <div id="chartContainer" style="height: 370px; width: 100%;" class="mt-3"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Đơn hàng mới</h5>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Mã đơn</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tên khách hàng</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Địa chỉ</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Giá tiền</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thanh toán</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Thời gian</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $tran) : ?>
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0"><?= $tran['id'] ?></h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1"><?= $tran['nameuser'] ?></h6>
                                            <span class="fw-normal"><?= $tran['phoneuser'] ?></span>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal"><?= $tran['addressuser'] ?></p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if ($tran['status'] == 0) : ?>
                                                    <span class="badge bg-secondary rounded-3 fw-semibold">Đang chờ duyệt</span>
                                                <?php elseif ($tran['status'] == 1) : ?>
                                                    <span class="badge bg-success rounded-3 fw-semibold">Đã duyệt</span>
                                                <?php elseif ($tran['status'] == 2) : ?>
                                                    <span class="badge bg-danger rounded-3 fw-semibold">Đã huỷ</span>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4"><?= number_format($tran['amount']) ?> đ</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if ($tran['payment_method'] == 1) : ?>
                                                    <p class="mb-0 fw-normal">Thanh toán Momo</p>
                                                <?php elseif ($tran['payment_method'] == 2) : ?>
                                                    <p class="mb-0 fw-normal">Thanh toán khi nhận hàng</p>
                                                <?php endif ?>
                                            </div>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4"><?= $tran['created_at'] ?></h6>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showChartDay() {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "dark1", // "light2", "dark1", "dark2"
            animationEnabled: true, // change to true
            data: [{
                // Change type to "bar", "area", "spline", "pie",etc.
                type: "area",
                // Show sales by day
                dataPoints: <?php
                            $dataPoints = [];
                            foreach ($salesday as $item) {
                                $dataPoints[] = array("label" => $item['day'], "y" => $item['total']);
                            }
                            echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
                            ?>
            }]
        })
        chart.render();
    }

    function showChartMonth() {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "dark1", // "light2", "dark1", "dark2"
            animationEnabled: true, // change to true
            data: [{
                // Change type to "bar", "area", "spline", "pie",etc.
                type: "bar",
                // Show sales by day
                dataPoints: <?php
                            $dataPoints = [];
                            foreach ($salesmonth as $item) {
                                $dataPoints[] = array("label" => $item['month'], "y" => $item['total']);
                            }
                            echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
                            ?>
            }]
        })
        chart.render();
    }

    function showChartYear() {
        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "dark1", // "light2", "dark1", "dark2"
            animationEnabled: true, // change to true
            data: [{
                // Change type to "bar", "area", "spline", "pie",etc.
                type: "bar",
                // Show sales by day
                dataPoints: <?php
                            $dataPoints = [];
                            foreach ($salesyear as $item) {
                                $dataPoints[] = array("label" => $item['year'], "y" => $item['total']);
                            }
                            echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
                            ?>
            }]
        })
        chart.render();
    }
</script>
<script type="text/javascript">
    window.onload = function() {

        var chart = new CanvasJS.Chart("chartContainer", {
            theme: "dark1", // "light2", "dark1", "dark2"
            animationEnabled: false, // change to true
            data: [{
                // Change type to "bar", "area", "spline", "pie",etc.
                type: "area",
                // Show sales by day
                dataPoints: <?php
                            $dataPoints = [];
                            foreach ($salesday as $item) {
                                $dataPoints[] = array("label" => $item['day'], "y" => $item['total']);
                            }
                            echo json_encode($dataPoints, JSON_NUMERIC_CHECK);
                            ?>

            }]
        });
        chart.render();

    }
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
