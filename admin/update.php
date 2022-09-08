<?
    header("Content-type: application/json; charset=utf-8");
    include "function.php";
    $update = new DB_con();
    $data_arr = array();
    $data_arr = $_POST['data'];
    $update_id = $_POST['id_edit'];
    $where = 'id = '."$update_id";
    $table = $_POST['table'];

    if($update->update($table,$data_arr,$where)){
        echo "1";
    }else{
        echo "0";
    }
    
    // echo json_encode($data_arr);
?>