<?php require_once __DIR__ . '/../../autoload/autoload.php';
$id = intval(getInput('id'));
$sql = "SELECT * FROM orders LEFT JOIN product ON orders.product_id = product.id WHERE orders.transaction_id = $id";
$orders = $db->fetchsql($sql);
?>

<body onload="window.print();">
  <div id="page" class="page">
    <div class="header">
      <div class="company">C.Ty TNHH FM Style</div>
    </div>
    <br />
    <div class="title">
      HÓA ĐƠN THANH TOÁN
      <br />
      -------oOo-------
    </div>
    <br />
    <br />
    <table class="TableData">
      <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Đơn giá</th>
        <th>Size</th>
        <th>Màu sắc</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
      <?php
      if (count($orders) > 0) {
        $stt = 1;
        $sum = 0;
        foreach ($orders as $i => $order) {
          echo "<tr>";
          echo "<td class=\"cotSTT\">" . $stt++ . "</td>";
          echo "<td class=\"cotTenSanPham\">" . $order['name'] . "</td>";
          echo "<td class=\"cotSo\">" . formatPrice($order['price']) . "đ</td>";
          echo "<td class=\"cotGia\">" . $order['size'] . "</td>";
          echo "<td class=\"cotGia\">" . $order['color'] . "</td>";
          echo "<td class=\"cotSoLuong\" align='center'>" . $order['qty'] . "</td>";
          echo "<td class=\"cotSo\">" . formatPrice($order['price'] * $order['qty'])  . "đ</td>";
          echo "</tr>";
          $sum += $order['price'] * $order['qty'];
        }
      }
      ?>
      <tr>
        <td colspan="6" class="tong">Tổng cộng</td>
        <td class="cotSo"><?php echo formatPrice($sum) ?>đ</td>
      </tr>
    </table>
    <div class="footer-left"> Việt Nam, ngày ... tháng ... năm ....<br />
      Khách hàng </div>
    <div class="footer-right"> Việt Nam, ngày ... tháng ... năm ....<br />
      Nhân viên </div>
  </div>
</body>
<style>
  body {
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font: 12pt "Tohoma";
  }

  * {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
  }

  .page {
    width: 21cm;
    overflow: hidden;
    min-height: 297mm;
    padding: 2.5cm;
    margin-left: auto;
    margin-right: auto;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
  }

  .subpage {
    padding: 1cm;
    border: 5px red solid;
    height: 237mm;
    outline: 2cm #FFEAEA solid;
  }

  @page {
    size: A4;
    margin: 0;
  }

  button {
    width: 100px;
    height: 24px;
  }

  .header {
    overflow: hidden;
  }

  .logo {
    background-color: #FFFFFF;
    text-align: left;
    float: left;
  }

  .company {
    padding-top: 24px;
    text-transform: uppercase;
    background-color: #FFFFFF;
    text-align: right;
    float: right;
    font-size: 16px;
  }

  .title {
    text-align: center;
    position: relative;
    color: #0000FF;
    font-size: 24px;
    top: 1px;
  }

  .footer-left {
    text-align: center;
    text-transform: uppercase;
    padding-top: 24px;
    position: relative;
    height: 150px;
    width: 50%;
    color: #000;
    float: left;
    font-size: 12px;
    bottom: 1px;
  }

  .footer-right {
    text-align: center;
    text-transform: uppercase;
    padding-top: 24px;
    position: relative;
    height: 150px;
    width: 50%;
    color: #000;
    font-size: 12px;
    float: right;
    bottom: 1px;
  }

  .TableData {
    background: #ffffff;
    font: 11px;
    width: 100%;
    border-collapse: collapse;
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
    border: thin solid #d3d3d3;
  }

  .TableData TH {
    background: rgba(0, 0, 255, 0.1);
    text-align: center;
    font-weight: bold;
    color: #000;
    border: solid 1px #ccc;
    height: 24px;
  }

  .TableData TR {
    height: 24px;
    border: thin solid #d3d3d3;
  }

  .TableData TR TD {
    padding-right: 2px;
    padding-left: 2px;
    border: thin solid #d3d3d3;
  }

  .TableData TR:hover {
    background: rgba(0, 0, 0, 0.05);
  }

  .TableData .cotSTT {
    text-align: center;
    width: 5%;
  }

  .TableData .cotTenSanPham {
    text-align: left;
    width: 30%;
  }

  .TableData .cotHangSanXuat {
    text-align: left;
    width: 20%;
  }

  .TableData .cotGia {
    text-align: center;
    width: 120px;
  }

  .TableData .cotSoLuong {
    text-align: center;
    width: 120px;
  }

  .TableData .cotSo {
    text-align: center;
    width: 120px;
  }

  .TableData .tong {
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
    padding-right: 4px;
  }

  .TableData .cotSoLuong input {
    text-align: center;
  }

  @media print {
    @page {
      margin: 0;
      border: initial;
      border-radius: initial;
      width: initial;
      min-height: initial;
      box-shadow: initial;
      background: initial;
      page-break-after: always;
    }
  }
</style>
