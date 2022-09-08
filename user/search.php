<?
    header("Content-type: application/json; charset=utf-8");
    include "function.php";
    $search = new DB_con();
    $idcardSearch = $_POST['idcardSearch'];
    $monthSearch = $_POST['monthSearch'];
    $yearSearch = $_POST['yearSearch'];
    $result = array();
    $sql = "SELECT rec.*,up_type.topic FROM receipt_other AS rec
                JOIN upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type
                    WHERE rec.id_card = '$idcardSearch' AND MONTH(rec.pay_date) = '$monthSearch' AND YEAR(rec.pay_date) = '$yearSearch'";
    $query = $search->fetch_data($sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    
    echo json_encode($result);
?>