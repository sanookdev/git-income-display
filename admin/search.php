<?
  header("Content-type: application/json; charset=utf-8");
  include "function.php";
  $search = new DB_con();
  $topic = $_REQUEST['topic'];
  $result = array();
if ($topic == 'fullname'){
    $name = trim($_REQUEST['name']);
    $sql = $search->search_fullnameByreq($name);
    while($row = mysqli_fetch_assoc($sql)){
        $result[] = $row['FULLNAME'];
    } 
}else if($topic == 'department'){
    $sql = $search->fetch_department();
    while($row = mysqli_fetch_assoc($sql)){
        $result[] = $row;
    } 
}else if($topic == 'id_card'){
    $id_card = $_REQUEST['id_card'];
    $sql = "SELECT CONCAT(TFNAME , ' ' , TLNAME) AS FULLNAME FROM appm_personnel WHERE ID_CODE = '$id_card'";
    $query = $search->search_idcard($sql);
    while($row = mysqli_fetch_assoc($query)){
        $result[] = $row;
    } 
}

echo json_encode($result);
?>