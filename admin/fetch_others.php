<?
header("Content-type: application/json; charset=utf-8");
include "function.php";
$fetch = new DB_con();

$search_arr = $_POST['data'];
$result = array();

if($_POST['data']['idcardSearch'] == '' && $_POST['data']['nameSearch'] == ''
     && $_POST['data']['departmentSearch'] == '' ){
         $sql = "SELECT up_type.* , rec.* FROM receipt_other AS rec
                        JOIN upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type";
        
        if($_POST['data']['monthSearch'] == "" && $_POST['data']['yearSeach'])
         $empty = true;
    }

if($search_arr['idcardSearch'] != ''){
    $id_card = $search_arr['idcardSearch'];
    $sql = "SELECT up_type.* , rec.* FROM receipt_other AS rec
                        JOIN upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type WHERE id_card = '$id_card'";
}
else if($search_arr['nameSearch'] != '' || $search_arr['departmentSearch'] != ''){
    $chk = 0;
    if($search_arr['nameSearch'] != '' || $search_arr['departmentSearch'] != ''){
        $sql .= "SELECT per.`ID_CODE` FROM appm_personnel as per 
                        JOIN appm_section AS sec ON per.`SECTION_CODE` = sec.`SECTION_CODE` WHERE per.`EMP_STATUS` = '1'";
    }
    if($search_arr['nameSearch'] != ''){
        $chk++ ;
        $name = $search_arr['nameSearch'];
        $sql .= " AND CONCAT(per.`TFNAME`,' ',per.`TLNAME`) LIKE '%$name%'";
    }
    if($search_arr['departmentSearch'] != ''){
        $SECTION_CODE = $search_arr['departmentSearch'];
        $sql .= " AND sec.`SECTION_CODE` = '$SECTION_CODE'";
    }
    if($chk == 1){
        $sql .= " LIMIT 1";
        $chk = 0;
    }

    // echo $sql;
    $query = $fetch->search_idcard($sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $idcard_search[] = $row;
        }
    }
    
    $where = '';
    for($i = 0 ; $i < count($idcard_search) ; $i++){
        $id_card = $idcard_search[$i]['ID_CODE'];
        $where .= "rec.id_card = '$id_card'";
        if($i != count($idcard_search) - 1){
            $where .= " OR ";
        }
    }
    $sql = "SELECT rec.*,up_type.* FROM receipt_other AS rec 
                JOIN upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type WHERE ($where)";
}

// MONTH AND YEAR IS DEFINED 
if($search_arr['monthSearch'] != '' ){
    $month = $search_arr['monthSearch'];
    if($empty == true){
        $sql .= " WHERE ";
    }else{
        $sql .= " AND ";
    }
    $sql .= "MONTH(pay_date) = '$month'";
}
if($search_arr['yearSearch'] != ''){
    $year = $search_arr['yearSearch'];
    if($empty == true && $search_arr['monthSearch'] == ''){
        $sql .= " WHERE ";
    }else{
        $sql .= " AND ";
    }
    $sql .= "YEAR(pay_date) = '$year'";
}
if($search_arr['show_pick'] != '1'){
    $show_pick = $search_arr['show_pick'];
    if($empty == true && ( $search_arr['monthSearch'] == '' && $search_arr['yearSearch'] == '' )){
        $sql .= " WHERE ";
    }else{
        $sql .= " AND ";
    }
    $sql .= "rec.id_upload_type = '$show_pick'";
}
if($_POST['medcode'] != 'SS'){
    $sql .= " AND rec.id_upload_type < 14";
}else{
    $sql .= " AND rec.id_upload_type > 13";
}
$sql .= " ORDER BY pay_date DESC";

if($empty == true){
    $sql .= " LIMIT 200";
}
$query = $fetch->fetch_data($sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $result[] = $row;
    }
}
// echo $sql;
if(count($result) > 0){
    for($i = 0 ; $i < count($result) ; $i++){
        $idcard = $result[$i]['id_card'];
        $FULLNAME = mysqli_fetch_assoc($fetch->search_fullnameByIdcard($idcard));
        $result[$i]['fullname'] = $FULLNAME['prefix'] .$FULLNAME['FULLNAME'];
    }
}

echo json_encode($result);
?>