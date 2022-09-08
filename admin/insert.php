<?
    header("Content-type: application/json; charset=utf-8");
    include "function.php";
    session_start();
    $insert = new DB_con();
    $table = $_POST['table'];
    $topic = $_POST['topic'];
    $value = array();
    if($topic == 'sarary'){
        $value[] = @"'".$_POST['data']['id_card']."'";
        $value[] = @"'".$_POST['data']['sarary']."'";
        $value[] = @"'".$_POST['data']['col']."'";
        $value[] = @"'".$_POST['data']['sumPlus']."'";
        $value[] = @"'".$_POST['data']['vat']."'";
        $value[] = @"'".$_POST['data']['social_secure']."'";
        $value[] = @"'".$_POST['data']['provident_fund']."'";
        $value[] = @"'".$_POST['data']['cooperative']."'";
        $value[] = @"'".$_POST['data']['net']."'";
        $value[] = @"'".$_POST['data']['acc_num']."'";
        $value[] = @"'".$_POST['data']['name_bank']."'";
        $value[] = @"'".date('Y-m-d')."'";
        $value[] = @"'".$_POST['data']['date_Pay']."'";
        $value[] = @"'".strtoupper($_SESSION['_ID_CARD'])."'";
    }else if ($topic == 'other'){
        $value[] = @"'".$_POST['data']['id_card']."'";
        $value[] = @"'".$_POST['data']['fullname']."'";
        $value[] = @"'".$_POST['data']['position']."'";
        $value[] = @"'".$_POST['data']['id_upload_type']."'";
        $value[] = @"'".$_POST['data']['amount']."'";
        $value[] = @"'".$_POST['data']['vat']."'";
        $value[] = @"'".$_POST['data']['total']."'";
        $value[] = @"'".$_POST['data']['acc_num']."'";
        $value[] = @"'".$_POST['data']['name_bank']."'";
        $value[] = @"'".$_POST['data']['pay_date']."'";
        $value[] = @"'".strtoupper($_SESSION['_ID_CARD'])."'";
    }
    
    // echo $insert->insert($value,$table)

    // echo json_encode($value);
    // echo $insert->insert($value,$table);
    if($insert->insert($value,$table)){
        echo '1';
    }else{
        echo '0';
    }


?>