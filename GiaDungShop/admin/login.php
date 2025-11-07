<?php
session_start();
require_once __DIR__ . '/../libraries/Database.php';
require_once __DIR__ . '/../libraries/Function.php';

$db = new Database;

$data =
    [
        'email' => postInput("email"),
        'password' => postInput("password")
    ];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = [];
    if (postInput('email') == '') {
        $error['email'] = "Email không được để trống!!";
    }

    if (postInput('password') == '') {
        $error['password'] = "Mật khẩu không được để trống!!";
    } else {
        $data['password'] = MD5(postInput('password'));
    }

    //dang nhap thanh cong

    if (empty($error)) {

        $isset = $db->fetchOne("admin", "email = '" . $data['email'] . "' AND password = '" . $data['password'] . "' ");
        if ($isset > 0) {
            $_SESSION['admin_name'] = $isset['name'];
            $_SESSION['admin_id'] = $isset['id'];
            $_SESSION['admin_lv'] = intval($isset['level']);
            echo "<script>location.href='" . base_url() . "/admin/'</script>";
        } else {
            $_SESSION['error'] = "Đăng nhập thất bại";
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oganic Shop Admin</title>
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url() ?>/public/admin/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?php echo base_url() ?>/public/admin/css/styles.min.css" />
</head>

<body>
    <?php if (isset($_SESSION['error'])) : ?>
        <?php echo "<script>alert('Đăng nhập thất bại');</script>"; ?>
    <?php endif; ?>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <p class="text-center">Đăng nhập</p>
                                <form method="POST">
                                    <div class="mb-3" data-validate="Vui lòng điền email">
                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                                    </div>
                                    <div class="mb-4" data-validate="Vui lòng điền mật khẩu">
                                        <label for="exampleInputPassword1" class="form-label">Mật khẩu</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Đăng nhập</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url() ?>/public/admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>/public/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
