<?
header("Content-type: application/json; charset=utf-8");
session_start();
include "../config/connect.php";
include "function.php";
$medCheck = substr($_SESSION['_USER'],1,2);
$name = isset($_POST['name']) ? $_POST['name'] : '';

if($medCheck == 'SS'){
    $rs = select("SELECT * FROM upload_type WHERE id_upload_type > 13" , $conn);

}else{
    $rs = select("SELECT * FROM upload_type WHERE id_upload_type < 14", $conn);
}
echo json_encode($rs);