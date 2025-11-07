<?php 
$open ="category";  
require_once __DIR__."/../../autoload/autoload.php";


$id = intval(getInput('id'));



$Editadmin = $db->fetchID("feedback",$id);
if(empty($Editadmin))
{
  $_SESSION['error'] = " Dữ liệu không tồn tại";
  redirectAdmin("feedback");
}

$num = $db->delete("feedback",$id);
if($num > 0)
{
   $_SESSION['success'] = "Xóa thành công ";
              redirectAdmin("feedback");
}
else
{
   $_SESSION['error'] = "Xóa thất bại ";   // Thêm thất bại 
              redirectAdmin("feedback"); 
}
?>