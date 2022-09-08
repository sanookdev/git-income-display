<?
    header("Content-type: application/json; charset=utf-8");

    include "function.php";
    $fetch = new DB_con();
    $topic = $_POST['topic'];
    if($topic == 'fetch_default_other'){
        $sql = "SELECT rec.*, up_type.topic AS upload_name FROM receipt_other AS rec 
                    JOIN  upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type
                        ORDER BY rec.pay_date DESC LIMIT 200";
        $query = $fetch->fetch_data($sql);
    }
    else if($topic == 'sarary'){
        $id_edit = $_POST['id'];
        $sql = "SELECT * FROM sarary WHERE id = '$id_edit' LIMIT 1";
        $query = $fetch->fetch_data($sql);
        // $result[] = mysqli_fetch_assoc($query);
    }
    else if($topic == 'receipt_other'){
        $id_edit = $_POST['id'];
        $sql = "SELECT rec.*,up_type.topic FROM receipt_other AS rec
                    JOIN upload_type AS up_type ON rec.id_upload_type = up_type.id_upload_type
                        WHERE rec.id = '$id_edit'";
        $query = $fetch->fetch_data($sql);
    }
    $result = array();
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }

    if($topic == 'sarary'){
        for($i = 0 ; $i < count($result) ; $i++){
            $row =mysqli_fetch_assoc($fetch->search_by_idcard($result[$i]['id_card']));
            $result[$i]['DESCRIPTION'] = $row['DESCRIPTION'];
            $result[$i]['FULLNAME'] = $row['FULLNAME'];
        }
    }
    echo json_encode($result);



?>