<?php
require_once __DIR__ . '/autoload/autoload.php';
if (!isset($_SESSION['name_id'])) {
    $_SESSION['error_cm'] = "Sign in to write your review!";
    header("location:san_pham.php?id=" . getInput('id'));
} else {
    $data =
        [
            "id_users" => $_SESSION['name_id'],
            "id_product" => intval(getInput('id')),
            "comment" => getInput('comment'),
            "rated" => intval(getInput('star'))
        ];
    if (getInput('star') == '') {
        $_SESSION['error_cm'] = "You have not rated the number of stars!";
    } else
        if (getInput('comment') == '') {
        $_SESSION['error_cm'] = "Please write your thoughts!";
    } else {
        $id_insert = $db->insert("rated", $data);
        if ($id_insert > 0) {
            $_SESSION['success'] = "Successful evaluation!";
        }
    }
    header("location:san_pham.php?id=" . $data['id_product']);
}
