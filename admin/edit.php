<?
    // require_once "../config/connect.php";
    require_once "function.php";
    $id_update =$_POST['id'];
    $topic = $_POST['topic'];
    $update = new DB_con();
    $result = array();
    if($topic == 'update_sarary'){
        $sql = "SELECT * FROM sarary WHERE id = '$id_edit' LIMIT 1";
        $query = $edit->fetch_data($sql);
        $result[] = mysqli_fetch_assoc($query);
    }else{
        echo "0";
    }

    echo json_encode($result);
    
    
?>