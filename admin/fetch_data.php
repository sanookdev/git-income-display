<?
  header("Content-type: application/json; charset=utf-8");
  include "function.php";
  $fetch = new DB_con();

  $search_arr = $_POST['data'];
  $result = array();
  $empty = false;

    // NOT VALUE FOR SEARCH
    if($_POST['data']['idcardSearch'] == '' && $_POST['data']['nameSearch'] == ''
     && $_POST['data']['departmentSearch'] == ''){
         $sql = "SELECT * FROM sarary ";
         $empty = true;
    }
  
  
     // IS SEARCH
    if($search_arr['idcardSearch'] != ''){
        $id_card = $search_arr['idcardSearch'];
        $sql = "SELECT * FROM sarary WHERE id_card = '$id_card'";
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
            $where .= "id_card = '$id_card'";
            if($i != count($idcard_search) - 1){
                $where .= " OR ";
            }
        }
        $sql = "SELECT * FROM sarary WHERE ($where)";
    }


    // MONTH AND YEAR IS DEFINED 
    if($search_arr['monthSearch'] != '' ){
        $month = $search_arr['monthSearch'];
        if($empty == true){
            $sql .= " WHERE ";
        }else{
            $sql .= " AND ";
        }
        $sql .= "MONTH(date_Pay) = '$month'";
    }
    if($search_arr['yearSearch'] != ''){
        $year = $search_arr['yearSearch'];
        if($empty == true && $search_arr['monthSearch'] == ''){
            $sql .= " WHERE ";
        }else{
            $sql .= " AND ";
        }
        $sql .= "YEAR(date_Pay) = '$year'";
    }
    $sql .= " ORDER BY date_Pay DESC";

    if($empty == true){
        if($search_arr['monthSearch'] == '' && $search_arr['yearSearch'] == ''){
            $sql .= " LIMIT 200";
        }
    }
    // FETCH DATA
    // echo $sql;
    $query = $fetch->fetch_data($sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }

    if(count($result) > 0){
        for($i = 0 ; $i < count($result) ; $i++){
            $query = $fetch->search_by_idcard($result[$i]['id_card']);
            if(mysqli_num_rows($query) > 0 ){
            $result[$i]['profile'] = mysqli_fetch_assoc($query);
            }
        }
    }

  echo json_encode($result);
?>