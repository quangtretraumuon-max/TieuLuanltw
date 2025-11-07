<?php
require_once __DIR__ . "/autoload/autoload.php";
$con = mysqli_connect("localhost", "root", "", "webfast");
$data =
    [
        'name' => postInput("name"),
        'email' => postInput("email"),
        'content' => postInput("content")
    ];
$error = [];
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($data['name'] == '') {
        $error['name'] = "You have not entered the name !!!";
    }

    if ($data['email'] == '') {
        $error['email'] = "You have not entered your email name !!!";
    }

    if ($data['content'] == '') {
        $error['content'] = "You did not enter content !!!";
    }

    //kiểm tra mảng error
    if (empty($error)) {
        $idinsert = $db->insert("feedback", $data);
        if ($idinsert > 0) {
            echo "<script>alert('Thank you for contacting us.');location.reload()'</script>";
        } else {
        }
    }
}


?>
<?php require_once __DIR__ . "/layouts/header.php"; ?>
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49116.39176087041!2d-86.41867791216099!3d39.69977417971648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x886ca48c841038a1%3A0x70cfba96bf847f0!2sPlainfield%2C%20IN%2C%20USA!5e0!3m2!1sen!2sbd!4v1586106673811!5m2!1sen!2sbd" height="500" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
</div>
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__text">
                    <div class="section-title">
                        <span>Thông tin</span>
                        <h2>Liên hệ với chúng tôi</h2>
                        <p>Như bạn có thể mong đợi về một công ty bắt đầu với tư cách là nhà thầu nội thất cao cấp, chúng tôi rất chú ý.</p>
                    </div>
                    <ul>
                        <li>
                            <h4>America</h4>
                            <p>195 E Parker Square Dr, Parker, CO 801 <br>+43 982-314-0958</p>
                        </li>
                        <li>
                            <h4>France</h4>
                            <p>109 Avenue Léon, 63 Clermont-Ferrand <br>+12 345-423-9893</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <form action="#" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Họ tên" name="name" class="mb-0">
                                <?php if (isset($error['name'])) : ?>
                                    <p class="text-danger"><?php echo $error['name'] ?></p>
                                <?php endif ?>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email" name="email" class="mb-0">
                                <?php if (isset($error['email'])) : ?>
                                    <p class="text-danger"><?php echo $error['email'] ?></p>
                                <?php endif ?>
                            </div>
                            <div class="col-lg-12 mt-3 mb-3">
                                <textarea placeholder="Lời nhắn" name="content" class="mb-0"></textarea>
                                <?php if (isset($error['content'])) : ?>
                                    <p class="text-danger text-left"><?php echo $error['content'] ?></p>
                                <?php endif ?>
                                <button type="submit" class="site-btn">Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . "/layouts/footer.php"; ?>
