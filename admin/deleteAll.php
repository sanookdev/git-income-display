<?
    require_once "../config/connect.php";   
    require_once "function.php";
    $delete = new DB_con();
    $m = $_POST['data']['monthDel'];
    $y = $_POST['data']['yearDel'];
    $topic = $_POST['data']['deleteType'];
    $id_type = $_POST['data']['deleteType'];
    if($id_type == '1'){
        $sql = "DELETE FROM sarary WHERE MONTH(date_Pay)='$m' AND YEAR(date_Pay) = '$y'"; 
    }else{
        $sql = "DELETE FROM receipt_other WHERE id_upload_type = '$id_type' AND MONTH(pay_date)='$m' AND YEAR(pay_date) = '$y'"; 
    }
    
    if($delete->deleteAll($sql)){
        echo "1";
    }else{
        echo "0";
    }
?>