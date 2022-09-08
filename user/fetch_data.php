<?
  header("Content-type: application/json; charset=utf-8");
  include "function.php";
  $fetch = new DB_con();
  $result = array();
  $year = $_POST['year'];
  $id_card = $_POST['id_card'];
  $topic = $_POST['topic'];


    // NOT VALUE FOR SEARCH
    if($topic == 'sarary' ){
         $sql = "SELECT * FROM sarary WHERE id_card = '$id_card'";
         if($year != ''){
            $sql .= " AND YEAR(date_Pay) = '$year'";
         }else{
             $y = date('Y');
             $sql .= " AND YEAR(date_Pay) = '$y'";
         }
    }else if($topic == 'other'){
        $sql = "SELECT * , MONTH(pay_date) AS imp_month , YEAR(pay_date) AS imp_year FROM receipt_other WHERE id_card = '$id_card'";
        if($year != ''){
            $sql .= " AND YEAR(pay_date) = '$year'";
        }else{
            $y = date('Y');
            $sql .= " AND YEAR(pay_date) = '$y'";
        }
    }

    if($topic == 'sarary'){
        $sql .= " ORDER BY date_Pay DESC";

    }else if ($topic == 'other'){
        $sql .= " ORDER BY pay_date DESC";
    }

    // FETCH DATA
    $query = $fetch->fetch_data($sql);
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    // echo $sql;
    echo json_encode($result);
?>